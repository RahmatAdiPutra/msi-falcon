<?php

namespace Msi\Falcon\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class FalconCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'falcon:start {connection : Choose connection for migrate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("testing");
        exec("java --version", $output, $ret);
        $this->line($output);
        $this->line($ret);
        
        if ($this->argument('connection')) {
            $this->line($this->argument('connection'));
        }

        if ($this->setupConfig()) {
            $this->line('Setup config successfully');
            Artisan::call('vendor:publish', ['--tag' => ['falcon-config']]);
        }

        if ($this->setupMigrations()) {
            $this->line('Setup migrations successfully');
            Artisan::call('vendor:publish', ['--tag' => ['falcon-migrations']]);
        }
    }

    public function setupConfig()
    {
        $result = false;

        $listFile = collect([
            'database.php'
        ]);

        $pathConfig = __DIR__.'/../../../../../../config/';
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
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    public function setupMigrations()
    {
        $result = false;

        $listFile = collect([
            'create_users_table.php',
            'create_password_resets_table.php',
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

        $pathMigrations = __DIR__.'/../../../../../../database/migrations/';
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
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }
}
