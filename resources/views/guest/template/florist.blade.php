@php
    $floristBg = '#FFF5F8';
    $floristSurface = '#FFFFFF';
    $floristBorder = '#F8BBD0';
    $floristText = '#6A1B4D';
    $floristAccent = '#EC4899';
    $floristAccentDark = '#BE185D';
    $floristWhatsapp = '#25D366';
@endphp

<div class="mx-auto rounded-md bg-white min-h-screen relative">
    <div class="space-y-6">
        <div class="min-h-screen pt-6 relative space-y-4" style="background-color: {{ $floristBg }};">
            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-md overflow-hidden">
                <div class="relative w-full aspect-[2/1] overflow-hidden rounded-[1.2rem] shadow-[0_20px_60px_rgba(236,72,153,0.16)] text-[#6A1B4D]" style="background: linear-gradient(135deg, #FFF5F8 0%, #FBCFE8 52%, #F9A8D4 100%);">
                    <div class="absolute left-[6%] top-[10%] h-[80%] w-[42%] rounded-full border-2 border-white/70"></div>
                    <div class="absolute right-[6%] top-[16%] h-[68%] w-[36%] rounded-full border border-white/50"></div>
                    <div class="absolute inset-0 opacity-[0.08] bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $data->image }}');"></div>

                    @php
                        $keywords = $data->productTags
                            ->map(fn ($item) => optional($item->productTag)->tag)
                            ->filter()
                            ->take(3);
                    @endphp

                    <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-8">
                        <div class="max-w-[46%] space-y-2 sm:space-y-3">
                            <p class="text-[1.45rem] sm:text-[2.2rem] font-black leading-tight" style="font-family: 'Segoe Script', 'Brush Script MT', cursive; color: {{ $floristText }};">
                                {{ $data->name }}
                            </p>
                            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-[0.22em]" style="color: {{ $floristAccentDark }};">
                                {{ $data->subtitle ?: 'Custom Header' }}
                            </p>

                            @if ($keywords->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($keywords as $keyword)
                                        <div class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] sm:text-xs font-semibold shadow-sm" style="color: {{ $floristAccentDark }};">
                                            {{ $keyword }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex h-28 w-28 sm:h-40 sm:w-40 items-center justify-center overflow-hidden rounded-full border-[5px] sm:border-[6px] border-white shadow-xl shadow-pink-300/30">
                            <img src="{{ $data->image }}" class="h-full w-full object-cover" alt="{{ $data->name }}">
                        </div>
                    </div>
                </div>
            </div>

            @if ($data->productGallery->isNotEmpty())
                <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
                    @include('components.guest.gallery.' . $template->gallery_type)
                </div>
            @endif

            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
                <div class="flex items-center justify-center gap-4 text-center">
                    <span class="h-px w-10" style="background-color: {{ $floristAccent }};"></span>
                    <p class="text-[2rem] sm:text-[2.35rem] font-black tracking-tight" style="color: {{ $floristText }};">{{ $data->product_title ?: 'Koleksi Buket Pilihan' }}</p>
                    <span class="h-px w-10" style="background-color: {{ $floristAccent }};"></span>
                </div>
            </div>

            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative space-y-6">
                <div
                    x-data="{
                        checkedItems: [],
                        showOrderModal: false,
                        showQrisPreviewModal: false,
                        customerName: '',
                        customerAddress: '',
                        isPremiumBusiness: @js(in_array($role, ['admin', 'premium'])),
                        requiresCustomerData: @js(($data->customer_data ?? 'active') === 'active'),
                        showQrisSection: @js(($data->qris_status ?? 'active') === 'active'),
                        qrisUrl: @js($data->qris ? asset('storage/images/product/qris/' . $data->qris) : null),
                        get shouldShowOrderModal() {
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
                    <form id="myForm" action="{{ route('order', ['no_tlp' => $no_tlp]) }}" method="post" enctype="multipart/form-data" target="_blank" x-ref="orderForm">
                        @csrf
                        <input type="hidden" name="customer_name" :value="customerName">
                        <input type="hidden" name="customer_address" :value="customerAddress">
                        <input type="hidden" name="product_id" value="{{ $data->id }}">

                        <div class="grid grid-cols-2 gap-3">
                            @foreach ($data->productHighlight->take(3) as $item)
                                <div class="overflow-hidden rounded-[1.4rem] border bg-white shadow-[0_10px_30px_rgba(236,72,153,0.12)]" style="border-color: {{ $floristBorder }};">
                                    <div class="relative aspect-[1.05/1]">
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="h-full w-full object-cover object-center">

                                        @if (!$item->available)
                                            <div class="absolute left-4 top-4 rounded-full bg-pink-600 px-4 py-1.5 text-xs font-bold tracking-wide text-white shadow-md">
                                                Habis
                                            </div>
                                        @endif
                                    </div>

                                    <div id="product" class="space-y-3 p-3" style="background-color: {{ $template->product_main_color }}; color: {{ $template->product_text_color }};">
                                        <p class="min-h-[2.5rem] text-left text-sm font-black leading-snug">{{ $item->title }}</p>

                                        @if ($item->price)
                                            <p class="text-left text-sm font-semibold" style="color: {{ $floristAccent }};">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        @endif

                                        <div class="grid grid-cols-2 gap-2">
                                            <x-guest.product.detail-button
                                                :item="$item"
                                                label="Detail Buket"
                                                class="inline-flex w-full items-center justify-center rounded-full border px-3 py-2 text-xs font-semibold transition hover:bg-pink-50"
                                                :style="'border-color: ' . $floristBorder . '; color: ' . ($template->product_text_color ?? $floristText)"
                                            />

                                            @if ($role === 'admin' || $role === 'premium')
                                                <input
                                                    type="checkbox"
                                                    class="hidden"
                                                    name="order[{{ $item->id }}][id]"
                                                    value="{{ $item->id }}"
                                                    id="order-{{ $item->id }}"
                                                    @input="checkedItems.some(data => data.id === {{ $item->id }})
                                                        ? checkedItems = checkedItems.filter(data => data.id !== {{ $item->id }})
                                                        : checkedItems.push({ id: {{ $item->id }}, title: '{{ addslashes($item->title) }}', quantity: 1, price: {{ (int) ($item->price ?? 0) }} })"
                                                >
                                                <input
                                                    type="number"
                                                    class="hidden"
                                                    name="order[{{ $item->id }}][quantity]"
                                                    :value="checkedItems.find(item => item.id === {{ $item->id }})?.quantity || 1"
                                                    x-model="checkedItems.find(item => item.id === {{ $item->id }})?.quantity"
                                                >
                                                <label
                                                    @if ($item->available) for="order-{{ $item->id }}" @endif
                                                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-full px-3 py-2 text-xs font-bold text-white transition hover:opacity-90"
                                                    style="background-color: {{ $template->product_second_color ?? $floristWhatsapp }};"
                                                    :class="checkedItems.some(data => data.id === {{ $item->id }}) ? 'opacity-60' : ''"
                                                >
                                                    Pesan
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
                            <button
                                @click="dropdownOpen = !dropdownOpen"
                                :class="dropdownOpen ? 'bg-pink-700 rounded-b-none' : 'bg-pink-500 rounded-b-full'"
                                class="text-base flex flex-col items-center p-2.5 rounded-t-full duration-300 text-white relative backdrop-blur-sm shadow-lg"
                            >
                                <div class="absolute -top-1 -right-1 bg-red-500 rounded-full w-5 h-5 text-xs flex items-center justify-center" x-text="checkedItems.length"></div>
                                <div class="w-6 aspect-square">
                                    <svg data-name="Layer 1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.53 5 5 3H1.25a1 1 0 0 0 0 2h2.22L6.7 18H20v-2H8.26l-.33-1.34L21 12.17V5ZM19 10.52 7.45 12.71 6 7h13ZM7 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 7 19Zm12 0a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 19 19Z" fill="currentColor"></path>
                                    </svg>
                                </div>
                            </button>

                            <div
                                x-show="dropdownOpen"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute top-full right-0 mt-0 w-72 rounded-2xl rounded-tr-none border py-3 px-3 text-white shadow-xl backdrop-blur-sm"
                                style="background: #BE185D; border-color: #F8BBD0;"
                            >
                                <div class="flex flex-col gap-2">
                                    <template x-for="item in checkedItems" :key="item.id">
                                        <div class="flex justify-between items-center gap-3 py-2 px-2.5 rounded-xl bg-white/10 border border-white/20">
                                            <p class="font-semibold text-sm leading-snug flex-1" x-text="item.title"></p>

                                            <div class="flex flex-row items-center gap-2">
                                                <div class="flex items-center rounded-full border border-white/30 overflow-hidden">
                                                    <button type="button" @click="decrementQuantity(item)" class="w-8 h-8 hover:bg-white/10">-</button>
                                                    <input
                                                        type="number"
                                                        x-model="item.quantity"
                                                        @input="normalizeQuantity(item)"
                                                        @blur="normalizeQuantity(item)"
                                                        min="1"
                                                        max="999"
                                                        class="w-12 text-center bg-transparent border-0 ring-0"
                                                    >
                                                    <button type="button" @click="incrementQuantity(item)" class="w-8 h-8 hover:bg-white/10">+</button>
                                                </div>

                                                <label :for="'order-' + item.id" class="text-red-300 hover:text-red-100 text-xl cursor-pointer">&times;</label>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="w-full flex justify-end mt-3">
                                        <button
                                            type="button"
                                            @click="openOrderModal()"
                                            class="py-2 px-4 flex items-center gap-2 text-sm rounded-xl text-white font-semibold transition hover:opacity-90"
                                            style="background-color: {{ $floristWhatsapp }};"
                                        >
                                            <div class="w-5 h-5">
                                                <svg viewBox="0 0 56.693 56.693" fill="currentColor">
                                                    <path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428z"/>
                                                </svg>
                                            </div>
                                            <span>Pesan Buket via WhatsApp</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="showOrderModal" x-transition.opacity class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm px-4 py-6" style="display: none;">
                        <div class="flex min-h-full items-center justify-center">
                            <div @click.outside="closeOrderModal()" class="w-full max-w-md max-h-[calc(100vh-3rem)] overflow-hidden rounded-3xl bg-white shadow-2xl">
                                <div class="px-6 py-5 text-white" style="background: linear-gradient(135deg, #EC4899, #BE185D);">
                                    <div class="flex justify-between items-center gap-4">
                                        <div>
                                            <h2 class="text-xl font-bold">Form Pemesanan Buket</h2>
                                            <p class="text-pink-100 text-sm">Lengkapi data sebelum melakukan pemesanan.</p>
                                        </div>

                                        <button @click="closeOrderModal()" class="text-3xl leading-none">&times;</button>
                                    </div>
                                </div>

                                <div class="max-h-[calc(100vh-12rem)] overflow-y-auto space-y-5 p-6">
                                    <div x-show="requiresCustomerData" x-cloak>
                                        <label for="customer-name-florist" class="block text-sm font-semibold mb-2">Nama Pemesan</label>
                                        <input
                                            id="customer-name-florist"
                                            type="text"
                                            x-model="customerName"
                                            placeholder="Masukkan nama lengkap"
                                            class="w-full rounded-xl border px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
                                        >
                                    </div>

                                    <div x-show="requiresCustomerData" x-cloak>
                                        <label for="customer-address-florist" class="block text-sm font-semibold mb-2">Alamat Pengiriman</label>
                                        <textarea
                                            id="customer-address-florist"
                                            rows="3"
                                            x-model="customerAddress"
                                            placeholder="Masukkan alamat lengkap"
                                            class="w-full rounded-xl border px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
                                        ></textarea>
                                    </div>

                                    <div class="rounded-2xl p-4" style="background: #FFF1F6;">
                                        <div class="flex justify-between gap-3">
                                            <span>Total Pembayaran</span>
                                            <span class="font-bold text-lg" style="color: {{ $floristAccent }};" x-text="'Rp ' + formatCurrency(totalPrice)"></span>
                                        </div>
                                    </div>

                                    <div x-show="showQrisSection" x-cloak class="rounded-2xl border p-4" style="border-color: {{ $floristBorder }};">
                                        <h3 class="font-bold mb-3" style="color: {{ $floristAccentDark }};">Pembayaran QRIS</h3>

                                        <template x-if="qrisUrl">
                                            <img :src="qrisUrl" class="rounded-xl mx-auto w-52" alt="QRIS">
                                        </template>

                                        <div class="flex gap-3 mt-4">
                                            <button type="button" @click="openQrisPreview()" class="flex-1 rounded-xl py-2 text-white" style="background: {{ $floristAccent }};">
                                                Lihat QRIS
                                            </button>
                                            <button type="button" @click="downloadQris()" class="flex-1 rounded-xl py-2 text-white" style="background: {{ $floristWhatsapp }};">
                                                Download
                                            </button>
                                        </div>
                                    </div>

                                    <button type="button" @click="submitOrder()" class="w-full rounded-xl py-3 text-white font-bold" style="background: {{ $floristAccent }};">
                                        Kirim Pesanan
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

            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
                <div class="rounded-[1.8rem] px-5 py-6 sm:px-6 text-white shadow-lg" style="background: linear-gradient(135deg, {{ $floristAccentDark }} 0%, {{ $floristAccent }} 58%, #D94687 100%);">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-none items-center justify-center rounded-full bg-white/10">
                                <svg viewBox="0 0 24 24" class="h-8 w-8 sm:h-9 sm:w-9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 13.5a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/>
                                    <path d="M5 20a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M19 7.5h.01M5 7.5h.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xl sm:text-[2rem] font-black leading-tight">{{ $data->name }}</p>
                                <p class="mt-1 text-sm font-medium uppercase tracking-[0.18em] text-white/70">Tentang Usaha</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm sm:text-base leading-7 text-white/85">
                                {!! nl2br(e($data->description == '' ? 'Description' : $data->description)) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.guest.contact')
        </div>
    </div>
</div>

<x-guest.product.detail-modal />
