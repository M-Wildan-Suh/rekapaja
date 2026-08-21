@php
    $selectedHeader = old('header', $template->head_type ?? 'one');
@endphp
<div x-data="{header: false}" class="">
    <button @click="header = true" type="button" class=" absolute right-0 top-0 pl-3 pt-2 pr-2 pb-3 aspect-square bg-black/50 hover:bg-black duration-300 rounded-bl-[70%] z-10">
        <div class=" w-5 sm:w-6 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>

    <!-- Modal -->
    <div x-show="header" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Header -->
        <div @click.away="header = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-byolink-1">
            <div class=" pt-6 pb-3 bg-byolink-1 text-white z-30">
                <h2 class=" px-6 text-2xl font-bold">Edit Header</h2>
                <button @click="header = false"
                    type="button"
                    class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                    <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                        enable-background="new 0 0 512 512">
                        <path
                            d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                            fill="currentColor" class="fill-000000"></path>
                    </svg>
                </button>
            </div>
            <div class="w-full px-4 sm:px-6 h-[309px] sm:h-[292px] overflow-auto">
                <div class=" w-full grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <label class="w-full rounded-md bg-white aspect-[2/1] overflow-hidden relative">
                        <input type="radio" name="header" value="one" class="hidden peer" {{ $selectedHeader === 'one' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/one.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[2/1] overflow-hidden relative">
                        <input type="radio" name="header" value="two" class="hidden peer" {{ $selectedHeader === 'two' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/two.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[2/1] overflow-hidden relative">
                        <input type="radio" name="header" value="three" class="hidden peer" {{ $selectedHeader === 'three' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/three.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[2/1] overflow-hidden relative">
                        <input type="radio" name="header" value="four" class="hidden peer" {{ $selectedHeader === 'four' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/four.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md aspect-[2/1] overflow-hidden relative border border-dashed border-neutral-300 bg-gradient-to-br from-[#F7EFE5] to-[#F3D6C7]">
                        <input type="radio" name="header" value="ramen" class="hidden peer" {{ $selectedHeader === 'ramen' ? 'checked' : '' }}>
                        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                            <p class="text-lg font-black text-[#8F110E]">Ramen</p>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-700">Custom Header</p>
                        </div>
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[2/1] overflow-hidden relative">
                        <input type="radio" name="header" value="network" class="hidden peer" {{ $selectedHeader === 'network' ? 'checked' : '' }}>
                        <img src="{{asset('assets/images/template/header/network.png')}}" class="w-full h-full object-cover object-center" alt="">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    </label>
                    <label class="w-full rounded-md aspect-[2/1] overflow-hidden relative border border-dashed border-neutral-300 bg-gradient-to-br from-[#FFF7F2] via-[#FFE8EE] to-[#FFD6E1]">
                        <input type="radio" name="header" value="donut" class="hidden peer" {{ $selectedHeader === 'donut' ? 'checked' : '' }}>
                        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                            <p class="text-lg font-black text-[#E66B98]">Donut</p>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7A4A34]">Custom Header</p>
                        </div>
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    </label>
                    <label class="w-full rounded-md aspect-[2/1] overflow-hidden relative border border-dashed border-neutral-300 bg-gradient-to-br from-[#FFF7FB] via-[#FDECF7] to-[#FBE6EC]">
                        <input type="radio" name="header" value="skincare" class="hidden peer" {{ $selectedHeader === 'skincare' ? 'checked' : '' }}>
                        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                            <p class="text-lg font-black text-[#EF6AA5]">Skincare</p>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7A4A5A]">Custom Header</p>
                        </div>
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    </label>
                    <label class="w-full rounded-md aspect-[2/1] overflow-hidden relative border border-dashed border-neutral-300 bg-gradient-to-br from-[#FFF8F4] via-[#FDEEF8] to-[#F8EAFE]">
                        <input type="radio" name="header" value="pudding_putih" class="hidden peer" {{ $selectedHeader === 'pudding_putih' ? 'checked' : '' }}>
                        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                            <p class="text-lg font-black text-[#F0679A]">Pudding Putih</p>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7B4B5F]">Custom Header</p>
                        </div>
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    </label>
                    <label class="w-full rounded-md aspect-[2/1] overflow-hidden relative border border-dashed border-neutral-300 bg-gradient-to-br from-[#FFF8E9] via-[#F7F4DE] to-[#EAF4DE]">
                        <input type="radio" name="header" value="sembako" class="hidden peer" {{ $selectedHeader === 'sembako' ? 'checked' : '' }}>
                        <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center">
                            <p class="text-lg font-black text-[#2F9E44]">Sembako</p>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7B5B1C]">Custom Header</p>
                        </div>
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    </label>
                </div>
            </div>

            <div class=" sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="header = false"
                        onclick="changeheader()"
                        type="button"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>
                    <script>
                        function applyHeaderLinkedPreview(headerType) {
                            const hiddenHeaders = ['ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'];
                            const colorfulPalettes = {
                                skincare: [
                                    { surface: '#FFFFFF', border: '#F3D2E1', accent: '#F26CA7', text: '#5C3446' },
                                    { surface: '#FFFFFF', border: '#E3D4FF', accent: '#A875E8', text: '#4C3768' },
                                    { surface: '#FFFFFF', border: '#FFD8BC', accent: '#FF9A62', text: '#694533' },
                                ],
                                pudding_putih: [
                                    { surface: '#FFFFFF', border: '#F6D3E1', accent: '#F45B97', text: '#623549' },
                                    { surface: '#FFFFFF', border: '#FFE0B8', accent: '#FF9F1C', text: '#7A4D1E' },
                                    { surface: '#FFFFFF', border: '#D9E9BE', accent: '#8BBF59', text: '#4F6A33' },
                                ],
                            };

                            const shouldHideDescription = hiddenHeaders.includes(headerType);
                            const descPreviewSection = document.getElementById('desc-preview-section');
                            if (descPreviewSection) {
                                descPreviewSection.classList.toggle('hidden', shouldHideDescription);
                                descPreviewSection.style.display = shouldHideDescription ? 'none' : '';
                            }

                            [
                                document.getElementById('desc-default-preview'),
                                document.getElementById('desc-ramen-preview'),
                                document.getElementById('desc-network-preview'),
                            ].forEach((element, index) => {
                                if (!element) {
                                    return;
                                }

                                if (shouldHideDescription) {
                                    element.style.display = 'none';
                                    return;
                                }

                                element.style.display = index === 0 ? '' : 'none';
                            });

                            window.dispatchEvent(new CustomEvent('updateDescType', { detail: 'default' }));

                            const grid3Preview = document.getElementById('grid3-product-preview');
                            const cards = grid3Preview?.querySelector('.grid.grid-cols-3.gap-2')?.children ?? [];

                            Array.from(cards).forEach((card, index) => {
                                const productSurface = card.querySelector('#product');
                                const title = productSurface?.querySelector('p:nth-of-type(1)');
                                const text = productSurface?.querySelector('p:nth-of-type(2)');
                                const price = productSurface?.querySelector('p:nth-of-type(3)');
                                const button = productSurface?.querySelector('#probutton');
                                const productMain = document.getElementById('product_main_color')?.value ?? '{{ $template->product_main_color ?? '#FFFFFF' }}';
                                const productSecond = document.getElementById('product_second_color')?.value ?? '{{ $template->product_second_color ?? '#8E1616' }}';
                                const productText = document.getElementById('product_text_color')?.value ?? '{{ $template->product_text_color ?? '#111827' }}';
                                const accentColor = document.getElementById('accent_color')?.value ?? '{{ old('accent_color', $template->accent_color ?? '#EC4899') }}';

                                if (colorfulPalettes[headerType]) {
                                    const palette = colorfulPalettes[headerType][index] ?? colorfulPalettes[headerType][0];
                                    card.style.borderColor = palette.border;

                                    if (productSurface) {
                                        productSurface.style.backgroundColor = palette.surface;
                                        productSurface.style.color = palette.text;
                                    }

                                    if (title) title.style.color = palette.accent;
                                    if (text) text.style.color = palette.text;
                                    if (price) price.style.color = palette.accent;
                                    if (button) {
                                        button.style.backgroundColor = palette.accent;
                                        button.style.color = '#FFFFFF';
                                    }

                                    return;
                                }

                                card.style.borderColor = '#E5E7EB';
                                if (productSurface) {
                                    productSurface.style.backgroundColor = productMain;
                                    productSurface.style.color = productText;
                                }
                                if (title) title.style.color = accentColor;
                                if (text) text.style.color = productText;
                                if (price) price.style.color = productText;
                                if (button) {
                                    button.style.backgroundColor = productSecond;
                                    button.style.color = '#FFFFFF';
                                }
                            });
                        }

                        function changeheader() {
                            const headerInput = document.querySelector('input[name="header"]:checked');
                            const headerShow = document.getElementById("header");
                            const headerRamenPreview = document.getElementById("header-ramen-preview");
                            const headerDonutPreview = document.getElementById("header-donut-preview");
                            const headerSkincarePreview = document.getElementById("header-skincare-preview");
                            const headerPuddingPreview = document.getElementById("header-pudding-preview");
                            const headerSembakoPreview = document.getElementById("header-sembako-preview");


                            if (headerInput.value === 'ramen') {
                                headerShow.src = `/assets/images/template/header/one.jpg`;
                                headerShow.classList.add('opacity-0');
                                headerRamenPreview?.classList.remove('hidden');
                                headerDonutPreview?.classList.add('hidden');
                                headerSkincarePreview?.classList.add('hidden');
                                headerPuddingPreview?.classList.add('hidden');
                                headerSembakoPreview?.classList.add('hidden');
                                applyHeaderLinkedPreview(headerInput.value);
                                window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: headerInput.value }));
                                return;
                            }

                            if (headerInput.value === 'donut') {
                                headerShow.src = `/assets/images/template/header/one.jpg`;
                                headerShow.classList.add('opacity-0');
                                headerRamenPreview?.classList.add('hidden');
                                headerDonutPreview?.classList.remove('hidden');
                                headerSkincarePreview?.classList.add('hidden');
                                headerPuddingPreview?.classList.add('hidden');
                                headerSembakoPreview?.classList.add('hidden');
                                applyHeaderLinkedPreview(headerInput.value);
                                window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: headerInput.value }));
                                return;
                            }

                            if (headerInput.value === 'skincare') {
                                headerShow.src = `/assets/images/template/header/one.jpg`;
                                headerShow.classList.add('opacity-0');
                                headerRamenPreview?.classList.add('hidden');
                                headerDonutPreview?.classList.add('hidden');
                                headerSkincarePreview?.classList.remove('hidden');
                                headerPuddingPreview?.classList.add('hidden');
                                headerSembakoPreview?.classList.add('hidden');
                                applyHeaderLinkedPreview(headerInput.value);
                                window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: headerInput.value }));
                                return;
                            }

                            if (headerInput.value === 'pudding_putih') {
                                headerShow.src = `/assets/images/template/header/one.jpg`;
                                headerShow.classList.add('opacity-0');
                                headerRamenPreview?.classList.add('hidden');
                                headerDonutPreview?.classList.add('hidden');
                                headerSkincarePreview?.classList.add('hidden');
                                headerPuddingPreview?.classList.remove('hidden');
                                headerSembakoPreview?.classList.add('hidden');
                                applyHeaderLinkedPreview(headerInput.value);
                                window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: headerInput.value }));
                                return;
                            }

                            if (headerInput.value === 'sembako') {
                                headerShow.src = `/assets/images/template/header/one.jpg`;
                                headerShow.classList.add('opacity-0');
                                headerRamenPreview?.classList.add('hidden');
                                headerDonutPreview?.classList.add('hidden');
                                headerSkincarePreview?.classList.add('hidden');
                                headerPuddingPreview?.classList.add('hidden');
                                headerSembakoPreview?.classList.remove('hidden');
                                applyHeaderLinkedPreview(headerInput.value);
                                window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: headerInput.value }));
                                return;
                            }

                            headerShow.src = headerInput.value === 'network'
                                ? `/assets/images/template/header/network.png`
                                : `/assets/images/template/header/${headerInput.value}.jpg`;
                            headerShow.classList.remove('opacity-0');
                            headerRamenPreview?.classList.add('hidden');
                            headerDonutPreview?.classList.add('hidden');
                            headerSkincarePreview?.classList.add('hidden');
                            headerPuddingPreview?.classList.add('hidden');
                            headerSembakoPreview?.classList.add('hidden');

                            applyHeaderLinkedPreview(headerInput.value);
                            window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: headerInput.value}));
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            applyHeaderLinkedPreview(@js($selectedHeader));
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
