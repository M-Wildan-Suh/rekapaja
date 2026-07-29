{{-- ================= PRODUK ================= --}}
@if($data->productHighlight->count())

<section class="w-full max-w-[600px] mx-auto px-4 mt-8">
    

    {{-- Judul --}}
    <div class="text-center mb-5">

        <h2 class="text-2xl font-bold text-slate-800">
            Katalog Produk
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Pilihan terbaik untuk kebutuhan jaringan Anda
        </p>

    </div>

    {{-- Produk --}}
      <div class="grid grid-cols-2 gap-4">

        @foreach($data->productHighlight as $item)

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition">

            {{-- Foto --}}
            <div class="relative">

                <x-guest.lazyfancy-image
                    :image="$item->image"
                    class="w-full h-28 object-cover" />

                @if($loop->first)
                    <span class="absolute top-2 left-2 bg-blue-600 text-white text-[9px] px-2 py-1 rounded">
                        BEST SELLER
                    </span>
                @endif

            </div>

            {{-- Isi --}}
            <div class="p-3">

                <h3 class="font-semibold text-sm text-slate-800 line-clamp-2 h-10">

                    {{ $item->title }}

                </h3>

                @if($item->description)

                    <p class="text-[11px] text-gray-500 mt-1 line-clamp-2 leading-4">

                        {{ $item->description }}

                    </p>

                @endif

                {{-- Harga --}}
                @if($item->price)

                    <p class="mt-2 text-green-700 font-bold text-base">

                        Rp {{ number_format($item->price,0,',','.') }}

                    </p>

                @endif

                {{-- Harga --}}
                @if($item->price)
                <p class="mt-2 text-blue-600 text-lg font-medium">
                    Rp {{ number_format($item->price,0,',','.') }}
                </p>
                @endif


                {{-- Tombol --}}
                <a
                    href="https://wa.me/{{ $no_tlp }}?text={{ urlencode('Halo saya tertarik dengan '.$item->title) }}"
                    target="_blank"
                    class="mt-3 flex items-center justify-center gap-2 w-full bg-green-600 hover:bg-green-700 text-white rounded-md py-2 text-xs font-semibold duration-300">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 24 24">

                        <path d="M20.52 3.48A11.87 11.87 0 0012.06 0C5.5 0 .16 5.34.16 11.9c0 2.09.55 4.13 1.59 5.95L0 24l6.31-1.65a11.88 11.88 0 005.75 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.16-3.45-8.43z"/>

                    </svg>

                    Order via WhatsApp

                </a>

            </div>

        </div>

        @endforeach

    </div>

</section>

@endif