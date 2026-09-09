@php
    $sembakoBg = $template->bg_main_color ?? '#FFF8E9';
    $sembakoText = '#24411F';
    $sembakoAccent = $template->accent_color ?? '#2F9E44';
    $sembakoGold = '#D97706';
    $sembakoPill = '#FACC15';
    $sembakoCategory = optional($data->category->first())->category;
    $sembakoDescription = filled($data->description)
        ? $data->description
        : 'Menyediakan berbagai kebutuhan sembako pilihan dengan kualitas terjamin dan harga terjangkau untuk keluarga Anda.';
    $sembakoTags = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->values();
    $sembakoHeroTag = $sembakoTags->first();
    $sembakoFeatureTags = $sembakoTags->skip($sembakoHeroTag ? 1 : 0)->take(5);

    if ($sembakoFeatureTags->isEmpty()) {
        $sembakoFeatureTags = $sembakoTags->take(5);
    }
@endphp

<div class="banner-auto-resize w-full relative mb-20">
    <div class="w-full bg-white shadow-md shadow-slate-900/10 rounded-none md:mx-auto md:max-w-[600px] md:rounded-[2rem]">
        <div class="relative">
            <div class="relative aspect-[4/3] overflow-hidden" style="background-color: {{ $sembakoBg }};">
                <div class="absolute inset-0">
                    <img src="{{ $data->image }}" class="h-full w-full object-cover object-center" alt="{{ $data->name }}">
                </div>

                <x-guest.banner-gradient :color="$sembakoBg" />

                <div class="relative z-10 flex h-full items-center px-5 py-5 md:px-7 md:py-7">
                    <div class="w-[50%] space-y-2.5 md:space-y-3">
                        @if (filled($sembakoCategory))
                            <p class="text-[0.8rem] font-semibold italic leading-tight md:text-[1rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $sembakoAccent }};">
                                {{ $sembakoCategory }}
                            </p>
                        @endif

                        <div class="space-y-0.5">
                            <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.35rem] font-bold leading-none md:text-[2.4rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $sembakoAccent }};">
                                {{ $data->name }}
                            </p>

                            @if (filled($data->subtitle))
                                <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.35rem] font-bold leading-none md:text-[2.4rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $sembakoGold }};">
                                    {{ $data->subtitle }}
                                </p>
                            @endif
                        </div>

                        @if (filled($sembakoHeroTag))
                            <div class="pt-1">
                                <span data-auto-resize-text data-auto-resize-lines="1" class="inline-flex items-center rounded-full px-2.5 py-1 text-[0.48rem] font-bold md:px-3.5 md:text-[0.8rem]" style="background-color: {{ $sembakoPill }}; color: {{ $sembakoText }};">
                                    {{ $sembakoHeroTag }}
                                </span>
                            </div>
                        @endif

                        <p data-auto-resize-text data-auto-resize-lines="4" class="pt-1 text-[0.64rem] leading-[1.45] md:pt-2 md:text-[0.92rem]" style="color: {{ $sembakoText }};">
                            {!! nl2br(e($sembakoDescription)) !!}
                        </p>
                    </div>
                </div>
            </div>

            @if ($sembakoFeatureTags->isNotEmpty())
                <div class="absolute inset-x-4 bottom-0 z-20 translate-y-1/2 md:inset-x-6">
                    <div class="rounded-[1.4rem] border border-[#E7EDD9] bg-white px-3 py-3 shadow-[0_16px_32px_rgba(15,23,42,0.10)] md:px-4 md:py-4">
                        <div class="grid grid-cols-5 gap-1.5 md:gap-2">
                            @php
                                $featurePalette = [
                                    ['accent' => '#2F9E44', 'border' => '#D9F99D'],
                                    ['accent' => '#D97706', 'border' => '#FDE68A'],
                                    ['accent' => '#65A30D', 'border' => '#D9F99D'],
                                    ['accent' => '#F59E0B', 'border' => '#FDE68A'],
                                    ['accent' => '#4D7C0F', 'border' => '#DCFCE7'],
                                ];
                            @endphp
                            @foreach ($sembakoFeatureTags as $tag)
                                @php
                                    $tagTheme = $featurePalette[$loop->index % count($featurePalette)];
                                @endphp
                                <div class="flex flex-col items-center justify-start gap-1 text-center md:gap-1.5">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border text-[1rem] font-black md:h-10 md:w-10 md:text-[1.1rem]" style="border-color: {{ $tagTheme['border'] }}; color: {{ $tagTheme['accent'] }};">
                                        o
                                    </span>
                                    <span data-auto-resize-text data-auto-resize-lines="1" class="text-[0.46rem] font-semibold leading-[1.25] md:text-[0.68rem]" style="color: {{ $sembakoText }};">
                                        {{ $tag }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
