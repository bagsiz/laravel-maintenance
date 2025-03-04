<?php

namespace Bagsiz\Maintenance\Tests;

use Bagsiz\Maintenance\MaintenanceManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MaintenanceManagerTest extends TestCase
{
    protected $maintenanceManager;
    protected $maintenanceFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->maintenanceManager = new MaintenanceManager();
        $this->maintenanceFile = storage_path('framework/maintenance.php');
    }

    protected function tearDown(): void
    {
        if (File::exists($this->maintenanceFile)) {
            File::delete($this->maintenanceFile);
        }
        parent::tearDown();
    }

    /** @test */
    public function it_can_enable_maintenance_mode()
    {
        $result = $this->maintenanceManager->enable(['127.0.0.1'], ['admin/*']);

        $this->assertTrue($result);
        $this->assertTrue(File::exists($this->maintenanceFile));
        
        $data = require $this->maintenanceFile;
        $this->assertArrayHasKey('time', $data);
        $this->assertArrayHasKey('allowed_ips', $data);
        $this->assertArrayHasKey('allowed_paths', $data);
        $this->assertEquals(['127.0.0.1'], $data['allowed_ips']);
        $this->assertEquals(['admin/*'], $data['allowed_paths']);
    }

    /** @test */
    public function it_can_disable_maintenance_mode()
    {
        // First enable maintenance mode
        $this->maintenanceManager->enable(['127.0.0.1'], ['admin/*']);
        
        // Then disable it
        $result = $this->maintenanceManager->disable();

        $this->assertTrue($result);
        $this->assertFalse(File::exists($this->maintenanceFile));
    }

    /** @test */
    public function it_can_check_if_maintenance_mode_is_enabled()
    {
        $this->assertFalse($this->maintenanceManager->isEnabled());
        
        $this->maintenanceManager->enable(['127.0.0.1'], ['admin/*']);
        $this->assertTrue($this->maintenanceManager->isEnabled());
    }

    /** @test */
    public function it_can_get_maintenance_mode_data()
    {
        $this->assertNull($this->maintenanceManager->getData());
        
        $this->maintenanceManager->enable(['127.0.0.1'], ['admin/*']);
        $data = $this->maintenanceManager->getData();
        
        $this->assertIsArray($data);
        $this->assertArrayHasKey('time', $data);
        $this->assertArrayHasKey('allowed_ips', $data);
        $this->assertArrayHasKey('allowed_paths', $data);
    }
} 