<?php

namespace Msi\Falcon\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Msi\Falcon\Console\Commands\FalconCommand;

class FalconServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FalconCommand::class
            ]);
        }

        // overwrite database default in file /config/database.php
        Config::set('database.default', env('DB_CONNECTION', 'falcon'));

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }
}
