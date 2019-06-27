<?php

namespace Msi\Falcon\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
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
        // $this->mergeConfigFrom(__DIR__ . '/../../config/database.php', 'database');
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

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        $this->setupMigrations();

        $this->publishes([
            __DIR__.'/../../config/database.php' => config_path('database.php'),
        ], 'falcon-config');
        
        $this->publishes([
            __DIR__.'/../../database/migrations/create_users_table.php' => database_path('migrations/2019_06_26_000000_create_users_table.php'),
            __DIR__.'/../../database/migrations/create_sessions_table.php' => database_path('migrations/2019_06_26_000001_create_sessions_table.php'),
            __DIR__.'/../../database/migrations/create_logs_table.php' => database_path('migrations/2019_06_26_000002_create_logs_table.php'),
            __DIR__.'/../../database/migrations/create_settings_table.php' => database_path('migrations/2019_06_26_000003_create_settings_table.php'),
            __DIR__.'/../../database/migrations/create_applications_table.php' => database_path('migrations/2019_06_26_000004_create_applications_table.php'),
            __DIR__.'/../../database/migrations/create_companies_table.php' => database_path('migrations/2019_06_26_000005_create_companies_table.php'),
            __DIR__.'/../../database/migrations/create_departments_table.php' => database_path('migrations/2019_06_26_000006_create_departments_table.php'),
            __DIR__.'/../../database/migrations/create_roles_table.php' => database_path('migrations/2019_06_26_000007_create_roles_table.php'),
            __DIR__.'/../../database/migrations/create_user_has_roles_table.php' => database_path('migrations/2019_06_26_000008_create_user_has_roles_table.php'),
            __DIR__.'/../../database/migrations/create_permissions_table.php' => database_path('migrations/2019_06_26_000009_create_permissions_table.php'),
            __DIR__.'/../../database/migrations/create_role_has_permissions_table.php' => database_path('migrations/2019_06_26_000010_create_role_has_permissions_table.php'),
        ], 'falcon-migrations');

        Artisan::call('vendor:publish', ['--tag' => ['falcon-config', 'falcon-migrations']]);
    }

    public function setupMigrations()
    {
        $listFile = collect([
            'create_users_table.php',
            'create_sessions_table.php',
            'create_logs_table.php',
            'create_settings_table.php',
            'create_applications_table.php',
            'create_companies_table.php',
            'create_departments_table.php',
            'create_roles_table.php',
            'create_user_has_roles_table.php',
            'create_permissions_table.php',
            'create_role_has_permissions_table.php'
        ]);

        $pathMigrations = __DIR__.'/../../../../../database/migrations/';
        $fileMigrations = File::files($pathMigrations);

        foreach($fileMigrations as $file)
        {
            $pathinfo = pathinfo($file);
            $filename = $pathinfo['basename'];

            foreach($listFile as $name)
            {
                $allow = Str::contains($filename, $name);
                if ($allow) {
                    File::delete($pathMigrations.$filename);
                    break;
                }
            }
        }
    }

    public function setupConfig() {
        $listFile = collect([
            'database.php'
        ]);

        $pathConfig = __DIR__.'/../../../../../config/';
        $fileConfig = File::files($pathConfig);

        foreach($fileConfig as $file)
        {
            $pathinfo = pathinfo($file);
            $filename = $pathinfo['basename'];

            foreach($listFile as $name)
            {
                $allow = Str::contains($filename, $name);
                if ($allow) {
                    File::delete($pathConfig.$filename);
                    break;
                }
            }
        }
    }
}
