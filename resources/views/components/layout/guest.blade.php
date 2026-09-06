<!DOCTYPE html>
@props(['title' => null, 'desc' => null, 'tags' => null, 'canonical' => null, 'image' => null, 'robots' => 'index,follow'])
@php
    $metaTitle = $title ? 'RekapAja.com - ' . $title : 'RekapAja.com';
    $metaDescription = trim((string) ($desc ?? 'Bangun usaha online dengan sistem rekap otomatis bersama RekapAja.'));
    $metaKeywords = collect($tags)->pluck('productTag.tag')->filter()->implode(', ');
    $canonicalUrl = $canonical ?: url()->current();
    $metaImage = $image ?: asset('/assets/images/logo.webp');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $metaTitle }}</title>

        <meta name="description" content="{{ $metaDescription }}">
        <meta name="keywords" content="{{ $metaKeywords }}">
        <meta name="robots" content="{{ $robots }}">
        <meta name="googlebot" content="{{ $robots }},max-image-preview:large">
        <link rel="canonical" href="{{ $canonicalUrl }}">
        <meta property="og:site_name" content="RekapAja.com">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:image" content="{{ $metaImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDescription }}">
        <meta name="twitter:image" content="{{ $metaImage }}">
        <meta name="theme-color" content="#ff7100">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />    

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=DynaPuff:wdth,wght@75..100,400..700&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap');
        </style>

        <!-- CDN -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

        {{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script> --}}

        <link rel="icon" href="{{ asset('/assets/images/logo.webp') }}" type="image/x-icon">

        {!! app(\App\Support\ProjectVite::class)->tags(['resources/css/app.css', 'resources/js/app.js']) !!}

        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $metaTitle,
                'description' => $metaDescription,
                'url' => $canonicalUrl,
                'image' => $metaImage,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </head>
    <body class="antialiased">
        @include('components.page-loading')
        <audio id="order-klink-sound" preload="auto">
            <source src="{{ asset('assets/audio/order-klink.mp3') }}" type="audio/mpeg">
        </audio>
        <div class=" min-h-screen">
            {{$slot}}
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        (() => {
            const orderSound = document.getElementById('order-klink-sound');

            orderSound.volume = 1;
            console.info('[Order sound] Initialized', {
                source: orderSound.currentSrc || orderSound.querySelector('source')?.src,
                readyState: orderSound.readyState,
                volume: orderSound.volume,
            });

            orderSound.addEventListener('canplaythrough', () => {
                console.info('[Order sound] File is ready to play.');
            }, { once: true });

            orderSound.addEventListener('error', () => {
                const mediaError = orderSound.error;

                console.error('[Order sound] Failed to load the file.', {
                    source: orderSound.currentSrc || orderSound.querySelector('source')?.src,
                    code: mediaError?.code,
                    message: mediaError?.message,
                });
            });

            window.playOrderKlink = () => {
                console.info('[Order sound] Play requested.', {
                    readyState: orderSound.readyState,
                    paused: orderSound.paused,
                    source: orderSound.currentSrc || orderSound.querySelector('source')?.src,
                });
                orderSound.currentTime = 0;
                orderSound.play()
                    .then(() => console.info('[Order sound] Playback started.'))
                    .catch((error) => console.error('[Order sound] Playback was blocked or failed.', error));
            };

            document.addEventListener('click', (event) => {
                const orderControl = event.target.closest("label[for^='order-']");

                if (!orderControl || !event.isTrusted || event.defaultPrevented) {
                    return;
                }

                const orderInput = document.getElementById(orderControl.htmlFor);

                if (!orderInput?.checked) {
                    console.info('[Order sound] Product added to order.', { productId: orderInput?.value });
                    window.playOrderKlink();
                }
            });
        })();
    </script>
</html>
