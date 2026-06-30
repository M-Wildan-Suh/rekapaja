<x-app-layout title="Admin - Tambah Usaha">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Usaha') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4">
        <div class="max-w-xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" p-4 md:p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm sm:text-base font-semibold text-[#ff7100] hover:text-[#b95300] duration-300">
                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>
                    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class=" w-full space-y-6">
                            <p class=" text-lg sm:text-xl font-semibold">Data Usaha</p>
                            <div class=" flex flex-col gap-2">
                                <div class=" w-1/2 aspect-square overflow-hidden relative rounded-md mx-auto">
                                    <x-admin.component.imageinput :value="null" name="thumbnail" />
                                </div>
                            </div>

                            @if (Auth::user()->canAccessPremiumFeatures())
                                <div class=" flex flex-col gap-2">
                                    <label class="text-sm sm:text-base font-semibold text-center" for="qris-input">QRIS (Optional)</label>
                                    <div class="w-1/2 aspect-square overflow-hidden relative rounded-md mx-auto border border-dashed border-gray-300">
                                        <x-admin.component.imageinput :value="null" name="qris" />
                                    </div>
                                </div>
                            @endif

                            <div x-data="productChecker()">
                                <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                    <div class=" flex gap-2">
                                        <label for="name" class=" font-semibold">Nama Usaha Kamu</label>
                                        <div x-show="isDuplicate" class="relative group pt-1">
                                            <div class=" w-2 h-2 bg-red-500 rounded-full text-sm cursor-pointer"></div>
                                            <span class="absolute top-0 left-5 hidden group-hover:block w-max bg-gray-800 text-white text-xs rounded px-2 py-1">
                                                Nama sudah digunakan
                                            </span>
                                        </div>
                                    </div>
                                    <input 
                                        class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" 
                                        type="text" 
                                        placeholder="Masukkan Nama Usaha..."
                                        name="name" 
                                        id="name"
                                        x-model="inputName"
                                        value="{{ old('name') }}"
                                        required
                                        @input="checkProductName"
                                    >
                                </div>
                                <script>
                                    function productChecker() {
                                        return {
                                            // Data produk dari backend (menggunakan Blade untuk memasukkan data)
                                            products: @json($product->pluck('name')).map(name => name.toLowerCase()), // Konversi nama produk menjadi huruf kecil
                                            inputName: '', // Nilai input
                                            isDuplicate: false, // Status duplikasi
                                            
                                            // Fungsi pengecekan
                                            checkProductName() {
                                                // Perbandingan tanpa memperhatikan kapitalisasi
                                                this.isDuplicate = this.products.includes(this.inputName.trim().toLowerCase());
                                            }
                                        };
                                    }
                                </script>
                            </div>

                            <x-admin.component.textinput title="Tagline" placeholder="Masukkan Tagline..." :value="''" name="subtitle" required />
                            
                            <x-admin.component.numberinput title="No. Whatsapp (Optional)" placeholder="Masukkan Nomor..." :value="''" name="no_tlp" />

                            <x-admin.component.textinput title="Domain (Optional)" placeholder="contoh: tokoanda.com" :value="''" name="domain" />

                            <x-admin.component.linkinput title="Youtube (Optional)" placeholder="Masukkan link..." value="" name="link" link="Url" />

                            <x-admin.component.textareainput title="Tentang Usaha Anda" placeholder="Jelaskan Usaha Anda..." :value="''" name="description" required />
                            
                            <x-admin.component.categoryinput title="Category" :value="null" :tag="$category" name="category[]" />

                            <x-admin.component.taginput title="Tag" :value="null" :tag="$tag" name="tag[]" />

                            @if (Auth::user()->role === 'admin')
                                <x-admin.component.accessinput title="Access" :value="[]" :users="$accessUsers" name="access[]" />
                            @endif

                            <x-admin.component.radioinput title="Tombol Home" :value="[['label'=>'On', 'value'=>'on'], ['label'=>'Off', 'value'=>'off']]" :defaultvalue="old('home_button', $tagposition ?? '')" name="home_button" required />

                            <div class=" space-y-2">
                                <label for="template" class=" text-sm sm:text-base font-semibold">Template</label>
                                <div class=" w-full grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    @foreach ($template as $item)
                                        <label class="w-full rounded-md bg-white aspect-[2/3] overflow-hidden relative">
                                            <input type="radio" name="template_id" value="{{$item->id}}" class="hidden peer" {{ (string) old('template_id', $loop->first ? $item->id : '') === (string) $item->id ? 'checked' : '' }} required>
                                            <img src="{{asset('/storage/images/template/'.$item->image)}}" class=" w-full h-full object-cover object-top" alt="">
                                            <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="">
                                <button class=" text-sm sm:text-base font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
