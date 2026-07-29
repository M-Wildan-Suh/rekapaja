@php
    $themeBg = '#FFF0F5';      // Soft pink background
    $themeSurface = '#FFFFFF'; // Clean white surface
    $themeBorder = '#F7D6DE';  // Soft pink border
    $themeText = '#4A3B32';    // Deep brown text
    $themeMuted = '#8C746A';   // Muted brown
    $themeAccent = '#D9758F';  // Strawberry pink highlight
    $themeAccentDark = '#B5556F'; // Darker pink for gradients
    $themeWhatsapp = '#3EA648'; // Standard Whatsapp green
@endphp

<div class="mx-auto rounded-md bg-white min-h-screen relative">
    <div class="space-y-6">
        <div class="min-h-screen pt-6 relative space-y-4 pb-20" style="background-color: {{ $themeBg }};">
            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative rounded-[2.5rem] overflow-hidden pt-4 pb-2">
                <div class="w-full aspect-[2/1.1] sm:aspect-[2/1] overflow-hidden rounded-[2.5rem] bg-white shadow-[0_20px_50px_rgba(217,117,143,0.15)] group relative border-4 border-white">
                    <div class="grid grid-cols-[1fr_1fr] relative h-full overflow-hidden" style="background-color: {{ $themeBg }};">
                        
                        <!-- Background glow -->
                        <div class="absolute -top-12 -left-12 w-32 h-32 rounded-full bg-gradient-to-br from-[#FFF0F5] to-[#F7D6DE] blur-3xl opacity-80"></div>
                        
                        <!-- Pattern overlay -->
                        <div class="absolute inset-0 opacity-[0.05] bg-cover bg-center bg-no-repeat mix-blend-multiply transition-transform duration-1000 group-hover:scale-110" style="background-image: url('{{ $data->image }}');"></div>
                        
                        <div class="px-5 py-6 sm:px-8 sm:py-8 flex flex-col justify-center relative z-10">
                            <div class="space-y-4">
                                <div class="space-y-1 sm:space-y-2">
                                    <h1 class="text-[1.8rem] sm:text-[3.2rem] leading-[1.1] transform group-hover:-translate-y-1 transition-transform duration-500" style="font-family: 'Segoe Script', 'Brush Script MT', cursive; color: {{ $themeText }}; text-shadow: 2px 2px 4px rgba(217,117,143,0.1);">
                                        {{ $data->name }}
                                    </h1>
                                    <p class="text-[1.1rem] sm:text-[1.4rem] font-bold italic leading-tight opacity-90 transform group-hover:translate-x-1 transition-transform duration-500 delay-75" style="color: {{ $themeAccent }};">
                                        {{ $data->subtitle ?: 'Setiap Gigitan Penuh Kenangan' }}
                                    </p>
                                </div>

                                @php
                                    $keywords = $data->productTags
                                        ->map(fn ($item) => optional($item->productTag)->tag)
                                        ->filter()
                                        ->take(6);
                                @endphp

                                @if ($keywords->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 sm:gap-2 mt-4 transform group-hover:translate-y-1 transition-transform duration-500 delay-150">
                                        @foreach ($keywords as $keyword)
                                            <div class="rounded-full border border-white/50 bg-white/40 backdrop-blur-md px-3 py-1 text-[9px] sm:px-4 sm:py-1.5 sm:text-[11px] font-bold uppercase tracking-wider shadow-sm hover:bg-white transition-colors duration-300" style="color: {{ $themeText }};">
                                                {{ $keyword }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="relative h-full overflow-hidden z-10" style="background: radial-gradient(120% 120% at 0% 0%, #F2A2B3 0%, {{ $themeAccent }} 60%, {{ $themeAccentDark }} 100%);">
                            <!-- Animated decorative rings -->
                            <div class="absolute left-[-15%] top-[-5%] h-[110%] w-[110%] rounded-full border-[3px] border-dashed border-white/40 animate-[spin_20s_linear_infinite]"></div>
                            <div class="absolute left-[5%] top-[10%] h-[80%] w-[80%] rounded-full border-2 border-white/30 animate-[spin_15s_linear_infinite_reverse]"></div>
                            
                            <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-7">
                                <div class="w-full max-w-[440px] overflow-hidden rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.15)] ring-[6px] ring-white/25 group-hover:ring-white/40 transition-all duration-500 group-hover:scale-105">
                                    <img src="{{ $data->image }}" class="aspect-square w-full object-cover object-center group-hover:rotate-3 transition-transform duration-700 ease-out" alt="{{ $data->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($data->productGallery->isNotEmpty())
                <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
                    @include('components.guest.gallery.' . $template->gallery_type)
                </div>
            @endif

            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative pt-4">
                <div class="flex items-center justify-center gap-4 text-center">
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $themeAccent }}; opacity: 0.8;"></span>
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $themeAccent }}; opacity: 0.5;"></span>
                    <p class="text-[1.8rem] sm:text-[2.2rem] font-black tracking-tight mx-2" style="color: {{ $themeText }};">{{ $data->product_title ?: 'Produk Unggulan' }}</p>
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $themeAccent }}; opacity: 0.5;"></span>
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $themeAccent }}; opacity: 0.8;"></span>
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

                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach ($data->productHighlight as $item)
                                <div class="overflow-hidden rounded-[2rem] border bg-white/80 backdrop-blur-md shadow-[0_8px_30px_rgba(217,117,143,0.08)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(217,117,143,0.2)] transition-all duration-500 group flex flex-col" style="border-color: {{ $themeBorder }};">
                                    <div class="relative overflow-hidden m-2 sm:m-2.5 rounded-[1.5rem]">
                                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors z-10 duration-500"></div>
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="aspect-square w-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out">
                                        @if (!$item->available)
                                            <div class="absolute left-3 top-3 rounded-full bg-black/75 px-3 py-1 text-[10px] font-bold tracking-wide text-white shadow-md backdrop-blur-sm z-20">
                                                Kosong
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-2 px-3 sm:px-4 pb-4 pt-1 flex flex-col flex-1">
                                        <div class="flex-1 text-center">
                                            <p class="text-[1.1rem] sm:text-[1.2rem] font-black leading-snug line-clamp-2" style="color: {{ $themeText }};">{{ $item->title }}</p>
                                            <p class="text-[0.7rem] sm:text-[0.75rem] mt-1.5 line-clamp-2 font-medium opacity-80" style="color: {{ $themeMuted }};">{{ $item->description }}</p>
                                        </div>
                                        @if ($item->price)
                                            <div class="flex justify-center items-center py-1">
                                                <p class="text-[1.05rem] sm:text-[1.2rem] font-black" style="color: {{ $themeAccentDark }};">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                        @endif
                                        <div class="grid grid-cols-[1fr_auto] gap-2 mt-2">
                                            <x-guest.product.detail-button
                                                :item="$item"
                                                label="Detail"
                                                class="inline-flex w-full items-center justify-center rounded-[1rem] border px-2 py-2 text-[10px] sm:text-[11px] font-black uppercase tracking-wider transition-all duration-300 hover:bg-[#FFF0F5] hover:scale-[1.02]"
                                                :style="'border-color: ' . $themeBorder . '; color: ' . $themeAccent"
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
                                                    class="inline-flex w-8 h-8 sm:w-9 sm:h-9 cursor-pointer items-center justify-center rounded-[1rem] font-bold transition-all shadow-sm bg-[#FFF0F5] hover:bg-[#F7D6DE] hover:scale-[1.05]"
                                                    :class="checkedItems.some(data => data.id === {{ $item->id }}) ? 'opacity-50 ring-2 ring-offset-1 ring-[#D9758F] bg-[#F7D6DE]' : ''">
                                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" style="color: {{ $themeAccent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
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
                            <button @click="dropdownOpen = !dropdownOpen" :class="dropdownOpen ? 'bg-white text-[#D9758F] rounded-b-none shadow-md' : 'bg-white text-[#D9758F] rounded-b-full shadow-lg'" class="text-base flex flex-col items-center p-3 rounded-t-full duration-300 relative border border-[#F7D6DE] hover:bg-[#FFF0F5]">
                                <div class="absolute -top-1 -right-1 bg-[#D9758F] rounded-full w-5 h-5 text-xs font-bold text-white flex items-center justify-center shadow-sm" x-text="checkedItems.length"></div>
                                <div class="w-6 aspect-square">
                                    <svg data-name="Layer 1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.53 5 5 3H1.25a1 1 0 0 0 0 2h2.22L6.7 18H20v-2H8.26l-.33-1.34L21 12.17V5ZM19 10.52 7.45 12.71 6 7h13ZM7 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 7 19Zm12 0a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 19 19Z" fill="currentColor"></path>
                                    </svg>
                                </div>
                            </button>

                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
                                class="absolute top-full right-0 mt-0 w-72 rounded-2xl rounded-tr-none border border-[#F7D6DE] bg-white py-3 px-3 shadow-[0_15px_40px_rgba(217,117,143,0.15)]">
                                <div class="flex flex-col gap-2">
                                    <template x-for="item in checkedItems" :key="item.id">
                                        <div class="flex justify-between items-center gap-3 py-2 px-2.5 rounded-xl bg-[#FFF0F5] border border-[#F7D6DE]">
                                            <p class="font-semibold text-sm leading-snug flex-1" style="color: {{ $themeText }};" x-text="item.title"></p>
                                            <div class="flex flex-row items-center gap-2">
                                                <div class="flex items-center rounded-full border border-[#F7D6DE] bg-white overflow-hidden shadow-sm">
                                                    <button type="button" @click="decrementQuantity(item)" class="w-7 h-7 text-lg hover:bg-[#FFF0F5] text-[#D9758F] font-bold duration-200">-</button>
                                                    <input type="number" x-model="item.quantity" @input="normalizeQuantity(item)" @blur="normalizeQuantity(item)" max="999" min="1" class="w-10 text-center text-sm p-0 border-0 bg-transparent ring-0 focus:ring-0 focus:border-0 font-semibold text-[#4A3B32] [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                                                    <button type="button" @click="incrementQuantity(item)" class="w-7 h-7 text-lg hover:bg-[#FFF0F5] text-[#D9758F] font-bold duration-200">+</button>
                                                </div>
                                                <label :for="'order-' + item.id" class="text-red-400 hover:text-red-600 text-xl leading-none duration-300 cursor-pointer">&times;</label>
                                            </div>
                                        </div>
                                    </template>
                                    <div class="w-full flex justify-end mt-2">
                                        <button type="button" @click="openOrderModal()" class="py-2.5 px-4 flex items-center gap-2 text-sm font-bold rounded-xl text-white shadow-md duration-300 hover:opacity-90" style="background-color: {{ $themeWhatsapp }};">
                                            <div class="w-4 h-4">
                                                <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"></path></svg>
                                            </div>
                                            <p>Order WhatsApp</p>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="showOrderModal" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm px-4 py-6" style="display: none;">
                        <div class="flex min-h-full items-center justify-center">
                            <div @click.outside="closeOrderModal()" class="w-full max-w-md max-h-[calc(100vh-3rem)] overflow-hidden rounded-3xl bg-white shadow-2xl border border-[#F7D6DE]">
                                <div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-gray-100 bg-[#FFF0F5] px-5 py-5">
                                    <div>
                                        <p class="text-lg font-bold text-[#4A3B32]">Lengkapi data pemesan</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button type="button" @click="downloadQris()" x-show="qrisUrl" class="text-[#D9758F] duration-300 hover:text-[#B5556F]">
                                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 3V14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                <path d="M8 10L12 14L16 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5 17H19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                        <button type="button" @click="closeOrderModal()" class="text-2xl leading-none text-[#D9758F] hover:text-[#B5556F]">&times;</button>
                                    </div>
                                </div>
                                <div class="max-h-[calc(100vh-12rem)] overflow-y-auto px-5 py-4 space-y-4">
                                    <div x-show="requiresCustomerData" x-cloak>
                                        <label for="customer-name-donut" class="mb-1 block text-sm font-semibold text-[#4A3B32]">Nama Pemesan</label>
                                        <input id="customer-name-donut" type="text" x-model="customerName" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-[#D9758F] focus:ring-[#D9758F]" placeholder="Masukkan nama pemesan">
                                    </div>
                                    <div x-show="requiresCustomerData" x-cloak>
                                        <label for="customer-address-donut" class="mb-1 block text-sm font-semibold text-[#4A3B32]">Alamat</label>
                                        <textarea id="customer-address-donut" x-model="customerAddress" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-[#D9758F] focus:ring-[#D9758F]" placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>
                                    <div class="rounded-2xl border border-[#F7D6DE] bg-[#FFF0F5] px-4 py-3">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-sm font-semibold text-[#4A3B32]">Total Harga</p>
                                            <p class="text-lg font-bold text-[#D9758F]" x-text="'Rp' + formatCurrency(totalPrice)"></p>
                                        </div>
                                    </div>
                                    <div x-show="showQrisSection" x-cloak class="rounded-2xl border border-[#F7D6DE] bg-[#FFF0F5] px-4 py-4 mt-4">
                                        <div class="space-y-3">
                                            <div>
                                                <p class="text-sm font-semibold text-[#4A3B32]">Pembayaran QRIS</p>
                                            </div>
                                            <div x-show="qrisUrl" class="mx-auto w-full max-w-[220px] overflow-hidden rounded-2xl bg-white p-3 shadow-sm border border-[#F7D6DE]">
                                                <img :src="qrisUrl" alt="QRIS" class="w-full rounded-xl object-cover">
                                            </div>
                                            <div x-show="qrisUrl" class="flex justify-center">
                                                <button type="button" @click="openQrisPreview()" class="inline-flex items-center justify-center rounded-xl bg-[#D9758F] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#B5556F] shadow-md">
                                                    Lihat lebih besar
                                                </button>
                                            </div>
                                            <p x-show="!qrisUrl" class="text-center text-sm text-[#D9758F]">QRIS belum tersedia untuk usaha ini.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 bg-white px-5 py-4">
                                    <button type="button" @click="submitOrder()" :disabled="requiresCustomerData && (!customerName.trim() || !customerAddress.trim())" class="w-full rounded-xl px-4 py-3.5 text-sm font-bold text-white shadow-lg transition hover:opacity-90 disabled:cursor-not-allowed disabled:bg-gray-300 disabled:shadow-none" style="background-color: {{ $themeWhatsapp }};">
                                        Kirim pesanan ke WhatsApp
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="showQrisPreviewModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/80 px-4 py-6 backdrop-blur-sm" style="display: none;">
                        <div class="flex min-h-full items-center justify-center">
                            <div @click.outside="closeQrisPreview()" class="w-full max-w-sm rounded-3xl bg-white p-5 shadow-2xl">
                                <div class="mb-4 flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-lg font-bold text-gray-900">Preview QRIS</p>
                                    </div>
                                    <button type="button" @click="closeQrisPreview()" class="text-2xl leading-none text-gray-400 hover:text-red-500">&times;</button>
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

            @if ($data->embed)
            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative pt-10">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $themeAccent }}; opacity: 0.8;"></span>
                    <p class="text-xl sm:text-2xl font-black tracking-tight" style="color: {{ $themeText }};">Video <span style="color: {{ $themeAccent }};">Spesial</span></p>
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $themeAccent }}; opacity: 0.8;"></span>
                </div>
                
                <div class="relative rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(217,117,143,0.15)] group bg-white border border-[#F7D6DE] p-3 sm:p-4 hover:shadow-[0_25px_60px_rgba(217,117,143,0.2)] transition-all duration-500">
                    <!-- Floating decorative shapes -->
                    <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-[#FFF0F5] blur-2xl group-hover:bg-[#F7D6DE] transition-colors duration-500"></div>
                    <div class="absolute -bottom-10 -left-10 w-24 h-24 rounded-full bg-[#FFF0F5] blur-2xl group-hover:bg-[#F7D6DE] transition-colors duration-500"></div>
                    
                    <div class="relative w-full aspect-video rounded-[1.5rem] overflow-hidden bg-gray-50 z-10 border border-[#FFF0F5] shadow-inner">
                        <iframe class="w-full h-full object-cover pointer-events-auto" src="{{$data->embed}}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            @endif

            <div class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative pt-10 pb-4">
                <div class="rounded-[2.5rem] relative overflow-hidden bg-gradient-to-br from-[#FFFFFF] to-[#FFF0F5] border border-[#F7D6DE] group hover:shadow-[0_25px_60px_rgba(217,117,143,0.18)] transition-all duration-700 p-8 sm:p-10 shadow-[0_15px_40px_rgba(217,117,143,0.12)]">
                    
                    <!-- Decorative Patterns -->
                    <div class="absolute right-0 top-0 w-32 h-32 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-[#F7D6DE]/60 via-transparent to-transparent opacity-80 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="absolute left-0 bottom-0 w-32 h-32 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-[#D9758F]/20 via-transparent to-transparent opacity-80 group-hover:scale-110 transition-transform duration-700"></div>
                    
                    <!-- Floating elements -->
                    <div class="absolute top-[10%] right-[10%] w-3 h-3 rounded-full bg-[#D9758F]/40 animate-ping" style="animation-duration: 3s;"></div>
                    <div class="absolute bottom-[20%] left-[10%] w-4 h-4 rounded-full bg-[#F7D6DE] animate-bounce" style="animation-duration: 4s;"></div>
                    <div class="absolute top-[40%] left-[5%] w-2 h-2 rounded-full bg-[#D9758F]/60"></div>
                    
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <!-- Icon Badge -->
                        <div class="mb-6 relative">
                            <div class="absolute inset-0 bg-[#D9758F] rounded-full blur-md opacity-30 group-hover:opacity-50 transition-opacity duration-500"></div>
                            <div class="relative flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-[1.5rem] bg-white text-[#D9758F] shadow-lg rotate-3 group-hover:-rotate-3 group-hover:scale-110 transition-all duration-500 border border-[#F7D6DE]">
                                <svg class="h-8 w-8 sm:h-10 sm:w-10 animate-[pulse_2.5s_cubic-bezier(0.4,0,0.6,1)_infinite]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            </div>
                        </div>

                        <!-- Titles -->
                        <div class="space-y-2 mb-6">
                            <h3 class="text-[0.75rem] sm:text-xs font-black uppercase tracking-[0.3em]" style="color: {{ $themeAccent }};">Tentang Kami</h3>
                            <h2 class="text-2xl sm:text-[2.2rem] font-black leading-tight tracking-tight" style="color: {{ $themeText }};">{{ $data->name }}</h2>
                            <div class="w-12 h-1 mx-auto rounded-full bg-[#D9758F] mt-4 opacity-70"></div>
                        </div>

                        <!-- Description with quote marks -->
                        <div class="relative px-4 sm:px-6">
                            <span class="absolute -top-4 -left-2 text-4xl opacity-20 font-serif leading-none" style="color: {{ $themeAccent }};">"</span>
                            <p class="text-[0.9rem] sm:text-[1rem] leading-relaxed font-medium opacity-90 relative z-10" style="color: {{ $themeText }}; text-shadow: 0 1px 1px rgba(255,255,255,0.8);">
                                {!! nl2br(e($data->description == '' ? 'Description' : $data->description)) !!}
                            </p>
                            <span class="absolute -bottom-6 -right-2 text-4xl opacity-20 font-serif leading-none" style="color: {{ $themeAccent }};">"</span>
                        </div>
                    </div>
                </div>
            </div>

            <div
                x-data="{
                    showQrisSection: @js(($data->qris_status ?? 'active') === 'active'),
                    showQrisPreviewModal: false,
                    qrisUrl: @js($data->qris ? asset('storage/images/product/qris/' . $data->qris) : null),
                    openQrisPreview() {
                        if (!this.qrisUrl) {
                            return;
                        }

                        this.showQrisPreviewModal = true;
                    },
                    closeQrisPreview() {
                        this.showQrisPreviewModal = false;
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
                    }
                }"
                x-show="showQrisSection"
                x-cloak
                class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative pt-6 pb-4"
            >
                <div class="rounded-[2rem] border px-5 py-5 sm:px-6 shadow-[0_8px_20px_rgba(217,117,143,0.08)] bg-white" style="border-color: {{ $themeBorder }};">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex min-w-0 items-center gap-3">
                            <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full text-white shadow-sm" style="background-color: {{ $themeAccent }};">
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 7h16M7 4v6M17 4v6M5 11h4v4H5zm10 0h4v4h-4zM5 17h4v3H5zm10 0h4v3h-4z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <p class="text-lg sm:text-xl font-black leading-tight" style="color: {{ $themeText }};">Pembayaran QRIS</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" @click="openQrisPreview()" :disabled="!qrisUrl" class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-bold text-white transition hover:opacity-90 shadow-sm disabled:cursor-not-allowed disabled:bg-neutral-300 disabled:shadow-none" style="background-color: {{ $themeAccentDark }};">
                                Lihat
                            </button>
                            <button type="button" @click="downloadQris()" :disabled="!qrisUrl" class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-bold text-white transition hover:opacity-90 shadow-sm disabled:cursor-not-allowed disabled:bg-neutral-300 disabled:shadow-none" style="background-color: {{ $themeWhatsapp }};">
                                Download
                            </button>
                        </div>
                    </div>
                </div>

                <div x-show="showQrisPreviewModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/80 px-4 py-6 backdrop-blur-sm" style="display: none;">
                    <div class="flex min-h-full items-center justify-center">
                        <div @click.outside="closeQrisPreview()" class="w-full max-w-sm rounded-3xl bg-white p-5 shadow-2xl">
                            <div class="mb-4 flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-lg font-bold text-gray-900">Preview QRIS</p>
                                </div>
                                <button type="button" @click="closeQrisPreview()" class="text-2xl leading-none text-gray-400 hover:text-red-500">&times;</button>
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
    </div>

    <!-- Contact & Bottom Navigation wrapper (fixed bottom layer or trailing layer) -->
    <div class="fixed bottom-0 left-0 right-0 z-[60] bg-white border-t border-[#F7D6DE] shadow-[0_-10px_30px_rgba(217,117,143,0.1)] rounded-t-3xl pb-safe">
        <div class="w-full max-w-[600px] mx-auto">
            @include('components.guest.contact')
        </div>
    </div>
</div>

<x-guest.product.detail-modal />
