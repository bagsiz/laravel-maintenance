<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Maintenance Mode</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8fafc;
            color: #2d3748;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            padding: 2rem;
            text-align: center;
        }
        .maintenance-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #4a5568;
        }
        h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1a202c;
        }
        p {
            font-size: 1.125rem;
            color: #4a5568;
            margin-bottom: 2rem;
        }
        .status {
            background-color: #edf2f7;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        .status p {
            margin: 0;
            font-size: 0.875rem;
            color: #4a5568;
        }
        .contact {
            font-size: 0.875rem;
            color: #718096;
        }
        .contact a {
            color: #4299e1;
            text-decoration: none;
        }
        .contact a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="maintenance-icon">🔧</div>
        <h1>We're under maintenance</h1>
        <p>We're performing some maintenance on our site. We'll be back shortly.</p>
        
        <div class="status">
            <p>Maintenance started: {{ \Carbon\Carbon::createFromTimestamp($data['time'])->format('F j, Y g:i A') }}</p>
        </div>

        <div class="contact">
            <p>If you need immediate assistance, please contact us at <a href="mailto:{{ config('app.admin_email', 'admin@example.com') }}">{{ config('app.admin_email', 'admin@example.com') }}</a></p>
        </div>
    </div>
</body>
</html> 