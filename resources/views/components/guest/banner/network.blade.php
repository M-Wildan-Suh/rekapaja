@php
    $networkAccent = $template->accent_color ?? '#2563EB';
    $networkText = '#0F172A';
    $networkSurface = '#FFFFFF';
    $networkGold = '#FACC15';
    $networkDescription = filled($data->description) ? $data->description : null;
    $networkBadge = optional($data->category->first())->category;
    $networkTags = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->take(3);
@endphp

<div class="banner-auto-resize w-full relative overflow-hidden">
    <div class="w-full overflow-hidden bg-white shadow-md shadow-slate-900/10 rounded-none md:max-w-[600px] md:mx-auto md:rounded-[2.25rem]">
        <div class="relative aspect-[4/3] overflow-hidden" style="background-color: {{ $networkSurface }};">
            <div class="absolute inset-y-0 right-0 w-full">
                <img src="{{ $data->image }}" class="h-full w-full object-cover object-center" alt="{{ $data->name }}">
            </div>

            <div class="relative z-10 flex h-full items-center px-4 py-4 md:px-6 md:py-6">
                <div class="w-[64%] space-y-2 md:w-[56%] md:space-y-3">
                    @if (filled($networkBadge))
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-2.5 py-1 text-[0.4rem] font-extrabold uppercase tracking-[0.08em] text-white md:px-3 md:text-[0.62rem]" style="background-color: {{ $networkAccent }};">
                                {{ $networkBadge }}
                            </span>
                        </div>
                    @endif

                    <div class="space-y-1">
                        <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.2rem] font-black leading-[1.02] tracking-[-0.03em] md:text-[2.1rem]" style="color: {{ $networkText }};">
                            {{ $data->name }}
                        </p>
                        @if (filled($data->subtitle))
                            <p data-auto-resize-text data-auto-resize-lines="2" class="text-[1.2rem] font-black leading-[1.02] tracking-[-0.03em] md:text-[2.1rem]" style="color: {{ $networkAccent }};">
                                {{ $data->subtitle }}
                            </p>
                        @endif
                    </div>

                    @if ($networkTags->isNotEmpty())
                        <div class="flex flex-wrap gap-1.5 pt-1 md:gap-2">
                            @foreach ($networkTags->take(3) as $tag)
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-[0.4rem] font-bold md:px-2.5 md:text-[0.68rem]" style="background-color: {{ $networkGold }}; color: {{ $networkText }};">
                                    <span class="inline-block h-1.5 w-1.5 rounded-full" style="background-color: {{ $networkText }};"></span>
                                    <span data-auto-resize-text data-auto-resize-lines="1">{{ $tag }}</span>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    @if (filled($networkDescription))
                        <p data-auto-resize-text data-auto-resize-lines="3" class="max-w-[15rem] text-[0.62rem] leading-4 md:max-w-[18rem] md:text-[0.88rem] md:leading-6" style="color: {{ $networkText }};">
                            {!! nl2br(e($networkDescription)) !!}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
