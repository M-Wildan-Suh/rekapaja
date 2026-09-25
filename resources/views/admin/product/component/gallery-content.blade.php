                    <div  class=" p-4 md:p-6 text-gray-900 space-y-4">
                        <div x-data="galleryComponent({{ $product->productGallery }}, {{ $product->id }})" class="flex flex-col gap-2">
                            <label class="font-semibold" for="image_gallery">Galeri ( Max 9 )</label>
                            <input type="file" class="hidden" id="image_gallery" name="image_gallery[]" multiple
                                accept="image/*" @change="addImages($event)">
                            <div class="w-full grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-4">
                                <template x-for="(image, index) in images" :key="index">
                                    <div class="w-full aspect-[3/2] rounded-md relative overflow-hidden">
                                        <img :src="image.url" class="w-full h-full object-cover"
                                            alt="Gallery Image Preview">
                                        <label @click="deleteImage(index)"
                                            class="w-full text-transparent h-full absolute top-0 left-0 flex justify-center items-center p-[20%] hover:bg-black/60 hover:text-white/50 duration-300 cursor-pointer">
                                            <svg viewBox="0 0 24 24" class="w-full h-full"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19.5 8.99h-15a.5.5 0 0 0-.5.5v12.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.49a.5.5 0 0 0-.5-.5Zm-9.25 11.5a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0Zm5 0a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0ZM20.922 4.851a11.806 11.806 0 0 0-4.12-1.07 4.945 4.945 0 0 0-9.607 0A12.157 12.157 0 0 0 3.18 4.805 1.943 1.943 0 0 0 2 6.476 1 1 0 0 0 3 7.49h18a1 1 0 0 0 1-.985 1.874 1.874 0 0 0-1.078-1.654ZM11.976 2.01A2.886 2.886 0 0 1 14.6 3.579a44.676 44.676 0 0 0-5.2 0 2.834 2.834 0 0 1 2.576-1.569Z"
                                                    fill="currentColor" class="fill-000000"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </template>

                                <div class="w-full aspect-[3/2] border bg-neutral-100 border-neutral-600 rounded-md relative border-dashed overflow-hidden"
                                    x-show="images.length < 9">
                                    <label for="image_gallery"
                                        class="w-full text-neutral-600 h-full absolute top-0 left-0 flex justify-center items-center p-[20%] hover:bg-neutral-600 hover:text-white/50 duration-300 cursor-pointer">
                                        <svg viewBox="0 0 24 24" class="w-full h-full"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m9 13 3-4 3 4.5V12h4V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-4H5l3-4 1 2z"
                                                fill="currentColor" class="fill-000000"></path>
                                            <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z" fill="currentColor"
                                                class="fill-000000"></path>
                                        </svg>
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
                                        url: item.image ? `{{ asset('storage/images/product/gallery/') }}/${item.image}` :
                                            `{{ asset('assets/images/placeholder.png') }}`
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
                                                    window.dispatchEvent(new Event('business-gallery-updated'));
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
                                                window.dispatchEvent(new Event('business-gallery-updated'));
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

                    </div>
