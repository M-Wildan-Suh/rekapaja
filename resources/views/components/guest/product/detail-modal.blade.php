<div
    x-data="{
        show: false,
        product: { id: null, title: '', description: '', image: '', price: '', canOrder: false },
        openProductDetail(event) {
            this.product = event.detail ?? { id: null, title: '', description: '', image: '', price: '', canOrder: false };
            this.show = true;
        },
        closeProductDetail() {
            this.show = false;
        },
        orderProduct() {
            if (!this.product?.id || !this.product?.canOrder) {
                return;
            }

            const trigger = document.querySelector(`label[for='order-${this.product.id}']`);

            if (!trigger) {
                return;
            }

            this.closeProductDetail();
            trigger.click();
        }
    }"
    x-on:open-product-detail.window="openProductDetail($event)"
    x-on:keydown.escape.window="closeProductDetail()"
>
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm px-4 py-6"
        style="display: none;"
    >
        <div class="flex min-h-full items-center justify-center">
            <div
                x-show="show"
                x-transition:enter="transition ease-out duration-300 delay-75"
                x-transition:enter-start="opacity-0 translate-y-3 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-3 scale-[0.98]"
                @click.outside="closeProductDetail()"
                class="w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl"
            >
                <div x-show="product.image" class="overflow-hidden bg-gray-100 relative">
                    <img :src="product.image" :alt="product.title || 'Produk'" class="aspect-video w-full object-cover">
                    <button type="button" @click="closeProductDetail()" class=" absolute top-5 right-5 w-8 text-2xl rounded-full bg-white aspect-square leading-none text-gray-600 hover:text-gray-800">&times;</button>
                </div>
                <div class="space-y-2 px-5 py-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <p class="text-lg font-bold text-gray-900" x-text="product.title || 'Detail Produk'"></p>
                            <p x-show="product.price" class="mt-1 text-sm font-semibold text-gray-500" x-text="product.price"></p>
                        </div>
                        <button
                            type="button"
                            @click="orderProduct()"
                            x-show="product.canOrder"
                            class="shrink-0 rounded-xl bg-green-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-600"
                        >
                            Order
                        </button>
                    </div>
                    <p class="text-sm leading-7 text-gray-700" x-text="product.description || 'Deskripsi produk belum tersedia.'"></p>
                </div>
            </div>
        </div>
    </div>
</div>
