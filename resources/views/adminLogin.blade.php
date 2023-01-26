<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon/laraseats-admin-favicon.ico') }}">

    {{-- Scripts --}}
    @vite([
        'resources/js/app.js', // Vue
        'resources/css/app.css', // CSS file
        'resources/js/menu.js' // Menu button
    ])
</head>
<body class="bg-slate-200">
    {{-- Container --}}
    <div class="flex flex-col items-center justify-center h-screen px-3 md:px-0" id="app">
        <router-view />
    </div>
</body>
</html>