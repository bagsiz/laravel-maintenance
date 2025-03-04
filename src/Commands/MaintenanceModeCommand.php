<?php

namespace Bagsiz\Maintenance\Commands;

use Illuminate\Console\Command;
use Bagsiz\Maintenance\Facades\Maintenance;

class MaintenanceModeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance {action : The action to perform (on/off)} {--ip=* : IP addresses that should be allowed to access the application} {--path=* : Paths that should be accessible during maintenance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage the application maintenance mode';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = strtolower($this->argument('action'));

        if (!in_array($action, ['on', 'off'])) {
            $this->error('Invalid action. Use "on" or "off".');
            return 1;
        }

        if ($action === 'on') {
            $allowedIps = $this->option('ip');
            $allowedPaths = $this->option('path');

            if (Maintenance::enable($allowedIps, $allowedPaths)) {
                $this->info('Application is now in maintenance mode.');
                if (!empty($allowedIps)) {
                    $this->info('Allowed IPs: ' . implode(', ', $allowedIps));
                }
                if (!empty($allowedPaths)) {
                    $this->info('Allowed paths: ' . implode(', ', $allowedPaths));
                }
            } else {
                $this->error('Failed to enable maintenance mode.');
                return 1;
            }
        } else {
            if (Maintenance::disable()) {
                $this->info('Application is now live.');
            } else {
                $this->error('Failed to disable maintenance mode.');
                return 1;
            }
        }

        return 0;
    }
} 