@php
    $puddingBg = $template->bg_main_color ?? '#FFF8F4';
    $puddingText = '#5C3446';
    $puddingBrown = '#8B5E3C';
    $puddingPink = $template->accent_color ?? '#F0679A';
    $puddingPurple = '#9B6AE4';
    $puddingCategory = optional($data->category->first())->category;
    $puddingDescription = filled($data->description)
        ? $data->description
        : 'Pilihan camilan manis keluarga dengan rasa lembut, fresh, dan cocok dinikmati kapan saja.';
    $puddingTags = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->values();
    $puddingHeroTag = $puddingTags->first();
    $puddingFeatureTags = $puddingTags->skip($puddingHeroTag ? 1 : 0)->take(4);

    if ($puddingFeatureTags->isEmpty()) {
        $puddingFeatureTags = $puddingTags->take(4);
    }
@endphp

<div class="w-full relative overflow-hidden">
    <div class="w-full overflow-hidden bg-white shadow-md shadow-slate-900/10 rounded-none md:mx-auto md:max-w-[600px] md:rounded-[2rem]">
        <div class="relative aspect-[4/3] overflow-hidden" style="background-color: {{ $puddingBg }};">
            <div class="absolute inset-0">
                <img src="{{ $data->image }}" class="h-full w-full object-cover object-center" alt="{{ $data->name }}">
            </div>

            <div class="absolute left-[6%] top-[15%] h-10 w-10 rounded-full bg-[#F9BCD4]/35 blur-xl"></div>
            <div class="absolute right-[10%] top-[14%] h-16 w-16 rounded-full bg-[#E9D8FD]/40 blur-2xl"></div>

            <div class="relative z-10 flex h-full items-center px-5 py-5 md:px-7 md:py-7">
                <div class="w-[54%] space-y-2.5 md:w-[52%] md:space-y-3">
                    <div class="space-y-1.5">
                        @if (filled($puddingCategory))
                            <p class="text-[0.7rem] font-semibold italic leading-tight md:text-[1rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $puddingBrown }};">
                                {{ $puddingCategory }}
                            </p>
                        @endif

                        <div class="space-y-0.5">
                            <p class="text-[1.45rem] font-bold leading-none md:text-[2.35rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $puddingPink }};">
                                {{ $data->name }}
                            </p>

                            @if (filled($data->subtitle))
                                @php
                                    $subtitleWords = preg_split('/\s+/', trim($data->subtitle)) ?: [];
                                    $splitIndex = (int) ceil(count($subtitleWords) / 2);
                                    $subtitlePrimary = collect(array_slice($subtitleWords, 0, $splitIndex))->implode(' ');
                                    $subtitleAccent = collect(array_slice($subtitleWords, $splitIndex))->implode(' ');
                                @endphp
                                <div class="space-y-0.5">
                                    @if (filled($subtitlePrimary))
                                        <p class="text-[1.05rem] font-bold leading-none md:text-[1.95rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $puddingPurple }};">
                                            {{ $subtitlePrimary }}
                                        </p>
                                    @endif
                                    @if (filled($subtitleAccent))
                                        <p class="text-[1.05rem] font-bold leading-none md:text-[1.95rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $puddingBrown }};">
                                            {{ $subtitleAccent }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if (filled($puddingHeroTag))
                            <div class="pt-1">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/75 px-2.5 py-1 text-[0.48rem] font-bold md:px-3.5 md:text-[0.82rem]" style="color: {{ $puddingPink }};">
                                    <span class="text-[0.7rem] leading-none md:text-[0.95rem]">♡</span>
                                    <span>{{ $puddingHeroTag }}</span>
                                </span>
                            </div>
                        @endif

                        <p class="pt-1 text-[0.62rem] leading-[1.45] md:pt-2 md:text-[0.92rem]" style="color: {{ $puddingText }};">
                            {!! nl2br(e($puddingDescription)) !!}
                        </p>
                    </div>

                    @if ($puddingFeatureTags->isNotEmpty())
                        <div class="grid grid-cols-4 gap-1.5 pt-1 md:gap-2 md:pt-2">
                            @php
                                $featurePalette = [
                                    ['accent' => '#8BBF59', 'border' => '#D9E9BE'],
                                    ['accent' => '#A56BDB', 'border' => '#DFC8F4'],
                                    ['accent' => '#FF9F1C', 'border' => '#FFE0B8'],
                                    ['accent' => '#F58CB2', 'border' => '#F4D1DA'],
                                ];
                            @endphp
                            @foreach ($puddingFeatureTags as $tag)
                                @php
                                    $tagTheme = $featurePalette[$loop->index % count($featurePalette)];
                                @endphp
                                <div class="flex flex-col items-center justify-start gap-1 text-center md:gap-1.5">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border text-[1rem] font-black md:h-10 md:w-10 md:text-[1.15rem]" style="border-color: {{ $tagTheme['border'] }}; color: {{ $tagTheme['accent'] }};">
                                        o
                                    </span>
                                    <span class="text-[0.5rem] font-semibold leading-[1.25] md:text-[0.72rem]" style="color: {{ $puddingText }};">
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
