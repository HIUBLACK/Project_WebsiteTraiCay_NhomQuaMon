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
                'layoutUnreadAdminMessages' => 0,
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

                if (Schema::hasTable('tbl_messages')) {
                    $shared['layoutUnreadAdminMessages'] = (int) DB::table('tbl_messages')
                        ->where('user_id', Auth::id())
                        ->where('sender_type', 'admin')
                        ->where('is_read', false)
                        ->count();
                }
            }

            $view->with($shared);
        });

        View::composer('admin_layout', function ($view) {
            $shared = [
                'layoutAdminUnreadMessages' => 0,
                'layoutAdminLatestMessages' => collect(),
            ];

            if (Session()->has('admin_id') && Schema::hasTable('tbl_messages')) {
                $shared['layoutAdminUnreadMessages'] = (int) DB::table('tbl_messages')
                    ->where('sender_type', 'user')
                    ->where('is_read', false)
                    ->count();

                $latestMessageSub = DB::table('tbl_messages')
                    ->select('user_id', DB::raw('MAX(message_id) as latest_message_id'))
                    ->groupBy('user_id');

                $shared['layoutAdminLatestMessages'] = DB::table('users')
                    ->joinSub($latestMessageSub, 'latest_conversations', function ($join) {
                        $join->on('users.id', '=', 'latest_conversations.user_id');
                    })
                    ->join('tbl_messages', 'tbl_messages.message_id', '=', 'latest_conversations.latest_message_id')
                    ->leftJoin(DB::raw('(SELECT user_id, COUNT(*) as unread_count FROM tbl_messages WHERE sender_type = "user" AND is_read = 0 GROUP BY user_id) unread_stats'), 'users.id', '=', 'unread_stats.user_id')
                    ->select(
                        'users.id',
                        'users.name',
                        'tbl_messages.message_text',
                        'tbl_messages.created_at',
                        DB::raw('COALESCE(unread_stats.unread_count, 0) as unread_count')
                    )
                    ->orderByDesc('tbl_messages.created_at')
                    ->limit(5)
                    ->get();
            }

            $view->with($shared);
        });
    }
}
