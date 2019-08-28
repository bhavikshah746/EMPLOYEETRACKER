<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Area;
use App\Models\Admin\Salesperson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class SalespersonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.salespersons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        $areas=Area::select('*')
            ->lists('name','id');
        $data['areas'] = $areas->map(function ($item, $key) {
            return ucwords($item);
        });
        return view('admin.pages.salespersons.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,config('validation_rules.salespersons'));

        $salesperson = Salesperson::createSalesperson($request->all());

        if (!$salesperson) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'SalesPerson Added Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.salespersons.index');
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
        $areas=Area::select('*')
            ->lists('name','id');
        $data['areas'] = $areas->map(function ($item, $key) {
            return ucwords($item);
        });

        $data['salesperson']=Salesperson::find($id);
        
        return view('admin.pages.salespersons.create',$data);
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
        $this->validate($request,config('validation_rules.salespersons'));

        $salesperson = Salesperson::editSalesperson($request->all(),$id);

        if (!$salesperson) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {
            Session::flash('message', 'SalesPerson Edited Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.salespersons.index');
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
        $salesperson=Salesperson::deleteSalesperson($request->salesperson_id);
        $data=[];
        if (!$salesperson) {
            $data['status'] = false;
        } else {
            $data['status']=true;
        }
        return $data;
    }

    public function datatable(Request $request){
        $salespersons=Salesperson::select('salespersons.*','areas.name as area_name')
            ->join('areas','areas.id','=','salespersons.area_id')
            ->where('areas.deleted_at','=',null);

        return Datatables::of($salespersons)
            ->addColumn('area_name',function($salespersons){
                return ucwords($salespersons->area_name);
            })
            ->addColumn('action',function($salespersons){
                return '<ul class="actions_list ul_reset">
                            <li>
                                <a class="button" title="Show Tasks" href="'.URL::route('admin.tasks.index',$salespersons->id).'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23 8c0 1.1-.9 2-2 2-.18 0-.35-.02-.51-.07l-3.56 3.55c.05.16.07.34.07.52 0 1.1-.9 2-2 2s-2-.9-2-2c0-.18.02-.36.07-.52l-2.55-2.55c-.16.05-.34.07-.52.07s-.36-.02-.52-.07l-4.55 4.56c.05.16.07.33.07.51 0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2c.18 0 .35.02.51.07l4.56-4.55C8.02 9.36 8 9.18 8 9c0-1.1.9-2 2-2s2 .9 2 2c0 .18-.02.36-.07.52l2.55 2.55c.16-.05.34-.07.52-.07s.36.02.52.07l3.55-3.56C19.02 8.35 19 8.18 19 8c0-1.1.9-2 2-2s2 .9 2 2z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a  class="button" title="Add Task" href="'.URL::route('admin.tasks.create',$salespersons->id).'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 3H3c-1.11 0-2 .89-2 2v12c0 1.1.89 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.11-.9-2-2-2zm0 14H3V5h18v12zm-5-7v2h-3v3h-2v-3H8v-2h3V7h2v3h3z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a class="button red" href="' .URL::route('admin.salespersons.edit', $salespersons->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                            </li>
                            <li>
                                <button class="button delete" id="' . $salespersons->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </li>
                        </ul>';
            })
            ->addColumn('name',function($salespersons){
                return ucwords($salespersons->name);
            })
            ->make(true);
    }
}
