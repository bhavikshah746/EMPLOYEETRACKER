<?php

namespace App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expance extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = ['password', 'remember_token','created_at','deleted_at','updated_at'];

    protected $dates=['deleted_at'];

    public static function getUserExpance($id,$date)
    {
        $expance=Expance::select(DB::raw('sum(price) as price'))
            ->where('user_id','=',$id)
            ->where('approved','=',1)
            ->groupBy('subject');
        if($date!='' && $date!=null){
            $expance->where('day','=',$date);
        }else{
            $expance->where('day','=',date('Y-m-d'));
        }
        return $expance->first();

    }

    public static function expanceCount($id,$year)
    {
        list($month,$year)=explode('-',$year);

    	$expance=Expance::select('subject',DB::raw('sum(price) as price'))
    		->where('user_id','=',$id)
            ->groupBy('subject')
            ->where(DB::raw('month(day)'),'=',$month)
            ->where(DB::raw('year(day)'),'=',$year);
    	return $expance->get();
    }
}
