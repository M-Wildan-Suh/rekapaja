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
                <div class="flex w-full items-center justify-between gap-4">
                    <p class="text-sm font-semibold text-neutral-600">Id Rekap</p>
                    <div class="flex items-center gap-3">
                        <p>{{ $invoice->invoice_code }}</p>
                    <button class=" w-5 h-5 text-neutral-600 hover:text-[#ff7100] duration-300 relative" x-data="{ copied: false }" 
                        @click="navigator.clipboard.writeText('{{ route('invoice.show', ['code' => $invoice->invoice_code]) }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })">
                        <svg class="feather feather-copy" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect height="13" rx="2" ry="2" width="13" x="9" y="9"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span x-show="copied" class="absolute top-full right-0 mt-1 bg-gray-700 text-white text-xs py-1 px-2 rounded">Copied!</span>
                    </button>
                    </div>
                </div>
                <div class="flex w-full items-center justify-between gap-4">
                    <p class="text-sm font-semibold text-neutral-600">Status</p>
                    <p class="text-right">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ ($invoice->status ?? 'Pending') === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $invoice->status ?? 'Pending' }}
                        </span>
                    </p>
                </div>
                <div class="grid w-full grid-cols-[110px_minmax(0,1fr)] items-start gap-4">
                    <p class="text-sm font-semibold text-neutral-600">Nama Pemesan</p>
                    <p class="break-words text-right">{{ $invoice->customer_name ?: '-' }}</p>
                </div>
                <div class="grid w-full grid-cols-[110px_minmax(0,1fr)] items-start gap-4">
                    <p class="text-sm font-semibold text-neutral-600">Alamat</p>
                    <p class="whitespace-pre-line break-words text-right">{{ $invoice->customer_address ?: '-' }}</p>
                </div>
                <div class="flex w-full items-start justify-between gap-4">
                    <p class="text-sm font-semibold text-neutral-600">Tanggal</p>
                    <div class="space-y-1 text-right">
                        <p><span class="text-neutral-500">Jam:</span> {{ $invoice->created_at->format('H:i') }}</p>
                        <p><span class="text-neutral-500">Tanggal:</span> {{ $invoice->created_at->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                <div class=" w-full"></div>
                <div class="rekap-detail w-full text-sm sm:text-base">
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

<style>
    .rekap-detail > p[style*="font-size"] {
        display: inline-block;
        vertical-align: top;
        width: 45%;
    }

    .rekap-detail > p[style*="font-size"] + p,
    .rekap-detail > p[style*="font-size"] + b {
        display: inline-block;
        vertical-align: top;
        width: 55%;
        text-align: right;
    }
</style>
