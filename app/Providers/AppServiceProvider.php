<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
        URL::forceScheme('https');

        view()->composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Schema::hasTable('regions')) {
                $view->with('globalRegions', \App\Models\Region::where('status', true)->get());
            }
        });
    }
}
