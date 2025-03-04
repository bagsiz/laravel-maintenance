<?php

namespace Bagsiz\Maintenance\Middleware;

use Closure;
use Illuminate\Http\Request;
use Bagsiz\Maintenance\Facades\Maintenance;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Maintenance::isEnabled()) {
            return $next($request);
        }

        $data = Maintenance::getData();
        $allowedIps = $data['allowed_ips'] ?? [];
        $allowedPaths = $data['allowed_paths'] ?? [];

        // Check if the current IP is allowed
        if (in_array($request->ip(), $allowedIps)) {
            return $next($request);
        }

        // Check if the current path is allowed
        foreach ($allowedPaths as $path) {
            if ($request->is($path)) {
                return $next($request);
            }
        }

        // Return maintenance view
        return response()->view('maintenance.maintenance', [
            'data' => $data
        ], 503);
    }
} 