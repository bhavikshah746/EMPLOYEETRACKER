<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Closure;
use App\Libraries\Api;
use App\Models\Admin\Attendence;
use App\Models\Admin\User;
use App\Libraries\helpers;

class AttendenceMiddleware
{
   
    public function handle($request, Closure $next)
    {
    	if($request->token){
    		
    		$inputs=$request->all();

    		$user = JWTAuth::toUser($inputs['token']);

    		unset($inputs['token']);

    		if($user->type=='1'){
    			if(date('H:i')>config('site.app_login.domestic.start')){
    				$attendence=Attendence::select('*')
			            ->where('user_id','=',$user->id)
			            ->where('day','=',date('Y-m-d'))
			            ->first();
			        if( count($attendence)==0 ){
			            $inputs=[];
			            $inputs['start_time']=date('H:i:s');
			            $inputs['day']=date('Y-m-d');
			            $inputs['start_ip']=helpers::get_client_ip();
			            $inputs['user_id']=$user->id;
			            $attendence=new Attendence($inputs);
			            if(!$attendence->save()){
			                $data['errors']='Something Went Wrong';
		                	$data['statusCode']='404';
			            }
			        }
			        if(date('H:i')>'19:20'){
			        	$data_notification=[];
			        	$user_info=User::find($user->id);
		    			$notification=Api::firebaseNotification('Over Time Working','Happy To See you Working. Hope so you complete your task. Good Evening.',$user_info->gcm_id,$data_notification,$user->id);
		    		}
    			}
    		}else if($user->type=='2'){
    			if(date('H:i')>config('site.app_login.international.start')){
    				$attendence=Attendence::select('*')
			            ->where('user_id','=',$user->id)
			            ->where('day','=',date('Y-m-d'))
			            ->first();
			        if( count($attendence)==0 ){
			            $inputs=[];
			            $inputs['start_time']=date('H:i:s');
			            $inputs['day']=date('Y-m-d');
			            $inputs['start_ip']=helpers::get_client_ip();
			            $inputs['user_id']=$user->id;
			            $attendence=new Attendence($inputs);
			            if(!$attendence->save()){
			                $data['errors']='Something Went Wrong';
		                	$data['statusCode']='404';
			            }
			        }
    			}
    		}
            
    	}
        return $next($request);
    }
}
