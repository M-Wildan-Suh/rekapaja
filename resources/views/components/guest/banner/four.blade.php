<div class=" w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class=" w-full aspect-[2/1] max-h-[50vw] bg-[#1D1616] rounded-md overflow-hidden relative">
        <div class=" absolute inset-0">
            <img src="{{ $data->image }}" class=" w-full h-full object-cover object-center" alt="">
        </div>
        <div style="box-shadow: 0px -178px 115px -74px rgba(0,0,0,0.75) inset;" class=" w-full h-full flex items-end relative">
            <div class=" w-full px-4 sm:px-6 py-4 sm:py-8 text-white sm:space-y-3">
                <p class=" text-3xl sm:text-5xl font-bold">{{$data->name}}</p>
                <p class=" text-sm sm:text-xl">{{$data->subtitle}}</p>
            </div>
        </div>
    </div>
</div>