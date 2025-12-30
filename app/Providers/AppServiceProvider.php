<?php

namespace App\Providers;

use App\Models\country;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(200);

        // Har view ke liye countries share karna
        View::composer('*', function ($view) {
            $view->with('countries', country::where('status', '=', 'active')->get());
        });
    }
}
