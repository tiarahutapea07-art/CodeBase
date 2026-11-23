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
        // Paksa semua URL & form action menggunakan HTTPS jika diakses lewat proxy/ngrok
        if (str_contains(request()->getHost(), 'ngrok') || $this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
