<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        //
        //URL::forceRootUrl('http://localhost:8080/v4');
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme(config('app.scheme'));

    }
}
