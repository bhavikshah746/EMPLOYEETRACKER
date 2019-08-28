<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendence extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    protected $table = 'attendence';

    public static function attendenceByUserId($id,$offset){
    	$attendence=Attendence::select('*')
    		->where('user_id','=',$id)
    		->orderBy('id','desc')
            ->skip($offset)
            ->take(config('site.api_limit'))
    		->get();
    	return $attendence;
    }
}
