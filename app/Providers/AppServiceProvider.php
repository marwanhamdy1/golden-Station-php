<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // Set timezone from settings table if available
        try {
            $timezone = cache()->rememberForever('app_timezone', function() {
                return DB::table('settings')->where('key', 'timezone')->value('value');
            });
            if ($timezone) {
                Config::set('app.timezone', $timezone);
                date_default_timezone_set($timezone);
            }
        } catch (\Exception $e) {
            // If settings table doesn't exist yet, fallback to config/app.php
        }
    }
}
