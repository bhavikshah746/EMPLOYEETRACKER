<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use App\Models\Admin\Category;
use App\Models\Admin\UserSalesperson;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Task;
use App\Libraries\helpers;
use App\Models\Admin\UserArea;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests;
use App\Libraries\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Facades\Datatables;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data=[];

        $data['salesperson_id']=$id;

        $data['salesperson']=User::find($id);
        $data['user']=Sentinel::getUser();

        return view('admin.pages.tasks.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data=[];

        $data['salesperson_id']=$id;

        $salesperson=User::find($id);

        $data['salesperson']=$salesperson;

        $area_ids=UserArea::select('*')
        	->where('user_id','=',$salesperson->id)
        	->lists('area_id');

        $company=Company::select('*')
            ->whereIn('area_id',$area_ids)
            ->orderBy('name','asc')
            ->lists('name','id');

        $data['companies']=$company->map(function ($item, $key) {
            return ucwords($item);
        });

        return view('admin.pages.tasks.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $this->validate($request,config('validation_rules.tasks'));

        $inputs=$request->all();

        $date_time=$inputs['date_time'];

        list($date,$time)=explode('  ',$date_time);

        list($day,$month,$year)=explode('-',$date);
        
        if(!helpers::dateTest($year.'-'.$month.'-'.$day)){
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        }

        $inputs['date_time']=$year.'-'.$month.'-'.$day.' '.$time;

        $inputs['salesperson_id']=$id;

        $inputs['admin_id']=Sentinel::getUser()->id;

        $tasks=Task::createTask($inputs);

        if (!$tasks) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            if(isset($inputs['is_notification_send']) && $inputs['is_notification_send']=='1'){
                $user=User::find($id);

                $data_notification=[
                    'page'=>'task',
                    'date'=>$year.'-'.$month.'-'.$day
                ];

                $notification=Api::firebaseNotification('Task Added','Hello, New Task id added please check it out',$user->gcm_id,$data_notification,$id);
            }
            Session::flash('message', 'Task Added Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.users.index');
        }
    }

    public function ajaxStore(Request $request)
    {   
        $data=[];

        $validator=Validator::make($request->all(),config('validation_rules.tasks'));
        
        if($validator->fails()){
            $data['status']=false;
            $data['errors']=$validator;
            return $data;
        }

        $inputs=$request->all();

        $date_time=$inputs['date_time'];

        list($date,$time)=explode('  ',$date_time);

        list($day,$month,$year)=explode('-',$date);

        if(!helpers::dateTest($year.'-'.$month.'-'.$day)){
            $data['status']=false;
            $data['errors']='Date Should not Be Lower than today';
            return $data;
        }

        $inputs['date_time']=$year.'-'.$month.'-'.$day.' '.$time;

        $inputs['admin_id']=Sentinel::getUser()->id;

        $tasks=Task::createTask($inputs);

        if (!$tasks) {
            $data['status']=false;
            $data['errors']='Date Should not Be Lower than today';
        } else {
            if(isset($inputs['is_notification_send']) && $inputs['is_notification_send']=='1'){
                $user=User::find($inputs['salesperson_id']);

                $data_notification=[
                    'page'=>'task',
                    'date'=>$year.'-'.$month.'-'.$day
                ];

                $notification=Api::firebaseNotification('Task Added','Hello, New Task id added please check it out',$user->gcm_id,$data_notification,$inputs['salesperson_id']);
            }
            $data['status']=true;
            $data['message']='Task Added Successfully';
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=[];

        $data['task']=Task::find($id);

        $data['salesperson_id']=$data['task']->salesperson_id;

        $salesperson=User::find($data['task']->salesperson_id);

        $data['salesperson']=$salesperson;

        $area_ids=UserArea::select('*')
            ->where('user_id','=',$salesperson->id)
            ->lists('area_id');

        $company=Company::select('*')
            ->whereIn('area_id',$area_ids)
            ->orderBy('name','asc')
            ->lists('name','id');

        $data['companies']=$company->map(function ($item, $key) {
            return ucwords($item);
        });

        return view('admin.pages.tasks.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,config('validation_rules.tasks'));

        $inputs=$request->all();

        $date_time=$inputs['date_time'];

        list($date,$time)=explode('  ',$date_time);

        list($day,$month,$year)=explode('-',$date);
        
        if(!helpers::dateTest($year.'-'.$month.'-'.$day)){
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        }

        $inputs['date_time']=$year.'-'.$month.'-'.$day.' '.$time;

        $inputs['admin_id']=Sentinel::getUser()->id;

        $task=Task::editTask($inputs,$id);

        if (!$task) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            if(isset($inputs['is_notification_send']) && $inputs['is_notification_send']=='1'){
                $task=Task::find($id);
                $user=User::find($task->salesperson_id);

                $data_notification=[
                    'page'=>'task',
                    'date'=>$year.'-'.$month.'-'.$day
                ];

                $notification=Api::firebaseNotification('Task Edited','Hello, Task is edited plese check it out',$user->gcm_id,$data_notification,$task->salesperson_id);
            }
            Session::flash('message', 'Task Edited Successfully');
            Session::flash('class', 'success');
            $task=Task::find($id);
            return redirect()->route('admin.tasks.index',$task->salesperson_id);
        }
    }


    public function responce($id){
        $data=[];

        $data['task']=Task::find($id);

        $data['salesperson_id']=$data['task']->salesperson_id;

        $data['salesperson']=User::find($data['task']->salesperson_id);

        $data['user']=Sentinel::getUser();

        return view('admin.pages.tasks.responce',$data);
    }

    public function approval($id,Request $request){
        $inputs=$request->all();

        $inputs['approval_at']=date('Y-m-d H:i:s');
        
        $task=Task::editTask($inputs,$id);

        if (!$task) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'Task Edited Successfully');
            Session::flash('class', 'success');
            $task=Task::find($id);
            return redirect()->route('admin.tasks.index',$task->salesperson_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $task=Task::deleteTask($request->tasks_id);
        $data = [];
        if (!$task) {
            $data['status'] = false;
        } else {
            $data['status']=true;
        }
        return $data;
    }

    public function dataShow(Request $request)
    {
        $data=[];

        if($request->admin_mode==true){
            $data['admin_mode']=true;
        }

        if($request->user_id){
            $data['user_id']=$request->user_id;
        }
        if($request->id){
            $data['task_id']=$request->id;
        }
    
        $userList=UserSalesperson::select('*')
                ->where('admin_id','=',Sentinel::getUser()->id)
                ->lists('salesperson_id');

        $users=User::select('*',DB::raw('concat(first_name," ",last_name)'))
            ->where('role','=','3');

        if($request->admin_mode!=true && Sentinel::getUser()->role==2){
            $users->whereIn('id',$userList);
        }
        
        $user=$users->orderBy('first_name','desc')
            ->lists('first_name','id');

        $data['users']=$user->map(function ($item, $key) {
            return ucwords($item);
        });

        $data['user']=Sentinel::getUser();

        $data['task_completion']=[
            '0'=>'Incomplete',
            '1'=>'Complete'
        ];

        return view('admin.pages.tasks.index',$data);
    }

    public function updateTask(Request $request)
    {
        $inputs=$request->all();

        $task_id=$inputs['task_id'];

        unset($inputs['task_id']);

        $inputs['approval_at']=date('Y-m-d H:i:s');
        
        $task=Task::editTask($inputs,$task_id);

        $data=[];

        if (!$task) {
            $data['status']=false;
        } else {
            $data['status']=false;
        }

        return $data;
    }


    public function datatable(Request $request){

        $tasks=Task::select('tasks.*','companies.name as company_name','users.first_name as first_name','users.last_name as last_name')
            ->join('companies','companies.id','=','tasks.company_id')
            ->join('users','users.id','=','tasks.salesperson_id')
            ->where('companies.deleted_at','=',null)
            ->where('users.deleted_at','=',null);

        if($request->task_id && $request->task_id!=''){
            $tasks->where('tasks.id','=',$request->task_id);
        }

        if($request->salesperson_id && $request->salesperson_id!=''){
            $tasks->where('salesperson_id','=',$request->salesperson_id);
        }
        if($request->status!=''){
            $tasks->where('responce_status','=',$request->status);
        }

        if($request->date && $request->date!=''){
            list($day,$month,$year)=explode('-',$request->date);
            $tasks->where(DB::raw('date(date_time)'),'=',$year.'-'.$month.'-'.$day);
        }

        if($request->month && $request->month!='' && $request->year && $request->year!=''){
            $tasks->where(DB::raw('month(date_time)'),'=',$request->month);
            $tasks->where(DB::raw('year(date_time)'),'=',$request->year);
        }

        if($request->start_date!='' && $request->end_date!=''){
            $parts=explode('-',$request->start_date);
            $start_date=$parts[2].'-'.$parts[1].'-'.$parts[0];
            $parts=explode('-',$request->end_date);
            $end_date=$parts[2].'-'.$parts[1].'-'.$parts[0];
            $tasks->where(DB::raw('date(date_time)'),'<=',$end_date);
            $tasks->where(DB::raw('date(date_time)'),'>=',$start_date);
        }
        if(Sentinel::getUser()->role==2 && !$request->admin_mode && $request->admin_mode!=true ){
            $userList=UserSalesperson::select('*')
                ->where('admin_id','=',Sentinel::getUser()->id)
                ->lists('salesperson_id');

            $tasks->whereIn('tasks.salesperson_id',$userList);
        }
        return Datatables::of($tasks)
            ->addColumn('company_name',function($tasks){
                return ucwords($tasks->company_name);
            })
            ->addColumn('salesperson_id',function($tasks){
                return ucwords($tasks->first_name.' '.$tasks->last_name);
            })
            ->addColumn('title',function($tasks){
                return ucwords($tasks->title);
            })
            ->addColumn('date_time',function($tasks){
                return date_format(date_create($tasks->date_time),'d-M-Y H:i');
            })
            ->addColumn('action',function($tasks){
                $str='<ul class="actions_list ul_reset">';
                if($tasks->responce_status=='0' || $tasks->responce_status=='1'){
                    $str=$str.'<li>
                                <a class="button red showTaskResponce" id="'.$tasks->id.'" href="#" data-popup="responce_task">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"/></svg>
                                </a>
                            </li>';
                } 

                $str=$str.'<li>
                                <a class="button red" href="' .URL::route('admin.tasks.edit', $tasks->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                            </li>
                            <li>
                                <button class="button delete" id="' . $tasks->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </li>
                        </ul>';

                return $str;
            })
            ->make('true');
    }

    public function getTask(Request $request)
    {
        $data=[];
        $task=Task::find($request->task_id);
        $task->next_visit=date_format(date_create($task->next_visit),'d-M-Y h:i:s a');
        $task->responce_at=date_format(date_create($task->responce_at),'d-M-Y h:i:s a');
        $task->responce_status=config('site.responces.tasks_salesperson_responce')[$task->responce_status];
        $data['admin_user']=[];
        if($task->admin_responce=='0' || $task->admin_responce=='1'){
            $admin_user=User::find($task->admin_id);
            $data['admin_user']=ucwords($admin_user->first_name.' '.$admin_user->last_name);
            $task->admin_responce=config('site.responces.tasks_admin_responce')[$task->admin_responce];
        }
        $salesperson=User::find($task->salesperson_id);
        $salesperson->first_name=ucwords($salesperson->first_name);
        $salesperson->last_name=ucwords($salesperson->last_name);
        $data['task']=$task;
        $data['salesperson']=$salesperson;
        return $data;
    }

    public function exportExcel(Request $request)
    {
        if($request->salesperson_id && $request->salesperson_id!=''){
            $user=User::find($request->salesperson_id);
            $name=$user->first_name.' Task Report -'.date('d-M-Y');
        }else{
            $name='Overall Task Report'.date('d-M-Y');
        }
        Excel::create($name, function($excel) use($request){

            $excel->sheet('Sheetname', function($sheet) use($request){

                $tasks=Task::select('tasks.title as Title',DB::raw('date(tasks.date_time) as Date'),'tasks.disc as Descrption',DB::raw('tasks.interested_in as "Interested In"'),DB::raw('tasks.responce_status as "Salesperson Status"'),'tasks.meeting_duration as Duration',DB::raw('tasks.next_visit as "Next Visit"'),DB::raw('tasks.responce_note as "Salesperson Note"'),DB::raw('concat(users.first_name," ",users.last_name) as Salesperson'),DB::raw('users.employ_id as "Employee ID"'),DB::raw('tasks.admin_responce as "Admin Responce"'),DB::raw('tasks.admin_comments as "Admin Note"'),DB::raw('companies.name as "Company Name"'))
                    ->join('companies','companies.id','=','tasks.company_id')
                    ->join('users','users.id','=','tasks.salesperson_id');
                
                if($request->salesperson_id && $request->salesperson_id!=''){
                    $tasks->where('salesperson_id','=',$request->salesperson_id);
                }
                
                if($request->status!=''){
                    $tasks->where('responce_status','=',$request->status);
                }
                
                if($request->start_date!='' && $request->end_date!=''){
                    $parts=explode('-',$request->start_date);
                    $start_date=$parts[2].'-'.$parts[1].'-'.$parts[0];
                    $parts=explode('-',$request->end_date);
                    $end_date=$parts[2].'-'.$parts[1].'-'.$parts[0];
                    $tasks->where(DB::raw('date(date_time)'),'<=',$end_date);
                    $tasks->where(DB::raw('date(date_time)'),'>=',$start_date);
                }
                
                if(Sentinel::getUser()->role==2 && $request->admin_mode!=1 ){
                    $userList=UserSalesperson::select('*')
                        ->where('admin_id','=',Sentinel::getUser()->id)
                        ->lists('salesperson_id');

                    $tasks->whereIn('tasks.salesperson_id',$userList);
                }
                
                $data=$tasks->get();
                
                $data=$data->map(function($item,$key){
                    $item['Date']=date_format(date_create($item['Date']),'d M Y');
                    $item['Title']=ucwords($item['Title']);
                    if($item['Interested In']!=null && $item['Interested In']!=''){
                        $interested_in=Category::select('*')
                            ->where('id','=',$item['Interested In'])
                            ->first();
                        $item['Interested In']=ucwords($interested_in['name']);
                    }
                    if($item['Salesperson Status']!=null && $item['Salesperson Status']!=''){
                        $item['Salesperson Status']=ucwords(config('site.responces.tasks_salesperson_responce')[$item['Salesperson Status']]);
                    }
                    if($item['Admin Responce']!=null && $item['Admin Responce']!=''){
                        $item['Admin Responce']=ucwords(config('site.responces.tasks_admin_responce')[$item['Admin Responce']]);
                    }
                    if($item['Next Visit']!=null && $item['Next Visit']!=''){
                        $item['Next Visit']=date_format(date_create($item['Next Visit']),'d M Y H:i:s');
                    }
                    $item['Salesperson']=ucwords($item['Salesperson']);
                    $item['Company Name']=ucwords($item['Company Name']);
                    return $item;
                });

                $sheet->fromArray($data);

            });

        })->download('xlsx');
        return back();
    }
}