<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Facades\Datatables;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=[];
        if($request->admin_mode==true){
            $data['admin_mode']=true;
        }
        return view('admin.pages.areas.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('areas',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $data['states']=DB::table('indstate')
            ->lists('stmname','stmid');
        $data['cities']=[];
        return view('admin.pages.areas.create',$data);
    }

    public function cities(Request $request){
        $data=[];
        $cities=DB::table('indcity')->select('citname','citid');
        if($request->state_id && $request->state_id!=''){
            $cities->where('citstmid','=',$request->state_id);
        }
        $data['cities']=$cities->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('areas',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $this->validate($request,config('validation_rules.areas'));

        $area = Area::createArea($request->all());

        if (!$area) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'Area Added Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.areas.index');
        }
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
        $data=[];
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('areas',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $data['area']=Area::find($id);
        $data['states']=DB::table('indstate')
            ->lists('stmname','stmid');
        $data['cities']=[];
        return view('admin.pages.areas.create',$data);
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
        $logged_in_user=Sentinel::findById(Sentinel::getUser()->id);
        if(!in_array('areas',$logged_in_user->permissions) && Sentinel::getUser()->role==2){
            return back();
        }
        $this->validate($request,config('validation_rules.areas'));

        $area = Area::editArea($request->all(),$id);

        if (!$area) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'Area Edited Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.areas.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $area = Area::deleteArea($request->area_id);
        $data = [];
        if (!$area) {
            $data['status'] = false;
        } else {
            $data['status']=true;
        }
        return $data;
    }

    public function datatable(Request $request){
        // $areas=Area::select('areas.*','indstate.stmname as state','indcity.citname as city')
        //     ->leftJoin('indstate','indstate.stmid','=','areas.state_id')
        //     ->leftJoin('indcity','indcity.citid','=','areas.city_id');

        $areas=Area::select('*');

        return Datatables::of($areas)
            ->addColumn('name',function($areas){
                return ucwords($areas->name);
            })
            ->addColumn('state',function($areas){
                return ucwords($areas->state);
            })
            ->addColumn('city',function($areas){
                return ucwords($areas->city);
            })
            ->addColumn('country',function($areas){
                return ucwords($areas->country);
            })
            ->addColumn('action',function($areas){
                return '<ul class="actions_list ul_reset">
                            <li>
                                <a class="button red" href="' .URL::route('admin.areas.edit', $areas->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                            </li>
                            <li>
                                <button class="button delete" id="' . $areas->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </li>
                        </ul>';
            })
            ->make(true);
    }

    public function data(Request $request)
    {
        $data=[];

        $area=Area::select(DB::raw('concat(pincode,"-",name) as text'),'id');

        if(is_numeric($request->term)){
            $area->where('pincode','like',strval($request->term).'%');
        }else{
            $area->where('name','like',strval($request->term).'%');
        }
        $areas=$area->get();
        
        $data['items']=$areas->map(function($item,$key){
            $item->id=strval($item->id);
            $item->text=strval($item->text);
            return $item;
        });
        
        $data['incomplete_results']=false;
        
        $data['total_count']=count($data['items']);
        
        return $data;
    }
}
