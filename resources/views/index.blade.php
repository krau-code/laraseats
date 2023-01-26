<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon/laraseats-favicon.ico') }}">

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    {{-- Scripts --}}
    @vite([
            'resources/js/app.js', // Vue
            'resources/css/app.css', // CSS
            'resources/css/pageMenu.css', // Menu CSS
            'resources/js/menu.js' // Menu JS
    ])
</head>
<body class="bg-slate-700">
    {{-- Container --}}
    <div class="flex flex-col min-h-screen" id="app">
        {{-- Navigation --}}
        <nav class="flex items-center justify-between h-16 px-4 py-4 text-white bg-slate-800 md:px-8 2xl:px-20">
            {{-- Logo --}}
            <a href="/" class="flex items-center justify-center gap-x-2">
                <img class="w-8" src="{{ asset('images/laraseats-logo.png') }}" alt="laraseats logo">
                <h1 class="text-3xl font-bold">LaraSeats</h1>
            </a>

            {{-- Links for Desktop --}}
            <div class="hidden text-sm tracking-wide uppercase lg:flex gap-x-8">
                <router-link :to="{ name: 'home' }" active-class="border-b" class="hover:border-b">Home</router-link>
                <router-link :to="{ name: 'schedules' }" active-class="border-b" class="hover:border-b">Schedules</router-link>
                <router-link :to="{ name: 'safety' }" active-class="border-b" class="hover:border-b">Safety Protocols & Guidelines</router-link>
                <a href="{{ route('adminIndex') }}" class="hover:border-b">Admin</a>
            </div>

            <!-- Menu Button for Mobile -->
            <button id="menu-btn" class="block menu-btn lg:hidden focus:outline-none">
                <span class="menu-top"></span>
                <span class="menu-middle"></span>
                <span class="menu-bottom"></span>
            </button>
        </nav>

        <!-- Links for Mobile -->
        <div class="lg:hidden">
            <div id="menu" class="flex-col items-center self-center hidden w-auto py-6 space-y-6 tracking-wide text-white uppercase bg-slate-800 left-4 right-4 drop-shadow-xl">
                <router-link :to="{ name: 'home' }" active-class="border-b" class="hover:font-bold">Home</router-link>
                <router-link :to="{ name: 'schedules' }" active-class="border-b" class="hover:font-bold">Schedules</router-link>
                <router-link :to="{ name: 'safety' }" active-class="border-b" class="hover:font-bold">Safety Protocols & Guidelines</router-link>
                <a href="{{ route('adminIndex') }}" class="hover:font-bold">Admin</a>
            </div>
        </div>
        </nav>

        {{-- Main Content --}}
        <main class="px-4 py-6 grow md:px-16 2xl:px-32">
            <router-view />
        </main>

        {{-- Footer --}}
        <footer class="px-4 py-6 mt-auto bg-slate-800 text-slate-500 md:flex md:flex-row-reverse md:justify-between md:px-8 2xl:px-20">
            <div class="flex justify-center text-2xl gap-7">
                <a href="https://www.facebook.com" target="_blank"><i class="duration-150 ease-in fa-brands fa-facebook hover:text-white"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="duration-150 ease-in fa-brands fa-instagram hover:text-white"></i></a>
                <a href="https://www.twitter.com" target="_blank"><i class="duration-150 ease-in fa-brands fa-twitter hover:text-white"></i></a>
            </div>

            <h1 class="mt-2 text-sm text-center">&copy; Copyright. All rights reserved 2022</h1>
        </footer>
    </div>
</body>
</html>