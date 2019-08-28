<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function notificationBySalesperson($id,$offset)
    {
    	return Notification::select('*')
    		->where('salesperson_id','=',$id)
    		->orderBy('date_time','desc')
    		->skip($offset)
    		->take(config('site.api_limit'))
    		->get();
    }
}
