<?php

namespace App\Providers;

use App\Models\UmkmProfile;
use App\Observers\UmkmProfileObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register UmkmProfile observer for auto-generating SEO
        UmkmProfile::observe(UmkmProfileObserver::class);
    }
}
