<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token', 'created_at', 'deleted_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    public static function createOrder($inputs)
    {
        $order = new Order($inputs);
        if (!$order->save()) {
            return false;
        } else {
            return $order;
        }
    }

    public static function orderBySalesperson($id, $offset = 0, $day, $next_days = 0, $previous_days = 0)
    {
      //  dd($id);

        $orders = Order::select('orders.*', 'papers.name as paper', 'designs.name as design', 'areas.name as place', 'companies.name as company_name', 'companies.consunt_name', 'companies.client_name', 'companies.mobile', 'companies.landline', 'companies.email', 'companies.address', 'companies.pancard', 'companies.latitude as company_latitude', 'companies.longitude as company_longitude', 'orders.created_at as punched_at','categories.name as product_category')
            ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('categories', 'categories.id', '=', 'order_details.product_categories')
            ->leftJoin('papers', 'papers.id', '=', 'order_details.paper_id')
            ->leftJoin('designs', 'designs.id', '=', 'order_details.design_id')
            ->leftJoin('companies', 'companies.id', '=', 'orders.client_id')
            ->leftJoin('areas', 'areas.id', '=', 'companies.area_id')
            ->where('order_details.deleted_at', '=', null)
            ->where('categories.deleted_at', '=', null)
            ->where('papers.deleted_at', '=', null)
            ->where('designs.deleted_at', '=', null)
            ->where('companies.deleted_at', '=', null)
            ->where('areas.deleted_at', '=', null)
            ->where('orders.created_by', '=', $id);
            $orders->where(DB::raw('date(date)'), '=', $day);
         



        return $orders->skip($offset)
            ->take(config('site.api_limit'))
            ->get();
    }

    public static function orderById($id)
    {
        $order = Order::select('orders.*', 'categories.name as product_category', 'papers.name as paper', 'designs.name as design', 'areas.name as place', 'companies.name as company_name', 'companies.consunt_name', 'companies.client_name', 'companies.mobile', 'companies.landline', 'companies.email', 'companies.address', 'companies.pancard', 'companies.latitude as company_latitude', 'companies.longitude as company_longitude', 'orders.created_at as punched_at')
            ->where('orders.id', '=', $id)
            ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('categories', 'categories.id', '=', 'order_details.product_categories')
            ->leftJoin('papers', 'papers.id', '=', 'order_details.paper_id')
            ->leftJoin('designs', 'designs.id', '=', 'order_details.design_id')
            ->leftJoin('companies', 'companies.id', '=', 'orders.client_id')
            ->leftJoin('areas', 'areas.id', '=', 'companies.area_id')
            ->where('order_details.deleted_at', '=', null)
            ->where('categories.deleted_at', '=', null)
            ->where('papers.deleted_at', '=', null)
            ->where('designs.deleted_at', '=', null)
            ->where('companies.deleted_at', '=', null)
            ->where('areas.deleted_at', '=', null)
            ->first();
        return $order;
    }

    public static function orderCount($id, $year)
    {
        list($month, $year) = explode('-', $year);
        $orders = Order::select(DB::raw('day(date) as month'), DB::raw('count(id) as orders'))
            ->where('created_by', '=', $id)
            ->where(DB::raw('month(date)'), '=', $month)
            ->where(DB::raw('year(date)'), '=', $year)
            ->groupBY(DB::raw('day(date)'))
            ->lists('orders', 'month');
        $order = [];
        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, intval($month), $year); $i++) {
            if (isset($orders[$i])) {
                $order[$i] = $orders[$i];
            } else {
                $order[$i] = 0;
            }
        }
        return $order;
    }

}
