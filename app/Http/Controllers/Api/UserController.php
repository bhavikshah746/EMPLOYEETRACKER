<?php

namespace App\Http\Controllers\Api;
use Validator;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Libraries\Api;
use App\Models\Admin\User;
use App\Models\Admin\Task;
use App\Models\Admin\Order;
use Illuminate\Support\Facades\DB;
use App\Libraries\helpers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Expance;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=[]; 
        if($request->token){
            
            $inputs=$request->all();
                
            $user = JWTAuth::toUser($request->token);
            
            $data['user']=User::find($user->id);

            $data['tasks']=count(Task::select('*')
                ->where('salesperson_id','=',$user->id)
                ->get());

            $data['orders']=count(Order::select('*')
                ->where('created_by','=',$user->id)
                ->get());

            $expense=Expance::select(DB::raw('sum(price) as total_expense'))
                ->where('user_id',$user->id)
                ->first();

            $data['expenses']=$expense->total_expense;

        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
        
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), config('validation_rules.profile'));
        if ($validator->fails()) {
            $data['errors']=$validator->errors();
            $data['statusCode']='404';
        }else{
            if($request->token){
                $data=[]; 
                
                $inputs=$request->all();
                    
                $user = JWTAuth::toUser($request->token);

                $inputs=[];

                $inputs=$request->all();

                if ($request->hasFile('file'))
                {
                    $file = $request->file('file');
                    $destinationPath = public_path().'/uploads/image/'.date('d-m-Y');

                    $filename = time().'-'.$file->getClientOriginalName();

                    $upload_success = $file->move($destinationPath, $filename);
                    $inputs['image'] = $filename;
                    $inputs['image_path']='uploads/image/'.date('d-m-Y');
                }
                unset($inputs['file']);
                unset($inputs['token']);
                
                $user=User::updateUser($inputs,$user->id);

                if (!$user) {
                    $data['message']='Something Went Wrong';
                    $data['status']=false;
                } else {
                    $data['message']='Profile Edited Successfully';
                    $data['status']=true;
                }

            }
        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
                
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
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
        //
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
        //
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

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), config('validation_rules.change-password'));
        if ($validator->fails()) {
            $data['errors']=$validator->errors();
            $data['statusCode']='404';
        }else{
            if($request->token){
                $data=[]; 
                
                $inputs=$request->all();
                    
                $user = JWTAuth::toUser($request->token);

                unset($inputs['token']);

                $user = Sentinel::findById($user->id);

                $user = Sentinel::update($user, $inputs);

                if (!$user) {
                    $data['message']='Something Went Wrong';
                    $data['status']=false;
                } else {
                    $data['message']='Profile Edited Successfully';
                    $data['status']=true;
                }

            }
        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
                
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
    }
}
