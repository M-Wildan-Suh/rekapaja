<div class="w-full grid gap-4">
    <form id="highlight-form" action="{{ route('highlight.bulk-update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="active_tab" value="highlight">

        <template x-for="item in highlights" :key="item.id">
            <div class="w-full rounded-xl relative" x-data="highlightEditForm(item)">
                <div class="absolute top-0 left-0 flex flex-col gap-2 sm:flex-row sm:items-center">
                    <p>Tersedia</p>
                    <div class="flex items-center gap-2">
                        <input type="hidden" :name="`highlights[${item.id}][available]`" value="0">
                        <button
                            type="button"
                            @click="item.available = !item.available"
                            :class="item.available ? 'justify-end border-[#ff7100]' : 'justify-start'"
                            class="flex w-10 rounded-full border p-1 duration-300"
                        >
                            <div :class="item.available ? 'bg-[#ff7100]' : 'bg-gray-300'" class="w-4 aspect-square rounded-full duration-300"></div>
                        </button>
                        <input type="checkbox" class="hidden" :name="`highlights[${item.id}][available]`" value="1" x-model="item.available">
                    </div>
                </div>

                <div class="rounded-xl flex flex-col items-center justify-between gap-4 bg-white">
                    <div class="w-24 min-w-24 h-24 aspect-square rounded-md border-2 overflow-hidden">
                        <div class="w-full h-full flex flex-col text-sm font-medium gap-2 justify-center items-center">
                            <div class="w-full h-full relative flex justify-center overflow-hidden">
                                <img :src="previewImage" class="object-cover w-full" alt="Logo">
                                <div class="w-full h-full absolute z-10 top-0 opacity-0 hover:opacity-100 duration-300">
                                    <label :for="'highlightimage' + item.id + '-input'" class="relative">
                                        <div class="w-full h-full bg-black opacity-60 flex justify-center items-center text-neutral-400">
                                            <div class="w-7 aspect-square">
                                                <svg viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 14.2V18h3.8l11-11.1L11 3.1 0 14.2ZM17.7 4c.4-.4.4-1 0-1.4L15.4.3c-.4-.4-1-.4-1.4 0l-1.8 1.8L16 5.9 17.7 4Z" fill="currentColor" fill-rule="evenodd" class="fill-000000"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            accept="image/*"
                                            type="file"
                                            @change="previewFile"
                                            class="absolute bottom-0 left-0 z-0 w-40 opacity-0"
                                            :id="'highlightimage' + item.id + '-input'"
                                            :name="'highlightimage[' + item.id + ']'"
                                        >
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full sm:h-24 flex gap-2">
                        <div class="w-full sm:w-auto flex flex-col flex-grow justify-between gap-2">
                            <input type="text"
                                x-model="item.title"
                                :name="`highlights[${item.id}][title]`"
                                class="text-sm sm:text-base min-w-0 p-0 w-full border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0"
                                placeholder="Nama Product" maxlength="27" required>
                            <input type="text"
                                x-model="item.price"
                                :name="`highlights[${item.id}][price]`"
                                inputmode="numeric" pattern="[0-9]*"
                                class="min-w-0 p-0 w-full border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-xs sm:text-sm"
                                placeholder="Harga (opsional)" @input="item.price = (item.price ?? '').toString().replace(/[^0-9]/g, '')">
                            <textarea
                                x-model="item.description"
                                :name="`highlights[${item.id}][description]`"
                                class="min-w-0 w-full p-0 border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-xs sm:text-sm resize-none"
                                placeholder="Deskripsi (opsional)"></textarea>
                        </div>
                        <div x-data="{ loadingDelete : false }" class="min-w-[50px] grid grid-cols-1 gap-1">
                            <button @click="loadingDelete = true; $dispatch('delete-highlight', item.id)" :disabled="loadingDelete"
                                type="button"
                                class="min-w-[50px] h-full bg-red-500 hover:bg-red-700 duration-300 text-white rounded-md text-center text-sm">
                                <span x-show="!loadingDelete">Hapus</span>
                                <span x-show="loadingDelete" class="inline-block items-center">
                                    <svg class="animate-spin h-5 w-5 text-white"fill="none" viewBox="0 0 48 48"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 24c0 11.046 8.954 20 20 20s20-8.954 20-20S35.046 4 24 4"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="4" class="stroke-000000"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </form>

    <template x-if="canAddHighlight">
        <form x-data="highlightCreateForm()" @submit.prevent="submitForm">
            @csrf

            <div class="w-full max-w-full rounded-xl flex flex-col items-center justify-between gap-4 bg-white">
                <div class="w-24 min-w-24 h-24 aspect-square rounded-md overflow-hidden relative">
                    <img :src="previewImage || '{{ asset('assets/images/placeholder.webp') }}'"
                        class="object-cover w-full h-full" alt="Preview Image">
                    <div class="w-full h-full absolute top-0 opacity-0 hover:opacity-100 duration-300">
                        <label for="highlightimage-input" class="relative">
                            <div class="w-full h-full bg-black opacity-60 flex justify-center items-center text-neutral-400">
                                <div class="w-7 aspect-square">
                                    <svg viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 14.2V18h3.8l11-11.1L11 3.1 0 14.2ZM17.7 4c.4-.4.4-1 0-1.4L15.4.3c-.4-.4-1-.4-1.4 0l-1.8 1.8L16 5.9 17.7 4Z" fill="currentColor" fill-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <input type="file" accept="image/*" @change="previewFile" id="highlightimage-input"
                                class="absolute bottom-0 left-0 w-40 opacity-0">
                        </label>
                    </div>
                </div>

                <div class="w-full sm:h-2/4 flex gap-2">
                    <div class="flex flex-col flex-grow justify-between gap-2">
                        <input type="text" x-model="form.title"
                            class="min-w-0 p-0 w-full border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-sm sm:text-base"
                            placeholder="Nama Product" maxlength="27" required>
                        <input type="text" x-model="form.price" inputmode="numeric" pattern="[0-9]*"
                            class="min-w-0 p-0 w-full border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-xs sm:text-sm"
                            placeholder="Harga (opsional)" @input="form.price = (form.price ?? '').replace(/[^0-9]/g, '')">
                        <textarea x-model="form.description"
                            class="min-w-0 w-full p-0 border-t-0 border-l-0 border-r-0 ring-0 focus:ring-0 text-xs sm:text-sm"
                            placeholder="Deskripsi (opsional)"></textarea>
                    </div>

                    <button type="submit"
                        class="min-w-[50px] bg-[#ff7100] text-white rounded-md py-2 text-sm font-semibold"
                        :disabled="loading">
                        <span x-show="!loading">Save</span>
                        <span x-show="loading" class="inline-block">
                            <svg class="animate-spin h-5 w-5 text-white"fill="none" viewBox="0 0 48 48"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 24c0 11.046 8.954 20 20 20s20-8.954 20-20S35.046 4 24 4"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="4" class="stroke-000000"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

        </form>
    </template>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('highlightManager', (initialData, userRole) => ({
                highlights: Array.isArray(initialData)
                    ? initialData.map((item) => ({
                        ...item,
                        available: item.available === true || item.available === 1 || item.available === '1',
                    }))
                    : [],
                userRole: userRole,
                multiple: false,
                form: {
                    product_id: "{{ $product->id }}",
                    highlightimages: []
                },
                previewImages: [],
                get canAddHighlight() {
                    return ['admin', 'premium'].includes(this.userRole) || this.highlights.length < 3;
                },
                init() {
                    this.$root.addEventListener('delete-highlight', (event) => {
                        this.deleteHighlight(event.detail);
                    });

                    document.addEventListener('new-highlight', (event) => {
                        if (event.detail && event.detail.id) {
                            this.highlights.push({
                                ...event.detail,
                                available: event.detail.available === true || event.detail.available === 1 || event.detail.available === '1',
                            });
                        }
                    });
                },

                async submitMultipleDummyForm() {
                    this.loading = true;
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('input[name="_token"]').value);
                    formData.append('product_id', this.form.product_id);

                    const inputFiles = this.$refs.highlightInput.files;
                    if (inputFiles.length > 0) {
                        for (let i = 0; i < inputFiles.length; i++) {
                            formData.append('images[]', inputFiles[i]);
                        }
                    }

                    try {
                        const response = await fetch("{{ route('highlight.multiple') }}", {
                            method: "POST",
                            body: formData
                        });

                        if (!response.ok) throw new Error("Gagal menyimpan data");

                        const result = await response.json();

                        result.forEach(item => {
                            document.dispatchEvent(new CustomEvent('new-highlight', {
                                detail: item
                            }));
                        });

                        this.form.highlightimages = [];
                        this.previewImages = [];
                        this.$refs.highlightInput.value = null;
                        this.multiple = false;

                    } catch (error) {
                        console.error("Terjadi kesalahan:", error.message);
                    } finally {
                        this.loading = false;
                    }
                },

                deleteHighlight(id) {
                    fetch(`{{ route('highlight.destroy', '') }}/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Gagal menghapus item');
                            this.highlights = this.highlights.filter(item => item.id !== id);
                        })
                        .catch(error => alert(error.message));
                }
            }));

            Alpine.data('highlightEditForm', (item) => ({
                previewImage: item.image
                    ? `{{ asset('storage/images/product/highlight/') }}/${item.image}`
                    : `{{ asset('assets/images/placeholder.webp') }}`,
                previewFile(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.previewImage = URL.createObjectURL(file);
                    }
                }
            }));

            Alpine.data('highlightCreateForm', () => ({
                form: {
                    product_id: "{{ $product->id }}",
                    title: '',
                    price: '',
                    description: '',
                    highlightimage: null
                },
                previewImage: null,
                loading: false,
                previewFile(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.form.highlightimage = file;
                        this.previewImage = URL.createObjectURL(file);
                    }
                },
                async submitForm() {
                    this.loading = true;
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('input[name="_token"]').value);
                    formData.append('product_id', this.form.product_id);
                    formData.append('title', this.form.title);
                    formData.append('price', this.form.price);
                    formData.append('description', this.form.description);
                    if (this.form.highlightimage) {
                        formData.append('highlightimage', this.form.highlightimage);
                    }

                    try {
                        const response = await fetch("{{ route('highlight.store') }}", {
                            method: "POST",
                            body: formData
                        });

                        if (!response.ok) throw new Error("Gagal menyimpan data");

                        const result = await response.json();

                        document.dispatchEvent(new CustomEvent('new-highlight', {
                            detail: result
                        }));

                        this.form.title = '';
                        this.form.price = '';
                        this.form.description = '';
                        this.form.highlightimage = null;
                        this.previewImage = '';
                        document.getElementById('highlightimage-input').value = null;

                    } catch (error) {
                        console.log("Terjadi kesalahan: " + error.message);
                    } finally {
                        this.loading = false;
                    }
                }
            }));
        });
    </script>
</div>
