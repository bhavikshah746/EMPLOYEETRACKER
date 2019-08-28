<?php

namespace App\Models\Admin;
use App\Libraries\helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function createProduct($inputs){
        $product=new Product($inputs);
        if($product->save()){
            return $product;
        }else{
            return false;
        }
    }

    public static function editProduct($inputs,$id){
        $product=Product::find($id);
        return $product->update($inputs);
    }

    public static function deleteProduct($id){
        $product=Product::find($id);
        return $product->delete();
    }

    public static function productList($offset,$cat_id){
        $ProductCategory=[];
        if(isset($cat_id) && $cat_id!=0){
            $productCategory=ProductCategory::select("*")
                ->where('category_id','=',$cat_id)
                ->lists('product_id');
        }

        $product=Product::select('*');

        if(isset($cat_id) && $cat_id!=0){
            $product->whereIn('id',$productCategory);
        }

        return $product->skip($offset)
            ->take(config('site.api_limit'))
            ->get();
    }

    public static function productListByCat($offset,$cat_id){
        $ProductCategory=[];
        if(isset($cat_id) && $cat_id!=0){
            $productCategory=ProductCategory::select('*')
                ->where('category_id','=',$cat_id)
                ->lists('product_id');
        }

        $product=Product::select('id','name');

        if(isset($cat_id) && $cat_id!=0){
            $product->whereIn('id',$productCategory);
        }

        return $product->skip($offset)
            ->take(config('site.api_limit'))
            ->get();
    }
}
