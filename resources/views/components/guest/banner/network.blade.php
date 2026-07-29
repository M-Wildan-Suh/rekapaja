<div class="w-full max-w-[600px] mx-auto px-4 md:px-0">

    <div class="relative overflow-hidden rounded-3xl shadow-xl">

        {{-- Background Banner --}}
        <div class="relative w-full aspect-[2/1]">

            {{-- Gambar yang diupload admin --}}
            <img
                src="{{ $data->image }}"
                class="absolute inset-0 w-full h-full object-cover"
                alt="{{ $data->name }}">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-blue-700/40 to-transparent"></div>

            {{-- Content --}}
            <div class="relative z-10 grid grid-cols-2 h-full">

                {{-- KIRI --}}
                <div class="flex flex-col justify-center px-8">

    

                    <h1
                        h1 class="mt-2 text-3xl sm:text-4xl font-extrabold leading-tight text-white">

                        {{ $data->name }}

                    </h1>

                    @if(!empty($data->subtitle))

                        <p class="mt-3 text-white/90">

                            {{ $data->subtitle }}

                        </p>

                    @endif

                    <div class="mt-6">

                        <a
                            href="https://wa.me/{{ $notlp ?? '' }}"
                            class="rounded-xl bg-white px-6 py-3 font-semibold text-blue-600 shadow hover:bg-slate-100">

                            Hubungi Kami

                        </a>

                    </div>

                </div>

                {{-- KANAN --}}
                <div class="flex items-center justify-center p-6">

                    <div
                        class="w-48 h-48 rounded-full overflow-hidden border-8 border-white shadow-2xl">

                        <img
                            src="{{ $data->image }}"
                            class="w-full h-full object-cover"
                            alt="{{ $data->name }}">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>