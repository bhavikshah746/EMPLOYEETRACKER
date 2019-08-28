<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class SiteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		view()->composer(
            '*', 'App\ViewComposers\SiteComposer'
        ); 
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
