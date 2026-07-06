<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install S-Cart';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Are you sure you want to install S-Cart?')) {   
            $this->info('Installing S-Cart...');
            //Check command gp247:core-install is exist  
            if (array_key_exists('gp247:core-install', Artisan::all())) {
                $this->info(' - Installing Core...');
                $this->call('gp247:core-install', ['--force' => 1]);
            }
            //Check command gp247:front-install is exist
            if (array_key_exists('gp247:front-install', Artisan::all())) {
                $this->info(' - Installing Front...');
                $this->call('gp247:front-install');
            }

            //Check command gp247:shop-install is exist
            if (array_key_exists('gp247:shop-install', Artisan::all())) {
                $this->info('Installing Shop...');
                $this->call('gp247:shop-install');
            }

            $this->info('S-Cart installed successfully');
        }
    }
}
