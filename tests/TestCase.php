<?php

namespace Bagsiz\Maintenance\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Bagsiz\Maintenance\MaintenanceServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            MaintenanceServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:6rE9tddYtENr9wL0/cjDPVdf1zeagdGD1vi9xW3uWrk=');
    }
} 