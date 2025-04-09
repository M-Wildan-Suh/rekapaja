<!DOCTYPE html>
@props(['title' => null, 'desc' => null, 'tags' => null])
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rekapaja.com{{$title ? ' - '.$title : ''}}</title>

        <meta name="description" content="{{ $desc ?? '' }}">
        <meta name="keywords" content="{{ collect($tags)->pluck('productTag.tag')->implode(', ') }}">
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />    

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=DynaPuff:wdth,wght@75..100,400..700&display=swap');
        </style>

        <!-- CDN -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

        {{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script> --}}

        <link rel="icon" href="{{ asset('/assets/images/logo.webp') }}" type="image/x-icon">

        <!-- Styles -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet" />
    </head>
    <body class="antialiased">
        <div class=" min-h-screen">
            {{$slot}}
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="{{ asset('build/assets/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</html>
