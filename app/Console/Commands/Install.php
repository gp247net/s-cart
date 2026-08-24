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
     *
     * Confirmation is taken here once, then the platform orchestrator
     * gp247:install is delegated to (with --force=1 so it does not prompt
     * again). Older core packages without gp247:install fall back to calling
     * each package installer directly.
     *
     * @return void
     *
     * @aidlc-unit system-cli
     * @aidlc-story US-CLI-003
     * @aidlc-adr system-cli_command-registration-tiers
     */
    public function handle()
    {
        if (!$this->confirm('Are you sure you want to install S-Cart?')) {
            return;
        }

        $this->info('Installing S-Cart...');

        // WHY: gp247:install is the single common orchestrator (auto-detects
        // core/front/shop). Consent was just obtained above, so pass --force=1
        // to skip its nested confirmation gate.
        if (array_key_exists('gp247:install', Artisan::all())) {
            $this->call('gp247:install', ['--force' => 1]);
            $this->info('S-Cart installed successfully');
            return;
        }

        // Fallback for very old core without the gp247:install orchestrator.
        if (array_key_exists('gp247:core-install', Artisan::all())) {
            $this->info(' - Installing Core...');
            $this->call('gp247:core-install', ['--force' => 1]);
        }
        if (array_key_exists('gp247:front-install', Artisan::all())) {
            $this->info(' - Installing Front...');
            $this->call('gp247:front-install');
        }
        if (array_key_exists('gp247:shop-install', Artisan::all())) {
            $this->info(' - Installing Shop...');
            $this->call('gp247:shop-install');
        }

        $this->info('S-Cart installed successfully');
    }
}
