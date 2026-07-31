@props(['image', 'class'])
<div x-data="{ loading: true }" x-intersect="$el.querySelector('img').src = '{{ $image }}'"
    class="{{$class}}">
    <!-- Gambar dengan Fancybox -->
    <img class="w-full h-full object-cover object-center absolute inset-0 opacity-0 transition-opacity duration-500"
    alt="" @load="loading = false; $el.classList.add('opacity-100')">
    
    <a data-fancybox="gallery" href="{{ $image }}" class="">
        <div class="w-full absolute inset-0 bg-black/20"></div>
    </a>
    
    <!-- Overlay -->
    
    <!-- Loading Spinner -->
    <div x-show="loading" class="absolute inset-0 flex items-center justify-center">
        <svg class="animate-spin h-10 w-10 text-white opacity-50" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 24c0 11.046 8.954 20 20 20s20-8.954 20-20S35.046 4 24 4" stroke="#ffffff"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="4" class="stroke-000000">
            </path>
        </svg>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Fancybox.bind("[data-fancybox]", {});
    });
</script>
