<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Admin\WebNotification;
use Yajra\Datatables\Facades\Datatables;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.notifications.index');
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

    public function datatable(Request $request)
    {
        $noti=WebNotification::select('*')
            ->where('to','=',Sentinel::getUser()->id);

        return Datatables::of($noti)
            ->addColumn('body',function($noti){
                $str='<a href="'.URL::route($noti->route,'user_id='.$noti->from.'&id='.$noti->main_id.'&ref=noti&noti_id='.$noti->id).'" style="';
                if($noti->is_read==1){
                    $str=$str.'color:red';
                }
                $str=$str.'">'.$noti->body.'</a>';
                return $str;
            })
            ->make('true');
    }
}
