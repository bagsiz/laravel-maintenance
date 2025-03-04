<?php

namespace Bagsiz\Maintenance\Tests\Middleware;

use Bagsiz\Maintenance\Tests\TestCase;
use Bagsiz\Maintenance\Middleware\MaintenanceMode;
use Bagsiz\Maintenance\Facades\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MaintenanceModeTest extends TestCase
{
    protected $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new MaintenanceMode();
    }

    /** @test */
    public function it_allows_access_when_maintenance_mode_is_disabled()
    {
        $request = Request::create('/test', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_blocks_access_when_maintenance_mode_is_enabled()
    {
        Maintenance::enable(['127.0.0.1'], ['admin/*']);
        
        $request = Request::create('/test', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(503, $response->getStatusCode());
        $this->assertStringContainsString('We\'re under maintenance', $response->getContent());
    }

    /** @test */
    public function it_allows_access_for_whitelisted_ips()
    {
        Maintenance::enable(['127.0.0.1'], ['admin/*']);
        
        $request = Request::create('/test', 'GET');
        $request->server->set('REMOTE_ADDR', '127.0.0.1');
        
        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_allows_access_for_whitelisted_paths()
    {
        Maintenance::enable(['127.0.0.1'], ['admin/*']);
        
        $request = Request::create('/admin/login', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_blocks_access_for_non_whitelisted_ips_and_paths()
    {
        Maintenance::enable(['127.0.0.1'], ['admin/*']);
        
        $request = Request::create('/test', 'GET');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        
        $response = $this->middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(503, $response->getStatusCode());
        $this->assertStringContainsString('We\'re under maintenance', $response->getContent());
    }
} 