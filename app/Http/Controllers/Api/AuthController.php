<?php

namespace App\Http\Controllers\Api;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Libraries\Api;
use App\Models\Admin\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        if ($request->token) {

            $user = JWTAuth::toUser($request->token);
            $attendance = DB::table('attendence')
                ->where('user_id', '=', $user->id)
                ->where('end_time', '=', '')->update(['end_time' => date('Y-m-d H:i:s')]);;
                if($attendance){
                    return Api::ApiResponse('Logged out success');
                } else {
                    return Api::ApiResponse($attendance);
                }

        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = Sentinel::authenticate($credentials);

        if (!$user || $user->deleted_at != null) {
            $data['errors'] = 'Please Enter Correct User Name/ Password.';
            $data['statusCode'] = '404';
        } else {
            if ($request->gcm_id && $request->gcm_id != '' && $request->gcm_id != null) {
                $user = User::find($user->id);
                $user->gcm_id = $request->gcm_id;
                $user->save();
            }
            $data['token'] = JWTAuth::fromUser($user);
        }

        $data['header']['Cache-Control'] = 'public, max-age= 86400';

        $now = time();
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = 0;
        return Api::ApiResponse($data);


    }

    public function admin_login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $credentials['role'] = 2;

        $user = Sentinel::authenticate($credentials);

        if (!$user || $user->deleted_at != null) {
            $data['errors'] = 'Please Enter Correct User Name/ Password.';
            $data['statusCode'] = '404';
            $statusCode = 404;
        } else {
            if ($request->gcm_id && $request->gcm_id != '' && $request->gcm_id != null) {
                $user = User::find($user->id);
                $user->gcm_id = $request->gcm_id;
                $user->save();
            }
            $statusCode = 200;
            $data['token'] = JWTAuth::fromUser($user);
        }

        $data['header']['Cache-Control'] = 'public, max-age= 86400';

        $now = time();
        $then = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $now + 86440);
        $data['header']['Expires'] = 0;
        return Api::ApiResponse($data,$statusCode);


    }
}
