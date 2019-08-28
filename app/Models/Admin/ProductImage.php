<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    protected $table = 'productimages';

    public static function createImage($input){
    	$image=new ProductImage($input);
    	
    	return $image->save();
    }

    public static function deleteImage($id){
        $image=ProductImage::find($id);
        return $image->delete();
    }
}
