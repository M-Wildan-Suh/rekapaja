<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('/assets/images/logo.webp') }}" type="image/x-icon">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @if (config('app.deploy', true))
            <link href="{{ Vite::asset('resources/css/app.css') }}" rel="stylesheet" />
        @else
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @include('components.page-loading')
        <div class="min-h-screen flex flex-col justify-center items-center px-4 pt-6 sm:pt-0 bg-white">
            <div>
                <a href="/">
                    <div class=" w-16 sm:w-20 aspect-square">
                        <img src="{{asset('assets/images/logo.webp')}}" alt="">
                    </div>
                </a>
            </div>

        <div class="w-full sm:max-w-md mt-6 px-4 sm:px6 py-4 bg-black shadow-md overflow-hidden rounded-md relative">
                {{ $slot }}
            </div>
        </div>
    </body>
    @if (config('app.deploy', true))
        <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
    @endif
</html>
