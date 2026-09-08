@php
    $skincareBg = $template->bg_main_color ?? '#FFF7FB';
    $skincareText = '#4A2F3A';
    $skincareAccent = $template->accent_color ?? '#EF6AA5';
    $skincareCategory = optional($data->category->first())->category;
    $skincareDescription = filled($data->description)
        ? $data->description
        : 'Rangkaian skincare pilihan dengan bahan berkualitas untuk kulit sehat, cerah, dan glowing setiap hari.';
    $skincareTags = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->values();
    $skincareHeroTags = $skincareTags->take(3);
    $skincareFeatureTags = $skincareTags->skip(3)->take(3);

    if ($skincareFeatureTags->isEmpty()) {
        $skincareFeatureTags = $skincareHeroTags->take(4);
    }

@endphp

<div class="banner-auto-resize w-full relative overflow-hidden">
    <div class="w-full overflow-hidden bg-white shadow-md shadow-slate-900/10 rounded-none md:max-w-[600px] md:mx-auto md:rounded-[2rem]">
        <div class="relative aspect-[4/3] overflow-hidden" style="background-color: {{ $skincareBg }};">
            <div class="absolute inset-0">
                <img src="{{ $data->image }}" class="h-full w-full object-cover object-center" alt="{{ $data->name }}">
            </div>

            <div class="absolute left-[5%] top-[12%] h-10 w-10 rounded-full bg-[#F7B4C9]/35 blur-xl"></div>
            <div class="absolute right-[14%] top-[10%] h-16 w-16 rounded-full bg-[#FBD3E2]/35 blur-2xl"></div>
            <div class="absolute left-[62%] top-[14%] h-2 w-2 rounded-full bg-white/80"></div>
            <div class="absolute right-[10%] top-[18%] h-2.5 w-2.5 rounded-full bg-white/80"></div>

            <div class="relative z-10 flex h-full items-center px-5 py-5 md:px-7 md:py-7">
                <div class="w-[54%] space-y-2.5 md:w-[52%] md:space-y-3">
                    <div class="space-y-1.5">
                        @if (filled($skincareCategory))
                            <p class="text-[0.6rem] font-semibold italic md:text-[1rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $skincareAccent }};">
                                {{ $skincareCategory }}
                            </p>
                        @endif

                        <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.4rem] font-black leading-tight md:text-[2.2rem]" style="color: {{ $skincareText }};">
                            {{ $data->name }}
                        </p>

                        @if (filled($data->subtitle))
                            <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.4rem] font-black italic leading-[0.95] md:text-[2.2rem]" style="color: {{ $skincareAccent }};">
                                {{ $data->subtitle }}
                            </p>
                        @endif

                        @if ($skincareHeroTags->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 pt-1 md:gap-2">
                                @foreach ($skincareHeroTags as $tag)
                                    <span data-auto-resize-text data-auto-resize-lines="2" class="rounded-full px-2.5 py-1 text-[0.4rem] font-bold text-white md:px-3.5 md:text-[0.82rem]" style="background-color: rgba(181,120,221,0.9);">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <p data-auto-resize-text data-auto-resize-lines="3" class="pt-1 text-[0.66rem] md:pt-2 md:text-[0.92rem]" style="color: {{ $skincareText }};">
                            {!! nl2br(e($skincareDescription)) !!}
                        </p>
                    </div>

                    @if ($skincareFeatureTags->isNotEmpty())
                        <div class="grid grid-cols-3 gap-1.5 pt-1 md:gap-2 md:pt-2">
                            @foreach ($skincareFeatureTags as $tag)
                                <div class="flex flex-col items-center justify-start gap-1 text-center md:gap-1.5">
                                    <span class="inline-flex items-center justify-center text-[0.84rem] font-black md:text-[1rem]" style="color: {{ $skincareAccent }};">
                                        o
                                    </span>
                                    <span data-auto-resize-text data-auto-resize-lines="2" class="text-[0.5rem] font-semibold leading-[1.25] md:text-[0.72rem]" style="color: {{ $skincareText }};">
                                        {{ $tag }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
