<?php

namespace Bagsiz\Maintenance;

use Illuminate\Support\ServiceProvider;

class MaintenanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('maintenance', function ($app) {
            return new MaintenanceManager();
        });
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
                Commands\MaintenanceModeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/config/maintenance.php' => config_path('maintenance.php'),
            __DIR__.'/../resources/views/maintenance' => resource_path('views/maintenance'),
        ], 'maintenance');
    }
} 