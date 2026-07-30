{{-- ================= TENTANG KAMI ================= --}}

<section class="w-full max-w-[600px] mx-auto px-4 md:px-0 mt-8">

    <div class="relative overflow-hidden rounded-3xl bg-white shadow-xl border border-slate-100">

        {{-- Background Decoration --}}
        <div class="absolute -top-20 -right-20 w-56 h-56 rounded-full bg-blue-100 opacity-40 blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 w-40 h-40 rounded-full bg-blue-50 opacity-60 blur-2xl"></div>

        <div class="relative p-7">

            {{-- Header --}}
            <div class="flex items-center gap-4 mb-6">

                <div
                    class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 20h5V4H2v16h5m10 0v-4a3 3 0 00-3-3H10a3 3 0 00-3 3v4m10 0H7"/>

                    </svg>

                </div>

                <div>

                    <span
                        class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">

                        COMPANY PROFILE

                    </span>

                    <h2 class="mt-2 text-2xl font-bold text-slate-800">

                        Tentang Kami

                    </h2>

                </div>

            </div>

            {{-- Garis --}}
            <div class="w-20 h-1 rounded-full bg-blue-600 mb-6"></div>

            {{-- Isi --}}
            <div
                class="text-gray-600 leading-8 text-[15px] text-justify">

                {!! nl2br(e($data->description)) !!}

            </div>

        </div>

    </div>

</section>