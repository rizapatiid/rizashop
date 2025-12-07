<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            {{-- Pilih navigation sesuai role & route --}}
            @php
                $useMaster = false;
                if (request()->routeIs('admin.*') || request()->is('admindashboard*') || request()->is('masterdashboard*')) {
                    $useMaster = true;
                }
            @endphp

            @if($useMaster)
                @include('layouts.nav_masterdashboard')
            @else
                @include('layouts.nav_dashboard')
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{-- Support Breeze component slot --}}
                @isset($slot)
                    {{ $slot }}
                @endisset

                {{-- Support classic @extends / @section --}}
                @yield('content')
            </main>
        </div>
    </body>
</html>
