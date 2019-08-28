<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Admin\Task;
use App\Libraries\Api;
use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=[];
        if($request->token){

            $user = JWTAuth::toUser($request->token);
            //dd($user);

            $data['calendar']=Task::tasksBySalesPersonForMonth($user->id,$request->month);
            
        }
        $data['header']['Cache-Control'] = 'public, max-age= 86400';
        
        $now = time( );
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = $then;
        return Api::ApiResponse($data);
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
