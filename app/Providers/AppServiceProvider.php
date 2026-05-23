<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS khi dùng Ngrok hoặc production
        if ($this->app->environment('production') || request()->header('x-forwarded-proto') == 'https') {
            URL::forceScheme('https');
        }
        
        // Hoặc đơn giản hơn - force HTTPS khi KHÔNG phải local development
        // if (!$this->app->environment('local')) {
        //     URL::forceScheme('https');
        // }
    }
}