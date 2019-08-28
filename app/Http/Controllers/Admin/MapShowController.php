<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\CurrentLocation;
use App\Models\Admin\User;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Libraries\Api;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class MapShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=[];
        $map=CurrentLocation::select('latitude as lat','longitude as lng',DB::raw('time(date_time) as time'))
            ->where('user_id','=',$request->user_id)
            ->orderBy('date_time','asc');
        if($request->date && $request->date!=null && $request->date!=''){
            $parts=explode('-',$request->date);
            if(count($parts)!=3){
                $day=date('Y-m-d');
            }else{
                $day=$parts[2].'-'.$parts[1].'-'.$parts[0];
            }
            $map->where(DB::raw('date(date_time)'),'=',$day);
        }else{
            $map->where(DB::raw('date(date_time)'),'=',date('Y-m-d'));
        }
        $maps=$map->get();
        $maps=$maps->map(function ($item, $key) {
            $item->lat=floatval($item->lat);
            $item->lng=floatval($item->lng);
            return $item;
        });
        $data['map']=$maps;
        $data['user']=User::find($request->user_id);
        return $data; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
