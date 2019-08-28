<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesperson extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    protected $table = 'salespersons';

    public static function createSalesperson($inputs){
        $salesperson=new Salesperson($inputs);
        return $salesperson->save();
    }

    public static function editSalesperson($inputs,$id){
        $salesperson=Salesperson::find($id);
        return $salesperson->update($inputs);
    }

    public static function deleteSalesperson($id){
        $salesperson=Salesperson::find($id);
        return $salesperson->delete();
    }
}
