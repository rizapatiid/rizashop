<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        // ✅ Fix MySQL key too long (FreeSQLDatabase / MySQL lama)
        Schema::defaultStringLength(191);

        // ✅ Locale Indonesia
        Carbon::setLocale('id');

        // ✅ Timezone WIB Jakarta
        date_default_timezone_set('Asia/Jakarta');
    }
}
