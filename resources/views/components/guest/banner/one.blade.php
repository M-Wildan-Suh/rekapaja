<div class=" w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class=" w-full aspect-[2/1] max-h-[50vw] bg-[#81BFDA] rounded-md overflow-hidden relative">
        <div class=" absolute inset-0">
            <img src="{{asset('/assets/images/bgeleven.png')}}" class=" w-full h-full object-cover" alt="">
        </div>
        <div class=" w-full h-full grid grid-cols-2 relative">
            <div class=" w-full h-full flex items-center py-[20%] pl-[20%]">
                <div class=" w-full flex flex-col h-full justify-between text-white">
                    <div class=" flex">
                        <div class=" w-auto px-1 sm:px-3 py-0.5 sm:pt-2 bg-white text-[#81BFDA] rounded-sm text-xs sm:text-lg font-bold">Welcome</div>
                    </div>
                    <p class=" text-2xl sm:text-5xl font-black">{{$data->name}}</p>
                    <p class=" text-[8px] sm:text-sm">{{$data->subtitle}}</p>
                    <div class=" flex">
                        <a href="https://wa.me/{{ $notlp ?? '' }}">
                            <button class=" w-auto px-1 sm:px-3 py-[1px] sm:py-1 bg-white text-[#81BFDA] rounded-sm text-[9px] sm:text-base font-bold">Hubungi Kami</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" w-full h-full flex items-center justify-end overflow-hidden p-[20%]">
                <div class=" flex max-w-full max-h-full aspect-square rounded-full overflow-hidden">
                    <img src="{{ $data->image }}" class=" w-full h-full object-cover " alt="">
                </div>
            </div>
        </div>
    </div>
</div>