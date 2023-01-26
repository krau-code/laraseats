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
        'resources/css/app.css', // CSS
        'resources/css/adminMenu.css', // Menu CSS
        'resources/js/menu.js' // Menu JS
    ])
</head>
<body class="bg-gray-100">
    {{-- Container --}}
    <div class="flex flex-col min-h-screen" id="app">
        {{-- Navigation --}}
        <nav class="flex items-center justify-between px-4 py-4 text-gray-700 bg-white lg:py-0 md:px-8 2xl:px-20">
            {{-- Logo --}}
            <a href="/admin" class="flex items-center justify-center gap-x-2">
                <img class="w-8" src="{{ asset('images/laraseats-admin-logo.png') }}" alt="laraseats admin logo">
                <h1 class="text-3xl font-bold">Admin</h1>
            </a>

            {{-- Links for Desktop --}}
            <div class="hidden mr-10 text-sm tracking-wide uppercase lg:flex">
                <router-link :to="{ name: 'admin.index' }" active-class="font-bold bg-gray-100" class="px-3 py-4 border-gray-700 hover:bg-gray-100 ">Home</router-link>
                <router-link :to="{ name: 'reservations.index' }" active-class="font-bold bg-gray-100" class="px-3 py-4 border-gray-700 hover:bg-gray-100">Reservations</router-link>
                <router-link :to="{ name: 'schedules.index' }" active-class="font-bold bg-gray-100" class="px-3 py-4 border-gray-700 hover:bg-gray-100">Schedules</router-link>
                <router-link :to="{ name: 'movies.index' }" active-class="font-bold bg-gray-100" class="px-3 py-4 border-gray-700 hover:bg-gray-100">Movies</router-link>
                <router-link :to="{ name: 'cinemas.index' }" active-class="font-bold bg-gray-100" class="px-3 py-4 border-gray-700 hover:bg-gray-100">Cinemas</router-link>
            </div>
            <div class="items-center hidden text-sm tracking-wide uppercase lg:flex gap-x-6">
                <p class="capitalize cursor-default">Hi, {{ auth()->user()->name }}!</p>
                <a href="{{ route('index') }}" class="px-3 py-4 border-gray-700 hover:bg-gray-100">LaraSeats Site</a>
                <router-link :to="{ name: 'admin.logout' }" active-class="bg-gray-100" class="px-3 py-4 border-gray-700 hover:bg-gray-100">Logout</router-link>
            </div>
            
            <div class="flex gap-x-4 lg:hidden">
                <p class="capitalize cursor-none">Hi, {{ auth()->user()->name }}!</p>

                <!-- Menu Button for Mobile -->
                <button id="menu-btn" class="block menu-btn focus:outline-none">
                    <span class="menu-top"></span>
                    <span class="menu-middle"></span>
                    <span class="menu-bottom"></span>
                </button>
            </div>
        </nav>

        <!-- Links for Mobile -->
        <div class="lg:hidden">
            <div id="menu" class="flex-col items-center self-center hidden w-auto px-6 py-6 space-y-6 tracking-wide text-gray-700 uppercase bg-white left-4 right-4 drop-shadow-xl">
                <router-link :to="{ name: 'admin.index' }" active-class="border-b" class="border-gray-700 hover:font-bold">Home</router-link>
                <router-link :to="{ name: 'reservations.index' }" active-class="border-b" class="border-gray-700 hover:font-bold">Reservations</router-link>
                <router-link :to="{ name: 'schedules.index' }" active-class="border-b" class="border-gray-700 hover:font-bold">Schedules</router-link>
                <router-link :to="{ name: 'movies.index' }" active-class="border-b" class="border-gray-700 hover:font-bold">Movies</router-link>
                <router-link :to="{ name: 'cinemas.index' }" active-class="border-b" class="border-gray-700 hover:font-bold">Cinemas</router-link>
                <hr class="w-full bg-gray-300">
                <router-link :to="{ name: 'admin.logout' }" active-class="border-b" class="border-gray-700 hover:font-bold">Logout</router-link>
                <a href="{{ route('index') }}" class="hover:font-bold">LareSeats Site</a>
            </div>
        </div>

        {{-- Main Content --}}
        <main class="px-4 py-6 grow md:px-16 2xl:px-32">
            <router-view />
        </main>
    </div>
</body>
</html>