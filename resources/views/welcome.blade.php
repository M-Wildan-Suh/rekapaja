<x-layout.guest>
    @include('components.guest.header')
    <div class=" pt-16 w-full">
        <div
            class=" w-full bg-[#4b5d70] h-[calc(100vh-44px)] text-white px-4 md:px-8 pt-0 pb-16 sm:pt-8 sm:pb-18 overflow-hidden relative">
            <div class=" absolute inset-0 overflow-hidden">
                <img src="{{ asset('assets/images/bannerbg.webp') }}" class=" w-full h-full object-cover" alt="">
                <div class=" absolute w-full bottom-0 left-0 min-h-10 h-10">
                    <svg id="visual" viewBox="0 0 1200 40" class=" w-full h-full" preserveAspectRatio="none"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
                        <path
                            d="M0 0L28.5 2C57 4 114 8 171.2 10.8C228.3 13.7 285.7 15.3 342.8 17C400 18.7 457 20.3 514.2 18.5C571.3 16.7 628.7 11.3 685.8 11C743 10.7 800 15.3 857.2 16.8C914.3 18.3 971.7 16.7 1028.8 14.3C1086 12 1143 9 1171.5 7.5L1200 6L1200 41L1171.5 41C1143 41 1086 41 1028.8 41C971.7 41 914.3 41 857.2 41C800 41 743 41 685.8 41C628.7 41 571.3 41 514.2 41C457 41 400 41 342.8 41C285.7 41 228.3 41 171.2 41C114 41 57 41 28.5 41L0 41Z"
                            fill="#d9eafd" opacity="0"></path>
                        <path
                            d="M0 13L28.5 14C57 15 114 17 171.2 19.3C228.3 21.7 285.7 24.3 342.8 24.5C400 24.7 457 22.3 514.2 19.3C571.3 16.3 628.7 12.7 685.8 11.7C743 10.7 800 12.3 857.2 14.5C914.3 16.7 971.7 19.3 1028.8 21.5C1086 23.7 1143 25.3 1171.5 26.2L1200 27L1200 41L1171.5 41C1143 41 1086 41 1028.8 41C971.7 41 914.3 41 857.2 41C800 41 743 41 685.8 41C628.7 41 571.3 41 514.2 41C457 41 400 41 342.8 41C285.7 41 228.3 41 171.2 41C114 41 57 41 28.5 41L0 41Z"
                            fill="#d9eafd" opacity="0.33"></path>
                        <path
                            d="M0 20L28.5 19.3C57 18.7 114 17.3 171.2 19.5C228.3 21.7 285.7 27.3 342.8 28.2C400 29 457 25 514.2 23.7C571.3 22.3 628.7 23.7 685.8 25.2C743 26.7 800 28.3 857.2 28.8C914.3 29.3 971.7 28.7 1028.8 27.8C1086 27 1143 26 1171.5 25.5L1200 25L1200 41L1171.5 41C1143 41 1086 41 1028.8 41C971.7 41 914.3 41 857.2 41C800 41 743 41 685.8 41C628.7 41 571.3 41 514.2 41C457 41 400 41 342.8 41C285.7 41 228.3 41 171.2 41C114 41 57 41 28.5 41L0 41Z"
                            fill="#d9eafd" opacity="0.66"></path>
                        <path
                            d="M0 29L28.5 28.5C57 28 114 27 171.2 26.3C228.3 25.7 285.7 25.3 342.8 26.5C400 27.7 457 30.3 514.2 31.5C571.3 32.7 628.7 32.3 685.8 32.3C743 32.3 800 32.7 857.2 32.3C914.3 32 971.7 31 1028.8 29.8C1086 28.7 1143 27.3 1171.5 26.7L1200 26L1200 41L1171.5 41C1143 41 1086 41 1028.8 41C971.7 41 914.3 41 857.2 41C800 41 743 41 685.8 41C628.7 41 571.3 41 514.2 41C457 41 400 41 342.8 41C285.7 41 228.3 41 171.2 41C114 41 57 41 28.5 41L0 41Z"
                            fill="#d9eafd" opacity="1"></path>
                    </svg>
                </div>
            </div>
            <div class=" w-full max-w-[1080px] h-full mx-auto relative">
                <div class=" w-full h-full sm:grid flex flex-col items-center justify-center sm:grid-cols-2 gap-8 sm:gap-0 ">
                    <div class=" flex items-center order-2 sm:order-1">
                        <div class=" space-y-3 sm:space-y-6 text-center sm:text-left">
                            <p class=" text-2xl sm:text-4xl font-bold">Bangun Citra Bisnis Anda dengan Website
                                Profesional</p>
                            <p class=" text-neutral-200">Tampil modern dan terpercaya dengan website responsif yang
                                mudah diakses di berbagai perangkat.</p>
                            <div class="flex justify-center sm:justify-start">
                                <a href="{{ route('allproduct') }}">
                                    <button
                                        class=" px-4 flex items-center justify-center gap-3 py-2 border rounded-xl text-white bg-[#ff7100] border-[#ff7100] hover:text-white hover:bg-[#b95300] hover:border-[#b95300] font-black duration-300 relative capitalize">
                                        <p>Bisnis Terdaftar</p>
                                        <div class=" w-4 h-4">
                                            <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><path d="M69.844 43.388 33.842 13.386a6.003 6.003 0 0 0-7.688 9.223L56.624 48l-30.47 25.39a6.003 6.003 0 0 0 7.688 9.223l36.002-30.001a6.01 6.01 0 0 0 0-9.223Z" fill="currentColor" class="fill-000000"></path></svg>
                                        </div>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center sm:justify-end order-1 sm:order-2">
                        <div class=" w-4/5 sm:w-11/12 aspect-square justify-end overflow-hidden">
                            <img src="{{ asset('assets/images/banner.webp') }}" class=" w-full object-contain"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-24 px-4 sm:px-6 space-y-16">
        <div class=" w-full max-w-[1080px] mx-auto">
            <div class=" w-full space-y-16 px-6 sm:px-0">
                <div class=" w-full flex flex-col items-center justify-center gap-4 sm:gap-6">
                    <p class=" text-3xl font-black capitalize text-center">Kenapa RekapAja.com?</p>
                    <div class=" rounded-xl bg-black h-1 w-20"></div>
                </div>
                <div class=" w-full grid grid-cols-1 sm:grid-cols-3 gap-16 sm:gap-8 py-8">
                    <div x-data="{ show: false }" 
                        x-intersect.once="show = true" 
                        x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'" 
                        class=" w-full bg-[#F8FAFC] rounded-xl shadow-md shadow-[#4b5d70]/20 relative transition-all duration-1000 ease-out">
                        <div
                            class=" w-16 h-16 p-3 bg-[#4b5d70] text-white rounded-xl absolute left-1/2 -translate-x-1/2 top-0 -translate-y-1/2">
                            <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h256v256H0z"></path>
                                <path
                                    d="M221.6 149.4a96.2 96.2 0 0 0 2.4-22.2c-.4-52.9-44.2-95.7-97-95.2a96 96 0 0 0-31 186.5 23.9 23.9 0 0 0 32-22.6V192a23.9 23.9 0 0 1 24-24h46.2a24 24 0 0 0 23.4-18.6Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="24" class="stroke-000000"></path>
                                <circle cx="128" cy="76" r="16" fill="currentColor" class="fill-000000">
                                </circle>
                                <circle cx="83" cy="102" r="16" fill="currentColor" class="fill-000000">
                                </circle>
                                <circle cx="83" cy="154" r="16" fill="currentColor" class="fill-000000">
                                </circle>
                                <circle cx="173" cy="102" r="16" fill="currentColor" class="fill-000000">
                                </circle>
                            </svg>
                        </div>
                        <div class=" w-full px-4 pt-14 pb-4 text-center space-y-2">
                            <p class=" text-lg sm:text-xl text-[#4b5d70] font-semibold">Desain Modern dan Elegan</p>
                            <p class=" text-[#4b5d70] text-sm sm:text-base">Tampilkan citra bisnis terpercaya dengan desain elegan, modern,
                                menarik, dan berkelas.</p>
                        </div>
                    </div>
                    <div x-data="{ show: false }" 
                        x-intersect.once="setTimeout(() => { show = true }, 200)" 
                        x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1/4'" 
                        class=" w-full bg-[#F8FAFC] rounded-xl shadow-md shadow-[#4b5d70]/20 relative transition-all duration-1000 ease-out">
                        <div
                            class=" w-16 h-16 p-3 bg-[#4b5d70] text-white rounded-xl absolute left-1/2 -translate-x-1/2 top-0 -translate-y-1/2">
                            <svg viewBox="0 0 16 16" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                enable-background="new 0 0 16 16">
                                <path
                                    d="M5 16h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2zM4 2h8v12H4V2z"
                                    fill="currentColor" class="fill-000000"></path>
                            </svg>
                        </div>
                        <div class=" w-full px-4 pt-14 pb-4 text-center space-y-2">
                            <p class=" text-lg sm:text-xl text-[#4b5d70] font-semibold">Responsif di Semua Perangkat</p>
                            <p class=" text-[#4b5d70] text-sm sm:text-base">Website mudah diakses dengan tampilan sempurna di smartphone,
                                tablet, dan komputer.</p>
                        </div>
                    </div>
                    <div x-data="{ show: false }" 
                        x-intersect.once="setTimeout(() => { show = true }, 400)" 
                        x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'" 
                        class=" w-full bg-[#F8FAFC] rounded-xl shadow-md shadow-[#4b5d70]/20 relative transition-all duration-1000 ease-out">
                        <div
                            class=" w-16 h-16 p-3 bg-[#4b5d70] text-white rounded-xl absolute left-1/2 -translate-x-1/2 top-0 -translate-y-1/2">
                            <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h256v256H0z"></path>
                                <circle cx="128" cy="128" fill="none" r="48" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="16"
                                    class="stroke-000000"></circle>
                                <path
                                    d="M183.7 65.1q3.8 3.5 7.2 7.2l27.3 3.9a103.2 103.2 0 0 1 10.2 24.6l-16.6 22.1s.3 6.8 0 10.2l16.6 22.1a102.2 102.2 0 0 1-10.2 24.6l-27.3 3.9s-4.7 4.9-7.2 7.2l-3.9 27.3a103.2 103.2 0 0 1-24.6 10.2l-22.1-16.6a57.9 57.9 0 0 1-10.2 0l-22.1 16.6a102.2 102.2 0 0 1-24.6-10.2l-3.9-27.3q-3.7-3.5-7.2-7.2l-27.3-3.9a103.2 103.2 0 0 1-10.2-24.6l16.6-22.1s-.3-6.8 0-10.2l-16.6-22.1a102.2 102.2 0 0 1 10.2-24.6l27.3-3.9q3.5-3.7 7.2-7.2l3.9-27.3a103.2 103.2 0 0 1 24.6-10.2l22.1 16.6a57.9 57.9 0 0 1 10.2 0l22.1-16.6a102.2 102.2 0 0 1 24.6 10.2Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="16" class="stroke-000000"></path>
                            </svg>
                        </div>
                        <div class=" w-full px-4 pt-14 pb-4 text-center space-y-2">
                            <p class=" text-lg sm:text-xl text-[#4b5d70] font-semibold">Mudah Diakses dan Dikelola</p>
                            <p class=" text-[#4b5d70] text-sm sm:text-base">Navigasi intuitif dengan pengelolaan konten yang praktis dan
                                sangat sederhana.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" w-full max-w-[1080px] mx-auto">
            <div class=" w-full grid sm:grid-cols-2 gap-6 sm:gap-0">
                <div class=" w-full px-6 sm:pl-8 sm:pr-16 grid grid-cols-2 gap-4">
                    <div x-data="{ show: false }" 
                        x-intersect.once="show = true" 
                        x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-1/4'" 
                        class=" w-full rounded-3xl aspect-[3/5] border-4 border-[#F8FAFC] overflow-hidden transition-all duration-1000 ease-out">
                        <img src="{{ asset('assets/images/content/left.webp') }}" class=" w-full object-cover"
                            alt="">
                    </div>
                    <div x-data="{ show: false }" 
                        x-intersect.once="show = true" 
                        x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1/4'"  
                        class=" w-full rounded-3xl aspect-[3/5] border-4 border-[#F8FAFC] overflow-hidden mt-10 transition-all duration-1000 ease-out">
                        <img src="{{ asset('assets/images/content/right.webp') }}" class=" w-full object-cover"
                            alt="">
                    </div>
                </div>
                <div x-data="{ show: false }" 
                    x-intersect.once="show = true" 
                    x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1/4'"  
                    class=" flex items-center transition-all duration-1000 ease-out">
                    <div class=" space-y-3 text-left sm:pl-4 sm:pr-8">
                        <p class=" text-2xl font-black">Buat Usaha Anda Jadi Memiliki Website Profesional</p>
                        <p class=" text-[#4b5d70]">Tingkatkan citra usaha Anda dengan website profesional yang modern,
                            responsif, dan mudah diakses. Jadikan bisnis Anda lebih terpercaya dan menarik di era
                            digital!</p>
                        <div class="flex justify-start pt-2">
                            <a href="https://wa.me/{{ $no_tlp ?? '' }}">
                                <button
                                    class=" px-4 flex items-center gap-1.5 justify-center py-2 border rounded-xl text-white bg-[#ff7100] border-[#ff7100] hover:text-white hover:bg-[#b95300] hover:border-[#b95300] font-black duration-300 relative text-sm sm:text-base">
                                    <div class=" w-4">
                                        <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                                    </div>
                                    <p>Hubungi Kami</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-[1080px] mx-auto">
            <div class=" w-full space-y-8">
                <div class=" w-full flex flex-col items-center justify-center gap-4 md:gap-6">
                    <p class=" text-3xl font-black capitalize text-center">Bisnis Terdaftar</p>
                    <div class=" rounded-xl bg-black h-1 w-20"></div>
                </div>
                <div class="grid grid-cols-2 gap-4 lg:gap-8">
                    @foreach ($data->take(4) as $item)
                        <div x-data="{ show: false }" 
                            x-intersect.once="show = true" 
                            x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-1/4'" 
                            class=" w-full bg-[#F8FAFC] shadow-md shadow-black/20 rounded-xl grid grid-cols-1 md:grid-cols-8 gap-4 md:gap-0 transition-all duration-1000 ease-out">
                            <div
                                class=" md:col-span-3 flex items-center w-full aspect-square rounded-t-md md:rounded-xl md:rounded-r-none overflow-hidden">
                                <img class=" w-full h-full object-cover"
                                    src="{{ asset('storage/images/product/' . $item->image) }}" alt="">
                            </div>
                            <div
                                class=" md:col-span-5 flex flex-col justify-between gap-1 p-2 pt-0 md:pt-8 md:p-4 md:gap-2 text-sm md:text-base">
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
                                                class=" w-[14px] h-[14px] aspect-square">
                                                <svg viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M29.946 15.675C27.954 9.888 22.35 6 16 6S4.046 9.888 2.054 15.675c-.072.21-.072.44 0 .65C4.046 22.112 9.65 26 16 26s11.954-3.888 13.946-9.675c.072-.21.072-.44 0-.65zM16 22c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6-2.691 6-6 6z" fill="currentColor" class="fill-000000"></path></svg>
                                            </div>
                                            <p>Lihat Detail</p>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class=" w-full flex justify-center">
                    <a href="{{ route('allproduct') }}" class=" text-xs sm:text-sm">
                        <button
                            class="w-full flex justify-center py-2 px-4 border rounded-xl text-white bg-[#ff7100] border-[#ff7100] hover:text-white hover:bg-[#b95300] hover:border-[#b95300] font-black duration-300 relative">Lihat
                            Lainnya</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @include('components.guest.footer')
    @include('components.admin.mobile-navbar')
</x-layout.guest>
