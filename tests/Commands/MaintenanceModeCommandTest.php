<?php

namespace Bagsiz\Maintenance\Tests\Commands;

use Bagsiz\Maintenance\Tests\TestCase;
use Bagsiz\Maintenance\Facades\Maintenance;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MaintenanceModeCommandTest extends TestCase
{
    protected $maintenanceFile;

    protected function setUp(): void
    {
        parent::setUp();
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
        $this->artisan('maintenance', [
            'action' => 'on',
            '--ip' => ['127.0.0.1'],
            '--path' => ['admin/*']
        ])->assertExitCode(0);

        $this->assertTrue(File::exists($this->maintenanceFile));
        $this->assertTrue(Maintenance::isEnabled());

        $data = Maintenance::getData();
        $this->assertEquals(['127.0.0.1'], $data['allowed_ips']);
        $this->assertEquals(['admin/*'], $data['allowed_paths']);
    }

    /** @test */
    public function it_can_disable_maintenance_mode()
    {
        // First enable maintenance mode
        Maintenance::enable(['127.0.0.1'], ['admin/*']);

        $this->artisan('maintenance', [
            'action' => 'off'
        ])->assertExitCode(0);

        $this->assertFalse(File::exists($this->maintenanceFile));
        $this->assertFalse(Maintenance::isEnabled());
    }

    /** @test */
    public function it_validates_action_argument()
    {
        $this->artisan('maintenance', [
            'action' => 'invalid'
        ])->assertExitCode(1);
    }

    /** @test */
    public function it_handles_multiple_ip_and_path_options()
    {
        $this->artisan('maintenance', [
            'action' => 'on',
            '--ip' => ['127.0.0.1', '192.168.1.1'],
            '--path' => ['admin/*', 'api/*']
        ])->assertExitCode(0);

        $data = Maintenance::getData();
        $this->assertEquals(['127.0.0.1', '192.168.1.1'], $data['allowed_ips']);
        $this->assertEquals(['admin/*', 'api/*'], $data['allowed_paths']);
    }
} 