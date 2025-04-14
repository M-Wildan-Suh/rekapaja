<x-layout.guest>
    <div class=" w-full max-w-xl mx-auto grid grid-cols-2 gap-3 lg:gap-8">
        @foreach ($data as $item)
            <div x-data="{ show: false }" 
                x-intersect.once="show = true" 
                x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1/4'" 
                class=" w-full bg-[#F8FAFC] shadow-md shadow-black/20 rounded-xl grid grid-cols-1 gap-2 transition-all duration-1000 ease-out">
                <div
                    class=" flex items-center w-full aspect-square rounded-t-md overflow-hidden relative">
                    <img class=" w-full h-full object-cover"
                        src="{{ asset('storage/images/product/' . $item->image) }}" alt="">
                    <div class=" absolute bottom-4 left-4 z-20 flex flex-wrap gap-2">
                        @foreach ($item->category as $category)
                            <div class=" text-xs sm:text-sm backdrop-blur bg-black/50 cursor-default rounded-full border-2 border-[#ff7100] text-[#ff7100] px-2 py-1">{{$category->category}}</div>
                        @endforeach
                    </div>
                </div>
                <div
                    class=" flex flex-col justify-between gap-1 p-2 pt-0 text-sm">
                    <a href="{{ route('detail', ['slug' => $item->slug]) }}">
                        <p class=" text-lg font-semibold line-clamp-1">{{ $item->name }}</p>
                    </a>
                    <div class="">
                        {{-- <p class="">Mulai dari Rp. {{ str_replace(',', '.', number_format($item->price))}}</p> --}}
                        <p class=" text-neutral-600 text-sm line-clamp-2">{{ $item->subtitle }}</p>
                    </div>
                    <div class=" pt-2 gap-2">
                        <a href="{{ route('detail', ['slug' => $item->slug]) }}">
                            <button
                                class="w-full flex items-center justify-center py-1 sm:py-2 border rounded-xl text-white bg-[#ff7100] border-[#ff7100] hover:text-white hover:bg-[#b95300] hover:border-[#b95300] font-black duration-300 relative text-xs sm:text-sm gap-1 sm:gap-2">
                                <div
                                    class="w-[14px] h-[14px] aspect-square">
                                    <svg viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M29.946 15.675C27.954 9.888 22.35 6 16 6S4.046 9.888 2.054 15.675c-.072.21-.072.44 0 .65C4.046 22.112 9.65 26 16 26s11.954-3.888 13.946-9.675c.072-.21.072-.44 0-.65zM16 22c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6-2.691 6-6 6z" fill="currentColor" class="fill-000000"></path></svg>
                                </div>
                                <p>Lihat Detail</p>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        @if ($data->isEmpty())
            <div class=" col-span-2 text-sm sm:text-base text-gray-500">Bisnis tidak ditemukan</div>
        @endif
    </div>
    <script>
        window.addEventListener('load', () => {
          parent.postMessage({
            height: document.body.scrollHeight
          }, '*');
        });
      </script>      
</x-layout.guest>