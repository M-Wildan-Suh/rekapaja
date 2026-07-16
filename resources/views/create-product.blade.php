<x-layout.guest>
    @include('components.guest.header')
    @php
        $activeTab = session('highlight', 'product');

        if ($errors->has('image_gallery') || $errors->has('image_gallery.*')) {
            $activeTab = 'gallery';
        } elseif (
            $errors->has('inputs') ||
            $errors->has('inputs.*.image') ||
            $errors->has('inputs.*.title') ||
            $errors->has('inputs.*.price') ||
            $errors->has('inputs.*.description')
        ) {
            $activeTab = 'highlight';
        } elseif ($errors->any()) {
            $activeTab = 'product';
        }
    @endphp
    <div class="pt-28 pb-8 min-h-[calc(100vh-140px)] px-4 sm:px-6 space-y-4 md:space-y-8">
        <div class=" w-full max-w-xl mx-auto space-y-2 sm:space-y-6">
            <div class=" w-full flex items-center gap-4 md:gap-6">
                <p class=" text-lg sm:text-[28px] font-black capitalize text-left">Masukkan Data Usaha</p>
            </div>
        </div>
        <div x-data="{ activeTab: '{{ $activeTab }}' }" class="w-full">
            <div class=" w-full max-w-xl mx-auto bg-white rounded-xl overflow-hidden shadow-md shadow-black/20">
                <!-- Tabs -->
                <div class="w-full mx-auto pt-4 px-4 md:px-6 pb-0">
                    <div class=" grid grid-cols-3 gap-2 sm:gap-4 font-bold">
                        <button {{-- @click="activeTab = 'product'"  --}}
                            :class="activeTab === 'product' ? ' bg-[#ff7100] text-white' :
                                'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                            class="px-3 py-2 rounded-md">
                            Usaha
                        </button>
                        <button {{-- @click="activeTab = 'highlight'"  --}}
                            :class="activeTab === 'highlight' ? ' bg-[#ff7100] text-white' :
                                'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                            class="px-3 py-2 rounded-md">
                            <span class=" sm:hidden">Produk</span>
                            <span class=" hidden sm:block">Produk / Layanan</span>
                        </button>
                        <button {{-- @click="activeTab = 'gallery'"  --}}
                            :class="activeTab === 'gallery' ? ' bg-[#ff7100] text-white' :
                                'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                            class="px-3 py-2 rounded-md">
                            Galeri
                        </button>
                    </div>
                </div>
                <!-- Tab Contents -->
                <div class="">
                    <form action="{{ route('store.product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Bussiness --}}
                        <div x-show="activeTab === 'product'" class="">
                            <div class=" w-full mx-auto">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class=" p-4 md:p-6 text-gray-900">
                                        <div class=" w-full space-y-6">
                                            <div class=" flex flex-col gap-2">
                                                <div
                                                    class=" w-1/2 aspect-square overflow-hidden relative rounded-md mx-auto">
                                                    <x-admin.component.imageinput :value="null"
                                                        name="thumbnail" />
                                                </div>
                                            </div>
                                            <div x-data="productChecker()">
                                                <div
                                                    class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                                    <div class=" flex gap-2">
                                                        <label for="name" class=" font-semibold">Nama Usaha
                                                            Kamu</label>
                                                        <div x-show="isDuplicate" class="relative group pt-1">
                                                            <div
                                                                class=" w-2 h-2 bg-red-500 rounded-full text-sm cursor-pointer">
                                                            </div>
                                                            <span
                                                                class="absolute top-0 left-5 hidden group-hover:block w-max bg-gray-800 text-white text-xs rounded px-2 py-1">
                                                                Nama sudah digunakan
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input
                                                        class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                                                        type="text" placeholder="Masukkan Nama Usaha..."
                                                        name="name" id="name" x-model="inputName"
                                                        value="{{ old('name') }}"
                                                        required
                                                        @input="checkProductName">
                                                </div>
                                                <script>
                                                    function productChecker() {
                                                        return {
                                                            // Data produk dari backend (menggunakan Blade untuk memasukkan data)
                                                            products: @json($product->pluck('name')).map(name => name
                                                                .toLowerCase()), // Konversi nama produk menjadi huruf kecil
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
                                            <x-admin.component.textinput title="Tagline"
                                                placeholder="Masukkan Tagline..." :value="''"
                                                name="subtitle" required />
                                            <x-admin.component.numberinput title="No. Whatsapp"
                                                placeholder="Masukkan Nomor..." :value="''"
                                                name="no_tlp" required />
                                            <x-admin.component.textinput title="Domain (Optional)"
                                                placeholder="contoh: tokoanda.com" :value="''"
                                                name="domain" />
                                            <x-admin.component.textareainput title="Tentang Usaha Anda"
                                                placeholder="Jelaskan Usaha Anda..." :value="''" name="desc" required />
                                            <div class="">
                                                <button type="button" @click="activeTab = 'highlight'"
                                                    class=" text-sm sm:text-base font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md text-center">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Product / Service --}}
                        <div x-show="activeTab === 'highlight'" class="">
                            <div class=" w-full mx-auto">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class=" p-4 md:p-6 text-gray-900 space-y-6">
                                        <div x-data="formManager()" class=" space-y-2">
                                            <div class=" flex items-center gap-2">
                                                <p class=" text-sm sm:text-base font-semibold">Produk / Layanan ( Max 3
                                                    )</p>
                                                <button type="button" x-show="inputs.length < 3" @click="addNewInput"
                                                    class=" w-4 h-4 text-[#ff7100] hover:scale-110 duration-300">
                                                    <svg viewBox="0 0 24 24" xml:space="preserve"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        enable-background="new 0 0 24 24">
                                                        <path
                                                            d="M12 1C5.9 1 1 5.9 1 12s4.9 11 11 11 11-4.9 11-11S18.1 1 12 1zm5 13h-3v3c0 1.1-.9 2-2 2s-2-.9-2-2v-3H7c-1.1 0-2-.9-2-2s.9-2 2-2h3V7c0-1.1.9-2 2-2s2 .9 2 2v3h3c1.1 0 2 .9 2 2s-.9 2-2 2z"
                                                            fill="currentColor" class="fill-000000"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="w-full grid gap-4">
                                                <!-- Template untuk input -->
                                                <template x-for="(input, index) in inputs" :key="index">
                                                    <div
                                                        class="input-group w-full max-w-full rounded-xl flex flex-col justify-between items-center gap-2 bg-white">
                                                        <div
                                                            class=" w-24 min-w-24 aspect-square rounded-md overflow-hidden">
                                                            <div
                                                                class="w-full h-full flex flex-col text-sm font-medium gap-2 justify-center items-center">
                                                                <div
                                                                    class="w-full h-full relative flex justify-center overflow-hidden">
                                                                    <img :id="'highlightimage-preview-' + index"
                                                                        class="object-cover w-full"
                                                                        :src="input.image ||
                                                                            '{{ asset('assets/images/placeholder.webp') }}'"
                                                                        alt="Logo">
                                                                    <div
                                                                        class="w-full h-full absolute z-10 top-0 opacity-0 hover:opacity-100 duration-300">
                                                                        <label :for="'highlightimage-input-' + index"
                                                                            class="relative">
                                                                            <div
                                                                                class="w-full h-full bg-black opacity-60 flex justify-center items-center text-neutral-400">
                                                                                <div class="w-7 aspect-square">
                                                                                    <svg viewBox="0 0 18 18"
                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M0 14.2V18h3.8l11-11.1L11 3.1 0 14.2ZM17.7 4c.4-.4.4-1 0-1.4L15.4.3c-.4-.4-1-.4-1.4 0l-1.8 1.8L16 5.9 17.7 4Z"
                                                                                            fill="currentColor"
                                                                                            fill-rule="evenodd"
                                                                                            class="fill-000000"></path>
                                                                                    </svg>
                                                                                </div>
                                                                            </div>
                                                                            <input accept="image/*" type="file"
                                                                                :name="'inputs[' + index + '][image]'"
                                                                                class="absolute bottom-0 left-0 z-0 w-40 opacity-0"
                                                                                :id="'highlightimage-input-' + index"
                                                                                @change="handleImagePreview($event, index)" />
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class=" w-full flex flex-col flex-grow justify-between gap-2">
                                                            <div class=" flex items-center justify-between gap-2">
                                                                <input type="text" x-model="input.title"
                                                                    :name="'inputs[' + index + '][title]'"
                                                                    class="min-w-0 p-0 resize-none w-full border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-sm sm:text-base"
                                                                    placeholder="Produk / Layanan" maxlength="27">
                                                                <button
                                                                    class=" w-6 h-6 text-red-500 hover:scale-110 duration-300"
                                                                    type="button" @click="removeInput(index)">
                                                                    <svg viewBox="0 0 24 24" xml:space="preserve"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        enable-background="new 0 0 24 24">
                                                                        <path
                                                                            d="M18.9 8H5.1c-.6 0-1.1.5-1 1.1l1.6 13.1c.1 1 1 1.7 2 1.7h8.5c1 0 1.9-.7 2-1.7l1.6-13.1c.1-.6-.3-1.1-.9-1.1zM20 2h-5c0-1.1-.9-2-2-2h-2C9.9 0 9 .9 9 2H4c-1.1 0-2 .9-2 2v1c0 .6.4 1 1 1h18c.6 0 1-.4 1-1V4c0-1.1-.9-2-2-2z"
                                                                            fill="currentColor" class="fill-000000">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <input type="text" x-model="input.price" inputmode="numeric" pattern="[0-9]*"
                                                                    :name="'inputs[' + index + '][price]'"
                                                                    class="min-w-0 p-0 resize-none w-full border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-xs sm:text-sm"
                                                                    placeholder="Harga (opsional)" @input="input.price = (input.price ?? '').replace(/[^0-9]/g, '')">
                                                            <textarea x-model="input.description" :name="'inputs[' + index + '][description]'"
                                                                class="min-w-0 w-full p-0 resize-none border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-xs sm:text-sm"
                                                                placeholder="Deskripsi" maxlength="64" cols="40"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>

                                            <script>
                                                function formManager() {
                                                    return {
                                                        inputs: @json(collect(old('inputs', []))->map(function ($item) {
                                                            return [
                                                                'image' => '',
                                                                'title' => $item['title'] ?? '',
                                                                'price' => $item['price'] ?? '',
                                                                'description' => $item['description'] ?? '',
                                                                'saved' => false,
                                                            ];
                                                        })->values()),

                                                        // Menghapus input
                                                        removeInput(index) {
                                                            this.inputs.splice(index, 1);
                                                        },

                                                        // Menangani preview gambar
                                                        handleImagePreview(event, index) {
                                                            const file = event.target.files[0];
                                                            if (file) {
                                                                this.inputs[index].image = URL.createObjectURL(file);
                                                            }
                                                        },

                                                        // Menambahkan input baru di luar template
                                                        addNewInput() {
                                                            this.inputs.push({
                                                                image: '',
                                                                title: '',
                                                                price: '',
                                                                description: '',
                                                                saved: false
                                                            });
                                                        },

                                                        init() {
                                                            if (this.inputs.length === 0) {
                                                                this.addNewInput();
                                                            }
                                                        },
                                                    };
                                                }
                                            </script>

                                        </div>
                                        <div class=" grid grid-cols-2 gap-2 sm:gap-4">
                                            <button type="button" @click="activeTab = 'product'"
                                                class=" text-sm sm:text-base font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md text-center">Kembali</button>
                                            <button type="button" @click="activeTab = 'gallery'"
                                                class=" text-sm sm:text-base font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md text-center">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Gallery --}}
                        <div x-show="activeTab === 'gallery'" class="">
                            <div class=" w-full mx-auto">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class=" p-4 md:p-6 text-gray-900 space-y-4">
                                        <div x-data="imageGallery" class="flex flex-col gap-2">
                                            <label for="image_gallery"
                                                class=" text-sm sm:text-base font-semibold">Galeri ( Max 9 )</label>
                                            <input type="file" class="hidden" id="image_gallery"
                                                name="image_gallery[]" multiple @input="previewImages"
                                                accept="image/*">

                                            <!-- Pratinjau Gambar -->
                                            <div class="grid grid-cols-2 sm:grid-cols-3 sm:gap-4">
                                                <!-- Loop Gambar -->
                                                <template x-for="(image, index) in images" :key="index">
                                                    <div
                                                        class="w-full aspect-[3/2] rounded-md relative overflow-hidden shadow-md shadow-black/20">
                                                        <img :src="image" class="w-full h-full object-cover"
                                                            alt="Gallery Image Preview">
                                                        <!-- Tombol Hapus Gambar -->
                                                        <button type="button" @click="removeImage(index)"
                                                            class="absolute inset-0 text-transparent hover:bg-black/60 hover:text-[#F8FAFC]/50 transition duration-300 p-[20%]">
                                                            <svg viewBox="0 0 24 24" class="w-full h-full"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M19.5 8.99h-15a.5.5 0 0 0-.5.5v12.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.49a.5.5 0 0 0-.5-.5Zm-9.25 11.5a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0Zm5 0a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0ZM20.922 4.851a11.806 11.806 0 0 0-4.12-1.07 4.945 4.945 0 0 0-9.607 0A12.157 12.157 0 0 0 3.18 4.805 1.943 1.943 0 0 0 2 6.476 1 1 0 0 0 3 7.49h18a1 1 0 0 0 1-.985 1.874 1.874 0 0 0-1.078-1.654ZM11.976 2.01A2.886 2.886 0 0 1 14.6 3.579a44.676 44.676 0 0 0-5.2 0 2.834 2.834 0 0 1 2.576-1.569Z"
                                                                    fill="currentColor" class="fill-000000"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </template>

                                                <!-- Tambahkan Gambar (Placeholder jika kurang dari 8 gambar) -->
                                                <template x-if="images.length < 9">
                                                    <label for="image_gallery"
                                                        class="w-full aspect-[3/2] border bg-neutral-100 border-neutral-600 rounded-md relative border-dashed overflow-hidden">
                                                        <label for="image_gallery"
                                                            class="w-full text-neutral-600 h-full absolute top-0 left-0 flex justify-center items-center p-[20%] hover:bg-neutral-600 hover:text-[#F8FAFC]/50 duration-300 cursor-pointer">
                                                            <svg viewBox="0 0 24 24" class="w-full h-full"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="m9 13 3-4 3 4.5V12h4V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-4H5l3-4 1 2z"
                                                                    fill="currentColor" class="fill-000000"></path>
                                                                <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"
                                                                    fill="currentColor" class="fill-000000"></path>
                                                            </svg>
                                                        </label>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>

                                        <script>
                                            function imageGallery() {
                                                return {
                                                    images: [],

                                                    previewImages(event) {
                                                        const files = Array.from(event.target.files).slice(0, 9 - this.images.length);
                                                        files.forEach(file => {
                                                            const url = URL.createObjectURL(file);
                                                            this.images.push(url);
                                                        });
                                                    },

                                                    removeImage(index) {
                                                        this.images.splice(index, 1);
                                                    }
                                                };
                                            }
                                        </script>
                                        <div class=" grid grid-cols-2 gap-2 sm:gap-4">
                                            <button type="button" @click="activeTab = 'highlight'"
                                                class=" text-sm sm:text-base font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md text-center">Kembali</button>
                                            <button
                                                class=" text-sm sm:text-base font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md text-center">Join</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('components.validation-error')
    @include('components.guest.footer')
    @include('components.admin.mobile-navbar')
</x-layout.guest>
