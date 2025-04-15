<x-app-layout title="Admin - Edit Usaha">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Usaha') }}
        </h2>
    </x-slot>
    <!-- Tab Contents -->
    <div class="mt-4">
        <div class="py-4 px-4">
            <div class="max-w-xl mx-auto">
                <div x-data="{ activeTab: '{{ session('highlight', 'product') }}' }" class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <!-- Tabs -->
                    <div class="w-full mx-auto pt-4 px-4 md:px-6 pb-0">
                        <div class=" grid grid-cols-3 gap-2 sm:gap-4 font-bold">
                            <button 
                                @click="activeTab = 'product'" 
                                :class="activeTab === 'product' ? ' bg-[#ff7100] text-white' : 'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                                class="px-3 py-2 rounded-md">
                                Usaha
                            </button>
                            <button 
                                @click="activeTab = 'highlight'" 
                                :class="activeTab === 'highlight' ? ' bg-[#ff7100] text-white' : 'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                                class="px-3 py-2 rounded-md">
                                <span class=" sm:hidden">Produk</span>
                                <span class=" hidden sm:block">Produk / Layanan</span>
                            </button>
                            <button 
                                @click="activeTab = 'gallery'" 
                                :class="activeTab === 'gallery' ? ' bg-[#ff7100] text-white' : 'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                                class="px-3 py-2 rounded-md">
                                Galeri
                            </button>
                        </div>
                    </div>
                    <div x-show="activeTab === 'product'" class=" p-4 md:p-6 text-gray-900">
                        <form id="bussiness" action="{{route('product.update', ['product' => $product->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class=" w-full space-y-6">
                                <div class=" flex flex-col gap-2">
                                    <div class=" w-1/2 aspect-square overflow-hidden relative rounded-md mx-auto">
                                        <x-admin.component.imageinput :value="asset('storage/images/product/' . $product->image . '')" name="thumbnail" />
                                    </div>
                                </div>
                                <div x-data="productChecker({{ json_encode($product->name) }})">
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
                                            @input="checkProductName"
                                        >
                                    </div>
                                    <script>
                                        function productChecker(input) {
                                            return {
                                                // Data produk dari backend (menggunakan Blade untuk memasukkan data)
                                                products: @json($data->pluck('name')).map(name => name.toLowerCase()), // Konversi nama produk menjadi huruf kecil
                                                inputName: input, // Nilai input
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
                                <x-admin.component.textinput title="Tagline" placeholder="Masukkan Tagline..." :value="$product->subtitle" name="subtitle" />
                                <x-admin.component.numberinput title="No. Whatsapp" placeholder="Masukkan Nomor..." :value="$product->no_tlp" name="no_tlp" />
                                <x-admin.component.linkinput title="Youtube (Optional)" placeholder="Masukkan link..." :value="$product->youtube" name="link" link="Url" />

                                <x-admin.component.textareainput title="Tentang Usaha Anda" placeholder="Jelaskan Usaha Anda..." :value="$product->description" name="description" />
                                
                                @if (Auth::user()->role === 'admin' || (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') || (Auth::user()->role === 'premium' && Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                                    <x-admin.component.categoryinput title="Category" :value="$product->category" :tag="$category" name="category[]" />
                                    <x-admin.component.taginput title="Tag" :value="$product->productTags" name="tag[]" :tag="$tag"></x-admin.component.taginput>
                                    @if (Auth::user()->role === 'admin')
                                        <x-admin.component.radioinput title="Status" :value="[['label'=>'Active', 'value'=>'active'], ['label'=>'Unactive', 'value'=>'unactive']]" :defaultvalue="$product->status" name="status" />
                                    @endif
                                    <x-admin.component.radioinput title="Tombol Home" :value="[['label'=>'On', 'value'=>'on'], ['label'=>'Off', 'value'=>'off']]" :defaultvalue="$product->home_button" name="home_button" />
                                @endif
                                <div class=" space-y-2">
                                    <label for="template">Template</label>
                                    <div class=" w-full grid grid-cols-2 sm:grid-cols-3 gap-4">
                                        @foreach ($template as $item)
                                            <label class="w-full rounded-md bg-white aspect-[2/3] overflow-hidden relative">
                                                <input type="radio" name="template_id" value="{{$item->id}}" class="hidden peer" {{ $product->template_id === $item->id ? 'checked' : '' }}>
                                                <img src="{{asset('/storage/images/template/'.$item->image)}}" class=" w-full h-full object-cover object-top" alt="">
                                                <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="">
                                    <button class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div x-show="activeTab === 'highlight'" class=" p-4 md:p-6 text-gray-900 space-y-4">
                        @if (Auth::user()->role === 'admin' || (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') || (Auth::user()->role === 'premium' && Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                            <div class=" space-y-2">
                                <label for="order" class=" text-sm sm:text-base font-semibold">Edit Tombol Order</label>
                                <div class=" w-full">
                                    <form action="{{route('product.order', ['id' => $product->id])}}" method="post">
                                        @csrf
                                        @method('put')
                                        <x-admin.component.sectiontitleinput placeholder="Masukkan nama tombol order..." value="{{$product->order_title}}" name="order_title"></x-admin.component.sectiontitleinput>
                                    </form>
                                </div>
                            </div>
                            <div class=" space-y-2">
                                <label for="order" class=" text-sm sm:text-base font-semibold">Edit Title Produk</label>
                                <div class=" w-full">
                                    <form action="{{route('product.title', ['id' => $product->id])}}" method="post">
                                        @csrf
                                        @method('put')
                                        <x-admin.component.sectiontitleinput placeholder="Masukkan nama Title Produk..." value="{{$product->product_title}}" name="product_title"></x-admin.component.sectiontitleinput>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <div x-data="highlightManager({{ json_encode($product->productHighlight) }}, '{{ Auth::user()->role }}')" class=" space-y-4">
                            <div class=" space-y-2">
                                <p class=" text-sm sm:text-base font-semibold">Produk / Layanan {{ in_array(Auth::user()->role, ['admin', 'premium']) || $product->productHighlight->count() < 3 ? 'Unlimited' : '( Max 3 )' }}
                                </p>
                                @if (Auth::user()->role === 'admin' || (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') || (Auth::user()->role === 'premium' && Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                                    <button type="button" @click="multiple = true"
                                        class="font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">
                                        Tambah Produk Massal
                                    </button>
                                    <div x-show="multiple" class=" fixed inset-0 flex items-center justify-center bg-black/20 z-50 px-4">
                                        <div class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-[#ff7100]">
                                            <button @click="multiple = false"
                                                class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                                                <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                    enable-background="new 0 0 512 512">
                                                    <path
                                                        d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                                                        fill="currentColor" class="fill-000000"></path>
                                                </svg>
                                            </button>
                                            <div class=" pt-6 pb-3 bg-[#ff7100] text-white">
                                                <h2 class=" px-6 text-2xl font-bold">Tambah Berulang Menggunakan Gambar</h2>
                                            </div>
                                            <form @submit.prevent="submitMultipleDummyForm" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class=" w-full space-y-4">
                                                    <div class=" w-full px-6 py-4 flex items-center justify-center">
                                                        <input class=" w-full" type="file" name="image[]" id="highlightimages-input" multiple accept="image/*" x-ref="highlightInput">
                                                    </div>
                                                    <div class="flex justify-end space-x-4 px-6">
                                                        <x-admin.component.submitbutton title="Tambah" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class=" space-y-4">
                                @include('admin.product.component.product')
                                <div class="">
                                    <button @click="document.getElementById('bussiness').submit()" class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="activeTab === 'gallery'" class=" p-4 md:p-6 text-gray-900 space-y-4">
                        <div x-data="galleryComponent({{ $product->productGallery }}, {{ $product->id }})" class="flex flex-col gap-2">
                            <label class="font-semibold" for="image_gallery">Galeri ( Max 9 )</label>
                            <input type="file" class="hidden" id="image_gallery" name="image_gallery[]" multiple accept="image/*" @change="addImages($event)">
                            <div class="w-full grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-4">
                                <template x-for="(image, index) in images" :key="index">
                                    <div class="w-full aspect-[3/2] rounded-md relative overflow-hidden">
                                        <img :src="image.url" class="w-full h-full object-cover" alt="Gallery Image Preview">
                                        <label @click="deleteImage(index)" class="w-full text-transparent h-full absolute top-0 left-0 flex justify-center items-center p-[20%] hover:bg-black/60 hover:text-white/50 duration-300 cursor-pointer">
                                            <svg viewBox="0 0 24 24" class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><path d="M19.5 8.99h-15a.5.5 0 0 0-.5.5v12.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.49a.5.5 0 0 0-.5-.5Zm-9.25 11.5a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0Zm5 0a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0ZM20.922 4.851a11.806 11.806 0 0 0-4.12-1.07 4.945 4.945 0 0 0-9.607 0A12.157 12.157 0 0 0 3.18 4.805 1.943 1.943 0 0 0 2 6.476 1 1 0 0 0 3 7.49h18a1 1 0 0 0 1-.985 1.874 1.874 0 0 0-1.078-1.654ZM11.976 2.01A2.886 2.886 0 0 1 14.6 3.579a44.676 44.676 0 0 0-5.2 0 2.834 2.834 0 0 1 2.576-1.569Z" fill="currentColor" class="fill-000000"></path></svg>
                                        </label>
                                    </div>
                                </template>
                        
                                <div class="w-full aspect-[3/2] border bg-neutral-100 border-neutral-600 rounded-md relative border-dashed overflow-hidden" x-show="images.length < 9">
                                    <label for="image_gallery" class="w-full text-neutral-600 h-full absolute top-0 left-0 flex justify-center items-center p-[20%] hover:bg-neutral-600 hover:text-white/50 duration-300 cursor-pointer">
                                        <svg viewBox="0 0 24 24" class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><path d="m9 13 3-4 3 4.5V12h4V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-4H5l3-4 1 2z" fill="currentColor" class="fill-000000"></path><path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z" fill="currentColor" class="fill-000000"></path></svg>
                                    </label>
                                </div>
                            </div>
                            <p x-show="errorMessage" class="text-red-500" x-text="errorMessage"></p>
                            <p x-show="loading" class="text-blue-500">Loading...</p>
                        </div>
                        
                        <script>
                            function galleryComponent(initialImages = [], productId) {
                                return {
                                    images: initialImages.map(item => ({
                                        id: item.id,
                                        url: item.image ? `{{ asset('storage/images/product/gallery/') }}/${item.image}` : `{{ asset('assets/images/placeholder.png') }}`
                                    })),
                                    errorMessage: '',
                                    loading: false,
                                    addImages(event) {
                                        const files = Array.from(event.target.files);
                                        
                                        if (this.images.length + files.length > 9) {
                                            this.errorMessage = 'You can only upload up to 8 images.';
                                            return;
                                        }
                        
                                        this.errorMessage = '';
                                        this.loading = true;
                        
                                        files.forEach(file => {
                                            const formData = new FormData();
                                            formData.append('image_gallery', file);
                                            formData.append('product_id', productId);
                        
                                            axios.post('/admin/product-gallery', formData)
                                                .then(response => {
                                                    const newImage = response.data;
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        this.images.push({
                                                            id: newImage.id,
                                                            url: e.target.result
                                                        });
                                                    };
                                                    reader.readAsDataURL(file);
                                                })
                                                .catch(error => {
                                                    console.error('Error uploading image:', error);
                                                    this.errorMessage = 'Error uploading image. Please try again.';
                                                })
                                                .finally(() => {
                                                    this.loading = false;
                                                });
                                        });
                                    },
                                    deleteImage(index) {
                                        const image = this.images[index];
                                        this.loading = true;
                                        
                                        axios.delete(`/admin/product-gallery/${image.id}`)
                                            .then(() => {
                                                this.images.splice(index, 1);
                                            })
                                            .catch(error => {
                                                console.error('Error deleting image:', error);
                                                this.errorMessage = 'Error deleting image. Please try again.';
                                            })
                                            .finally(() => {
                                                this.loading = false;
                                            });
                                    }
                                };
                            }
                        </script>
                        
                        <div class="">
                            <button @click="document.getElementById('bussiness').submit()" class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('detail', ['slug' => $product->slug]) }}" target="_blank">
        <button class=" fixed rounded-l-full w-10 h-10 bg-[#ff7100] hover:opacity-60 duration-300 p-2 right-0 top-20">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M16 3a13 13 0 1 0 13 13A13 13 0 0 0 16 3Zm6.69 16.91A24.39 24.39 0 0 0 23 16a23.72 23.72 0 0 0-.32-3.91C25.37 13.08 27 14.58 27 16s-1.69 3-4.31 3.91ZM5 16c0-1.47 1.69-2.95 4.31-3.91A24.39 24.39 0 0 0 9 16a23.72 23.72 0 0 0 .32 3.91C6.63 18.92 5 17.42 5 16Zm6.5-10a14.2 14.2 0 0 0-1.68 3.82A14.19 14.19 0 0 0 6 11.49 11 11 0 0 1 11.5 6ZM6 20.5a14.63 14.63 0 0 0 4.32 1.8h.09A23.4 23.4 0 0 0 16 23c.6 0 1.19 0 1.76-.06a1 1 0 1 0-.14-2Q16.83 21 16 21a20.92 20.92 0 0 1-4.52-.47A21.33 21.33 0 0 1 11 16c0-6.48 2.64-11 5-11 1 0 2 .76 2.89 2.14a1 1 0 0 0 .84.47 1 1 0 0 0 .54-.15 1 1 0 0 0 .31-1.38.86.86 0 0 0-.07-.1A11 11 0 0 1 26 11.5a14.94 14.94 0 0 0-4.48-1.84A23.21 23.21 0 0 0 16 9c-.6 0-1.19 0-1.76.06a1 1 0 1 0 .14 2Q15.18 11 16 11a20.92 20.92 0 0 1 4.52.47A21.33 21.33 0 0 1 21 16c0 6.48-2.64 11-5 11-1 0-2-.76-2.89-2.14a1 1 0 1 0-1.69 1.06.86.86 0 0 0 .07.1A11 11 0 0 1 6 20.5ZM20.5 26a14.2 14.2 0 0 0 1.68-3.85A14.19 14.19 0 0 0 26 20.51 11 11 0 0 1 20.5 26Z" data-name="world www web website" fill="#ffffff" class="fill-000000"></path></svg>
        </button>
    </a>
</x-app-layout>
