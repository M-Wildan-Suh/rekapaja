<div class=" mx-auto rounded-md bg-white min-h-screen relative">
    <div class=" space-y-6">
        <div class=" background min-h-screen pt-6 relative space-y-4 bg-gradient-to-b">
            @include('components.guest.banner.'.$template->head_type)

            @include('components.guest.gallery.potrait')

            {{-- <x-guest.description color="#81BFDA" :data="$data" /> --}}
            @include('components.guest.description')

            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
                <div x-data="{ checkedItems: [] }" class="w-full">
                    <form id="myForm" action="{{ route('order') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-3">
                            @foreach ($data->productHighlight as $item)
                                @php
                                    $colors = ['#F29D35', '#81BFDA']; // Kuning, Biru gelap kehijauan
                                    $boxShadowColor = $colors[$loop->index % 2]; // Berganti warna setiap kelipatan 2
                                    $textColor = $colors[($loop->index + 1) % 2]; // Warna kebalikan untuk teks
                                @endphp
                                <div style="background-color: {{ $boxShadowColor }};" class="w-full p-3 rounded-xl flex gap-2 text-white">
                                    <div class="min-w-24 h-24 aspect-square rounded-full border-2 overflow-hidden border-[#00fffb]">
                                        <img src="{{ $item->image }}" class="w-full h-full object-cover" alt="">
                                    </div>
                                    <div class="w-full flex flex-col justify-between gap-2">
                                        <p class="line-clamp-1 font-semibold">{{ $item->title }}</p>
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
                        class="fixed top-6 left-1/2 -translate-x-1/2 pr-5 sm:pr-0 flex justify-end z-10 w-full max-w-[600px]">
                        <button 
                            @click="dropdownOpen = !dropdownOpen" 
                            :class="dropdownOpen ? 'bg-black rounded-b-none' : 'bg-black/60 rounded-b-full'" 
                            class="text-base flex flex-col items-center p-2 rounded-t-full duration-300 text-white relative">
                            <div 
                                class="absolute -top-1 -right-1 bg-red-600 rounded-full w-5 h-5 text-xs flex items-center justify-center" 
                                x-text="checkedItems.length"></div>
                            <div class="w-6 aspect-square">
                                <svg data-name="Layer 1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.53 5 5 3H1.25a1 1 0 0 0 0 2h2.22L6.7 18H20v-2H8.26l-.33-1.34L21 12.17V5ZM19 10.52 7.45 12.71 6 7h13ZM7 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 7 19Zm12 0a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 19 19Z" 
                                        fill="currentColor" class="fill-000000"></path>
                                </svg>
                            </div>
                        </button>
                
                        <!-- Dropdown menu -->
                        <div 
                            x-show="dropdownOpen" 
                            {{-- @click.outside="dropdownOpen = false"  --}}
                            x-transition:enter="transition ease-out duration-300" 
                            x-transition:enter-start="opacity-0 transform scale-95" 
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute top-full mt-0 right-5 sm:right-0 py-3 px-3 bg-black text-white rounded-md rounded-tr-none w-72 flex flex-col gap-2">
                            <template x-for="item in checkedItems" :key="item.id">
                                <div class="flex justify-between items-center py-1 px-2 border-2 border-white rounded-md">
                                    <p class="font-semibold" x-text="item.title"></p>
                                    <button 
                                        @click="checkedItems = checkedItems.filter(checkedItem => checkedItem.id !== item.id)" 
                                        class="text-red-500 hover:text-red-700 text-xl duration-300">&times;</button>
                                </div>
                            </template>
                            <div class=" w-full flex justify-end">
                                <button onclick="document.getElementById('myForm') ? document.getElementById('myForm').submit() : console.error('Form tidak ditemukan!')" class=" py-1.5 px-3 flex items-center gap-2 text-sm border-2 border-white rounded-md hover:bg-white/50 duration-300">
                                    <div class=" w-4 h-4">
                                        <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                                    </div>
                                    <p>{{$data->order_title}}</p>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @include('components.guest.youtube')

            <x-guest.contact :role="$role" classa="text-white bg-[#F29D35] hover:text-white hover:bg-[#e6c154]" classb="bg-[#81BFDA] text-white hover:text-white hover:bg-[#629bb3]" :data="$data" :notlp="$no_tlp"/>
        </div>
    </div>
</div>
<style>
    .background {
        @if ($template->bg_type === 'normal')
            background-color: {{ $template->bg_main_color }};
        @elseif ($template->bg_type === 'gradient')
            background: linear-gradient(to bottom, {{ $template->bg_main_color }}, {{ $template->bg_second_color }});
        @elseif ($template->bg_type === 'image')
            background-image: url('{{ asset('storage/images/template/background/'.$template->bg_image) }}');
            background-size: cover;
            background-position: center;
        @endif
    };
</style>
