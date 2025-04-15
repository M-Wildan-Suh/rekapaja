<x-layout.guest>
    <div class=" w-full bg-neutral-100">
        <div class=" w-full max-w-[600px] mx-auto p-6 rounded-lg min-h-screen flex flex-col justify-center items-center">
            <h1 class=" text-xl sm:text-2xl font-bold text-center mb-4 uppercase">Rekap Orderan {{$data->name}}</h1>
    
            <hr class="my-2">
    
            <div class=" bg-white p-4 rounded-md w-full space-y-2 relative">
                <div class="flex justify-between items-center w-full">
                    <p class=" w-full text-lg font-bold">Rekap orderan</p>
                    <button x-data="{ copied: false }" 
                        @click="navigator.clipboard.writeText('{{ route('invoice.show', ['code' => $invoice->invoice_code]) }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })" 
                        class=" text-sm bg-[#ff7100] py-1 px-3 rounded-full text-white hover:bg-[#b95300] duration-300 relative text-nowrap">
                        Copy link
                        <span x-show="copied" class="absolute top-full right-0 mt-1 bg-gray-700 text-white text-xs py-1 px-2 rounded">Copied!</span>
                    </button>
                </div>
                <div class=" flex w-full items-center justify-between">
                    <div class=" ">
                        <p class=" text-sm text-neutral-600 font-semibold">Id Rekap</p>
                        <p class="">{{$invoice->invoice_code}}</p>
                    </div>
                    <button class=" w-5 h-5 text-neutral-600 hover:text-[#ff7100] duration-300 relative" x-data="{ copied: false }" 
                        @click="navigator.clipboard.writeText('{{ route('invoice.show', ['code' => $invoice->invoice_code]) }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })">
                        <svg class="feather feather-copy" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect height="13" rx="2" ry="2" width="13" x="9" y="9"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span x-show="copied" class="absolute top-full right-0 mt-1 bg-gray-700 text-white text-xs py-1 px-2 rounded">Copied!</span>
                    </button>
                </div>
                <div class=" w-full"></div>
                <div class=" w-full text-sm sm:text-base">
                    {!! nl2br($invoice->invoice_text) !!}
                    <p class=" text-sm text-neutral-600">*Belum termasuk ongkir</p>
                </div>
            </div>
    
            <a href="{{ route('detail', ['slug' => $data->slug]) }}" class=" text-sm sm:text-base text-center w-full block mt-4 bg-[#ff7100] text-white py-2 px-4 rounded-md font-bold hover:bg-[#b95300]">
                Kembali ke {{$data->name}}
            </a>
        </div>
    </div>
</x-layout.guest>