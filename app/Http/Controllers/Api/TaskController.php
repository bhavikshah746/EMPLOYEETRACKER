<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Models\Admin\Task;
use App\Models\Admin\User;
use App\Models\Admin\WebNotification;
use App\Libraries\helpers;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use App\Libraries\Api;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{

    public function get(Request $request){
        $data=[];
        
        if($request->token){

            $user = JWTAuth::toUser($request->token);

            $data['tasks']=Task::tasksBySalesPerson($user->id,$request->offset,$request->date,$request->next_days,$request->previous_days);

            foreach ($data['tasks'] as $key => $value) {
                if($value->admin_id!=null){
                    $data['tasks'][$key]['admin']=User::select('first_name','last_name')
                        ->where('id','=',$value->admin_id)
                        ->get();
                }
            }

            $data['interested_in']=Category::select('*')
                ->lists('name','id');
        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
        
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
    }

    public function store($id,Request $request)
    {
        $data=[];
        if($request->token){
            
            $inputs=$request->all();

            $validator = Validator::make($request->all(), config('validation_rules.tasks_responce_api'));

            if ($validator->fails()) {
                $data['errors']=$validator->errors();
                $data['statusCode']='404';
            }else{

                $user = JWTAuth::toUser($inputs['token']);

                unset($inputs['token']);

                list($date,$time)=explode(' ',$inputs['next_visit']);

                // list($day,$month,$year)=explode('-',$date);

                if(!helpers::dateTest($date)){
                    $data['errors']='Date shold not be lower than current date';
                    $data['statusCode']='404';
                }else{
                    $inputs['next_visit']=date_format(date_create($date.' '.$time),'Y-m-d H:i:s');

                    $inputs['responce_by']=$user->id;

                    $inputs['responce_at']=date('Y-m-d H:i:s');

                    $task=Task::find($id);

                    if(!$task->update($inputs)){
                        $data['errors']='Something Went Wrong';
                        $data['statusCode']='404';
                    }else{

                        $user=User::find($user->id);
                        
                        $body='Salesperson '.ucwords($user->first_name.' '.$user->last_name).' Have Submitted His response for Task id '.$task->id.'. Please Check it out';
                        
                        $route='admin.tasks.datatable';
                        
                        $inputs=helpers::createWebNotification($user->id,$body,$route,$task->id);

                        if(!isset($inputs['statusCode']) || $inputs['statusCode']!='404'){
                            $data['message']="Submitted Successfully";
                            $data['status']=true;
                        }
                        else{
                            $data['errors']='Something Went Wrong';
                            $data['statusCode']='404';
                        }

                    }
                }
            }
        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
        
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
    }

    public function show(Request $request,$id){
        $data=[];
        if($request->token){

            $user = JWTAuth::toUser($request->token);

            $data['tasks']=Task::taskById($id);

            if($data['tasks']->admin_id!=null){
                $data['tasks']['admin']=User::select('first_name','last_name')
                    ->where('id','=',$data['tasks']->admin_id)
                    ->get();
            }

        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
        
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
    }

}
