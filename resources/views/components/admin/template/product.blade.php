@php
    $rawProductType = old('product_type', $template->product_type ?? 'grid2');
    $selectedProductType = match ($rawProductType) {
        'grid' => 'grid2',
        'ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako' => 'grid3',
        default => $rawProductType,
    };
    $selectedHeaderType = old('header', $template->head_type ?? 'one');
@endphp
<div @open-business-section.window="if ($event.detail === 'product') article = true" x-data="{article: false, editorTab: 'content', lockedHeader: @js($selectedHeaderType)}" x-init="window.addEventListener('updateHeaderType', (e) => lockedHeader = e.detail)" class="">
    @unless ($businessContentEditor ?? false)
    <button @click="article = true" type="button" class=" absolute right-0 top-0 pl-3 pt-2 pr-2 pb-3 aspect-square bg-black/50 hover:bg-black duration-300 rounded-bl-[70%] rounded-tr-md z-10">
        <div class=" w-5 sm:w-6 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>
    @endunless

    <!-- Modal -->
    <div x-cloak x-show="article" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Article -->
        <div x-data="{tab : 'section'}" @click.away="article = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative max-h-[90vh] overflow-hidden border-2 border-byolink-1">
            <div class="shrink-0 relative pt-6 pb-3 bg-byolink-1 text-white z-30">
                <h2 class=" px-6 text-2xl font-bold">Edit Product</h2>
                <button @click="article = false"
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
                <div x-show="editorTab === 'content'" class="px-4 sm:px-6 text-gray-900">
                    <x-admin.component.textinput title="Title Produk" placeholder="Contoh: Produk Kami"
                        :value="$product->product_title" name="product_title" form="bussiness" maxlength="255" required />
                    @error('product_title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
            <div @if ($businessContentEditor ?? false) x-show="editorTab === 'design'" @endif class="min-h-0 overflow-y-auto overscroll-contain w-full px-4 sm:px-6">
                <div class=" space-y-4 sm:space-y-6 text-black">
                    <div x-show="['skincare', 'pudding_putih'].includes(lockedHeader)" class="rounded-xl border border-pink-200 bg-pink-50 px-4 py-3 text-sm text-pink-700">
                        Warna produk dan tipe produk dikunci otomatis ke preset untuk template custom ini.
                    </div>
                    <div class="w-full">
                        <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="">Type</label>
                            <div class=" w-full grid grid-cols-3 gap-2">
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>Grid 2</p>
                                    <input type="radio" name="product_type" value="grid2" class="hidden peer" {{ $selectedProductType === 'grid2' ? 'checked' : '' }}>
                                    <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                                    </div>
                                </label>
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>List</p>
                                    <input type="radio" name="product_type" value="list" class="hidden peer" {{ $selectedProductType === 'list' ? 'checked' : '' }}>
                                    <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                                    </div>
                                </label>
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>Grid 3</p>
                                    <input type="radio" name="product_type" value="grid3" class="hidden peer" {{ $selectedProductType === 'grid3' ? 'checked' : '' }}>
                                    <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="product_main_color">Background Color</label>
                            <x-admin.component.colorinput name="product_main_color" :value="old('product_main_color', $template->product_main_color ?? '#000000')" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="product_second_color">Button Color</label>
                            <x-admin.component.colorinput name="product_second_color" :value="old('product_second_color', $template->product_second_color ?? '#8E1616')" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="product_text_color">Text Color</label>
                            <x-admin.component.colorinput name="product_text_color" :value="old('product_text_color', $template->product_text_color ?? '#ffffff')" />
                        </div>
                    </div>

                </div>
            </div>

            <div class="shrink-0 sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="article = false"
                        @if ($businessContentEditor ?? false) :form="editorTab === 'content' ? 'bussiness' : 'business-design'" @else onclick="changeproduct()" @endif
                        type="{{ ($businessContentEditor ?? false) ? 'submit' : 'button' }}"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>
                    <script>
                        function applyPastelProductPreset(buttonColor = '#F26CA7', textColor = '#4A2F3A') {
                            const productMain = document.getElementById('product_main_color');
                            const productSecond = document.getElementById('product_second_color');
                            const productText = document.getElementById('product_text_color');
                            const grid3Input = document.querySelector('input[name="product_type"][value="grid3"]');
                            const productCards = document.querySelectorAll('#product');
                            const productButtons = document.querySelectorAll('#probutton');

                            if (grid3Input) {
                                grid3Input.checked = true;
                            }

                            if (productMain) {
                                productMain.value = '#FFFFFF';
                            }

                            if (productSecond) {
                                productSecond.value = buttonColor;
                            }

                            if (productText) {
                                productText.value = textColor;
                            }

                            productCards.forEach((item) => {
                                item.style.backgroundColor = '#FFFFFF';
                                item.style.color = textColor;
                            });

                            productButtons.forEach((item) => {
                                item.style.backgroundColor = buttonColor;
                                item.style.color = '#FFFFFF';
                            });
                        }

                        window.addEventListener('updateHeaderType', (event) => {
                            const presets = {
                                skincare: { button: '#F26CA7', text: '#4A2F3A' },
                                pudding_putih: { button: '#F26CA7', text: '#5C3446' },
                            };

                            if (!presets[event.detail]) {
                                return;
                            }

                            applyPastelProductPreset(presets[event.detail].button, presets[event.detail].text);
                            window.dispatchEvent(new CustomEvent('updateProductType', { detail: 'grid3' }));
                        });

                        function changeproduct() {
                            const selectedHeader = document.querySelector('input[name="header"]:checked')?.value;
                            const presets = {
                                skincare: { button: '#F26CA7', text: '#4A2F3A' },
                                pudding_putih: { button: '#F26CA7', text: '#5C3446' },
                            };

                            if (presets[selectedHeader]) {
                                applyPastelProductPreset(presets[selectedHeader].button, presets[selectedHeader].text);
                            }

                            const producttype = document.querySelector('input[name="product_type"]:checked');
                            const productmain = document.getElementById('product_main_color');
                            const productsecond = document.getElementById('product_second_color');
                            const producttext = document.getElementById('product_text_color');
                            const product = document.querySelectorAll("#product")
                            const productbtn = document.querySelectorAll("#probutton")

                            product.forEach(element => {
                                element.style.color = producttext.value;
                                element.style.backgroundColor = productmain.value;
                            });
                            productbtn.forEach(element => {
                                element.style.backgroundColor = productsecond.value;
                            });

                            product.forEach(item => {
                            item.style.backgroundColor = productmain.value;
                            item.style.color = producttext.value;
                        });

                            productbtn.forEach(item => {
                            item.style.backgroundColor = productsecond.value;
                            item.style.color = "#fff";
                        });

                            if (typeof applyHeaderLinkedPreview === 'function' && selectedHeader) {
                                applyHeaderLinkedPreview(selectedHeader);
                            }

                            window.dispatchEvent(new CustomEvent('updateProductType', { detail: producttype.value }));
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
