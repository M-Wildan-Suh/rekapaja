@php
    $ramenText = $template->desc_text_color ?? '#231914';
    $ramenBg = $template->desc_main_color ?? '#A72018';
@endphp

<div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
    <div class="rounded-md px-5 py-6 sm:px-6 shadow-lg" style="background-color: {{ $ramenBg }}; color: {{ $ramenText }};">
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-none items-center justify-center rounded-full bg-white/10">
                    <svg viewBox="0 0 24 24" class="h-8 w-8 sm:h-9 sm:w-9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 13.5a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M5 20a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M19 7.5h.01M5 7.5h.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xl sm:text-[2rem] font-black leading-tight">{{ $data->name }}</p>
                    <p class="mt-1 text-sm font-medium uppercase tracking-[0.18em] opacity-70">Tentang Usaha</p>
                </div>
            </div>
            <div>
                <p class="text-sm sm:text-base leading-7 opacity-85">
                    {!! nl2br(e($data->description == '' ? 'Description' : $data->description)) !!}
                </p>
            </div>
        </div>
    </div>
</div>
