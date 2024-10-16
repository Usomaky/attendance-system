<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/bootstrap.min.css', 'resources/js/bootstrap.bundle.min.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        @if (session('message'))
            <x-toast :message="session('message')" />
        @endif
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- @isset($header)
                <header class="bg-white">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset --}}

        <div class="mt-4 mb-5 lg:flex max-w-7xl">
            <!-- Side Navbar -->
            <nav class="sticky hidden p-3 py-4 bg-white top-10 sidebar sm:px-6 lg:px-8 h-2/3 lg:border-e-2 lg:block"
                style="min-width: 250px">
                {{-- <div class="overflow-y-scroll scrollbar-hide h-100">
                    </div> --}}
                <ul class="nav flex-column">
                    <li class="mb-3 nav-item">
                        <x-side-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <i class="bi bi-speedometer2 pe-1"></i> Dashboard
                        </x-side-link>
                    </li>
                    <small class="mb-2 text-sm font-bold text-blue-700">ANALYSE</small>
                    <li class="mb-3 nav-item">
                        {{-- <x-side-link class="nav-link" href="{{ route('attendance.report') }}" :active="request()->routeIs('report')"> --}}
                        <x-side-link href="{{ route('attendance.show') }}" :active="request()->routeIs('attendance.show')">
                            <i class="bi bi-calendar-check pe-1"></i> Attendance
                        </x-side-link>
                    </li>
                    <li class="mb-2 nav-item">
                        <x-side-link class="nav-link" href="#"  :active="request()->routeIs('absence')">
                            <i class="bi bi-calendar-x pe-1"></i> Absence
                        </x-side-link>
                    </li>


                    <li class="mb-3 nav-item">
                        <x-side-link href="{{ route('attendance.report') }}" :active="request()->routeIs('attendance.report')">
                            <i class="bi bi-file-earmark-bar-graph pe-1"></i> Report
                        </x-side-link>
                    </li>
                    <small class="mb-2 text-sm font-bold text-blue-700">MANAGE</small>
                    <li class="mb-2 nav-item">
                        <x-side-link :href="route('manageFacilitator')" :active="request()->routeIs('manageFacilitator')">
                            <i class="bi bi-person pe-1"></i> Facilitator
                        </x-side-link>
                    </li>
                    <li class="mb-2 nav-item">
                        <x-side-link :href="route('manageStudent')" :active="request()->routeIs('manageStudent')">
                            <i class="bi bi-people pe-1"></i> Student
                        </x-side-link>
                    </li>
                    <li class="mb-5 nav-item">
                        <x-side-link :href="route('manageCourse')" :active="request()->routeIs('manageCourse')">
                            <i class="bi bi-book pe-1"></i> Course
                        </x-side-link>
                    </li>

                    <li class="nav-item">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-side-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                <i class="bi bi-box-arrow-right pe-1"></i>
                                {{ __('Log Out') }}
                            </x-side-link>
                        </form>
                        {{-- <a class="nav-link" href="#">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a> --}}
                    </li>
                </ul>

            </nav>

            <main class="basis-[100%] px-4">
                {{ $slot }}
            </main>
        </div>

    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>
