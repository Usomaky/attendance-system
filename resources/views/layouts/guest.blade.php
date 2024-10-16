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
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/bootstrap.min.css'])
    </head>
    <body class="gap-20 antialiased text-gray-900 lg:justify-center lg:items-center lg:flex roboto-regular" style="background-color: #F0F4FB">

        <div class="items-start hidden gap-1 lg:flex-col lg:flex">
            <img src="{{ asset('images/coriftech-logo.png')}}" alt="" class="w-15 img-fluid">
            <p class="text-blue-800 roboto-thin display-4">Attendance System</p>
        </div>

        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            <div>
                {{-- <a href="/">
                    <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
                </a> --}}
            </div>

            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg lg:w-96">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
