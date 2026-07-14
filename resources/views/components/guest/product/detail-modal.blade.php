<div
    x-data="{
        show: false,
        product: { title: '', description: '', image: '', price: '' },
        openProductDetail(event) {
            this.product = event.detail ?? { title: '', description: '', image: '', price: '' };
            this.show = true;
        },
        closeProductDetail() {
            this.show = false;
        }
    }"
    x-on:open-product-detail.window="openProductDetail($event)"
    x-on:keydown.escape.window="closeProductDetail()"
>
    <div
        x-show="show"
        x-transition.opacity
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm px-4 py-6"
        style="display: none;"
    >
        <div class="flex min-h-full items-center justify-center">
            <div @click.outside="closeProductDetail()" class="w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl">
                <div class="flex items-start justify-between gap-4 border-b border-gray-100 px-5 py-5">
                    <div>
                        <p class="text-lg font-bold text-gray-900" x-text="product.title || 'Detail Produk'"></p>
                        <p x-show="product.price" class="mt-1 text-sm font-semibold text-gray-500" x-text="product.price"></p>
                    </div>
                    <button type="button" @click="closeProductDetail()" class="text-2xl leading-none text-gray-400 hover:text-gray-600">&times;</button>
                </div>
                <div class="space-y-4 px-5 py-5">
                    <div x-show="product.image" class="overflow-hidden rounded-2xl bg-gray-100">
                        <img :src="product.image" :alt="product.title || 'Produk'" class="aspect-video w-full object-cover">
                    </div>
                    <div class="rounded-2xl bg-gray-50 px-4 py-4">
                        <p class="text-sm leading-7 text-gray-700" x-text="product.description || 'Deskripsi produk belum tersedia.'"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
