<div class="px-4">

    <div class="bg-white rounded-3xl overflow-hidden shadow-xl">

        {{-- Banner --}}
        <div class="relative">

            <img
                src="{{ asset('storage/images/product/'.$data->image) }}"
                class="w-full h-72 object-cover"
                alt="{{ $data->name }}">

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

            <div class="absolute bottom-0 left-0 p-6 w-full">

                <div class="flex items-center gap-4">

                    <img
                        src="{{ asset('storage/images/product/'.$data->image) }}"
                        class="w-16 h-16 rounded-full border-4 border-white object-cover">

                    <div>

                        <h1 class="text-white text-3xl font-bold">
                            {{ $data->name }}
                        </h1>

                        @if($data->subtitle)
                            <p class="text-white/90">
                                {{ $data->subtitle }}
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- MENU FITUR --}}

<div class="px-4 mt-5">

    <div class="grid grid-cols-4 gap-3">

        <div class="bg-white rounded-xl shadow p-4 text-center">

            <div class="text-3xl">🛒</div>

            <p class="text-xs mt-2 font-semibold">
                Produk
            </p>

        </div>

        <div class="bg-white rounded-xl shadow p-4 text-center">

            <div class="text-3xl">⭐</div>

            <p class="text-xs mt-2 font-semibold">
                Terlaris
            </p>

        </div>

        <div class="bg-white rounded-xl shadow p-4 text-center">

            <div class="text-3xl">🚚</div>

            <p class="text-xs mt-2 font-semibold">
                Pengiriman
            </p>

        </div>

        <div class="bg-white rounded-xl shadow p-4 text-center">

            <div class="text-3xl">💬</div>

            <p class="text-xs mt-2 font-semibold">
                Chat
            </p>

        </div>

    </div>

</div>