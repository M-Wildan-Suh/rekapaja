@props(['color' => '#FFF8F4'])

<div
    aria-hidden="true"
    class="pointer-events-none absolute inset-0"
    style="background-color: {{ $color }}; opacity: 0.8; -webkit-mask-image: linear-gradient(to right, #000 0%, #000 45%, rgba(0, 0, 0, 0.95) 55%, rgba(0, 0, 0, 0.45) 72%, transparent 90%); mask-image: linear-gradient(to right, #000 0%, #000 45%, rgba(0, 0, 0, 0.95) 55%, rgba(0, 0, 0, 0.45) 72%, transparent 90%);"
></div>
