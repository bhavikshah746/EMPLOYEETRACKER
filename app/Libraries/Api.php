<?php 

namespace App\Libraries;
use App\Models\Admin\Notification;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Illuminate\Support\Facades\Log;
use FCM;
class Api{

	public static function ApiResponse($data, $statusCode = '200',$specialMsg = array() ){
		if( ! is_null($data)){

			if(isset($data['header'])){
				foreach($data['header'] as $key => $value){
					$headers[$key] = $value;
				}
				unset($data['header']);
			}
			$returnArray['status'] = $statusCode;	
			$returnArray['data'] = $data;
		}else{
			$returnArray['status'] = '404';
		}

		if( ! empty( $specialMsg) ){
			$returnArray['specialMsg'] = $specialMsg;
		}


		$headers['Content-Type'] =  'application/json';
		$headers['Cache-Control'] =  'no-cache, no-store, must-revalidate';
		$headers['Pragma'] =  'no-cache';

		//return $headers;
		//return \Response::make(json_encode($returnArray, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK))->header('Content-Type', "application/json");
		return \Response::make(json_encode(
				$returnArray, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK
			) , $returnArray['status']  , $headers );
	}

	public static function firebaseNotification($title,$body,$token,$data,$id){
		if($token!='' && $token!=null){
			Log::info('firebase started');
			$page='';
			if(isset($data['page'])){
				$page=$data['page'];
			}
			$date=null;
			if(isset($data['date'])){
				$date=$data['date'];
			}

			$optionBuiler = new OptionsBuilder();

			$optionBuiler->setTimeToLive(60*20);

			$notificationBuilder = new PayloadNotificationBuilder($title);

			$notificationBuilder
				->setBody($body)
	           	->setSound('default');

			$dataBuilder = new PayloadDataBuilder();

			$dataBuilder->addData($data);

			$option = $optionBuiler->build();

			$notification = $notificationBuilder->build();

			$data = $dataBuilder->build();

			$downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
			Log::info('Notification Sended');

			$data=$downstreamResponse;

			$input=[];
			$input['date_time']=date('Y-m-d H:i:s');
			$input['title']=$title;
			$input['body']=$body;
			$input['salesperson_id']=$id;
			$input['page']=$page;
			$input['data_date']=$date;

			$noti=new Notification($input);
			$noti->save();

			Log::info('Database stored');

			return $data;
		}

	}

}