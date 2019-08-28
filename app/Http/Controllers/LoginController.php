<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;


class LoginController extends Controller
{
    
    public function __construct(){
        $this->middleware('guest',['except'=>['logout']]);
    }

    public function index()
    {
        return view('admin.pages.login.index');
    }

    public function store(Request $request)
    {

        $credentials=[
            'login'=>$request->login,
            'password'=>$request->password,

        ];

        $user=false;

        if($request->remember_me && $request->remember_me=='1'){
            $user=Sentinel::authenticateAndRemember($credentials);
        }else {
            $user = Sentinel::authenticate($credentials);
        }

        if(!$user){
            Session::flash('message','Username/Email or Password is Wrong');
            Session::flash('class','danger');
            return back();
        }else{
        	if($user->role!='1' && $user->role!='2'){
        		Sentinel::logout();
        		
	            Session::flash('message','Username/Email or Password is Wrong');
	            Session::flash('class','danger');
	            return back();
        	}
            // Session::flash('message','Successfully Logged In');
            // Session::flash('class','success');
            return redirect('/');
        }
    }

    public function logout(){
        Sentinel::logout();
        Session::flash('message','Successfully Logged Out');
        Session::flash('class','success');

        return redirect()->route('login');
    }

}
