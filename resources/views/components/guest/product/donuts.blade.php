@php
    $donutBg = $template->bg_main_color ?? '#FFFAFB';
    $donutTextDark = $template->desc_main_color ?? '#2D2D2D';
    $donutAccent = $template->accent_color ?? '#E57384';
    $donutAccentLight = $template->product_second_color ?? '#FFF0F3';
    $donutBorder = $template->product_second_color ?? '#FFE4E8';
@endphp

{{-- Products Section --}}
<section class="px-6 py-20 md:px-12 lg:px-16 max-w-7xl mx-auto relative space-y-16">
    <!-- Ambient subtle glow -->
    <div class="absolute top-[20%] left-[-10%] w-[400px] h-[400px] rounded-full mix-blend-multiply filter blur-[100px] opacity-20 pointer-events-none" style="background-color: {{ $donutAccentLight }};"></div>
    <div class="absolute bottom-[10%] right-[-5%] w-[300px] h-[300px] rounded-full mix-blend-multiply filter blur-[80px] opacity-10 pointer-events-none" style="background-color: {{ $donutAccent }};"></div>

    <div class="flex flex-col items-center justify-center gap-4 text-center mb-16 relative z-10">
        <p class="text-xs font-black uppercase tracking-[0.4em] opacity-70" style="color: {{ $donutAccent }};">Discover Excellence</p>
        <h2 class="text-5xl md:text-6xl font-black tracking-tighter" style="color: {{ $donutTextDark }};">Our Collection</h2>
        <div class="w-24 h-1 rounded-full mt-4" style="background: linear-gradient(90deg, transparent, {{ $donutAccent }}, transparent);"></div>
    </div>

    <div x-data="{
        checkedItems: [],
        showOrderModal: false,
        customerName: '',
        customerAddress: '',
        isPremiumBusiness: @js(in_array($role ?? '', ['admin', 'premium'])),
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
            if (!this.checkedItems.length) return;
            if (!this.shouldShowOrderModal) {
                this.$nextTick(() => this.$refs.orderForm.submit());
                return;
            }
            this.showOrderModal = true;
        },
        closeOrderModal() {
            this.showOrderModal = false;
        },
        get totalPrice() {
            return this.checkedItems.reduce((total, item) => {
                return total + ((parseInt(item.price || 0)) * (parseInt(item.quantity || 1)));
            }, 0);
        }
    }" class="w-full relative z-10">
        <form id="myForm" action="{{ route('order', ['no_tlp' => $no_tlp ?? '']) }}" method="post" enctype="multipart/form-data" target="_blank" x-ref="orderForm">
            @csrf
            <input type="hidden" name="customer_name" :value="customerName">
            <input type="hidden" name="customer_address" :value="customerAddress">
            <input type="hidden" name="product_id" value="{{ $data->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                @foreach ($data->productHighlight as $item)
                    <div class="group relative rounded-[2.5rem] overflow-hidden bg-white/70 backdrop-blur-xl border border-white/60 transition-all duration-700 hover:-translate-y-4 hover:shadow-2xl flex flex-col" style="box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);">
                        <div class="relative w-full aspect-[4/5] overflow-hidden bg-gray-100">
                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent z-10 opacity-70 group-hover:opacity-90 transition-opacity duration-700 mix-blend-overlay"></div>
                            
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 group-hover:rotate-1">
                            
                            @php
                                $badges = ['POPULAR' => 'bg-white/90 text-gray-900', 'NEW' => 'bg-gray-900/90 text-white', 'LIMITED' => 'bg-['. $donutAccent .']/90 text-white'];
                                $badgeKey = array_rand($badges);
                                $badgeClass = $badges[$badgeKey];
                            @endphp
                            <div class="absolute top-6 left-6 z-20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-lg backdrop-blur-md {{ $badgeClass }}">
                                {{ $badgeKey }}
                            </div>
                            
                            @if (!$item->available)
                                <div class="absolute inset-0 z-30 bg-white/40 backdrop-blur-md flex items-center justify-center">
                                    <span class="bg-white px-6 py-3 rounded-full text-xs font-black uppercase tracking-[0.3em] text-gray-900 shadow-2xl">Sold Out</span>
                                </div>
                            @endif

                            <!-- Content Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 z-20 flex flex-col justify-end transform transition-all duration-500">
                                <h3 class="font-bold text-2xl leading-tight text-white mb-2 transform group-hover:-translate-y-2 transition-transform duration-500">{{ $item->title }}</h3>
                                <p class="text-white/90 font-medium text-lg transform group-hover:-translate-y-2 transition-transform duration-500 delay-75" style="color: {{ $donutAccentLight }};">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="p-6 md:p-8 flex-1 flex flex-col relative z-10">
                            <p class="text-sm text-gray-500 line-clamp-3 mb-8 font-light leading-relaxed flex-1 opacity-90 group-hover:opacity-100 transition-opacity">{{ $item->description ?? 'Sebuah mahakarya yang diracik khusus untuk memberikan pengalaman tak terlupakan bagi Anda.' }}</p>
                            
                            <div class="flex items-center gap-4 mt-auto w-full">
                                <x-guest.product.detail-button
                                    :item="$item"
                                    class="flex-1 py-4 text-xs uppercase tracking-[0.2em] rounded-2xl font-bold text-center transition-all duration-300 bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md"
                                >
                                    Lihat Detail
                                </x-guest.product.detail-button>
                                
                                @if ($item->available)
                                    <label class="cursor-pointer">
                                        <input
                                            type="checkbox"
                                            class="peer sr-only"
                                            value="{{ json_encode(['id' => $item->id, 'title' => $item->title, 'price' => $item->price, 'quantity' => 1]) }}"
                                            x-model="checkedItems"
                                        >
                                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 border border-gray-200 shadow-sm peer-checked:shadow-inner hover:scale-105 peer-checked:scale-95"
                                            style="background-color: white;"
                                            :class="checkedItems.find(i => {try{ return JSON.parse(i).id === {{ $item->id }} } catch(e){return false}}) ? '!bg-['+ '{{ $donutAccent }}' +'] !text-white !border-transparent shadow-[0_10px_20px_-10px_{{ $donutAccent }}]' : 'hover:bg-gray-50 hover:border-gray-300'"
                                        >
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
</section>

