<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Admin\WebNotification;
use Illuminate\Http\Request;

class Notification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->ref && $request->noti_id && $request->ref=='noti' && $request->noti_id!=''){
            $noti=WebNotification::readNotification($request->noti_id);
        }
        return $next($request);
    }
}
