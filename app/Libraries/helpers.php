<?php
/**
 * Created by PhpStorm.
 * User: Nikhil
 * Date: 03-05-2016
 * Time: 11:20
 */

namespace App\Libraries;
use App\Models\Admin\WebNotification;
use App\Models\Admin\UserSalesperson;

class helpers
{
    static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function createSlug($string){
        
        $len =  strlen($string);
        if($len > 60){
            
            $new = substr($string, 0, 60);
            $result = substr($new,0, strrpos($new,' '));
            $string =  $result;
        }
        
        $string = strtolower($string);
        if(empty(($string))){
            $slug   =   'Facebook Video';
        }else{
            $slug   =   self::normalize($string);
        }
        
        $slug = trim($slug , '-');
        return $slug;
        
    }
    public static function normalize( $string = null ) {
        if (empty($string)) {
            throw new \InvalidArgumentException('No input string is given');
        }
        $string = strip_tags($string);
        // Preserve escaped octets.
        $string = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $string);
        // Remove percent signs that are not part of an octet.
        $string = str_replace('%', '', $string);
        // Restore octets.
        $string = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $string);
        if (function_exists('mb_strtolower')) {
            $string = mb_strtolower($string, 'UTF-8');
        } else {
            $string = strtolower($string);
        }
        //$string = preg_replace('/\p{Mn}/u', '', \Normalizer::normalize($string, \Normalizer::FORM_KD));
        $string = preg_replace('/[^%a-z0-9 _-]/', '', $string);
        $string = preg_replace('/\s+/', '-', $string);
        $string = preg_replace('|-+|', '-', $string);
        $string = trim($string, '-');
        return $string;
    }

    public static function implode_array($arr)
    {
        $str='';

        foreach ($arr as $key => $value) {
            if($key==count($arr)-1){
                $str=$str.$value;
            }else{
                $str=$str.$value.',';
            }
        }
        return $str;
    }

    public static function dateTest($date){
        if($date<date('Y-m-d')){
            $status=false;
        }else{
            $status=true;
        }
        return $status;
    }

    public static function createWebNotification($salesperson_id,$body,$route,$main_id)
    {
        $data=[];
        $admins=UserSalesperson::select('*')
            ->where('salesperson_id','=',$salesperson_id)
            ->get();
        foreach ($admins as $key => $value) {
            $input=[];
            $input['from']=$salesperson_id;
            $input['to']=$value->admin_id;
            $input['body']=$body;
            $input['route']=$route;
            $input['main_id']=$main_id;
            // $input['date']=date_format(date_create($task->date_time),'Y-m-d');
            $noti=WebNotification::createNotification($input);
            if(!$noti){
                $data['errors']='Something Went Wrong';
                $data['statusCode']='404';
            }
        }
        return $data;
    }
}