<?php

namespace App\Providers;
use Auth;
use App\AdminNotification;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', function ($view) {

            //get request notification number on topnavber in all views
            if (Auth::check()) {
                $notifications = AdminNotification::where('status','0')->count();
                $allNotifications = AdminNotification::where('status','0')->latest()->take(10)->get();
                

                $view->with([
                    'notifications'=>$notifications,
                    'allNotifications'=>$allNotifications,
                ]);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
    }
}
