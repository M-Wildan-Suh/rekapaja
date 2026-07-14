<div class=" mx-auto rounded-md bg-white min-h-screen relative">
    <div class=" space-y-6">
        <div class=" min-h-screen pt-6 relative space-y-4 bg-gradient-to-b bg-neutral-100">
            <div class=" w-full max-w-[640px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
                <div class=" w-full aspect-[2/1] max-h-[50vw] bg-[#81BFDA] rounded-md overflow-hidden relative">
                    <div class=" absolute flex items-center left-0 top-0 w-[60%] h-full">
                        <img src="{{ $data->image }}" class=" w-full h-full object-cover object-center" alt="">
                    </div>
                    <div class=" w-full h-full grid grid-cols-2 relative">
                        <div class=" w-full h-full flex items-center justify-end overflow-hidden p-[20%]">
                            
                        </div>
                        <div class=" bg-gradient-to-tl from-violet-500 to-violet-600 w-full h-full flex items-center py-[20%] px-[10%] rounded-l-3xl border-l-8 border-violet-800">
                            <div class=" w-full flex flex-col items-center text-center h-full justify-between text-white">
                                <hr class=" w-full h-[2%] bg-white">
                                <p class=" text-xl sm:text-4xl font-black">{{$data->name}}</p>
                                <hr class=" w-full h-[2%] bg-white">
                                <p class=" text-[8px] sm:text-sm">{{$data->subtitle}}</p>
                                <div class=" flex">
                                    <a href="https://wa.me/{{ $notlp ?? '' }}">
                                        <button class=" w-auto px-1 sm:px-3 py-[1px] sm:py-1 bg-white text-violet-500 rounded-sm text-[9px] sm:text-base font-bold">Hubungi Kami</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" w-full max-w-[640px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
                <div class="swiper h-full max-h-full">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        @foreach ($data->productGallery as $item)
                            <div class="swiper-slide w-full aspect-[3/4] rounded-md overflow-hidden relative">
                                <img src="{{ $item->image }}" class="w-full h-full object-cover object-center" alt="Raja Ampat">
                                <div class=" w-full absolute inset-0 bg-black/20"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="prev absolute top-1/2 -translate-y-1/2 flex items-center px-2 left-0 z-10 py-3 bg-black/50 rounded-r-md">
                        <div class=" text-white w-6 h-6">
                            <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><path d="m39.376 48.002 30.47-25.39a6.003 6.003 0 0 0-7.688-9.223L26.156 43.391a6.01 6.01 0 0 0 0 9.223l36.002 30.001a6.003 6.003 0 0 0 7.688-9.223Z" fill="currentColor" class="fill-000000"></path></svg>
                        </div>
                    </div>
                    <div class="next absolute top-1/2 -translate-y-1/2 flex items-center px-2 right-0 z-10 py-3 bg-black/50 rounded-l-md">
                        <div class=" text-white w-6 h-6">
                            <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><path d="M69.844 43.388 33.842 13.386a6.003 6.003 0 0 0-7.688 9.223L56.624 48l-30.47 25.39a6.003 6.003 0 0 0 7.688 9.223l36.002-30.001a6.01 6.01 0 0 0 0-9.223Z" fill="currentColor" class="fill-000000"></path></svg>
                        </div>
                    </div>
                </div>
                <script>
                    window.addEventListener('load', function() {
                        const swiper = new Swiper('.swiper', {
                            direction: 'horizontal',
                            slidesPerView: 2,
                            spaceBetween: 16,
                            loop: true,
                            speed: 500,
                            autoplay: {
                                delay: 6000,
                                disableOnInteraction: false,
                            },
                            breakpoints: {
                                640: {
                                    slidesPerView: 3,
                                },
                            },
                            // Navigation arrows
                            navigation: {
                                nextEl: '.next',
                                prevEl: '.prev',
                            },
                        });
                    });
                </script>
            </div>

            <x-guest.description color="#8b5cf6" :data="$data" />
            @include('components.guest.qris-section')

            <div x-data="{ checkedItems: [] }" class="w-full max-w-[640px] mx-auto px-4 md:px-0 relative">
                <div class=" w-full">
                    <form id="myForm" action="{{route('order')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-3">
                            @foreach ($data->productHighlight as $item)
                                @php
                                    // Tentukan warna berdasarkan indeks
                                    $colors = ['#fa82d8', '#FCC737', '#8b5cf6']; // Pink, Kuning, Ungu
                                    $boxShadowColor = $colors[$loop->index % 3]; // Berganti warna setiap kelipatan 3
                                @endphp
                                <div style="background-color: {{ $boxShadowColor }};" class="w-full p-3 rounded-xl flex gap-2 text-white">
                                    <div class="min-w-24 h-24 aspect-square rounded-full border-2 overflow-hidden border-[#00fffb]">
                                        <img src="{{ $item->image }}" class="w-full h-full object-cover" alt="">
                                    </div>
                                    <div class="w-full flex flex-col justify-between gap-2">
                                        <p class="line-clamp-1 font-semibold">{{$item->title}}</p>
                                        <x-guest.product.detail-button :item="$item" class="duration-300 rounded-md py-1 px-3 text-sm cursor-pointer border-2 border-white hover:bg-white/50 self-start" />
                                        <div class="w-full flex items-end justify-end">
                                            @if ($role === "admin" || $role === "premium")
                                                <div class="rounded-md">
                                                    <input 
                                                        type="checkbox" 
                                                        class="hidden" 
                                                        name="order[]" 
                                                        value="{{$item->id}}" 
                                                        id="order-{{ $item->id }}" 
                                                        @input="checkedItems.some(data => data.id === {{ $item->id }}) 
                                                            ? checkedItems = checkedItems.filter(data => data.id !== {{ $item->id }}) 
                                                            : checkedItems.push({ id: {{ $item->id }}, title: '{{ $item->title }}' })">
                
                                                    <label 
                                                        for="order-{{ $item->id }}" 
                                                        :class="checkedItems.some(data => data.id === {{ $item->id }}) ? 'bg-white/50' : ''" 
                                                        class="duration-300 rounded-md py-1 px-3 text-sm cursor-pointer border-2 border-white">
                                                        {{$data->order_title}}
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                    <div 
                        x-data="{ dropdownOpen: false }" 
                        x-show="checkedItems.length > 0" 
                        class="">
                        <div class=" fixed left-1/2 -translate-x-1/2 bottom-16 z-40">
                            <button 
                                @click="dropdownOpen = !dropdownOpen" 
                                :class="dropdownOpen ? 'bg-black' : 'bg-black/60'" 
                                class="text-base flex items-center justify-center py-2 px-3 gap-2 rounded-full duration-300 text-white relative">
                                <div 
                                    class="absolute -top-1 -right-1 bg-red-600 rounded-full w-5 h-5 text-xs flex items-center justify-center" 
                                    x-text="checkedItems.length"></div>
                                <div class="w-5 aspect-square">
                                    <svg data-name="Layer 1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.53 5 5 3H1.25a1 1 0 0 0 0 2h2.22L6.7 18H20v-2H8.26l-.33-1.34L21 12.17V5ZM19 10.52 7.45 12.71 6 7h13ZM7 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 7 19Zm12 0a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 19 19Z" 
                                            fill="currentColor" class="fill-000000"></path>
                                    </svg>
                                </div>
                                <p>Order</p>
                            </button>
                        </div>
                
                        <!-- Dropdown menu -->
                        <div 
                            x-show="dropdownOpen" 
                            {{-- @click.outside="dropdownOpen = false"  --}}
                            
                            class="fixed z-40 inset-0 flex items-end bg-black/40">
                            <div
                                x-show="dropdownOpen" 
                                x-transition:enter="transition ease-out duration-300" 
                                x-transition:enter-start="opacity-0 transform scale-95 translate-y-full" 
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95 translate-y-full" 
                                class=" pt-5 pb-12 px-3 bg-white sm:rounded-t-md flex flex-col gap-2 w-full max-w-[640px] mx-auto">
                                <template x-for="item in checkedItems" :key="item.id">
                                    <div class="flex justify-between items-center py-1 px-2 border border-black rounded-md">
                                        <p class="" x-text="item.title"></p>
                                        <button 
                                            @click="checkedItems = checkedItems.filter(checkedItem => checkedItem.id !== item.id)" 
                                            class="text-red-500 hover:text-red-700 text-xl duration-300">&times;</button>
                                    </div>
                                </template>
                                <div class=" w-full flex justify-end gap-2">
                                    <button @click="dropdownOpen = !dropdownOpen"  class=" py-1.5 px-3 flex items-center gap-2 text-sm border border-black rounded-md hover:bg-black/50 duration-300">Close</button>
                                    <button onclick="document.getElementById('myForm') ? document.getElementById('myForm').submit() : console.error('Form tidak ditemukan!')" class=" py-1.5 px-3 flex items-center gap-2 text-sm border border-green-500 hover:border-green-700 rounded-md bg-green-500 hover:bg-green-700 text-white duration-300">
                                        <div class=" w-4 h-4">
                                            <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                                        </div>
                                        <p>Order</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" w-full max-w-[640px] mx-auto px-4 md:px-0 relative">
                <div class=" w-full grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class=" w-full h-full rounded-md bg-[#FF0000] hidden sm:flex items-center justify-center p-[10%]">
                        <div class=" w-full aspect-square">
                            <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><rect height="512" rx="64" ry="64" width="512" fill="#ff0000" fill-opacity="1" fill-rule="nonzero" stroke="none" class="fill-cf2200"></rect><path d="M371.289 348.587h-21.956l.103-12.751c0-5.667 4.653-10.303 10.342-10.303h1.4c5.698 0 10.364 4.636 10.364 10.303l-.253 12.75zm-82.342-27.325c-5.57 0-10.125 3.742-10.125 8.325V391.6c0 4.573 4.556 8.307 10.125 8.307 5.59 0 10.15-3.734 10.15-8.307v-62.013c0-4.587-4.56-8.325-10.15-8.325zm133.72-34.689v117.974c0 28.297-24.543 51.453-54.534 51.453H143.871c-30.004 0-54.538-23.156-54.538-51.453V286.573c0-28.297 24.534-51.457 54.538-51.457h224.262c29.991 0 54.534 23.16 54.534 51.457zM158.83 417.356V293.084l27.8.01V274.68l-74.107-.111v18.102l23.134.067v124.618h23.19zm83.333-105.76h-23.177v66.36c0 9.6.582 14.4-.045 16.093-1.884 5.147-10.355 10.609-13.657.555-.56-1.76-.067-7.07-.076-16.19l-.093-66.818h-23.05l.072 65.764c0 10.08-.227 17.6.08 21.018.564 6.03.364 13.066 5.96 17.08 10.426 7.515 30.413-1.12 35.413-11.858l-.044 13.702 18.613.022V311.596zm74.147 75.99-.049-55.23c0-21.05-15.764-33.658-37.142-16.627l.093-41.062-23.155.035-.111 141.734 19.035-.28 1.734-8.827c24.337 22.324 39.63 7.031 39.595-19.742zm72.538-7.32-17.382.094c0 .689-.045 1.484-.045 2.351v9.698c0 5.187-4.289 9.413-9.497 9.413h-3.405c-5.218 0-9.502-4.226-9.502-9.413v-25.507h39.795v-14.978c0-10.946-.28-21.888-1.186-28.146-2.845-19.796-30.631-22.938-44.667-12.805-4.409 3.165-7.773 7.4-9.729 13.094-1.978 5.693-2.955 13.47-2.955 23.35v32.93c.004 54.746 66.502 47.009 58.568-.08zm-89.147-178.79c1.196 2.906 3.054 5.262 5.574 7.04 2.488 1.75 5.675 2.63 9.484 2.63 3.342 0 6.302-.902 8.88-2.764 2.569-1.853 4.733-4.622 6.498-8.315l-.436 9.093h25.836V99.289H335.2V184.8c0 4.631-3.813 8.422-8.476 8.422-4.635 0-8.462-3.79-8.462-8.422V99.289h-21.226v74.107c0 9.44.168 15.733.448 18.924a32.158 32.158 0 0 0 2.218 9.156zm-78.293-62.054c0-10.546.88-18.782 2.627-24.72 1.76-5.915 4.92-10.67 9.497-14.258 4.565-3.604 10.41-5.408 17.516-5.408 5.978 0 11.098 1.173 15.378 3.47 4.297 2.312 7.609 5.312 9.91 9.014 2.343 3.716 3.934 7.533 4.783 11.44.867 3.96 1.293 9.933 1.293 17.991v27.787c0 10.19-.409 17.689-1.2 22.449-.786 4.773-2.475 9.2-5.089 13.35-2.582 4.107-5.91 7.179-9.946 9.139-4.08 1.977-8.747 2.946-14.018 2.946-5.889 0-10.849-.813-14.938-2.51-4.102-1.69-7.27-4.236-9.529-7.619-2.28-3.386-3.884-7.51-4.853-12.32-.973-4.804-1.436-12.03-1.436-21.662v-29.089zm20.235 43.645c0 6.222 4.632 11.302 10.272 11.302 5.644 0 10.253-5.08 10.253-11.302v-58.49c0-6.213-4.609-11.293-10.253-11.293-5.64 0-10.272 5.08-10.272 11.294v58.489zM170.142 212.6h24.374l.044-84.267 28.8-72.186h-26.658l-15.31 53.617L165.861 56H139.48l30.64 72.373.044 84.227z" fill="#ffffff" fill-opacity="1" class="fill-ffffff"></path></svg>
                        </div>
                    </div>
                    <div class=" sm:col-span-2 w-full aspect-video rounded-md overflow-hidden bg-white">
                        <div class="w-full h-full">
                            <iframe src="{{$data->embed}}" frameborder="0" class="w-full h-full" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" w-full max-w-[640px] mx-auto px-4 md:px-0 relative flex flex-wrap gap-2">
                @foreach ($data->productTags as $item)
                    <div class=" text-sm px-3 py-1.5 bg-violet-500 text-white rounded-md">{{$item->productTag->tag}}</div>
                @endforeach
            </div>
                
            <x-guest.contact :role="$role" classa="text-white bg-[#fa82d8] border-[#e85fc1] hover:text-white hover:bg-[#dd5bb8] hover:border-[#dd5bb8]" classb="bg-[#FCC737] text-white border-[#FCC737] hover:text-white hover:bg-[#d2ab41] hover:border-[#d2ab41]" :data="$data" :notlp="$no_tlp"/>
        </div>
    </div>
</div>
