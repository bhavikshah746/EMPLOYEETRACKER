<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Api;
use App\Models\Admin\Area;
use App\Models\Admin\Company;
use App\Models\Admin\Expance;
use App\Models\Admin\Order;
use App\Models\Admin\Task;
use App\Models\Admin\User;
use App\Models\Admin\UserArea;
use App\Models\Admin\UserSalesperson;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
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
    public function index(Request $request)
    {
        $data = [];
        if ($request->admin_mode == true) {
            $data['admin_mode'] = true;
        }
        return view('admin.pages.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        // $areas=Area::select('*',DB::raw('concat(pincode,"-",name) as name'))
        //     ->lists('name','id');
        // $data['areas'] = $areas->map(function ($item, $key) {
        //     return ucwords($item);
        // });
        $data['types'] = config('site.salesperson_types');
        return view('admin.pages.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->role == '3' || $request->role == '2') {
            $this->validate($request, config('validation_rules.salesperson_create'));
        } else {
            $this->validate($request, config('validation_rules.users_saving'));
        }

        $inputs = $request->all();

        $areas = [];
        if (isset($inputs['area_id'])) {
            $areas = $inputs['area_id'];

            unset($inputs['area_id']);
        }

        $salespersons = [];
        if (isset($inputs['salesperson_id'])) {
            $salespersons = $inputs['salesperson_id'];

            unset($inputs['salesperson_id']);
        }

        $user = Sentinel::registerAndActivate($inputs);

        if (!$user) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {

            foreach ($areas as $key => $value) {
                $input = [];
                $input['user_id'] = $user->id;
                $input['area_id'] = $value;
                $userAreas = new UserArea($input);
                $userAreas->save();
            }

            foreach ($salespersons as $key => $value) {
                $input = [];
                $input['admin_id'] = $user->id;
                $input['salesperson_id'] = $value;
                $usersSalesperson = new UserSalesperson($input);
                $usersSalesperson->save();
            }

            Session::flash('message', 'User Added Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = [];

        $data['user'] = Sentinel::findById($id);

        $data['areasUsers'] = UserArea::select('*')
            ->where('user_id', '=', $id)
            ->lists('area_id')->toArray();

        $salespersonAreas = UserArea::select('*')
            ->whereIn('area_id', $data['areasUsers'])
            ->lists('user_id');

        $data['userssalesperson'] = UserSalesperson::select('*')
            ->where('admin_id', '=', $id)
            ->lists('salesperson_id')->toArray();

        $salesperson_list = UserSalesperson::select('*')
            ->where('admin_id', '=', Sentinel::getUser()->id)
            ->lists('salesperson_id')->toArray();

        $data['salespersons'] = User::select('*', DB::raw('concat(first_name," ",last_name) as name'))
            ->where('role', '=', 3)
            ->whereIn('id', $salespersonAreas)
            ->lists('name', 'id')->toArray();

        $areas = Area::select('*', DB::raw('concat(pincode,"-",name) as name'))
            ->whereIn('id', $data['areasUsers'])
            ->lists('name', 'id');

        $data['areas'] = $areas->map(function ($item, $key) {
            return ucwords($item);
        });

        $data['types'] = config('site.salesperson_types');

        $logged_in_user = Sentinel::findById(Sentinel::getUser()->id);

        if (Sentinel::getUser()->role == 2 && !in_array('users', $logged_in_user->permissions)) {
            $status = false;
            if ($id != Sentinel::getUser()->id && $data['user']->role == 2) {
                $status = true;
            } else {
                if (!in_array($id, $salesperson_list)) {
                    $status = true;
                }
            }
            if ($status) {
                Session::flash('message', 'You Doesn\'t have Authorization For Accessing this Account');
                Session::flash('class', 'danger');
                return redirect()->route('admin.users.index');
            }
        }

        return view('admin.pages.users.create', $data);
    }

    public function profile()
    {
        $id = Sentinel::getUser()->id;
        $data = [];

        $data['user'] = User::find($id);

        $data['areasUsers'] = UserArea::select('*')
            ->where('user_id', '=', $id)
            ->lists('area_id')->toArray();

        $salespersonAreas = UserArea::select('*')
            ->whereIn('area_id', $data['areasUsers'])
            ->lists('user_id');

        $data['userssalesperson'] = UserSalesperson::select('*')
            ->where('admin_id', '=', $id)
            ->lists('salesperson_id')->toArray();

        $data['salespersons'] = User::select('*', DB::raw('concat(first_name," ",last_name) as name'))
            ->where('role', '=', 3)
            ->whereIn('id', $salespersonAreas)
            ->lists('name', 'id')->toArray();

        $areas = Area::select('*', DB::raw('concat(pincode,"-",name) as name'))
            ->whereIn('id', $data['areasUsers'])
            ->lists('name', 'id');

        $data['areas'] = $areas->map(function ($item, $key) {
            return ucwords($item);
        });

        $data['types'] = config('site.salesperson_types');

        $data['page'] = 'profile';

        return view('admin.pages.users.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, User::validationRule($request->role, $id));
        // if($request->role=='3' || $request->role=='2'){
        //     $this->validate($request, config('validation_rules.salesperson_edit'));
        // }else{
        //     $this->validate($request, config('validation_rules.users_edit'));
        // }

        $inputs = $request->all();

        $permissions = [];

        if (isset($inputs['permissions'])) {
            $permissions = $inputs['permissions'];
        }

        $user_pass = Sentinel::findById($id);
        $credentials = [
            'permissions' => $permissions,
        ];

        $user_pass = Sentinel::update($user_pass, $credentials);

        $password = $inputs['password'];
        if ($password != '') {
            $user_pass = Sentinel::findById($id);
            $credentials = [
                'password' => $password,
            ];

            $user_pass = Sentinel::update($user_pass, $credentials);
        }

        unset($inputs['permissions']);
        unset($inputs['password']);
        unset($inputs['password_confirmation']);

        $areas = [];
        if (isset($inputs['area_id'])) {
            $areas = $inputs['area_id'];

            unset($inputs['area_id']);
        }

        $salespersons = [];
        if (isset($inputs['salesperson_id'])) {
            $salespersons = $inputs['salesperson_id'];

            unset($inputs['salesperson_id']);
        }
        $user = User::updateUser($inputs, $id);

        if (!$user) {
            Session::flash('message', 'Something Went Wrong');
            Session::flash('class', 'danger');
            return back();
        } else {

            $oldAreas = UserArea::select('*')
                ->where('user_id', '=', $id)
                ->delete();

            $oldSalesperson = UserSalesperson::select('*')
                ->where('admin_id', '=', $id)
                ->delete();

            if ($request->role != '2' && $request->role != '1' && $user->gcm_id != '') {
                $data_notification = ['page' => 'clients'];
                $notification = Api::firebaseNotification('Area Change', 'Admin Has Changed Area Please Check It Out!',
                    $user->gcm_id, $data_notification, $id);
            }

            foreach ($areas as $key => $value) {
                $input = [];
                $input['user_id'] = $user->id;
                $input['area_id'] = $value;
                $userAreas = new UserArea($input);
                $userAreas->save();
            }

            foreach ($salespersons as $key => $value) {
                $input = [];
                $input['admin_id'] = $user->id;
                $input['salesperson_id'] = $value;
                $usersSalesperson = new UserSalesperson($input);
                $usersSalesperson->save();
            }
            Session::flash('message', 'User Edited Successfully');
            Session::flash('class', 'success');
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatable(Request $request)
    {
        $users = User::select('*');
        if (Sentinel::getUser()->role == 2 && !$request->admin_mode && $request->admin_mode != true) {
            $userList = UserSalesperson::select('*')
                ->where('admin_id', '=', Sentinel::getUser()->id)
                ->lists('salesperson_id');

            $users->whereIn('id', $userList)
                ->where('role', '=', 3);
        }

        return Datatables::of($users)
            ->addColumn('role', function ($users) {
                return config('site.user_roles')[$users->role];
            })
            ->addColumn('action', function ($users) {
                $str = '<ul class="actions_list ul_reset">';
                if ($users->role == '3') {
                    $str = $str . '<li>
                                <a class="button" title="Show Tasks" href="' . URL::route('admin.tasks.datatable',
                            'user_id=' . $users->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23 8c0 1.1-.9 2-2 2-.18 0-.35-.02-.51-.07l-3.56 3.55c.05.16.07.34.07.52 0 1.1-.9 2-2 2s-2-.9-2-2c0-.18.02-.36.07-.52l-2.55-2.55c-.16.05-.34.07-.52.07s-.36-.02-.52-.07l-4.55 4.56c.05.16.07.33.07.51 0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2c.18 0 .35.02.51.07l4.56-4.55C8.02 9.36 8 9.18 8 9c0-1.1.9-2 2-2s2 .9 2 2c0 .18-.02.36-.07.52l2.55 2.55c.16-.05.34-.07.52-.07s.36.02.52.07l3.55-3.56C19.02 8.35 19 8.18 19 8c0-1.1.9-2 2-2s2 .9 2 2z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a  class="button taskCreate" id="' . $users->id . '" title="Add Task"  data-popup="create_task" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 3H3c-1.11 0-2 .89-2 2v12c0 1.1.89 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.11-.9-2-2-2zm0 14H3V5h18v12zm-5-7v2h-3v3h-2v-3H8v-2h3V7h2v3h3z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a class="button" title="Show Expenses" href="' . URL::route('admin.expance.index',
                            $users->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a class="button map_show" title="Show map_show"  id="' . $users->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                </a>
                            </li>';
                }

                $str = $str . '<li>
                                <a class="button red" href="' . URL::route('admin.users.edit', $users->id) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                            </li>
                            <li>
                                <button class="button delete" id="' . $users->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </li>
                        </ul>';

                return $str;
            })
            ->make(true);
    }

    public function delete(Request $request)
    {
        $user = User::deleteUser($request->user_id);
        $data = [];
        if (!$user) {
            $data['status'] = false;
        } else {
            $data['status'] = true;
        }
        return $data;
    }

    public function getCompanies(Request $request)
    {
        $area_ids = UserArea::select('*')
            ->where('user_id', '=', $request->user_id)
            ->lists('area_id');

        $company = Company::select('*')
            ->whereIn('area_id', $area_ids)
            ->orderBy('name', 'asc')
            ->get();

        $data = [];

        $data['companies'] = $company;

        return $data;
    }

    public function getSalesperson(Request $request)
    {
        $data = [];
        $users_list = UserArea::select('*')
            ->whereIn('area_id', $request->area_id)
            ->lists('user_id');
        $users = User::select('*', DB::raw('concat(first_name," ",last_name) as name'))
            ->whereIn('id', $users_list)
            ->where('role', '=', 3)
            ->get();
        $data['salesperson'] = $users;
        return $data;
    }

    public function getUsersData(Request $request)
    {
        $data = [];

        $data['tasks'] = Task::getTaskCount($request->user_id, 'day', $request->month . '-' . $request->year);

        foreach ($data['tasks'] as $key => $value) {
            if ($value == 0) {
                unset($data['tasks'][$key]);
            }
        }

        $data['orders'] = Order::orderCount($request->user_id, $request->month . '-' . $request->year);

        foreach ($data['orders'] as $key => $value) {
            if ($value == 0) {
                unset($data['orders'][$key]);
            }
        }

        $data['expances'] = Expance::expanceCount($request->user_id, $request->month . '-' . $request->year);

        $expences = [];
        foreach ($data['expances'] as $key => $value) {
            $expences[$value->subject] = $value->price;
        }

        $data['expances'] = $expences;

        return $data;
    }
}
