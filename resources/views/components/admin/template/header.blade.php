@php
    $selectedHeader = old('header', $template->head_type ?? 'one');
@endphp
<div @open-business-section.window="if ($event.detail === 'header') header = true" x-data="{header: @js(($businessContentEditor ?? false) && $errors->any() && old('active_tab') !== 'design'), editorTab: 'content'}" class="">
    @unless ($businessContentEditor ?? false)
    <button @click="header = true" type="button" class=" absolute right-0 top-0 pl-3 pt-2 pr-2 pb-3 aspect-square bg-black/50 hover:bg-black duration-300 rounded-bl-[70%] z-10">
        <div class=" w-5 sm:w-6 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>
    @endunless

    <!-- Modal -->
    <div x-cloak x-show="header" @keydown.escape.window="header = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Header -->
        <div @click.away="header = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative max-h-[90vh] overflow-hidden border-2 border-byolink-1">
            <div class="shrink-0 relative pt-6 pb-3 bg-byolink-1 text-white z-30">
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
            @if ($businessContentEditor ?? false)
                <div class="grid grid-cols-2 gap-2 px-4 sm:px-6" role="tablist">
                    <button type="button" @click="editorTab = 'content'" :aria-selected="editorTab === 'content'" :class="editorTab === 'content' ? 'bg-[#ff7100] text-white' : 'bg-gray-100 text-gray-700'" class="rounded-md px-4 py-2 font-semibold" role="tab">Konten</button>
                    <button type="button" @click="editorTab = 'design'" :aria-selected="editorTab === 'design'" :class="editorTab === 'design' ? 'bg-[#ff7100] text-white' : 'bg-gray-100 text-gray-700'" class="rounded-md px-4 py-2 font-semibold" role="tab">Desain</button>
                </div>
                <div x-show="editorTab === 'content'" class="min-h-0 overflow-y-auto px-4 sm:px-6 text-gray-900">
                    @include('admin.product.component.business-content')
                </div>
            @endif
            <div @if ($businessContentEditor ?? false) x-show="editorTab === 'design'" @endif class="min-h-0 overflow-y-auto overscroll-contain w-full px-4 sm:px-6 h-[309px] sm:h-[292px]">
                <div class=" w-full grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative">
                        <input type="radio" name="header" value="one" class="hidden peer" {{ $selectedHeader === 'one' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/one.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative">
                        <input type="radio" name="header" value="two" class="hidden peer" {{ $selectedHeader === 'two' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/two.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative">
                        <input type="radio" name="header" value="three" class="hidden peer" {{ $selectedHeader === 'three' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/three.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative">
                        <input type="radio" name="header" value="four" class="hidden peer" {{ $selectedHeader === 'four' ? 'checked' : '' }}>
                        <img src="{{asset('/assets/images/template/header/four.jpg')}}" class=" w-full h-full object-cover object-center" alt="">
                        <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                        </div>
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative cursor-pointer">
                        <input type="radio" name="header" value="ramen" class="hidden peer" {{ $selectedHeader === 'ramen' ? 'checked' : '' }}>
                        <img src="{{ asset('assets/images/template/header/Template-Ramen.webp') }}" class="w-full h-full object-cover object-center" alt="ramen">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    @include('components.admin.template.header-status', ['lockedColors' => false])
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative cursor-pointer">
                        <input type="radio" name="header" value="network" class="hidden peer" {{ $selectedHeader === 'network' ? 'checked' : '' }}>
                        <img src="{{ asset('assets/images/template/header/Template-Network.webp') }}" class="w-full h-full object-cover object-center" alt="network">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    @include('components.admin.template.header-status', ['lockedColors' => false])
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative cursor-pointer">
                        <input type="radio" name="header" value="donut" class="hidden peer" {{ $selectedHeader === 'donut' ? 'checked' : '' }}>
                        <img src="{{ asset('assets/images/template/header/Template-Donat.webp') }}" class="w-full h-full object-cover object-center" alt="donut">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    @include('components.admin.template.header-status', ['lockedColors' => false])
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative cursor-pointer">
                        <input type="radio" name="header" value="skincare" class="hidden peer" {{ $selectedHeader === 'skincare' ? 'checked' : '' }}>
                        <img src="{{ asset('assets/images/template/header/Template-Skincare.webp') }}" class="w-full h-full object-cover object-center" alt="skincare">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    @include('components.admin.template.header-status', ['lockedColors' => true])
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative cursor-pointer">
                        <input type="radio" name="header" value="pudding_putih" class="hidden peer" {{ $selectedHeader === 'pudding_putih' ? 'checked' : '' }}>
                        <img src="{{ asset('assets/images/template/header/Template-Puding.webp') }}" class="w-full h-full object-cover object-center" alt="pudding_putih">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    @include('components.admin.template.header-status', ['lockedColors' => true])
                    </label>
                    <label class="w-full rounded-md bg-white aspect-[4/3] overflow-hidden relative cursor-pointer">
                        <input type="radio" name="header" value="sembako" class="hidden peer" {{ $selectedHeader === 'sembako' ? 'checked' : '' }}>
                        <img src="{{ asset('assets/images/template/header/Template-Sembako.webp') }}" class="w-full h-full object-cover object-center" alt="sembako">
                        <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                    @include('components.admin.template.header-status', ['lockedColors' => false])
                    </label>
                </div>
            </div>

            <div @if ($businessContentEditor ?? false) x-show="editorTab === 'design'" @endif class="shrink-0 sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="header = false"
                        @unless ($businessContentEditor ?? false) onclick="changeheader()" @endunless
                        type="{{ ($businessContentEditor ?? false) ? 'submit' : 'button' }}"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>
                    <script>
                        function applyHeaderLinkedPreview(headerType) {
                            const hiddenHeaders = ['one', 'two', 'three', 'four', 'ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'];
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
                            const cards = grid3Preview?.querySelector('.grid.gap-2')?.children ?? [];

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
                            const selectedImage = headerInput?.closest('label')?.querySelector('img');
                            if (!headerShow || !selectedImage) return;
                            headerShow.src = selectedImage.src;
                            headerShow.alt = `Preview header ${headerInput.value}`;
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
