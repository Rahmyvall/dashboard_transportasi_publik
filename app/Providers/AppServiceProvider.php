<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Alert;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Pagination Bootstrap Style
         */
        Paginator::useBootstrap();



        /**
         * Global Notification Data
         *
         * Digunakan oleh:
         * - Admin Layout
         * - Dashboard
         * - Navbar Notification
         */
        View::composer('*', function ($view) {


            // Ambil 5 notifikasi terbaru yang aktif
            $notifications = Alert::published()
                ->latest()
                ->limit(5)
                ->get();



            // Total notifikasi aktif
            $notificationCount = Alert::published()
                ->count();



            $view->with([

                'notifications' => $notifications,

                'notificationCount' => $notificationCount,

            ]);
        });
    }
}
