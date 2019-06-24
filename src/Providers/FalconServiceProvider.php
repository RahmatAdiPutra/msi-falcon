<?php

namespace Msi\Falcon;

use Illuminate\Support\ServiceProvider;
use Msi\Falcon\Commands\FalconCommand;

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

        $this->loadRoutesFrom(__DIR__.'../../routes/api.php');
    }
}
