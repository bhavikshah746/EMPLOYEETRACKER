<?php

namespace App\Models\Admin;

use App\Libraries\helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function createCompany($inputs){
        $company=new Company($inputs);
        $company->slug=helpers::createSlug($inputs['name']);
        if(!$company->save()){
            return false;
        }else{
            return $company;
        }
    }

    public static function editCompany($inputs,$id){
        $inputs['slug']=helpers::createSlug($inputs['name']);
        $company=Company::find($id);
        return $company->update($inputs);
    }

    public static function deleteCompany($id){
        $company=Company::find($id);
        return $company->delete();
    }

    public static function getCompanies($userArea,$specificUser,$offset){
        $company=Company::select('companies.*','areas.name as area_name')
            ->join('areas','areas.id','=','companies.area_id')
            ->where('areas.deleted_at','=',null);
        if($specificUser==true || $specificUser=='1'){
            $company->whereIn('companies.area_id',$userArea);
        }
        return $company->skip($offset)
            ->take(config('site.api_limit'))
            ->get();
    }
}
