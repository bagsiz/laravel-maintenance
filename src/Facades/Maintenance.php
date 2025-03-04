<?php

namespace Bagsiz\Maintenance\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool enable(array $allowedIps = [], array $allowedPaths = [])
 * @method static bool disable()
 * @method static bool isEnabled()
 * @method static array|null getData()
 *
 * @see \Bagsiz\Maintenance\MaintenanceManager
 */
class Maintenance extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'maintenance';
    }
} 