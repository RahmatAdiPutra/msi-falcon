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

        Config::set('auth.providers.users.model', \Msi\Falcon\Models\User::class);

        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        $this->publishes([
            __DIR__.'/../../config/database.php' => config_path('database.php'),
        ], 'falcon-config');
        
        $this->publishes([
            __DIR__.'/../../database/migrations/create_users_table.php' => database_path('migrations/2019_06_26_000000_create_users_table.php'),
            __DIR__.'/../../database/migrations/create_password_resets_table.php' => database_path('migrations/2019_06_26_000001_create_password_resets_table.php'),
            __DIR__.'/../../database/migrations/create_sessions_table.php' => database_path('migrations/2019_06_26_000002_create_sessions_table.php'),
            __DIR__.'/../../database/migrations/create_logs_table.php' => database_path('migrations/2019_06_26_100000_create_logs_table.php'),
            __DIR__.'/../../database/migrations/create_settings_table.php' => database_path('migrations/2019_06_26_100001_create_settings_table.php'),
            __DIR__.'/../../database/migrations/create_applications_table.php' => database_path('migrations/2019_06_26_200000_create_applications_table.php'),
            __DIR__.'/../../database/migrations/create_companies_table.php' => database_path('migrations/2019_06_26_200001_create_companies_table.php'),
            __DIR__.'/../../database/migrations/create_departments_table.php' => database_path('migrations/2019_06_26_200002_create_departments_table.php'),
            __DIR__.'/../../database/migrations/create_roles_table.php' => database_path('migrations/2019_06_26_200003_create_roles_table.php'),
            __DIR__.'/../../database/migrations/create_user_has_roles_table.php' => database_path('migrations/2019_06_26_200004_create_user_has_roles_table.php'),
            __DIR__.'/../../database/migrations/create_permissions_table.php' => database_path('migrations/2019_06_26_200005_create_permissions_table.php'),
            __DIR__.'/../../database/migrations/create_role_has_permissions_table.php' => database_path('migrations/2019_06_26_200006_create_role_has_permissions_table.php'),
        ], 'falcon-migrations');
    }
}
