<?php

namespace App\Models\Admin;
use App\Libraries\helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Design extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function createDesign($inputs){
    	$design=new Design($inputs);
        $design->slug=helpers::createSlug($inputs['name']);
        return $design->save();
    }
    public static function editDesign($inputs,$id){
        $inputs['slug']=helpers::createSlug($inputs['name']);
        $design=Design::find($id);
        return $design->update($inputs);
    }

    public static function deleteDesign($id){
        $design=Design::find($id);

        return $design->delete();
    }
}
