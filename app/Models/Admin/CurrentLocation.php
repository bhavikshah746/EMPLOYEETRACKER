<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentLocation extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    protected $table = 'current_location';

    public static function createCurrentLocation($inputs)
    {
    	$location= new CurrentLocation($inputs);
    	return $location->save();
    }
}
