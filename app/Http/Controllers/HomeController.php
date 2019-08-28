<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests;
use App\Models\Admin\Attendence;
use App\Models\Admin\User;
use App\Models\Admin\UserSalesperson;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['attendence']=Attendence::select('*')
            ->where('day','=',date('Y-m-d'))
            ->where('user_id','=',Sentinel::getUser()->id)
            ->first();

        $user_id=Sentinel::getUser()->id;

        $user=Sentinel::findById($user_id);

        if($user!=null && $user->role==2){

            $usersList=UserSalesperson::select('*')
                ->where('admin_id','=',$user_id)
                ->lists('salesperson_id');

            $data['salespersons']=User::select(DB::raw('concat(first_name," ",last_name) as name'),'id')
                ->whereIn('id',$usersList)
                ->where('role','=',3)
                ->lists('name','id');

        }else{
            $data['salespersons']=User::select(DB::raw('concat(first_name," ",last_name) as name'),'id')
                ->where('role','=',3)
                ->lists('name','id');
        }

        $months=[];
        
        $x = 1;
    
        while($x <= 12) {
            $MonthNumbers[] = $x;
            $x++;
        }
            
        foreach ($MonthNumbers as $MonthNumber) {
            $months[$MonthNumber] = date('F', mktime(0, 0, 0, $MonthNumber, 10)); 
        }
        $data['months']=$months;

        $data['years']=array_combine(range(date("Y"), 2016), range(date("Y"), 2016));

        return view('admin.pages.home.index',$data);
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
