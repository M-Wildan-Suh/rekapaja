<x-app-layout title="Admin - Edit Usaha">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Usaha') }}
        </h2>
    </x-slot>
    <!-- Tab Contents -->
    <div class="mt-4">


        {{-- <div class="sticky top-[76px] left-0 right-0 z-10 px-4">
            <div class="max-w-xl mx-auto pointer-events-none">
                <div
                    class="pointer-events-auto rounded-md border border-[#ff7100]/20 bg-white/95 px-4 py-3 shadow-sm backdrop-blur">
                    <div class="pr-10 sm:pr-0">
                        @if (in_array(Auth::user()->role, ['admin', 'superadmin', 'operator']))
                            <a href="{{ route('dashboard', ['return_page' => max((int) request('return_page', 1), 1)]) }}"
                                class="inline-flex items-center gap-2 text-sm sm:text-base font-semibold text-[#ff7100] hover:text-[#b95300] duration-300">
                                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Kembali ke daftar usaha</span>
                            </a>
                        @else
                            <div
                                class="inline-flex items-center gap-2 text-sm sm:text-base font-semibold text-[#ff7100]">
                                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="8" r="3" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M5 20a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                                @if (Auth::user()->role === 'premium')
                                    @if (Auth::user()->premium_type === 'lifetime')
                                        <span>Premium Aktif — Masa aktif: Lifetime</span>
                                    @elseif (Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired)))
                                        <span>Premium Aktif — Masa aktif hingga {{ Auth::user()->expired }}</span>
                                    @else
                                        <span>Premium Tidak Aktif — Berakhir {{ Auth::user()->expired }}</span>
                                    @endif
                                @else
                                    <span>Anda adalah User Gratis</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="py-4">
            <div class="w-full">
                @php
                    $qrisImageUrl =
                        old('remove_qris') === '1'
                            ? null
                            : ($product->qris
                                ? asset('storage/images/product/qris/' . $product->qris)
                                : null);
                @endphp
                <div x-data="{
                    activeTab: @js(in_array(old('active_tab', session('highlight')), ['highlight', 'feature']) ? old('active_tab', session('highlight')) : 'content'),
                    orderViaWhatsapp: '{{ old('order_via_whatsapp', $product->order_via_whatsapp ?? 'instan_rekap') }}'
                }" class="space-y-4">
                    <!-- Tabs -->
                    <div class=" sticky top-[76px] left-0 right-0 z-40 w-full max-w-xl mx-auto p-4 bg-white shadow-sm rounded-lg">
                        <div class=" grid grid-cols-3 gap-2 sm:gap-4 font-bold">
                            <button @click="activeTab = 'content'"
                                :class="activeTab === 'content' ? ' bg-[#ff7100] text-white' :
                                    'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                                class="px-3 py-2 rounded-md">
                                Konten
                            </button>
                            <button @click="activeTab = 'highlight'"
                                :class="activeTab === 'highlight' ? ' bg-[#ff7100] text-white' :
                                    'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                                class="px-3 py-2 rounded-md">
                                Produk/Jasa
                            </button>
                            <button @click="activeTab = 'feature'"
                                :class="activeTab === 'feature' ? ' bg-[#ff7100] text-white' :
                                    'text-neutral-600 border-transparent hover:border-black hover:text-black duration-300'"
                                class="px-3 py-2 rounded-md">
                                Fitur
                            </button>
                        </div>
                    </div>
                    <form id="bussiness" action="{{ route('product.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="active_tab" x-model="activeTab">
                    </form>
                    <div x-show="activeTab === 'feature'" class="max-w-xl mx-auto bg-white shadow-sm rounded-lg p-4 md:p-6 text-gray-900">
                        <div class="space-y-6">
                            @if (Auth::user()->role === 'admin' ||
                                    (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') ||
                                    (Auth::user()->role === 'premium' &&
                                        Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                                @if (Auth::user()->role === 'admin')
                                    <x-admin.component.radioinput title="Status" :value="[
                                        ['label' => 'Active', 'value' => 'active'],
                                        ['label' => 'Unactive', 'value' => 'unactive'],
                                    ]" :defaultvalue="$product->status"
                                        name="status" form="bussiness" />
                                @endif
                                <x-admin.component.radioinput title="Order via WhatsApp" :value="[
                                    ['label' => 'Instan Rekap', 'value' => 'instan_rekap'],
                                    ['label' => 'Tanya', 'value' => 'tanya'],
                                ]"
                                    :defaultvalue="$product->order_via_whatsapp ?? 'instan_rekap'" name="order_via_whatsapp" form="bussiness"
                                    xModel="orderViaWhatsapp" />
                                <x-admin.component.radioinput title="Customer Data" :value="[
                                    ['label' => 'Active', 'value' => 'active'],
                                    ['label' => 'Unactive', 'value' => 'unactive'],
                                ]"
                                    :defaultvalue="$product->customer_data ?? 'active'" name="customer_data" form="bussiness" />
                            @endif
                            @if (in_array(Auth::user()->role, ['admin', 'superadmin']))
                                <x-admin.component.accessinput title="Akun Pemilik"
                                    :value="$product->access->pluck('user_id')->take(1)->all()"
                                    :users="$accessUsers" name="access" form="bussiness" />
                            @endif
                            @if (Auth::user()->canAccessPremiumFeatures())
                                <div class="grid grid-cols-[minmax(0,1fr)_minmax(0,2fr)] items-start gap-4">
                                    <div class="overflow-hidden rounded-md border border-dashed border-gray-300">
                                        <x-admin.component.imageinput :value="$qrisImageUrl" name="qris" form="bussiness" />
                                    </div>
                                    <div class="min-w-0 space-y-3">
                                        <label for="qris-input" class="text-sm sm:text-base font-semibold">QRIS (Opsional)</label>
                                        <p class="text-xs sm:text-sm text-neutral-500">
                                            Jika gambar QRIS kosong atau dihapus, fitur QRIS otomatis nonaktif.
                                            Jika upload gambar baru, fitur otomatis aktif.
                                        </p>
                                        <input type="hidden" name="remove_qris" id="remove-qris-input" form="bussiness"
                                            value="{{ old('remove_qris', '0') }}">
                                        <button type="button" id="remove-qris-button"
                                            class="rounded-md border border-red-200 px-3 py-2 text-sm font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50">
                                            Hapus Gambar QRIS
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="">
                                <button @click="document.getElementById('bussiness').submit()"
                                    class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <div x-show="activeTab === 'content'" x-cloak>
                        @include('components.admin.template.business-editor', ['businessContentEditor' => true])
                    </div>
                    <div x-show="activeTab === 'highlight'" class="max-w-xl mx-auto bg-white shadow-sm rounded-lg p-4 md:p-6 text-gray-900 space-y-4">
                        @php
                            $viewerRole = Auth::user()->role;

                            if (
                                $viewerRole !== 'admin' &&
                                $viewerRole === 'premium' &&
                                (Auth::user()->premium_type === 'lifetime' ||
                                    Carbon\Carbon::now()->lessThanOrEqualTo(
                                        Carbon\Carbon::parse(Auth::user()->expired),
                                    ))
                            ) {
                                $viewerRole = 'premium';
                            } elseif ($viewerRole !== 'admin') {
                                $viewerRole = 'user';
                            }
                        @endphp
                        <div class=" space-y-6 mb-6">
                            <x-admin.component.textinput title="Tombol Order" placeholder="Contoh: Beli Sekarang"
                                :value="$product->order_title" name="order_title" form="highlight-form" maxlength="255" required />
                            <x-admin.component.textinput title="Teks Sebelum Harga (Optional)"
                                placeholder="Contoh: Mulai dari" :value="$product->price_prefix" name="price_prefix" form="highlight-form" maxlength="50" />
                        </div>
                        <div x-data="highlightManager({{ json_encode($product->productHighlight) }}, '{{ $viewerRole }}')" class=" space-y-4">
                            <div class=" space-y-2">
                                <p class=" text-sm sm:text-base font-semibold">Produk / Layanan
                                    {{ in_array($viewerRole, ['admin', 'premium']) ? 'Unlimited' : '( Max 3 )' }}
                                </p>
                                @if (Auth::user()->role === 'admin' ||
                                        (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') ||
                                        (Auth::user()->role === 'premium' &&
                                            Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                                    <button type="button" @click="multiple = true"
                                        class="font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">
                                        Tambah Produk Massal
                                    </button>
                                    <div x-show="multiple"
                                        class=" fixed inset-0 flex items-center justify-center bg-black/20 z-[60] px-4">
                                        <div
                                            class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-[#ff7100]">
                                            <button @click="multiple = false"
                                                class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                                                <svg viewBox="0 0 512 512" xml:space="preserve"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    enable-background="new 0 0 512 512">
                                                    <path
                                                        d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                                                        fill="currentColor" class="fill-000000"></path>
                                                </svg>
                                            </button>
                                            <div class=" pt-6 pb-3 bg-[#ff7100] text-white">
                                                <h2 class=" px-6 text-2xl font-bold">Tambah Berulang Menggunakan Gambar
                                                </h2>
                                            </div>
                                            <form @submit.prevent="submitMultipleDummyForm" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class=" w-full space-y-4">
                                                    <div class=" w-full px-6 py-4 flex items-center justify-center">
                                                        <input class=" w-full" type="file" name="image[]"
                                                            id="highlightimages-input" multiple accept="image/*"
                                                            x-ref="highlightInput">
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
                                    <button type="submit" form="highlight-form"
                                        class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role !== 'operator')
    <a href="{{ route('detail', ['slug' => $product->slug]) }}" target="_blank">
        <button
            class="fixed z-30 rounded-l-full w-10 h-10 bg-[#ff7100] hover:opacity-60 duration-300 p-2 right-0 top-20">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16 3a13 13 0 1 0 13 13A13 13 0 0 0 16 3Zm6.69 16.91A24.39 24.39 0 0 0 23 16a23.72 23.72 0 0 0-.32-3.91C25.37 13.08 27 14.58 27 16s-1.69 3-4.31 3.91ZM5 16c0-1.47 1.69-2.95 4.31-3.91A24.39 24.39 0 0 0 9 16a23.72 23.72 0 0 0 .32 3.91C6.63 18.92 5 17.42 5 16Zm6.5-10a14.2 14.2 0 0 0-1.68 3.82A14.19 14.19 0 0 0 6 11.49 11 11 0 0 1 11.5 6ZM6 20.5a14.63 14.63 0 0 0 4.32 1.8h.09A23.4 23.4 0 0 0 16 23c.6 0 1.19 0 1.76-.06a1 1 0 1 0-.14-2Q16.83 21 16 21a20.92 20.92 0 0 1-4.52-.47A21.33 21.33 0 0 1 11 16c0-6.48 2.64-11 5-11 1 0 2 .76 2.89 2.14a1 1 0 0 0 .84.47 1 1 0 0 0 .54-.15 1 1 0 0 0 .31-1.38.86.86 0 0 0-.07-.1A11 11 0 0 1 26 11.5a14.94 14.94 0 0 0-4.48-1.84A23.21 23.21 0 0 0 16 9c-.6 0-1.19 0-1.76.06a1 1 0 1 0 .14 2Q15.18 11 16 11a20.92 20.92 0 0 1 4.52.47A21.33 21.33 0 0 1 21 16c0 6.48-2.64 11-5 11-1 0-2-.76-2.89-2.14a1 1 0 1 0-1.69 1.06.86.86 0 0 0 .07.1A11 11 0 0 1 6 20.5ZM20.5 26a14.2 14.2 0 0 0 1.68-3.85A14.19 14.19 0 0 0 26 20.51 11 11 0 0 1 20.5 26Z"
                    data-name="world www web website" fill="#ffffff" class="fill-000000"></path>
            </svg>
        </button>
    </a>
    @endif
</x-app-layout>
@if (Auth::user()->canAccessPremiumFeatures())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const qrisInput = document.getElementById('qris-input');
            const qrisPreview = document.getElementById('qris-preview');
            const removeQrisInput = document.getElementById('remove-qris-input');
            const removeQrisButton = document.getElementById('remove-qris-button');
            const placeholderImage = @js(asset('assets/images/placeholder.jpg'));
            const initialQrisImage = @js($qrisImageUrl);

            if (!qrisInput || !qrisPreview || !removeQrisInput || !removeQrisButton) {
                return;
            }

            const syncRemoveButtonState = () => {
                const hasInitialImage = Boolean(initialQrisImage) && removeQrisInput.value !== '1';
                const hasNewImage = qrisInput.files && qrisInput.files.length > 0;

                removeQrisButton.disabled = !hasInitialImage && !hasNewImage;
            };

            if (removeQrisInput.value === '1') {
                qrisPreview.src = placeholderImage;
            }

            qrisInput.addEventListener('change', () => {
                if (qrisInput.files && qrisInput.files.length > 0) {
                    removeQrisInput.value = '0';
                }

                syncRemoveButtonState();
            });

            removeQrisButton.addEventListener('click', () => {
                removeQrisInput.value = '1';
                qrisInput.value = '';
                qrisPreview.src = placeholderImage;
                syncRemoveButtonState();
            });

            syncRemoveButtonState();
        });
    </script>
@endif
