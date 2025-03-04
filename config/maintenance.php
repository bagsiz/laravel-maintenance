<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Settings
    |--------------------------------------------------------------------------
    |
    | Here you can configure the maintenance mode settings for your application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Allowed IPs
    |--------------------------------------------------------------------------
    |
    | These IP addresses will be allowed to access the application when it's
    | in maintenance mode. You can override these when enabling maintenance mode.
    |
    */
    'allowed_ips' => [
        '127.0.0.1',
        '::1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Allowed Paths
    |--------------------------------------------------------------------------
    |
    | These paths will be accessible when the application is in maintenance mode.
    | You can override these when enabling maintenance mode.
    |
    */
    'allowed_paths' => [
        'admin/*',
        'api/*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode View
    |--------------------------------------------------------------------------
    |
    | This is the view that will be shown when the application is in maintenance
    | mode. You can publish and customize this view.
    |
    */
    'view' => 'maintenance::maintenance',
]; 