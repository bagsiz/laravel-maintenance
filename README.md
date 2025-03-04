# Laravel Maintenance Mode Package

A simple and flexible maintenance mode package for Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require bagsiz/laravel-maintenance
```

The package will automatically register its service provider.

## Configuration

You can publish the configuration file and views:

```bash
php artisan vendor:publish --provider="Bagsiz\Maintenance\MaintenanceServiceProvider" --tag="maintenance"
```

This will create:
- `config/maintenance.php` - Configuration file
- `resources/views/maintenance/maintenance.blade.php` - Default maintenance view

## Usage

### Using the Facade

```php
use Bagsiz\Maintenance\Facades\Maintenance;

// Enable maintenance mode
Maintenance::enable(['127.0.0.1'], ['admin/*']);

// Disable maintenance mode
Maintenance::disable();

// Check if maintenance mode is enabled
if (Maintenance::isEnabled()) {
    // ...
}

// Get maintenance mode data
$data = Maintenance::getData();
```

### Using Artisan Commands

Enable maintenance mode:
```bash
php artisan maintenance on --ip=127.0.0.1 --ip=192.168.1.1 --path=admin/* --path=api/*
```

Disable maintenance mode:
```bash
php artisan maintenance off
```

### Using the Middleware

Add the middleware to your `app/Http/Kernel.php`:

```php
protected $middleware = [
    // ...
    \Bagsiz\Maintenance\Middleware\MaintenanceMode::class,
];
```

### Customizing the Maintenance View

The package includes a default maintenance view that you can customize. After publishing the views, you can modify `resources/views/maintenance/maintenance.blade.php` to match your application's design.

The view includes:
- A maintenance icon
- A title and description
- Maintenance start time
- Contact information (uses `config('app.admin_email')`)

## Features

- Enable/disable maintenance mode
- Allow specific IP addresses to access the application during maintenance
- Allow specific paths to be accessible during maintenance
- Command-line interface for easy management
- Configurable through config file
- Customizable maintenance view
- Middleware for automatic maintenance mode handling
- Simple and lightweight

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 