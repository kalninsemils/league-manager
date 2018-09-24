<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\League;

class LeagueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('League', function ($app) {
            return new League();
        });
    }
}
