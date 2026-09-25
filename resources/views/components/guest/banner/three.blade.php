<div class="banner-auto-resize w-full max-w-xl mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class=" w-full aspect-[4/3] bg-white rounded-md overflow-hidden relative">
        <div class=" absolute inset-0">
            <img src="{{ $data->image }}" class=" w-full h-full object-cover object-center" alt="">
        </div>
        <div class=" w-full h-full grid grid-cols-2 relative">
            <div class=" w-full h-full flex items-center justify-end overflow-hidden">
                <div class=" w-full h-full bg-black/40" style="clip-path: polygon(0% 0%, 85% 0%, 100% 100%, 0% 100%);">
                    <div class=" w-full flex flex-col h-full justify-center gap-2 sm:gap-4 text-white py-[6%] px-[10%]">
                        @include('components.guest.banner.numbered-content')
                        <div class=" flex">
                            <a href="https://wa.me/{{ $notlp ?? '' }}">
                                <button class=" w-auto px-1 sm:px-3 py-[1px] sm:py-1 bg-white text-black rounded-sm text-[9px] sm:text-base font-bold">Hubungi Kami</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>