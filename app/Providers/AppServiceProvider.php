<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('user_layout', function ($view) {
            $shared = [
                'layoutUserName' => session()->get('name_acoutn'),
                'layoutCartCount' => 0,
                'layoutNotificationCount' => 0,
            ];

            if (Auth::check() && Schema::hasTable('tbl_oder') && Schema::hasTable('tbl_order_main')) {
                $shared['layoutUserName'] = Auth::user()->name;
                $shared['layoutCartCount'] = (int) DB::table('tbl_oder')
                    ->where('oder_id_user', Auth::id())
                    ->where('oder_status', 2)
                    ->sum('oder_soluong');

                $shared['layoutNotificationCount'] = (int) DB::table('tbl_order_main')
                    ->where('user_id', Auth::id())
                    ->count();
            }

            $view->with($shared);
        });
    }
}
