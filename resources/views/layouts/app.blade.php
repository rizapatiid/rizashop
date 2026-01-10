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

    <!-- App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    {{-- ================= NAVBAR ================= --}}
    @php
        $useMaster = request()->routeIs('admin.*')
            || request()->is('admindashboard*')
            || request()->is('masterdashboard*');
    @endphp

    @if($useMaster)
        {{-- ADMIN / MASTER --}}
        @include('layouts.nav_masterdashboard')
    @else
        {{-- USER / MARKETPLACE --}}
        @include('layouts.nav_dashboard')
    @endif


    {{-- ================= OPTIONAL PAGE HEADER (BREEZE) ================= --}}
    @if (isset($header))
        <header class="bg-white shadow relative z-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif


    {{-- ================= PAGE CONTENT ================= --}}
    <main class="relative z-0">

        {{-- Breeze / Jetstream slot --}}
        @isset($slot)
            {{ $slot }}
        @endisset

        {{-- Classic Blade section --}}
        @yield('content')

    </main>

</body>
</html>
