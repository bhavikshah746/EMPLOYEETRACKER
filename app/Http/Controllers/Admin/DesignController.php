<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\Admin\Design;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\Admin\ExcelUploads;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=[];
        if($request->admin_mode==true){
            $data['admin_mode']=true;
        }
        return view('admin.pages.designs.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('products',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $data=[];
        return view('admin.pages.designs.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('products',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $this->validate($request,config('validation_rules.designs'));

        $design = Design::createDesign($request->all());

        if (!$design) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'Design Added Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.designs.index');
        }
    }

    public function excel()
    {
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('products',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $data=[];
        return view('admin.pages.designs.excel',$data);
    }

    public function excelStore(Request $request)
    {
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('products',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $data=[];

        $status=0;

        if($request->hasFile('file')){
            if ($request->file('file')->isValid()) {
                
                $file = $request->file('file');

                $destinationPath = public_path().'/uploads/excels/'.date('d-m-Y');

                $filename = time().'-'.$file->getClientOriginalName();

                $upload_success = $file->move($destinationPath, $filename);
                
                $data['file_name'] = $filename;
                
                $data['file_path']='uploads/excels/'.date('d-m-Y');

                $input=[];
                $input['status']=$status;
                $input['file_name']=$filename;
                $input['file_path']=$data['file_path'];
                $input['from']='designs';
                $excelUploads=new ExcelUploads($input);
                $excelUploads->save();

                $excelData=Excel::load($destinationPath.'/'.$filename, function($reader) {})->get();

                $excelData=json_decode($excelData);
                
                foreach ($excelData as $key => $value) {
                    if($value->designs!='' && $value->designs!=null){
                        $input=[];
                        
                        $input['name']=$value->designs;
                        $input['sheet_id']=$excelUploads->id;
                        $design=new Design($input);
                        if(!$design->save()){
                            $status=2;
                        }
                    }
                }
                
                if($status!=2){
                    $status=1;
                }
                
                if($status=1){
                    $excelUploads=ExcelUploads::find($excelUploads->id);
                    $excelUploads->status=$status;
                    $excelUploads->save();
                    Session::flash('message', 'Designs Added Successfully');
                    Session::flash('class', 'success');
                    return redirect()->route('admin.designs.index');
                }
                
            }
        }
        Session::flash('message', 'Something Went Wrong');
        Session::flash('class', 'danger');
        return back();
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
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('products',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $data=[];
        $data['design']=Design::find($id);
        return view('admin.pages.designs.create',$data);
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
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('products',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $this->validate($request,config('validation_rules.designs'));

        $design = Design::editDesign($request->all(),$id);

        if (!$design) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'Design Edited Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.designs.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        
        $design = Design::deleteDesign($request->area_id);
        $data = [];
        if (!$design) {
            $data['status'] = false;
        } else { 
            $data['status']=true;
        }
        return $data;
    }

    public function datatable(Request $request){
        $design=Design::select('*');
        return Datatables::of($design)
            ->addColumn('name',function($design){
                return ucwords($design->name);
            })
            ->addColumn('action',function($design){
                return '<ul class="actions_list ul_reset">
                            <li>
                                <a class="button red" href="' .URL::route('admin.designs.edit', $design->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                            </li>
                            <li>
                                <button class="button delete" id="' . $design->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </li>
                        </ul>';
            })
            ->make(true);
    }
}
