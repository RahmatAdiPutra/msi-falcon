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
        $this->mergeConfigFrom(__DIR__ . '/../../config/database.php', 'database');
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
            __DIR__.'/../../config/database.php' => base_path('config/database.php'),
        ], 'config');

        // $this->publishes([
        //     __DIR__.'/../../database/migrations/create_newname_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_nename_table.php'),
        // ], 'migrations');
        
        // $this->publishes([
        //     __DIR__ . '/../../config' => base_path('config')
        // ], 'config');

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }
}
