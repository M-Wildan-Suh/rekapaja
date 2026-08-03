<div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
    <div class="relative w-full aspect-[2/1] overflow-hidden rounded-[32px] bg-[#FFF0F5] shadow-[0_20px_60px_rgba(233,120,150,.15)]">
        <div class="absolute inset-0">
            <img
                src="{{ $data->image }}"
                class="w-full h-full object-cover opacity-15"
                alt="{{ $data->name }}">
        </div>

        <div class="relative grid grid-cols-[0.95fr_1.05fr] sm:grid-cols-[0.88fr_1.12fr] items-center h-full">
            <div class="px-4 py-4 sm:px-6 sm:py-6 h-full flex items-center">
                <div class="space-y-2.5 sm:space-y-4">
                    <div>
                        <h1 class="text-[1.3rem] sm:text-[2.65rem] font-black leading-[0.95] text-[#4D3A3A]">
                            {{ $data->name }}
                        </h1>

                        <p class="mt-2 sm:mt-4 text-[11px] sm:text-base text-gray-500 leading-5 sm:leading-7">
                            {{ $data->subtitle ?: 'Rangkaian bunga segar untuk setiap momen spesial Anda.' }}
                        </p>
                    </div>

                    @if($data->productTags->count())
                        <div class="flex flex-wrap gap-1.5 sm:gap-2">
                            @foreach($data->productTags->take(4) as $tag)
                                <span class="px-2.5 py-1 sm:px-4 sm:py-2 rounded-full bg-white shadow text-[10px] sm:text-sm text-pink-500 font-semibold">
                                    {{ optional($tag->productTag)->tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="relative h-full flex justify-center items-center p-3 sm:p-6">
                <div class="absolute w-36 h-36 sm:w-72 sm:h-72 bg-pink-200 rounded-full blur-3xl opacity-40"></div>
                <div class="relative w-full max-w-[220px] sm:max-w-[320px]">
                    <img
                        src="{{ $data->image }}"
                        class="aspect-square w-full rounded-full object-cover border-[6px] sm:border-8 border-white shadow-2xl"
                        alt="{{ $data->name }}">
                </div>
            </div>
        </div>
    </div>
</div>
