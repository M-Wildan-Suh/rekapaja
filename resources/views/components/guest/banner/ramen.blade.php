@php
    $ramenBg = $template->bg_main_color ?? '#F7EFE5';
    $ramenText = '#231914';
    $ramenAccent = $template->accent_color ?? '#A72018';
    $ramenCategory = optional($data->category->first())->category;
    $ramenDescription = filled($data->description)
        ? $data->description
        : 'Ramen berkualitas dengan kuah kaya rasa, mie kenyal, dan topping premium pilihan.';
    $ramenTags = $data->productTags
        ->map(fn ($item) => optional($item->productTag)->tag)
        ->filter()
        ->take(4);
@endphp

<div class="banner-auto-resize w-full relative overflow-hidden">
    <div class="w-full overflow-hidden bg-white shadow-md shadow-black/10 rounded-none md:max-w-[600px] md:mx-auto md:rounded-[2rem]">
        <div
            class="relative aspect-[4/3] overflow-hidden"
            style="background-color: {{ $ramenBg }};"
        >
            <div class="absolute inset-0">
                <img src="{{ $data->image }}" class="h-full w-full object-cover object-center" alt="{{ $data->name }}">
            </div>
            <x-guest.banner-gradient :color="$ramenBg" />

            <div class="relative z-10 flex h-full items-center px-5 py-5 md:px-7 md:py-7">
                <div class="w-[45%] space-y-2.5 md:space-y-3">
                    <div class="space-y-1.5">
                        @if (filled($ramenCategory))
                            <div class="flex items-center gap-1.5 md:gap-2">
                                <p class="text-[0.58rem] font-semibold tracking-[0.08em] md:text-[0.78rem]" style="color: {{ $ramenAccent }};">
                                    {{ $ramenCategory }}
                                </p>
                            </div>
                        @endif
                        <p data-auto-resize-text data-auto-resize-lines="1" class="text-[1.7rem] font-semibold italic leading-[0.95] md:text-[2.8rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $ramenText }};">
                            {{ $data->name }}
                        </p>
                        @if (filled($data->subtitle))
                            <p data-auto-resize-text data-auto-resize-lines="2" class="text-[1.7rem] font-semibold italic leading-[0.95] md:text-[2.8rem]" style="font-family: 'Patrick Hand', cursive; color: {{ $ramenAccent }};">
                                {{ $data->subtitle }}
                            </p>
                        @endif
                        <p data-auto-resize-text data-auto-resize-lines="3" class="pt-2 text-[0.62rem] md:text-[0.92rem]" style="color: {{ $ramenText }};">
                            {!! nl2br(e($ramenDescription)) !!}
                        </p>
                        @if ($ramenTags->isNotEmpty())
                            <div class="grid grid-cols-3 gap-1.5 pt-1 md:gap-2 md:pt-2">
                                @foreach ($ramenTags->take(3) as $tag)
                                    <div
                                        class="flex flex-col items-center justify-start px-1 py-1 text-center md:px-2 md:py-1.5"
                                        style="color: {{ $ramenText }};"
                                    >
                                        <span class="inline-flex items-center justify-center text-[1rem] font-bold md:text-[1.25rem]" style="color: {{ $ramenAccent }};">
                                            o
                                        </span>
                                        <span data-auto-resize-text data-auto-resize-lines="2" class="text-[0.42rem] font-semibold leading-[1.25] md:text-[0.62rem]" style="color: {{ $ramenText }};">
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
</div>
