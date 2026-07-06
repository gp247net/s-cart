<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
class Sample extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:sample';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install S-Cart Sample';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Are you sure you want to install S-Cart Sample?')) {   
            $this->info('Installing S-Cart Sample...');
            //Check command gp247:shop-sample is exist
            if (array_key_exists('gp247:shop-sample', Artisan::all())) {
                $this->info('Installing Shop Sample...');
                $this->call('gp247:shop-sample');
            }
            $this->info('S-Cart Sample installed successfully');
        }
    }
}
