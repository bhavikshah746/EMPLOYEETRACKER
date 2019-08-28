<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebNotification extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    protected $table = 'web_notifications';

    public static function createNotification($input)
    {
    	$noti=new WebNotification($input);
    	if($noti->save())
    	{
    		return $noti;
    	}
    	else
    	{
    		return false;
    	}
    }

    public static function readNotification($id)
    {
    	$noti=WebNotification::find($id);
    	$noti->is_read=1;
    	if($noti->save())
    	{
    		return $noti;
    	}
    	else
    	{
    		return false;
    	}
    }
}
