<x-layout.guest>
    @include('components.guest.header')
    <div class="pt-28 pb-8 px-4 sm:px-6 space-y-8 min-h-[calc(100vh-140px)]">  
        <div class="w-full max-w-xl mx-auto">
            <div class=" w-full space-y-8">
                <div class=" w-full space-y-2 sm:space-y-6">
                    <div class=" w-full flex items-center gap-4 md:gap-6">
                        <p class=" text-lg sm:text-[28px] font-black capitalize text-left">Pilih Paket Anda</p>
                    </div>
                </div>
                <div class=" w-full space-y-4">
                    @php
                        function formatHarga($harga) {
                            if ($harga >= 1000000) {
                                $juta = $harga / 1000000;
                                // Tampilkan satu angka di belakang koma jika ada desimal
                                return (fmod($juta, 1) > 0) ? number_format($juta, 1, '.', '') . 'jt' : number_format($juta, 0) . 'jt';
                            } elseif ($harga >= 1000) {
                                return number_format($harga / 1000, 0) . 'k';
                            } else {
                                return $harga;
                            };
                        };
                    @endphp
                    @foreach ($data as $item)
                        <div class=" w-full h-[128px] sm:h-40 flex justify-between gap-4 bg-white shadow-md shadow-black/20 rounded-md overflow-hidden">
                            <div class=" w-16 sm:w-36 bg-[#ff7100] flex justify-center items-center">
                                <h1 class=" text-sm sm:text-2xl text-white font-bold">{{$item->name}}</h1>
                            </div>
                            <div class=" flex flex-grow flex-col py-2 sm:py-4 gap-1">
                                <p class=" text-sm sm:text-base font-bold">Manfaat Paket :</p>
                                <div class=" text-xs sm:text-sm">
                                    {!! nl2br($item->desc) !!}
                                </div>
                            </div>
                            <div class=" w-[76px] sm:w-24 flex flex-col justify-center items-center gap-4 bg-[#ff7100] text-white relative overflow-hidden">
                                <div class="">
                                    <div class=" flex justify-center text-center">
                                        <p class=" text-xs sm:text-sm font-bold">Rp</p>
                                        <div class=" text-xl sm:text-2xl">{{ formatHarga($item->price) }}</div>
                                    </div>
                                    <p class=" text-xs sm:text-sm text-center">per Bulan</p>
                                </div>
                                <a href="{{route('buy.package', ['id' => $item->id])}}" target="_blank">
                                    <button class=" absolute group inset-0">
                                        <div class=" text-sm sm:text-base bg-black flex items-center justify-center text-center w-full h-full translate-x-full group-hover:translate-x-0 duration-300">
                                            <p class=" font-bold">Beli Sekarang</p>
                                        </div>
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('components.guest.footer')
    @include('components.admin.mobile-navbar')
</x-layout.guest>