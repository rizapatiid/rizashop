<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

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
         * =====================================================
         * FIX MySQL key too long (FreeSQLDatabase / MySQL lama)
         * =====================================================
         */
        Schema::defaultStringLength(191);

        /**
         * =====================================================
         * Locale & Timezone Indonesia
         * =====================================================
         */
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        /**
         * =====================================================
         * HTTPS HANDLING (LOCAL vs PRODUCTION)
         * =====================================================
         *
         * - Local  → HTTP (biar artisan serve aman)
         * - Railway / Production → HTTPS (hindari mixed content)
         */
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
