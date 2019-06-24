<?php

namespace Msi\Falcon\Providers;

use Illuminate\Support\ServiceProvider;
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

        $this->loadRoutesFrom('../../routes/api.php');
    }
}
