<div class=" w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class=" w-full aspect-[2/1] max-h-[50vw] bg-[#81BFDA] rounded-md overflow-hidden relative">
        <div class=" absolute flex items-center left-0 top-0 w-[60%] h-full">
            <img src="{{ $data->image }}" class=" w-full h-full object-cover object-center" alt="">
        </div>
        <div class=" w-full h-full grid grid-cols-2 relative">
            <div class=" w-full h-full flex items-center justify-end overflow-hidden p-[20%]">
                
            </div>
            <div class=" bg-gradient-to-tl from-violet-500 to-violet-600 w-full h-full flex items-center py-[20%] px-[10%] rounded-l-3xl border-l-8 border-violet-800">
                <div class=" w-full flex flex-col items-center text-center h-full justify-between text-white">
                    <hr class=" w-full h-[2%] bg-white">
                    <p class=" text-xl sm:text-4xl font-black">{{$data->name}}</p>
                    <hr class=" w-full h-[2%] bg-white">
                    <p class=" text-[8px] sm:text-sm">{{$data->subtitle}}</p>
                    <div class=" flex">
                        <a href="https://wa.me/{{ $notlp ?? '' }}">
                            <button class=" w-auto px-1 sm:px-3 py-[1px] sm:py-1 bg-white text-violet-500 rounded-sm text-[9px] sm:text-base font-bold">Hubungi Kami</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>