{{-- Bottom Banner --}}
<section class="px-6 md:px-12 lg:px-16 max-w-5xl mx-auto my-16">
    <div class="rounded-[3rem] p-10 md:p-14 flex flex-col md:flex-row items-center gap-10 relative overflow-hidden border border-white/60 shadow-2xl backdrop-blur-md" style="background-color: {{ $donutAccentLight }}80; box-shadow: 0 25px 50px -12px {{ $donutAccentLight }}50;">
        <div class="absolute inset-0 bg-white/40 mix-blend-overlay"></div>
        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-l from-white/40 to-transparent pointer-events-none"></div>

        <div class="w-20 h-20 md:w-28 md:h-28 flex-shrink-0 relative z-10 p-4 bg-white/60 rounded-3xl shadow-lg border border-white/80 backdrop-blur transform -rotate-3 hover:rotate-0 transition-transform duration-500">
            <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="{{ $donutAccent }}" stroke-width="2"/>
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="{{ $donutAccent }}" stroke-width="2"/>
                <path d="M7.5 7.5L8.5 8.5M16.5 7.5L15.5 8.5M7.5 16.5L8.5 15.5M16.5 16.5L15.5 15.5" stroke="{{ $donutAccent }}" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="text-center md:text-left z-10 flex-1">
            <h3 class="text-2xl md:text-3xl font-black mb-3 leading-tight" style="color: {{ $donutTextDark }};">
                Pilihan Terbaik dari<br><span style="color: {{ $donutAccent }};">{{ $data->name ?? 'Kami' }}</span> untuk Anda.
            </h3>
            <p class="text-base md:text-lg text-gray-700 font-light max-w-xl">
                Temukan layanan dan produk berkualitas dengan sentuhan elegan untuk memenuhi segala kebutuhan spesial Anda.
            </p>
        </div>
        <div class="hidden md:block absolute right-[-5%] top-[-30%] opacity-10 transform rotate-[15deg] scale-150 pointer-events-none">
                <svg width="300" height="300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="{{ $donutAccent }}" stroke-width="2"/>
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="{{ $donutAccent }}" stroke-width="2"/>
            </svg>
        </div>
    </div>
</section>
