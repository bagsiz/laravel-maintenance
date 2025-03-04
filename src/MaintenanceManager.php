<?php

namespace Bagsiz\Maintenance;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MaintenanceManager
{
    /**
     * The maintenance mode file path.
     *
     * @var string
     */
    protected $maintenanceFile;

    /**
     * Create a new maintenance manager instance.
     */
    public function __construct()
    {
        $this->maintenanceFile = storage_path('framework/maintenance.php');
    }

    /**
     * Enable maintenance mode.
     *
     * @param array $allowedIps
     * @param array $allowedPaths
     * @return bool
     */
    public function enable(array $allowedIps = [], array $allowedPaths = []): bool
    {
        $payload = [
            'time' => time(),
            'allowed_ips' => $allowedIps,
            'allowed_paths' => $allowedPaths,
        ];

        return File::put($this->maintenanceFile, '<?php return '.var_export($payload, true).';');
    }

    /**
     * Disable maintenance mode.
     *
     * @return bool
     */
    public function disable(): bool
    {
        if (File::exists($this->maintenanceFile)) {
            return File::delete($this->maintenanceFile);
        }

        return true;
    }

    /**
     * Check if maintenance mode is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return File::exists($this->maintenanceFile);
    }

    /**
     * Get maintenance mode data.
     *
     * @return array|null
     */
    public function getData(): ?array
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return require $this->maintenanceFile;
    }
} 