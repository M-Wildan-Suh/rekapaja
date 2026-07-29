@php
    $ramenBg = $template->bg_main_color ?? '#F7EFE5';
    $ramenSurface = '#FFF8F1';
    $ramenBorder = '#EAD8C7';
    $ramenText = '#231914';
    $ramenAccent = $template->accent_color ?? '#A72018';
@endphp

<div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class="w-full aspect-[2/1] overflow-hidden rounded-md bg-white shadow-md shadow-black/10">
        <div class="grid grid-cols-[0.95fr_1.05fr] sm:grid-cols-[0.88fr_1.12fr] relative h-full overflow-hidden" style="background-color: {{ $ramenBg }};">
            <div
                class="absolute inset-0 opacity-[0.08] bg-cover bg-center bg-no-repeat"
                style="background-image: url('{{ $data->image }}');"
            ></div>
            <div class="px-4 py-4 sm:px-6 sm:py-6 h-full flex items-center">
                <div class="space-y-2.5 sm:space-y-4 relative z-10">
                    <div class="space-y-1">
                        <p class="text-[1.3rem] sm:text-[2.8rem] leading-none" style="font-family: 'Segoe Script', 'Brush Script MT', cursive; color: {{ $ramenText }};">
                            {{ $data->name }}
                        </p>
                        <p class="text-[1.45rem] sm:text-[2.9rem] font-bold italic leading-[0.95]" style="color: {{ $ramenAccent }};">
                            {{ $data->subtitle ?: 'Buat Hari Makin Nikmat!' }}
                        </p>
                    </div>

                    @php
                        $keywords = $data->productTags
                            ->map(fn ($item) => optional($item->productTag)->tag)
                            ->filter()
                            ->take(6);
                    @endphp

                    @if ($keywords->isNotEmpty())
                        <div class="flex flex-wrap gap-1.5 sm:gap-2">
                            @foreach ($keywords as $keyword)
                                <div class="rounded-full border px-3 py-1.5 text-[11px] sm:px-4 sm:py-2 sm:text-sm font-semibold" style="background-color: {{ $ramenSurface }}; border-color: {{ $ramenBorder }}; color: {{ $ramenText }};">
                                    {{ $keyword }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="relative h-full overflow-hidden z-10" style="background: radial-gradient(circle at top left, #D3492F 0%, {{ $ramenAccent }} 58%, #7D140F 100%);">
                <div class="absolute left-[-6%] top-[4%] h-[92%] w-[92%] rounded-full border-2 opacity-90" style="border-color: #F2DDD4;"></div>
                <div class="absolute left-[2%] top-[1%] h-[95%] w-[92%] rounded-full border opacity-50" style="border-color: #F2DDD4;"></div>
                <div class="absolute inset-0 flex items-center justify-center p-3 sm:p-6">
                    <div class="w-full max-w-[440px] overflow-hidden rounded-full shadow-2xl shadow-black/30">
                        <img src="{{ $data->image }}" class="aspect-square w-full object-cover object-center" alt="{{ $data->name }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
