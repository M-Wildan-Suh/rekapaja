@php
    $bannerKeywords = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->take(3);
@endphp

<div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class="relative w-full aspect-[2/1] overflow-hidden rounded-[1.2rem] shadow-[0_20px_60px_rgba(236,72,153,0.16)] text-[#6A1B4D]" style="background: linear-gradient(135deg, #FFF5F8 0%, #FBCFE8 52%, #F9A8D4 100%);">
        <div class="absolute left-[6%] top-[10%] h-[80%] w-[42%] rounded-full border-2 border-white/70"></div>
        <div class="absolute right-[6%] top-[16%] h-[68%] w-[36%] rounded-full border border-white/50"></div>
        <div class="absolute inset-0 opacity-[0.08] bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $data->image }}');"></div>

        <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-8">
            <div class="max-w-[46%] space-y-2 sm:space-y-3">
                <p class="text-[1.45rem] sm:text-[2.2rem] font-black leading-tight" style="font-family: 'Segoe Script', 'Brush Script MT', cursive; color: #6A1B4D;">
                    {{ $data->name }}
                </p>
                <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-[0.22em] text-[#9D174D]">
                    {{ $data->subtitle ?: 'Custom Header' }}
                </p>

                @if ($bannerKeywords->isNotEmpty())
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($bannerKeywords as $keyword)
                            <div class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] sm:text-xs font-semibold shadow-sm text-[#9D174D]">
                                {{ $keyword }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex h-28 w-28 sm:h-40 sm:w-40 items-center justify-center overflow-hidden rounded-full border-[5px] sm:border-[6px] border-white shadow-xl shadow-pink-300/30">
                <img
                    src="{{ $data->image }}"
                    class="h-full w-full object-cover"
                    alt="{{ $data->name }}">
            </div>
        </div>
    </div>
</div>
