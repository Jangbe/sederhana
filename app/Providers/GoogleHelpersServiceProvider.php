<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleHelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        return require_once app_path(). '/Helpers/GoogleHelpers.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
