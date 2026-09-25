<div x-init="$el.querySelectorAll('input, select, textarea').forEach(field => field.setAttribute('form', 'bussiness'))">
                            <div class=" w-full space-y-6">
                                <div class=" flex flex-col gap-2">
                                    <div class=" w-1/2 aspect-[4/3] overflow-hidden relative rounded-md mx-auto">
                                        <x-admin.component.imageinput :value="asset('storage/images/product/' . $product->image . '')" name="thumbnail" aspect="aspect-[4/3]" />
                                    </div>
                                </div>
                                <div x-data="productChecker({{ json_encode(old('name', $product->name)) }})">
                                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                        <div class=" flex gap-2">
                                            <label for="name" class=" font-semibold">Nama Usaha Kamu</label>
                                            <div x-show="isDuplicate" class="relative group pt-1">
                                                <div class=" w-2 h-2 bg-red-500 rounded-full text-sm cursor-pointer">
                                                </div>
                                                <span
                                                    class="absolute top-0 left-5 hidden group-hover:block w-max bg-gray-800 text-white text-xs rounded px-2 py-1">
                                                    Nama sudah digunakan
                                                </span>
                                            </div>
                                        </div>
                                        <input
                                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                                            type="text" placeholder="Masukkan Nama Usaha..." name="name"
                                            id="name" maxlength="100" x-model="inputName"
                                            value="{{ old('name', $product->name) }}" required
                                            @input="checkProductName">
                                    </div>
                                    <script>
                                        function productChecker(input) {
                                            return {
                                                // Data produk dari backend (menggunakan Blade untuk memasukkan data)
                                                products: @json($data->pluck('name')).map(name => name
                                            .toLowerCase()), // Konversi nama produk menjadi huruf kecil
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
                                <x-admin.component.textinput title="Tagline" placeholder="Masukkan Tagline..."
                                    :value="$product->subtitle" name="subtitle" maxlength="120" />

                                <x-admin.component.textareainput title="Tentang Usaha Anda"
                                    placeholder="Jelaskan Usaha Anda..." :value="$product->description" name="description"
                                    maxlength="1200" helper="Deskripsi usaha maksimal 1200 karakter." />

                                @if (Auth::user()->role === 'admin' ||
                                        (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') ||
                                        (Auth::user()->role === 'premium' &&
                                            Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                                    <x-admin.component.categoryinput title="Category" :value="$product->category"
                                        :tag="$category" name="category[]" />
                                    <x-admin.component.taginput title="Tag" :value="$product->productTags" name="tag[]"
                                        :tag="$tag"></x-admin.component.taginput>
                                @endif

                                <div class="">
                                    <button type="submit" form="bussiness"
                                        class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                                </div>
                            </div>
</div>
