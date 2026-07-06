<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Information extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Information S-Cart';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('== S-Cart: '.(gp247_composer_get_package_installed()['s-cart/s-cart'] ?? '')."==");
        $this->info('Core: '.(gp247_composer_get_package_installed()['gp247/core'] ?? ''));
        $this->info('Front: '.(gp247_composer_get_package_installed()['gp247/front'] ?? ''));
        $this->info('Shop: '.(gp247_composer_get_package_installed()['gp247/shop'] ?? ''));

    }
}
