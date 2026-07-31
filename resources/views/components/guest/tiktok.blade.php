@php
    preg_match('/video\/(\d+)/', $data->articles->tiktok, $matches);
    $tiktokVideoId = $matches[1] ?? null;
@endphp

<blockquote class="tiktok-embed" cite="https://www.tiktok.com/{{ $data->articles->tiktok }}" data-video-id="{{ $tiktokVideoId }}" style="max-width: 605px; min-width: 325px;">
    <script async src="https://www.tiktok.com/embed.js"></script>
</blockquote>