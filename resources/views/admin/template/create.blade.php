<x-app-layout title="Admin - Tambah Template">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Template') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4">
        <div class="w-full max-w-xl mx-auto bg-neutral-100 rounded-md shadow-md shadow-black/20 relative overflow-hidden">
            <div id="background" class=" absolute inset-0 flex items-center justify-center">
                <img style="display: none" id="bg_image-now" src="" class=" w-full h-full object-cover object-center" alt="">
            </div>
            <form action="{{ route('template.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="relative border-b border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 sm:px-6">
                        {{ $errors->first() }}
                    </div>
                @endif
                @include('components.admin.template.background')
                <div class=" bg-white p-4 sm:p-6 relative">
                    <x-admin.component.textinput title="Nama Template" placeholder="Masukkan Nama Template..." :value="''" name="name" />
                </div>
                <div class=" p-4 sm:p-6 space-y-4 sm:space-y-6 relative">
                    <div class=" w-full">
                        <div class="w-full flex items-center justify-center">
                            <div class=" w-[400px] aspect-[2/1] max-h-full max-w-full rounded-md overflow-hidden shadow-md shadow-black/20 relative">
                                @include('components.admin.template.header')
                                <div class=" w-full relative">
                                    <img id="header" src="{{asset('assets/images/template/header/one.jpg')}}" class=" w-full duration-300" alt="">
                                    <div id="header-ramen-preview" class="hidden absolute inset-0 bg-gradient-to-br from-[#F7EFE5] to-[#E7B79A] text-[#8F110E]">
                                        <div class="flex h-full items-center justify-center">
                                            <div class="space-y-1 text-center">
                                                <p id="header-ramen-title-preview" style="color: {{ old('accent_color', '#A72018') }}" class="text-3xl font-black">Ramen</p>
                                                <p id="header-ramen-subtitle-preview" class="text-sm font-semibold uppercase tracking-[0.24em] text-neutral-700">Custom Header</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="header-florist-preview" class="hidden absolute inset-0 overflow-hidden bg-gradient-to-br from-[#FFF5F8] via-[#FBCFE8] to-[#F9A8D4] text-[#6A1B4D]">
                                        <div class="absolute left-[6%] top-[10%] h-[80%] w-[42%] rounded-full border-2 border-white/70"></div>
                                        <div class="absolute right-[6%] top-[16%] h-[68%] w-[36%] rounded-full border border-white/50"></div>
                                        <div class="absolute inset-0 opacity-[0.08] bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/placeholder.webp') }}');"></div>
                                        <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-8">
                                            <div class="max-w-[46%] space-y-2">
                                                <p class="text-[1.45rem] font-black leading-tight" style="font-family: 'Segoe Script', 'Brush Script MT', cursive;">Nama Usaha</p>
                                                <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#9D174D]">Subtitle usaha florist</p>
                                                <div class="flex flex-wrap gap-1.5">
                                                    <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-semibold text-[#9D174D] shadow-sm">Buket</span>
                                                    <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-semibold text-[#9D174D] shadow-sm">Fresh Flower</span>
                                                    <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-semibold text-[#9D174D] shadow-sm">Wisuda</span>
                                                </div>
                                            </div>
                                            <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-full border-4 border-white shadow-xl shadow-pink-300/30">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="header-donut-preview" class="hidden absolute inset-0 overflow-hidden bg-gradient-to-br from-[#FFF8F4] via-[#FFECEF] to-[#FFDCE8] text-[#4A2F22]">
                                        <div class="absolute left-[6%] top-[12%] h-12 w-12 rounded-full bg-[#F7B4C9]/35 blur-xl"></div>
                                        <div class="absolute right-[14%] top-[10%] h-16 w-16 rounded-full bg-[#FFD8A8]/30 blur-2xl"></div>
                                        <div class="absolute bottom-[10%] left-[10%] h-20 w-20 rounded-full border border-white/60"></div>
                                        <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-7">
                                            <div class="max-w-[46%] space-y-2">
                                                <p class="text-[1.35rem] font-black leading-tight text-[#E66B98]" style="font-family: 'Patrick Hand', cursive;">Donat Lezat,</p>
                                                <p class="text-[1.8rem] font-black leading-[0.95]">Setiap Gigitan</p>
                                                <p class="text-[1.8rem] font-black leading-[0.95] text-[#E66B98]">Penuh Kenangan</p>
                                            </div>
                                            <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-[2rem] bg-white/70 shadow-xl shadow-pink-200/40">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="header-skincare-preview" class="hidden absolute inset-0 overflow-hidden bg-gradient-to-br from-[#FFF7FB] via-[#FDECF7] to-[#FBE6EC] text-[#4A2F3A]">
                                        <div class="absolute left-[6%] top-[14%] h-10 w-10 rounded-full bg-[#F7B4C9]/35 blur-xl"></div>
                                        <div class="absolute right-[10%] top-[12%] h-14 w-14 rounded-full bg-[#FBD3E2]/35 blur-2xl"></div>
                                        <div class="absolute bottom-[12%] left-[10%] h-20 w-20 rounded-full border border-white/70"></div>
                                        <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-7">
                                            <div class="max-w-[48%] space-y-2">
                                                <p class="text-[0.85rem] font-semibold italic text-[#D66AA3]" style="font-family: 'Patrick Hand', cursive;">Cantik Alami Setiap Hari</p>
                                                <p class="text-[1.55rem] font-black leading-tight">Skincare Terbaik</p>
                                                <p class="text-[1.55rem] font-black leading-tight text-[#EF6AA5]">untuk Kulitmu</p>
                                            </div>
                                            <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-[2rem] bg-white/70 shadow-xl shadow-pink-200/40">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="header-pudding-preview" class="hidden absolute inset-0 overflow-hidden bg-gradient-to-br from-[#FFF8F4] via-[#FDEEF8] to-[#F8EAFE] text-[#5C3446]">
                                        <div class="absolute left-[6%] top-[14%] h-10 w-10 rounded-full bg-[#F9BCD4]/35 blur-xl"></div>
                                        <div class="absolute right-[10%] top-[12%] h-14 w-14 rounded-full bg-[#E7D5FF]/35 blur-2xl"></div>
                                        <div class="absolute bottom-[12%] left-[10%] h-20 w-20 rounded-full border border-white/70"></div>
                                        <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-7">
                                            <div class="max-w-[50%] space-y-2">
                                                <p class="text-[0.95rem] font-semibold italic text-[#8B5E3C]" style="font-family: 'Patrick Hand', cursive;">Manisnya Pas, Lembutnya Juara!</p>
                                                <p class="text-[1.55rem] font-black leading-none text-[#F0679A]" style="font-family: 'Patrick Hand', cursive;">Puding Putih</p>
                                                <p class="text-[1.4rem] font-black leading-none text-[#9B6AE4]" style="font-family: 'Patrick Hand', cursive;">Aneka Rasa</p>
                                            </div>
                                            <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-[2rem] bg-white/75 shadow-xl shadow-pink-200/40">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="header-sembako-preview" class="hidden absolute inset-0 overflow-hidden bg-gradient-to-br from-[#FFF8E9] via-[#F7F4DE] to-[#EAF4DE] text-[#24411F]">
                                        <div class="absolute left-[4%] top-[14%] h-14 w-14 rounded-full bg-[#FDE68A]/40 blur-xl"></div>
                                        <div class="absolute right-[8%] top-[12%] h-16 w-16 rounded-full bg-[#D9F99D]/35 blur-2xl"></div>
                                        <div class="relative flex h-full items-center justify-between gap-4 px-5 sm:px-7">
                                            <div class="max-w-[50%] space-y-2">
                                                <p class="text-[1.45rem] font-bold leading-none text-[#2F9E44]" style="font-family: 'Patrick Hand', cursive;">Sembako Lengkap,</p>
                                                <p class="text-[1.45rem] font-bold leading-none text-[#D97706]" style="font-family: 'Patrick Hand', cursive;">Harga Bersahabat!</p>
                                                <p class="inline-flex rounded-full bg-[#FACC15]/90 px-3 py-1 text-[0.72rem] font-bold text-[#365314]">Belanja harian dari rumah</p>
                                            </div>
                                            <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-[2rem] bg-white/80 shadow-xl shadow-lime-200/40">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" w-full">
                        <div class="w-full flex items-center justify-center">
                            <div class=" w-[400px] rounded-md overflow-hidden relative">
                                @include('components.admin.template.gallery')
                                <div class=" w-full">
                                    <img id="gallery" src="{{asset('assets/images/template/gallery/square.png')}}" class=" w-full" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" w-full">
                        <div class=" w-full flex items-center justify-center">
                            <div x-data="{desctype: 'default'}"
                                x-init="window.addEventListener('updateDescType', (e) => desctype = e.detail)"
                                class="max-w-[400px] w-full relative">
                                @include('components.admin.template.article')
                                <div x-show="desctype === 'default'" id="desc-default-preview" style="background-color: {{$background ?? 'white'}}" class="w-full rounded-md shadow-md p-4 space-y-2 overflow-hidden relative">
                                    <p class="w-full font-bold tracking-wide text-lg">Tentang Kami</p>
            
                                    @include('components.guest.termandcondition')

                                    <div class=" text-sm rounded-md">
                                        <p class="">Tahu bulat adalah camilan khas Indonesia yang terbuat dari tahu berbentuk bulat, digoreng hingga renyah di luar dan lembut di dalam. Dijual keliling dengan panggilan khas, camilan ini sering disajikan dengan bumbu tabur seperti balado atau keju. Harganya terjangkau, menjadikannya favorit banyak orang.</p>
                                    </div>
                                </div>
                                <div x-show="desctype === 'ramen'" id="desc-ramen-preview" class="w-full rounded-[1.8rem] px-5 py-6 sm:px-6 shadow-lg overflow-hidden relative" style="background-color: #B12719; color: #FFF7F0;">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-14 w-14 flex-none items-center justify-center rounded-full bg-white/10">
                                                <div class="w-8 h-8">
                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 13.5a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/><path d="M5 20a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M19 7.5h.01M5 7.5h.01" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-xl font-black leading-tight">Nama Usaha</p>
                                                <p class="mt-1 text-sm font-medium uppercase tracking-[0.18em] opacity-70">Tentang Usaha</p>
                                            </div>
                                        </div>
                                        <p class="text-sm leading-7 opacity-85">Deskripsi usaha akan tampil dengan layout highlight seperti template ramen.</p>
                                    </div>
                                </div>
                                <div
                                    x-show="desctype === 'florist'"
                                    id="desc-florist-preview"
                                    class="rounded-md px-5 py-6 sm:px-6 shadow-lg shadow-pink-200/40 relative overflow-hidden"
                                    style="background-color: #EC4899; color: #FFFFFF;"
                                >
                                    <div class="absolute inset-0 opacity-20">
                                        <div class="absolute -top-10 right-0 h-28 w-28 rounded-full bg-white/40 blur-2xl"></div>
                                        <div class="absolute bottom-0 left-0 h-24 w-24 rounded-full bg-white/20 blur-2xl"></div>
                                    </div>
                                    <div class="relative space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/15">
                                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 21c4.418 0 8-2.91 8-6.5 0-2.377-1.57-4.456-3.91-5.593A4.5 4.5 0 1 0 7.91 8.907C5.57 10.044 4 12.123 4 14.5 4 18.09 7.582 21 12 21Z" stroke="currentColor" stroke-width="1.5"/>
                                                    <path d="M12 7.5c.828 0 1.5-.672 1.5-1.5S12.828 4.5 12 4.5 10.5 5.172 10.5 6 11.172 7.5 12 7.5Z" fill="currentColor"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-lg font-black leading-tight">Tentang Florist</p>
                                                <p class="text-sm opacity-80">Preview deskripsi usaha dengan nuansa lembut dan elegan.</p>
                                            </div>
                                        </div>
                                        <p class="text-sm leading-7 opacity-90">Cocok untuk usaha bunga, buket wisuda, papan ucapan, dan dekorasi spesial dengan tampilan yang manis dan premium.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" w-full">
                        <div class=" w-full flex items-center justify-center">
                            <div
                                x-data="{producttype: 'grid2'}"
                                x-init="
                                    window.addEventListener('updateProductType', (e) => producttype = e.detail);
                                    window.addEventListener('updateHeaderType', (e) => {
                                        if (['skincare', 'pudding_putih', 'sembako'].includes(e.detail)) producttype = 'grid3';
                                    });
                                "
                                class=" max-w-[400px] w-full rounded-md relative">
                                @include('components.admin.template.product')
                                <div x-show="producttype === 'grid2'" class=" w-full grid grid-cols-2 gap-2 sm:gap-3">
                                    <div class=" w-full rounded-md overflow-hidden">
                                        <div class=" w-full aspect-square bg-white">
                                            <img src="{{asset('assets/images/placeholder.webp')}}" class=" w-full h-full object-cover" alt="">
                                        </div>
                                        <div id="product" style="background-color: black; color: white;" class=" px-2 py-1 flex flex-col items-center justify-center text-center gap-1">
                                            <p class=" text-sm">Tahu Bulat</p>
                                            <button id="probutton" style="background-color: #8E1616" type="button" class=" text-xs px-2 py-1 border-2 rounded-md">Order</button>
                                        </div>
                                    </div>
                                    <div class=" w-full rounded-md overflow-hidden">
                                        <div class=" w-full aspect-square bg-white">
                                            <img src="{{asset('assets/images/placeholder.webp')}}" class=" w-full h-full object-cover" alt="">
                                        </div>
                                        <div id="product" style="background-color: black; color: white;" class=" px-2 py-1 flex flex-col items-center justify-center text-center gap-1">
                                            <p class=" text-sm">Sotong</p>
                                            <button id="probutton" style="background-color: #8E1616" type="button" class=" text-xs px-2 py-1 border-2 rounded-md">Order</button>
                                        </div>
                                    </div>
                                    <div class=" w-full rounded-md overflow-hidden">
                                        <div class=" w-full aspect-square bg-white">
                                            <img src="{{asset('assets/images/placeholder.webp')}}" class=" w-full h-full object-cover" alt="">
                                        </div>
                                        <div id="product" style="background-color: black; color: white;" class=" px-2 py-1 flex flex-col items-center justify-center text-center gap-1">
                                            <p class=" text-sm">Tempe</p>
                                            <button id="probutton" style="background-color: #8E1616" type="button" class=" text-xs px-2 py-1 border-2 rounded-md">Order</button>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="producttype === 'list'" class=" w-full space-y-3">
                                    <div id="product" style="background-color: black; color: white;" class="w-full p-3 rounded-xl flex gap-2 relative">
                                        <div class=" min-w-20 h-20 aspect-square rounded-full overflow-hidden bg-white">
                                            <img src="{{asset('assets/images/placeholder.webp')}}" class=" w-full h-full object-cover" alt="">
                                        </div>
                                        <div class="w-full flex flex-col gap-1.5">
                                            <p class="line-clamp-1 font-semibold">Tahu Bulat</p>
                                            <p class="line-clamp-2 text-sm">Murah nikmat, pilihan segala kalangan</p>
                                            <div class=" absolute flex justify-end right-2 -translate-y-3/4 top-full">
                                                <div class=" flex rounded-md bg-black">
                                                    <label 
                                                        style="background-color: #8E1616"
                                                        class="duration-300 rounded-md py-1 px-3 text-sm cursor-pointer border-2 border-white">
                                                        Order
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="product" style="background-color: black; color: white;" class="w-full p-3 rounded-xl flex gap-2 relative">
                                        <div class=" min-w-20 h-20 aspect-square rounded-full overflow-hidden bg-white">
                                            <img src="{{asset('assets/images/placeholder.webp')}}" class=" w-full h-full object-cover" alt="">
                                        </div>
                                        <div class="w-full flex flex-col gap-1.5">
                                            <p class="line-clamp-1 font-semibold">Sotong</p>
                                            <p class="line-clamp-2 text-sm">Variasi yang membuat anda menjadi tidak bosan</p>
                                            <div class=" absolute flex justify-end right-2 -translate-y-3/4 top-full">
                                                <div class=" flex rounded-md bg-black">
                                                    <label 
                                                        style="background-color: #8E1616"
                                                        class="duration-300 rounded-md py-1 px-3 text-sm cursor-pointer border-2 border-white">
                                                        Order
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="product" style="background-color: black; color: white;" class="w-full p-3 rounded-xl flex gap-2 relative">
                                        <div class=" min-w-20 h-20 aspect-square rounded-full overflow-hidden bg-white">
                                            <img src="{{asset('assets/images/placeholder.webp')}}" class=" w-full h-full object-cover" alt="">
                                        </div>
                                        <div class="w-full flex flex-col gap-1.5">
                                            <p class="line-clamp-1 font-semibold">Tempe</p>
                                            <p class="line-clamp-2 text-sm">Sehat bergizi</p>
                                            <div class=" absolute flex justify-end right-2 -translate-y-3/4 top-full">
                                                <div class=" flex rounded-md bg-black">
                                                    <label 
                                                        style="background-color: #8E1616"
                                                        class="duration-300 rounded-md py-1 px-3 text-sm cursor-pointer border-2 border-white">
                                                        Order
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="producttype === 'grid3'" class="w-full space-y-4">
                                    <div class="flex items-center justify-center gap-3 text-center">
                                        <span class="h-px w-8 bg-[#EC4899]"></span>
                                        <p class="text-lg sm:text-xl font-black text-[#6A1B4D]">Produk Grid 3</p>
                                        <span class="h-px w-8 bg-[#EC4899]"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="overflow-hidden rounded-xl border border-[#E5E7EB] bg-white shadow-[0_8px_18px_rgba(15,23,42,0.10)]">
                                            <div class="aspect-[4/3] bg-[#F8FAFC]">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                            <div id="product" style="background-color: #FFFFFF; color: #111827;" class="space-y-1.5 p-2.5">
                                                <p class="text-left text-[11px] font-bold leading-[1.25] min-h-[2rem]" style="color: {{ old('accent_color', '#EC4899') }};">Switch 8 Port</p>
                                                <p class="text-left text-[10px] leading-[1.45] min-h-[2.6rem] text-[#111827]">Transfer data cepat dan stabil untuk kebutuhan jaringan Anda.</p>
                                                <p class="text-left text-[11px] font-extrabold text-[#2563EB]">Rp 275.000</p>
                                                <div class="grid grid-cols-1 gap-1.5">
                                                    <button id="probutton" type="button" style="background-color: #16A34A" class="inline-flex w-full items-center justify-center gap-1.5 rounded-md px-2 py-1.5 text-[10px] font-semibold text-white"><span class="text-[11px]">◔</span>Beli</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="overflow-hidden rounded-xl border border-[#E5E7EB] bg-white shadow-[0_8px_18px_rgba(15,23,42,0.10)]">
                                            <div class="aspect-[4/3] bg-[#F8FAFC]">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                            <div id="product" style="background-color: #FFFFFF; color: #111827;" class="space-y-1.5 p-2.5">
                                                <p class="text-left text-[11px] font-bold leading-[1.25] min-h-[2rem]" style="color: {{ old('accent_color', '#EC4899') }};">Adapter WiFi</p>
                                                <p class="text-left text-[10px] leading-[1.45] min-h-[2.6rem] text-[#111827]">Menerima sinyal WiFi lebih kuat, praktis dan mudah digunakan.</p>
                                                <p class="text-left text-[11px] font-extrabold text-[#2563EB]">Rp 125.000</p>
                                                <div class="grid grid-cols-1 gap-1.5">
                                                    <button id="probutton" type="button" style="background-color: #16A34A" class="inline-flex w-full items-center justify-center gap-1.5 rounded-md px-2 py-1.5 text-[10px] font-semibold text-white"><span class="text-[11px]">◔</span>Beli</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="overflow-hidden rounded-xl border border-[#E5E7EB] bg-white shadow-[0_8px_18px_rgba(15,23,42,0.10)]">
                                            <div class="aspect-[4/3] bg-[#F8FAFC]">
                                                <img src="{{ asset('assets/images/placeholder.webp') }}" class="h-full w-full object-cover" alt="">
                                            </div>
                                            <div id="product" style="background-color: #FFFFFF; color: #111827;" class="space-y-1.5 p-2.5">
                                                <p class="text-left text-[11px] font-bold leading-[1.25] min-h-[2rem]" style="color: {{ old('accent_color', '#EC4899') }};">Connector RJ45</p>
                                                <p class="text-left text-[10px] leading-[1.45] min-h-[2.6rem] text-[#111827]">Konektor berkualitas untuk hasil crimping yang rapi dan optimal.</p>
                                                <p class="text-left text-[11px] font-extrabold text-[#2563EB]">Rp 350 / pcs</p>
                                                <div class="grid grid-cols-1 gap-1.5">
                                                    <button id="probutton" type="button" style="background-color: #16A34A" class="inline-flex w-full items-center justify-center gap-1.5 rounded-md px-2 py-1.5 text-[10px] font-semibold text-white"><span class="text-[11px]">◔</span>Beli</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" w-full">
                        <div class="w-full flex items-center justify-center">
                            <div class=" w-[400px] aspect-video max-h-full max-w-full rounded-md overflow-hidden shadow-md shadow-black/20 relative">
                                <img src="{{asset('assets/images/ytplaceholder.jpg')}}" class=" w-full h-full object-cover" alt="">
                                <div class=" absolute inset-0 flex items-center justify-center bg-black/10">
                                    <div class=" w-10">
                                        <svg viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><g data-name="Layer 2"><path d="M15 2.5A12.5 12.5 0 1 0 27.5 15 12.514 12.514 0 0 0 15 2.5Zm4.968 14.14-5.647 3.942a2 2 0 0 1-3.144-1.64v-7.883a2 2 0 0 1 3.144-1.641l5.647 3.941a2 2 0 0 1 0 3.28Z" fill="none"></path><path d="M15 0a15 15 0 1 0 15 15A15.016 15.016 0 0 0 15 0Zm0 27.5A12.5 12.5 0 1 1 27.5 15 12.514 12.514 0 0 1 15 27.5Z" fill="#ffffff" class="fill-000000"></path><path d="M19.968 13.36 14.32 9.417a2 2 0 0 0-3.144 1.64v7.883a2 2 0 0 0 3.144 1.641l5.647-3.941v-.001a2 2 0 0 0 0-3.28Z" fill="#ffffff" class="fill-000000"></path></g></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" w-full">
                        <div class="w-full flex items-center justify-center">
                            <div class=" w-full max-w-[400px] relative">
                                @include('components.admin.template.contact')
                                <div class=" w-full grid grid-cols-3 gap-2 text-sm">
                                    <button id="wa" class=" w-full flex items-center justify-center gap-0.5 bg-black py-2 text-white rounded-md">
                                        <div class=" w-4 aspect-square">
                                            <svg viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"><path d="m21.146 8.576-7.55-6.135a2.543 2.543 0 0 0-3.192 0L2.855 8.575a1.119 1.119 0 0 0-.416.873v11.543c0 .62.505 1.13 1.125 1.13h5.062c.62 0 1.125-.51 1.125-1.13v-7.306h4.499v7.306c0 .62.505 1.13 1.125 1.13h5.062c.62 0 1.125-.51 1.125-1.13V9.448a1.122 1.122 0 0 0-.416-.872zm-.71 12.421h-5.062V13.68c0-.62-.505-1.119-1.125-1.119H9.75c-.62 0-1.125.499-1.125 1.119v7.317H3.564V9.448l7.55-6.134a1.411 1.411 0 0 1 1.773 0l7.55 6.134v11.549z" fill="currentColor" class="fill-000000"></path></svg>
                                        </div>
                                    </button>
                                    <button id="phone" class=" w-full flex items-center justify-center gap-0.5 bg-[#8E1616] py-2 text-white rounded-md">
                                        <div class=" w-4 aspect-square">
                                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g data-name="1"><path d="M348.73 450.06a198.63 198.63 0 0 1-46.4-5.85c-52.43-12.65-106.42-44.74-152-90.36s-77.71-99.62-90.36-152c-13.32-55.1-3.82-102.24 26.72-132.78l8.72-8.72a42.2 42.2 0 0 1 59.62 0l50.11 50.1a42.18 42.18 0 0 1 0 59.62l-29.6 29.59c14.19 24.9 33.49 49.82 56.3 72.63s47.75 42.12 72.64 56.31l29.59-29.6a42.15 42.15 0 0 1 59.62 0l50.1 50.1a42.16 42.16 0 0 1 0 59.61l-8.73 8.72c-21.53 21.57-51.33 32.63-86.33 32.63ZM125.22 78a12 12 0 0 0-8.59 3.56l-8.73 8.72c-22.87 22.87-29.55 60-18.81 104.49 11.37 47.13 40.64 96.1 82.41 137.86s90.73 71 137.87 82.41c44.5 10.74 81.61 4.06 104.48-18.81l8.72-8.72a12.16 12.16 0 0 0 0-17.19l-50.09-50.1a12.16 12.16 0 0 0-17.19 0l-37.51 37.51a15 15 0 0 1-17.5 2.72c-30.75-15.9-61.75-39.05-89.65-66.95s-51-58.88-66.94-89.63a15 15 0 0 1 2.71-17.5l37.52-37.51a12.16 12.16 0 0 0 0-17.19l-50.1-50.11a12.07 12.07 0 0 0-8.6-3.56Z" fill="currentColor" class="fill-000000"></path><path d="M364.75 269.73a15 15 0 0 1-15-15 99.37 99.37 0 0 0-99.25-99.26 15 15 0 0 1 0-30c71.27 0 129.25 58 129.25 129.26a15 15 0 0 1-15 15Z" fill="currentColor" class="fill-000000"></path><path d="M428.15 269.73a15 15 0 0 1-15-15c0-89.69-73-162.66-162.65-162.66a15 15 0 0 1 0-30c106.23 0 192.65 86.43 192.65 192.66a15 15 0 0 1-15 15Z" fill="currentColor" class="fill-000000"></path></g></svg>
                                        </div>
                                    </button>
                                    <button id="wa" class=" w-full flex items-center justify-center gap-0.5 bg-black py-2 text-white rounded-md">
                                        <div class=" w-4 aspect-square">
                                            <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" bg-white p-4 sm:p-6 relative">
                    <x-admin.component.submitbutton title="Tambah" />
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
