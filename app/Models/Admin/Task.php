<?php

namespace App\Models\Admin;

use App\Target;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token', 'created_at', 'deleted_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public static function createTask($inputs)
    {
        $task = new Task($inputs);
        return $task->save();
    }

    public static function editTask($inputs, $id)
    {
        $task = Task::find($id);
        return $task->update($inputs);
    }

    public static function deleteTask($id)
    {
        $task = Task::find($id);
        return $task->delete();
    }

    public static function tasksBySalesPerson($id, $offset = 0, $day, $next_days = 0, $previous_days = 0)
    {
        $tasks = Task::select('tasks.*', 'users.first_name as first_name', 'users.last_name as last_name', DB::raw('date(date_time) as date'), DB::raw('time_format(time(date_time),"%r") as time'), 'areas.name as place', 'companies.name as company_name', 'companies.consunt_name', 'companies.client_name', 'companies.mobile', 'companies.landline', 'companies.email', 'companies.address', 'companies.pancard', 'companies.latitude as company_latitude', 'companies.longitude as company_longitude')
            ->join('users', 'users.id', '=', 'tasks.salesperson_id')
            ->join('companies', 'companies.id', '=', 'tasks.company_id')
            ->join('areas', 'areas.id', '=', 'companies.area_id')
            ->where('users.deleted_at', '=', null)
            ->where('companies.deleted_at', '=', null)
            ->where('areas.deleted_at', '=', null)
            ->where('salesperson_id', '=', $id);

        if ($day == '' || $day == null) {
            $day = date('Y-m-d');
        }

        if ($next_days != 0) {
            $tasks->where(DB::raw('date(date_time)'), '>=', $day)
                ->where(DB::raw('date(date_time)'), '<=', date('Y-m-d', strtotime('+' . $next_days . ' days')));
        } else if ($previous_days != 0) {
            $tasks->where(DB::raw('date(date_time)'), '<=', $day)
                ->where(DB::raw('date(date_time)'), '>=', date('Y-m-d', strtotime('+' . $previous_days . ' days')));
        } else if ($next_days == 0 && $previous_days == 0) {
            $tasks->where(DB::raw('date(date_time)'), '=', $day);
        } else {
            $tasks->where(DB::raw('date(date_time)'), '<=', date('Y-m-d', strtotime('+' . $next_days . ' days')))
                ->where(DB::raw('date(date_time)'), '>=', date('Y-m-d', strtotime('+' . $previous_days . ' days')));
        }

        return $tasks->skip($offset)
            ->take(config('site.api_limit'))
            ->get();
    }

    public static function taskById($id)
    {
        $tasks = Task::select('tasks.*', 'users.first_name as first_name', 'users.last_name as last_name', DB::raw('date(date_time) as date'), DB::raw('time_format(time(date_time),"%r") as time'), 'areas.name as place', 'companies.name as company_name', 'companies.consunt_name', 'companies.client_name', 'companies.mobile', 'companies.landline', 'companies.email', 'companies.address', 'companies.pancard', 'companies.latitude as company_latitude', 'companies.longitude as company_longitude')
            ->leftJoin('users', 'users.id', '=', 'tasks.salesperson_id')
            ->leftJoin('areas', 'areas.id', '=', 'users.area_id')
            ->leftJoin('companies', 'companies.id', '=', 'tasks.company_id')
            ->where('tasks.id', '=', $id)
            ->where('users.deleted_at', '=', null)
            ->where('companies.deleted_at', '=', null)
            ->where('areas.deleted_at', '=', null)
            ->first();

        return $tasks;
    }

    public static function tasksBySalesPersonForMonth($user_id, $month)
    {
        list($month0, $year) = explode('-', $month);
        $tasks = Task::select(DB::raw('date(date_time) as date'), DB::raw('count(id) as tasks'))
            ->where(DB::raw('month(date_time)'), '=', $month0)
            ->where(DB::raw('year(date_time)'), '=', $year)
            ->where('salesperson_id', '=', $user_id)
            ->groupBY(DB::raw('date(date_time)'))
            ->lists('tasks', 'date');

        $orders = Order::select('date', DB::raw('count(id) as orders'))
            ->where(DB::raw('month(date)'), '=', $month0)
            ->where(DB::raw('year(date)'), '=', $year)
            ->where('created_by', '=', $user_id)
            ->groupBY('date')
            ->lists('orders', 'date');


        $calendar = [];
        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, $month0, $year); $i++) {
            $task = 0;
            $order = 0;
            $date = date_format(date_create($year . '-' . $month0 . '-' . $i), 'Y-m-d');
            $ords = Order::where(DB::raw('date(date)'), '=', $date)->get();
            $tsks = Task::where(DB::raw('date(date_time)'), '=', $date)->get();
            $calendar[$date] = [
                'tasks' => $tsks->count(),
                'orders' => $ords->count()
            ];

            /*if( isset($tasks[$date]) && isset($orders[$date]) ){
               // dd($tasks[$date]);
                $task=$tasks[$date];
                $order=$orders[$date];
            }
            else if( isset($tasks[$date]) && !isset($orders[$date]) ){
                //dd($tasks[$date]);
                $task=$tasks[$date];
            }else if( !isset($tasks[$date]) && isset($orders[$date]) ){
                //dd($tasks[$date]);
                $order=$orders[$date];
            }*/


        }


        return $calendar;
    }

    public static function getTaskCount($id, $type, $month)
    {
        list($month, $year) = explode('-', $month);
        $task = [];
        if ($type == 'month') {
            $tasks = Task::select(DB::raw('month(date_time) as month'), DB::raw('count(id) as tasks'))
                ->where('salesperson_id', '=', $id)
                ->where(DB::raw('year(date_time)'), '=', $year)
                ->groupBY(DB::raw('month(date_time)'))
                ->lists('tasks', 'month');
            for ($i = 1; $i <= 12; $i++) {
                if (isset($tasks[$i])) {
                    $task[$i] = $tasks[$i];
                } else {
                    $task[$i] = 0;
                }
            }
        } else if ($type == 'week') {
            $tasks = Task::select(DB::raw('week(date_time) as day'), DB::raw('count(id) as tasks'))
                ->where('salesperson_id', '=', $id)
                ->where(DB::raw('month(date_time)'), '=', $month)
                ->where(DB::raw('year(date_time)'), '=', $year)
                ->groupBY(DB::raw('week(date_time)'))
                ->lists('tasks', 'day');

            $last_day_of_month = date("Y-m-t", strtotime($year . '-' . $month . '-2'));

            $first_week_number = date("W", strtotime($year . '-' . $month . '-2'));

            $last_week_number = date("W", strtotime($last_day_of_month));


            for ($i = $first_week_number; $i <= $last_week_number; $i++) {
                if (isset($tasks[$i])) {
                    $task[$i] = $tasks[$i];
                } else {
                    $task[$i] = 0;
                }
            }

        } else if ($type == 'day') {
            $tasks = Task::select(DB::raw('day(date_time) as day'), DB::raw('count(id) as tasks'))
                ->where('salesperson_id', '=', $id)
                ->where(DB::raw('month(date_time)'), '=', $month)
                ->where(DB::raw('year(date_time)'), '=', $year)
                ->groupBY(DB::raw('day(date_time)'))
                ->lists('tasks', 'day');

            for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, intval($month), $year); $i++) {
                if (isset($tasks[$i])) {
                    $task[$i] = $tasks[$i];
                } else {
                    $task[$i] = 0;
                }
            }
        }
        return $task;

    }
}
