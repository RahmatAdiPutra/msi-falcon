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
        $this->mergeConfigFrom(__DIR__ . '/../../config/falcon.php', 'falcon');
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
        // Config::set('database.default', env('DB_CONNECTION', 'falcon'));

        $this->publishes([
            __DIR__.'/../../config/falcon.php' => config_path('falcon.php'),
        ], 'config');

        // $this->publishes([
        //     __DIR__.'/../../database/migrations/create_newname_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_nename_table.php'),
        // ], 'migrations');

        // $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }
}
