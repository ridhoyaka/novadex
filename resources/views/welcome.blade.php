<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <style>
            body {
                font-family: 'Inter', 'Poppins', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9fafb;
            }
            .container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-center;
            }
            .content {
                text-align: center;
            }
            h1 {
                font-size: 2.25rem;
                font-weight: bold;
                color: #16a34a;
                margin-bottom: 1rem;
            }
            p {
                color: #4b5563;
            }
            .version {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 1rem;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="content">
                <h1>NovaDex</h1>
                <p>Platform Digital UMKM Salatiga</p>
                <p class="version">
                    Laravel {{ Illuminate\Foundation\Application::VERSION }} (PHP {{ PHP_VERSION }})
                </p>
            </div>
        </div>
    </body>
</html>
