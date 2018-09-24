<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Team;

class TeamServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Team', function ($app) {
            return new Team();
        });
    }
}
