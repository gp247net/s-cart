<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update S-Cart';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Updating S-Cart...');
        // Code handle update

        // Update package
        $this->handleUpdate();
        $this->info('S-Cart updated successfully');
    }

    public function handleUpdate()
    {
        // Get all available commands
        $commands = Artisan::all();
        
        // Update GP247
        // check command gp247:core-update is exist
        if (array_key_exists('gp247:core-update', $commands)) {
            $this->info('Updating Core...');
            $this->call('gp247:core-update');
        }
        // Update Front
        if (array_key_exists('gp247:front-update', $commands)) {
            $this->info('Updating Front...');
            $this->call('gp247:front-update');
        }
        // Update Shop
        if (array_key_exists('gp247:shop-update', $commands)) {
            $this->info('Updating Shop...');
            $this->call('gp247:shop-update');
        }
    }
}
