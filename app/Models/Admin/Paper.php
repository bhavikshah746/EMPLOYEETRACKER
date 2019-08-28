<?php

namespace App\Models\Admin;
use App\Libraries\helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function createPaper($inputs){
    	$paper=new Paper($inputs);
        $paper->slug=helpers::createSlug($inputs['name']);
        return $paper->save();
    }
    public static function editPaper($inputs,$id){
        $inputs['slug']=helpers::createSlug($inputs['name']);
        $paper=Paper::find($id);
        return $paper->update($inputs);
    }

    public static function deletePaper($id){
        $paper=Paper::find($id);

        return $paper->delete();
    }
}
