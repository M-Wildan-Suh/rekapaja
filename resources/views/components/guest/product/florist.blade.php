<section id="product" class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        {{-- Heading --}}

        <div class="text-center mb-14">

            <span class="text-pink-500 font-semibold uppercase tracking-[5px]">
                Produk Kami
            </span>

            <h2 class="text-4xl md:text-5xl font-bold mt-3 text-gray-800">
                Bouquet Terfavorit
            </h2>

            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                Pilihan rangkaian bunga terbaik dengan desain elegan
                untuk berbagai momen spesial.
            </p>

        </div>

        @php

        $products = [

            [
                'title'=>'Sweet Pink',
                'price'=>'Rp175.000',
                'image'=>'product1.webp',
                'badge'=>'BEST SELLER'
            ],

            [
                'title'=>'White Lily',
                'price'=>'Rp210.000',
                'image'=>'product2.webp',
                'badge'=>'NEW'
            ],

            [
                'title'=>'Classic Rose',
                'price'=>'Rp195.000',
                'image'=>'product3.webp',
                'badge'=>'BEST SELLER'
            ],

            [
                'title'=>'Sunflower',
                'price'=>'Rp165.000',
                'image'=>'product4.webp',
                'badge'=>'HOT'
            ],

            [
                'title'=>'Tulip Fresh',
                'price'=>'Rp240.000',
                'image'=>'product5.webp',
                'badge'=>'NEW'
            ],

            [
                'title'=>'Romantic Box',
                'price'=>'Rp325.000',
                'image'=>'product6.webp',
                'badge'=>'PREMIUM'
            ],

        ];

        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach($products as $item)

            <div
            class="bg-white rounded-[30px] overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group">

                {{-- Badge --}}

                <div class="absolute z-20">

                    <span
                    class="bg-pink-500
                    text-white
                    text-xs
                    px-4
                    py-2
                    rounded-br-2xl">

                    {{ $item['badge'] }}

                    </span>

                </div>

                {{-- Image --}}

                <div class="overflow-hidden">

                    <img
                    src="{{ asset('images/templates/florist/'.$item['image']) }}"
                    class="w-full h-[320px] object-cover group-hover:scale-110 duration-500">

                </div>

                {{-- Content --}}

                <div class="p-7">

                    <h3 class="font-bold text-2xl">

                        {{ $item['title'] }}

                    </h3>

                    <p class="text-gray-500 mt-3 leading-7">

                        Rangkaian bunga segar pilihan
                        dengan kualitas premium,
                        cocok untuk hadiah maupun dekorasi.

                    </p>

                    <div
                    class="flex justify-between items-center mt-7">

                        <div>

                            <span
                            class="text-pink-500
                            text-3xl
                            font-bold">

                            {{ $item['price'] }}

                            </span>

                        </div>

                    </div>

                    <button
                    class="w-full
                    mt-7
                    bg-pink-500
                    hover:bg-pink-600
                    text-white
                    rounded-2xl
                    py-4
                    font-semibold
                    transition">

                        Lihat Detail →

                    </button>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>