<?php

namespace App\Models\Admin;

use App\Libraries\helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function createArea($inputs){
        $area=new Area($inputs);
        $area->slug=helpers::createSlug($inputs['name']);
        return $area->save();
    }

    public static function editArea($inputs,$id){
        $inputs['slug']=helpers::createSlug($inputs['name']);
        $area=Area::find($id);
        return $area->update($inputs);
    }

    public static function deleteArea($id){
        $area=Area::find($id);

        return $area->delete();
    }
}
