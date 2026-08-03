@php
    $floristSurface = '#FFFFFF';
    $floristBorder = '#F8BBD0';
    $floristText = '#6A1B4D';
    $floristAccent = $template->accent_color ?? '#EC4899';
    $floristAccentDark = '#BE185D';
    $floristWhatsapp = $template->contact_main_color ?? '#25D366';
@endphp

<div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative space-y-6">
    <div
        x-data="{
            checkedItems: [],
            showOrderModal: false,
            showQrisPreviewModal: false,
            customerName: '',
            customerAddress: '',
            isPremiumBusiness: @js(in_array($role, ['admin', 'premium'])),
            orderViaWhatsapp: @js($data->order_via_whatsapp ?? 'instan_rekap'),
            askWhatsappUrl: @js('https://wa.me/' . $no_tlp . '?text=' . urlencode("Halo, saya ingin bertanya mengenai produk.\nAsal chat: RekapAja.com")),
            requiresCustomerData: @js(($data->customer_data ?? 'active') === 'active'),
            showQrisSection: @js(($data->qris_status ?? 'active') === 'active'),
            qrisUrl: @js($data->qris ? asset('storage/images/product/qris/' . $data->qris) : null),
            get shouldShowOrderModal() {
                if (this.orderViaWhatsapp === 'tanya') {
                    return false;
                }

                return this.isPremiumBusiness && (this.requiresCustomerData || this.showQrisSection);
            },
            normalizeQuantity(item) {
                item.quantity = Math.min(999, Math.max(1, parseInt(item.quantity || 1)));
            },
            decrementQuantity(item) {
                item.quantity = Math.max(1, (parseInt(item.quantity || 1) - 1));
            },
            incrementQuantity(item) {
                item.quantity = Math.min(999, (parseInt(item.quantity || 1) + 1));
            },
            openOrderModal() {
                if (!this.checkedItems.length) {
                    return;
                }

                if (this.orderViaWhatsapp === 'tanya') {
                    window.open(this.askWhatsappUrl, '_blank', 'noopener');
                    return;
                }

                if (!this.shouldShowOrderModal) {
                    this.$nextTick(() => this.$refs.orderForm.submit());
                    return;
                }

                this.showOrderModal = true;
            },
            closeOrderModal() {
                this.showOrderModal = false;
            },
            openQrisPreview() {
                if (!this.qrisUrl) {
                    return;
                }

                this.showQrisPreviewModal = true;
            },
            closeQrisPreview() {
                this.showQrisPreviewModal = false;
            },
            get totalPrice() {
                return this.checkedItems.reduce((total, item) => {
                    return total + ((parseInt(item.price || 0)) * (parseInt(item.quantity || 1)));
                }, 0);
            },
            formatCurrency(value) {
                return new Intl.NumberFormat('id-ID').format(value || 0);
            },
            async downloadQris() {
                if (!this.qrisUrl) {
                    return;
                }

                try {
                    const response = await fetch(this.qrisUrl);

                    if (!response.ok) {
                        throw new Error('Gagal mengunduh QRIS.');
                    }

                    const blob = await response.blob();
                    const blobUrl = window.URL.createObjectURL(blob);
                    const extension = blob.type.split('/')[1] || 'png';
                    const link = document.createElement('a');

                    link.href = blobUrl;
                    link.download = `qris.${extension}`;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    window.URL.revokeObjectURL(blobUrl);
                } catch (error) {
                    console.error(error);
                    window.open(this.qrisUrl, '_blank', 'noopener');
                }
            },
            submitOrder() {
                if (this.requiresCustomerData && (!this.customerName.trim() || !this.customerAddress.trim())) {
                    return;
                }

                this.$refs.orderForm.submit();
            }
        }"
        class="w-full"
    >
        <div x-show="showQrisSection" x-cloak class="rounded-md border px-5 py-5 sm:px-6 shadow-[0_10px_30px_rgba(236,72,153,0.10)]" style="border-color: {{ $floristBorder }}; background-color: {{ $floristSurface }};">
            <div class="flex items-center justify-between gap-4">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full text-white" style="background: linear-gradient(135deg, {{ $floristAccent }} 0%, {{ $floristAccentDark }} 100%);">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 7h16M7 4v6M17 4v6M5 11h4v4H5zm10 0h4v4h-4zM5 17h4v3H5zm10 0h4v3h-4z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-lg sm:text-xl font-black leading-tight" style="color: {{ $floristText }};">Pembayaran QRIS</p>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" @click="openQrisPreview()" :disabled="!qrisUrl" class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-bold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:bg-neutral-300" style="background-color: {{ $floristAccent }};">
                        Lihat
                    </button>
                    <button type="button" @click="downloadQris()" :disabled="!qrisUrl" class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-bold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:bg-neutral-300" style="background-color: {{ $floristWhatsapp }};">
                        Download
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full relative py-4">
            <div class="flex items-center justify-center gap-4 text-center">
                <span class="h-px w-10" style="background-color: {{ $floristAccent }};"></span>
                <p class="text-[2rem] sm:text-[2.35rem] font-black tracking-tight" style="color: {{ $floristText }};">{{ $data->product_title ?: 'Koleksi Buket Pilihan' }}</p>
                <span class="h-px w-10" style="background-color: {{ $floristAccent }};"></span>
            </div>
        </div>

        <form id="myForm" action="{{ route('order', ['no_tlp' => $no_tlp]) }}" method="post" enctype="multipart/form-data" target="_blank" x-ref="orderForm">
            @csrf
            <input type="hidden" name="customer_name" :value="customerName">
            <input type="hidden" name="customer_address" :value="customerAddress">
            <input type="hidden" name="product_id" value="{{ $data->id }}">

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                @foreach ($data->productHighlight->take(3) as $item)
                    <div class="overflow-hidden rounded-md border bg-white shadow-[0_10px_30px_rgba(236,72,153,0.12)]" style="border-color: {{ $floristBorder }};">
                        <div class="relative">
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="aspect-[1.15/1] w-full object-cover object-center">
                            @if (!$item->available)
                                <div class="absolute left-4 top-4 rounded-full bg-pink-600 px-4 py-1.5 text-xs font-bold tracking-wide text-white shadow-md">
                                    Habis
                                </div>
                            @endif
                        </div>
                        <div class="space-y-3 p-4">
                            <div>
                                <p class="text-lg sm:text-xl font-black leading-snug" style="color: {{ $floristText }};">{{ $item->title }}</p>
                            </div>
                            @if ($item->price)
                                <p class="text-[1.35rem] sm:text-[1.8rem] font-black" style="color: {{ $floristAccent }};">
                                    @if (($data->order_via_whatsapp ?? 'instan_rekap') === 'tanya' && filled($data->price_prefix))
                                        {{ $data->price_prefix }}
                                    @endif
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            @endif
                            <div class="grid grid-cols-2 gap-2">
                                <x-guest.product.detail-button
                                    :item="$item"
                                    label="Detail"
                                    class="inline-flex w-full items-center justify-center rounded-full border px-4 py-1 text-sm font-semibold transition hover:bg-pink-50"
                                    :style="'border-color: ' . $floristBorder . '; color: ' . $floristText"
                                />
                                @if ($role === 'admin' || $role === 'premium')
                                    <input type="checkbox" class="hidden" name="order[{{ $item->id }}][id]" value="{{ $item->id }}" id="order-{{ $item->id }}"
                                        @input="checkedItems.some(data => data.id === {{ $item->id }})
                                            ? checkedItems = checkedItems.filter(data => data.id !== {{ $item->id }})
                                            : checkedItems.push({ id: {{ $item->id }}, title: '{{ addslashes($item->title) }}', quantity: 1, price: {{ (int) ($item->price ?? 0) }} })">
                                    <input type="number" class="hidden" name="order[{{ $item->id }}][quantity]"
                                        :value="checkedItems.find(item => item.id === {{ $item->id }})?.quantity || 1"
                                        x-model="checkedItems.find(item => item.id === {{ $item->id }})?.quantity">
                                    <label @if ($item->available) for="order-{{ $item->id }}" @endif
                                        @click="if (orderViaWhatsapp === 'tanya' && {{ $item->available ? 'true' : 'false' }}) { $event.preventDefault(); window.open('https://wa.me/{{ $no_tlp }}?text=' + encodeURIComponent('Halo, saya ingin bertanya mengenai produk {{ addslashes($item->title) }}.\nAsal chat: RekapAja.com'), '_blank', 'noopener'); return; }"
                                        class="inline-flex w-full cursor-pointer items-center justify-center rounded-full px-5 py-1 text-sm font-bold text-white transition hover:opacity-90"
                                        style="background-color: {{ $floristWhatsapp }};"
                                        :class="checkedItems.some(data => data.id === {{ $item->id }}) ? 'opacity-60' : ''">
                                        {{ $data->order_title ?: 'Pesan' }}
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>

        <div class="fixed top-5 left-1/2 -translate-x-1/2 px-4 md:px-0 flex justify-end z-10 w-full max-w-[600px]" x-show="checkedItems.length > 0">
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" :class="dropdownOpen ? 'bg-pink-700 rounded-b-none' : 'bg-pink-500 rounded-b-full'" class="text-base flex flex-col items-center p-2.5 rounded-t-full duration-300 text-white relative backdrop-blur-sm shadow-lg shadow-pink-300/30">
                    <div class="absolute -top-1 -right-1 bg-red-500 rounded-full w-5 h-5 text-xs flex items-center justify-center" x-text="checkedItems.length"></div>
                    <div class="w-6 aspect-square">
                        <svg data-name="Layer 1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.53 5 5 3H1.25a1 1 0 0 0 0 2h2.22L6.7 18H20v-2H8.26l-.33-1.34L21 12.17V5ZM19 10.52 7.45 12.71 6 7h13ZM7 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 7 19Zm12 0a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 19 19Z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>

                <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute top-full right-0 mt-0 w-72 rounded-2xl rounded-tr-none border py-3 px-3 text-white shadow-xl backdrop-blur-sm"
                    style="background: {{ $floristAccentDark }}; border-color: {{ $floristBorder }};">
                    <div class="flex flex-col gap-2">
                        <template x-for="item in checkedItems" :key="item.id">
                            <div class="flex justify-between items-center gap-3 py-2 px-2.5 rounded-xl bg-white/10 border border-white/20">
                                <p class="font-semibold text-sm leading-snug flex-1" x-text="item.title"></p>
                                <div class="flex flex-row items-center gap-2">
                                    <div class="flex items-center rounded-full border border-white/20 bg-black/10 overflow-hidden">
                                        <button type="button" @click="decrementQuantity(item)" class="w-8 h-8 text-lg hover:bg-white/10 duration-200">-</button>
                                        <input type="number" x-model="item.quantity" @input="normalizeQuantity(item)" @blur="normalizeQuantity(item)" max="999" min="1" class="w-12 text-center text-sm p-0 border-0 bg-transparent ring-0 focus:ring-0 focus:border-0 [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                                        <button type="button" @click="incrementQuantity(item)" class="w-8 h-8 text-lg hover:bg-white/10 duration-200">+</button>
                                    </div>
                                    <label :for="'order-' + item.id" class="text-red-200 hover:text-white text-xl leading-none duration-300 cursor-pointer">&times;</label>
                                </div>
                            </div>
                        </template>
                        <div class="w-full flex justify-end">
                            <button type="button" @click="openOrderModal()" class="py-2 px-3.5 flex items-center gap-2 text-sm rounded-xl text-white duration-300 hover:opacity-90" style="background-color: {{ $floristWhatsapp }};">
                                <div class="w-4 h-4">
                                    <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"></path></svg>
                                </div>
                                <p>Pesan via WhatsApp</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showOrderModal" x-transition.opacity class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm px-4 py-6" style="display: none;">
            <div class="flex min-h-full items-center justify-center">
                <div @click.outside="closeOrderModal()" class="w-full max-w-md max-h-[calc(100vh-3rem)] overflow-hidden rounded-2xl bg-white shadow-2xl">
                    <div class="sticky top-0 z-10 px-5 py-5 text-white" style="background: linear-gradient(135deg, {{ $floristAccent }} 0%, {{ $floristAccentDark }} 100%);">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-lg font-bold">Lengkapi data pemesan</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" @click="downloadQris()" x-show="qrisUrl" class="text-white/80 duration-300 hover:text-white">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 3V14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M8 10L12 14L16 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5 17H19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </button>
                                <button type="button" @click="closeOrderModal()" class="text-2xl leading-none text-white/80 hover:text-white">&times;</button>
                            </div>
                        </div>
                    </div>
                    <div class="max-h-[calc(100vh-12rem)] overflow-y-auto px-5 py-4 space-y-4">
                        <div x-show="requiresCustomerData" x-cloak>
                            <label for="customer-name-florist" class="mb-1 block text-sm font-semibold text-gray-700">Nama Pemesan</label>
                            <input id="customer-name-florist" type="text" x-model="customerName" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Masukkan nama pemesan">
                        </div>
                        <div x-show="requiresCustomerData" x-cloak>
                            <label for="customer-address-florist" class="mb-1 block text-sm font-semibold text-gray-700">Alamat</label>
                            <textarea id="customer-address-florist" x-model="customerAddress" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                        <div class="rounded-2xl border border-pink-100 bg-pink-50 px-4 py-3">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-gray-600">Total Harga</p>
                                <p class="text-lg font-bold" style="color: {{ $floristAccentDark }};" x-text="'Rp' + formatCurrency(totalPrice)"></p>
                            </div>
                        </div>
                        <div x-show="showQrisSection" x-cloak class="rounded-2xl border px-4 py-4" style="border-color: {{ $floristBorder }}; background-color: #FFF5F8;">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm font-semibold" style="color: {{ $floristAccentDark }};">Pembayaran QRIS</p>
                                </div>
                                <div x-show="qrisUrl" class="mx-auto w-full max-w-[220px] overflow-hidden rounded-2xl bg-white p-3 shadow-sm">
                                    <img :src="qrisUrl" alt="QRIS" class="w-full rounded-xl object-cover">
                                </div>
                                <div x-show="qrisUrl" class="flex justify-center">
                                    <button type="button" @click="openQrisPreview()" class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-semibold text-white transition hover:opacity-90" style="background-color: {{ $floristAccent }};">
                                        Lihat lebih besar
                                    </button>
                                </div>
                                <p x-show="!qrisUrl" class="text-center text-sm" style="color: {{ $floristAccentDark }};">QRIS belum tersedia untuk usaha ini.</p>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 bg-white px-5 py-4">
                        <button type="button" @click="submitOrder()" :disabled="requiresCustomerData && (!customerName.trim() || !customerAddress.trim())" class="w-full rounded-xl px-4 py-3 text-sm font-bold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:bg-gray-300" style="background-color: {{ $floristWhatsapp }};">
                            Kirim pesanan ke WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showQrisPreviewModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/80 px-4 py-6" style="display: none;">
            <div class="flex min-h-full items-center justify-center">
                <div @click.outside="closeQrisPreview()" class="w-full max-w-sm rounded-3xl bg-white p-5 shadow-2xl">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-lg font-bold text-gray-900">Preview QRIS</p>
                        </div>
                        <button type="button" @click="closeQrisPreview()" class="text-2xl leading-none text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
                    <div class="overflow-hidden rounded-2xl bg-gray-50 p-3">
                        <template x-if="qrisUrl">
                            <img :src="qrisUrl" alt="QRIS" class="w-full rounded-xl object-cover">
                        </template>
                        <p x-show="!qrisUrl" class="text-center text-sm text-gray-500">QRIS belum tersedia untuk usaha ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
