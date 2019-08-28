<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Admin\WebNotification;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SiteComposer 
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data=[];
        if( Sentinel::check()){
            $noti=WebNotification::select('*')
                ->where('to','=',Sentinel::getUser()->id)
                ->where('is_read','=',0)
                ->orderBy('created_at','desc')
                ->get();
            $data['noti_count']=count($noti);
            $data['notification']=WebNotification::select('*')
                ->where('to','=',Sentinel::getUser()->id)
                ->orderBy('created_at','desc')
                ->limit(config('site.noti_limit'))
                ->get();
            $data['logged_in_user']=Sentinel::findById(Sentinel::getUser()->id);
        }
        $view->with($data);
    }
}