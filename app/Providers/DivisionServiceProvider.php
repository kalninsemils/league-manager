<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Division;

class DivisionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Division', function ($app) {
            return new Division();
        });
    }
}
