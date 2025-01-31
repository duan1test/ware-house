<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite([
            'resources/css/bootstrap.min.css',
            'resources/css/icons.css',
            'resources/css/syndash.css',
        ])
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="bg-login">
        {{ $slot }}
        @vite([
            'resources/js/app.js',
            'resources/js/guest.js',
        ])
        @livewireScripts
    </body>
</html>
