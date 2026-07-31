<div class="relative overflow-hidden rounded-[40px] bg-[#FFF0F5] shadow-[0_20px_60px_rgba(233,120,150,.15)]">

    {{-- Background --}}
    <div class="absolute inset-0">
        <img
            src="{{ $data->image }}"
            class="w-full h-full object-cover opacity-15">
    </div>

    <div class="relative grid md:grid-cols-2 items-center min-h-[420px]">

        {{-- Kiri --}}
        <div class="px-8 py-10 space-y-6">

            <span class="inline-block px-5 py-2 rounded-full bg-pink-100 text-pink-500 font-semibold tracking-widest uppercase text-xs">
                Flower Shop
            </span>

            <div>

                <h1 class="text-5xl font-black leading-tight text-[#4D3A3A]">
                    {{ $data->name }}
                </h1>

                <p class="mt-5 text-lg text-gray-500 leading-8">
                    {{ $data->subtitle ?: 'Rangkaian bunga segar untuk setiap momen spesial Anda.' }}
                </p>

            </div>

            @if($data->productTags->count())

            <div class="flex flex-wrap gap-3">

                @foreach($data->productTags as $tag)

                    <span class="px-4 py-2 rounded-full bg-white shadow text-sm text-pink-500 font-semibold">

                        {{ optional($tag->productTag)->tag }}

                    </span>

                @endforeach

            </div>

            @endif

        </div>

        {{-- Kanan --}}
        <div class="relative flex justify-center items-center py-10">

            <div class="absolute w-72 h-72 bg-pink-200 rounded-full blur-3xl opacity-40"></div>

            <img
                src="{{ $data->image }}"
                class="relative w-[320px] h-[320px] rounded-full object-cover border-8 border-white shadow-2xl">

        </div>

    </div>

</div>