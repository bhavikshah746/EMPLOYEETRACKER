<?php

namespace App\Models\Admin;
use App\Libraries\helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function createCategory($inputs){
        $category=new Category($inputs);
        $category->slug=helpers::createSlug($inputs['name']);
        return $category->save();
    }

    public static function editCategory($inputs,$id){
        $inputs['slug']=helpers::createSlug($inputs['name']);
        $category=Category::find($id);
        return $category->update($inputs);
    }

    public static function deleteCategory($id){
        $category=Category::find($id);

        return $category->delete();
    }
}
