<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    protected $table = 'productcategory';

    public static function createRelation($input){
    	$category=new ProductCategory($input);
    	
    	return $category->save();
    }

    public static function deleteCategory($id){
    	$category=ProductCategory::select('*')
    		->where('product_id','=',$id)
    		->delete();
    	return $category;
    }
}
