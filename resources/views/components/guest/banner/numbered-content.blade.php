@php
    $bannerCategory = $data->category->pluck('category')->filter()->take(3)->implode(', ');
    $bannerTags = $data->productTags->map(fn ($item) => optional($item->productTag)->tag)->filter()->take(3);
@endphp

<div class="w-full min-w-0 space-y-1.5 md:space-y-2">
    @if (filled($bannerCategory))
        <p data-auto-resize-text data-auto-resize-lines="2" class="text-[0.58rem] md:text-[0.78rem] font-semibold tracking-wide">{{ $bannerCategory }}</p>
    @endif
    <p data-auto-resize-text data-auto-resize-lines="1" class="text-2xl md:text-5xl font-black leading-tight">{{ $data->name }}</p>
    @if (filled($data->subtitle))
        <p data-auto-resize-text data-auto-resize-lines="2" class="text-sm md:text-xl font-semibold leading-tight">{{ $data->subtitle }}</p>
    @endif
    @if (filled($data->description))
        <p data-auto-resize-text data-auto-resize-lines="3" class="line-clamp-3 text-[0.62rem] md:text-[0.92rem] leading-snug">{!! nl2br(e($data->description)) !!}</p>
    @endif
    @if ($bannerTags->isNotEmpty())
        <div class="grid grid-cols-3 gap-1.5">
            @foreach ($bannerTags as $tag)
                <span data-auto-resize-text data-auto-resize-lines="2" class="text-[0.5rem] md:text-[0.65rem] leading-tight font-semibold">{{ $tag }}</span>
            @endforeach
        </div>
    @endif
</div>
