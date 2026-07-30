<div class="w-full max-w-[600px] mx-auto px-4 md:px-0">

    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl shadow-xl">

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
            <div class="relative z-10 grid h-full grid-cols-2">

                {{-- KIRI --}}
                <div class="flex flex-col justify-center px-4 sm:px-8">

    

                    <h1
                        h1 class="mt-1 text-[1.35rem] sm:mt-2 sm:text-4xl font-extrabold leading-tight text-white">

                        {{ $data->name }}

                    </h1>

                    @if(!empty($data->subtitle))

                        <p class="mt-2 text-[10px] leading-4 text-white/90 sm:mt-3 sm:text-base sm:leading-normal">

                            {{ $data->subtitle }}

                        </p>

                    @endif

                    <div class="mt-3 sm:mt-6">

                        <a
                            href="https://wa.me/{{ $notlp ?? '' }}"
                            class="inline-flex rounded-lg bg-white px-3 py-1.5 text-[11px] font-semibold text-blue-600 shadow hover:bg-slate-100 sm:rounded-xl sm:px-6 sm:py-3 sm:text-base">

                            Hubungi Kami

                        </a>

                    </div>

                </div>

                {{-- KANAN --}}
                <div class="flex items-center justify-center p-3 sm:p-6">

                    <div
                        class="h-24 w-24 rounded-full overflow-hidden border-4 border-white shadow-2xl sm:h-48 sm:w-48 sm:border-8">

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
