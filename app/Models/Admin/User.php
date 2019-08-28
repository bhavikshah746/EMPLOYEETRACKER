<?php

namespace App\Models\Admin;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    // use SoftDeletes;

    protected $fillable = [
        'email',
        'username',
        'password',
        'role',
        'last_name',
        'first_name',
        'permissions',
        'area_id',
        'type',
        'address',
        'phone',
        'image',
        'image_path',
        'gsm_id',
        'expance_limit',
        'permissions',
        'employ_id'
    ];

    protected $loginNames = ['email', 'username'];

    // protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    // protected $dates=['deleted_at'];

    public static function deleteUser($id){
        $user=User::find($id);

        return $user->delete();
    }

    public static function updateUser($input,$id){
        $user=User::find($id); 

        if(!$user->update($input)){
            return false;
        }else{
            return $user;
        }
    }

    public static function validationRule($role=1,$id=0){
        $rules=[];

        if($role==1){
            $rules+=[
                'first_name'=>'required',
                'role'=>'required',
                'phone'=>'numeric',
                'permissions'=>'array',
                'password'=>'confirmed',
                'employ_id'=>'required',
                'email'=>'required|email|unique:users,email,'.$id,
                'username'=>'required|unique:users,username,'.$id,
            ];
        }else{
            $rules+=[
                'first_name'=>'required',
                'role'=>'required',
                'area_id'=>'array',
                'salesperson_id'=>'array',
                'phone'=>'numeric',
                'type'=>'numeric',
                'permissions'=>'array',
                'password'=>'confirmed',
                'employ_id'=>'required',
                'email'=>'required|email|unique:users,email,'.$id,
                'username'=>'required|unique:users,username,'.$id,
            ];
        }

        return $rules;
    }
}
