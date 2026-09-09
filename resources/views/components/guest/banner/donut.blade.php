@php
    $donutBg = $template->bg_main_color ?? '#FFF8F4';
    $donutText = '#4A2F22';
    $donutAccent = $template->accent_color ?? '#E66B98';
    $donutNameFont = "'Dancing Script', 'Patrick Hand', cursive";
    $donutDescription = filled($data->description)
        ? $data->description
        : 'Donat fresh setiap hari, dibuat dari bahan berkualitas dengan topping pilihan terbaik. Lembut, empuk dan nikmat.';
    $donutTags = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->take(3);
    $donutSubtitleWords = filled($data->subtitle)
        ? preg_split('/\s+/', trim($data->subtitle)) ?: []
        : [];
    $donutSubtitleSplitIndex = (int) ceil(count($donutSubtitleWords) / 2);
    $donutSubtitlePrimary = collect(array_slice($donutSubtitleWords, 0, $donutSubtitleSplitIndex))->implode(' ');
    $donutSubtitleAccent = collect(array_slice($donutSubtitleWords, $donutSubtitleSplitIndex))->implode(' ');
@endphp

<div class="banner-auto-resize w-full relative overflow-hidden">
    <div class="w-full overflow-hidden bg-white shadow-md shadow-slate-900/10 rounded-none md:max-w-[600px] md:mx-auto md:rounded-[2rem]">
        <div class="relative aspect-[4/3] overflow-hidden" style="background-color: {{ $donutBg }};">
            <div class="absolute inset-y-0 right-0 w-full">
                <img src="{{ $data->image }}" class="h-full w-full object-cover object-center" alt="{{ $data->name }}">
            </div>

            <x-guest.banner-gradient :color="$donutBg" />

            <div class="relative z-10 flex h-full items-center px-5 py-5 md:px-7 md:py-7">
                <div class="w-[45%] space-y-2.5 md:w-[55%] md:space-y-3">
                    <div class="space-y-1.5">
                        <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.58rem] font-semibold leading-none md:text-[2.65rem]" style="font-family: {!! $donutNameFont !!}; color: {{ $donutAccent }};">
                            {{ $data->name }}
                        </p>
                        @if (filled($data->subtitle))
                            <div class="space-y-0.5">
                                @if (filled($donutSubtitlePrimary))
                                    <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1rem] font-black leading-[0.95] md:text-[2.2rem]" style="color: {{ $donutText }};">
                                        {{ $donutSubtitlePrimary }}
                                    </p>
                                @endif
                                @if (filled($donutSubtitleAccent))
                                    <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1rem] font-black leading-[0.95] md:text-[2.2rem]" style="color: {{ $donutAccent }};">
                                        {{ $donutSubtitleAccent }}
                                    </p>
                                @endif
                            </div>
                        @endif
                        @if (filled($donutDescription))
                            <p data-auto-resize-text data-auto-resize-lines="3" class="pt-1 text-[0.66rem] md:pt-2 md:text-[0.92rem]" style="color: {{ $donutText }};">
                                {!! nl2br(e($donutDescription)) !!}
                            </p>
                        @endif
                    </div>

                    @if ($donutTags->isNotEmpty())
                        <div class="grid grid-cols-3 gap-1.5 pt-1 md:gap-2 md:pt-2">
                            @foreach ($donutTags as $tag)
                                <div class="flex items-center justify-start gap-1 text-left md:gap-1.5">
                                    <span class="inline-flex items-center justify-center text-[0.72rem] font-black md:text-[0.9rem]" style="color: {{ $donutAccent }};">
                                        o
                                    </span>
                                    <span data-auto-resize-text data-auto-resize-lines="2" class="text-[0.46rem] font-semibold leading-[1.25] md:text-[0.68rem]" style="color: {{ $donutText }};">
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
