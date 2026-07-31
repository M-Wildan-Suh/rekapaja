@php
    $selectedDescType = old('desc_type', $template->desc_type ?? 'default');
@endphp
<div x-data="{article: false}" class="">
    <button @click="article = true" type="button" class=" absolute right-0 top-0 pl-3 pt-2 pr-2 pb-3 aspect-square bg-black/50 hover:bg-black duration-300 rounded-bl-[70%] z-10">
        <div class=" w-5 sm:w-6 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>

    <!-- Modal -->
    <div x-show="article" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40 px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Article -->
        <div x-data="{tab : 'section'}" @click.away="article = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-byolink-1">
            <div class=" pt-6 pb-3 bg-byolink-1 text-white z-30">
                <h2 class=" px-6 text-2xl font-bold">Edit Tentang Kami</h2>
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
            <div class="w-full px-4 sm:px-6">
                <div class=" space-y-4 sm:space-y-6 text-black">
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="">Type</label>
                            <div class="w-full grid grid-cols-3 gap-2">
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>Default</p>
                                    <input type="radio" name="desc_type" value="default" class="hidden peer" {{ $selectedDescType === 'default' ? 'checked' : '' }}>
                                    <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                                </label>
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>Ramen</p>
                                    <input type="radio" name="desc_type" value="ramen" class="hidden peer" {{ $selectedDescType === 'ramen' ? 'checked' : '' }}>
                                    <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                                </label>
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>network</p>
                                    <input type="radio" name="desc_type" value="network" class="hidden peer" {{ $selectedDescType === 'network' ? 'checked' : '' }}>
                                    <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                                </label>
                                <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center p-2 justify-center text-center">
                                    <p>Florist</p>
                                    <input type="radio" name="desc_type" value="florist" class="hidden peer" {{ $selectedDescType === 'florist' ? 'checked' : '' }}>
                                    <div class="absolute inset-0 peer-checked:bg-black/50 duration-300"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="desc_main_color">Background Color</label>
                            <div class=" w-full flex items-center justify-center overflow-hidden shadow-md shadow-black/20 rounded-md h-10">
                                <input type="color" name="desc_main_color" id="desc_main_color" class=" min-w-[105%] h-14 rounded-md cursor-pointer" value="{{ old('desc_main_color', $template->desc_main_color ?? '#ffffff') }}">
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="desc_text_color">Text Color</label>
                            <div class=" w-full flex items-center justify-center overflow-hidden shadow-md shadow-black/20 rounded-md h-10">
                                <input type="color" name="desc_text_color" id="desc_text_color" class=" min-w-[105%] h-14 rounded-md cursor-pointer" value="{{ old('desc_text_color', $template->desc_text_color ?? '#000000') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="article = false"
                        onclick="changedesc()"
                        type="button"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>
                    <script>
                        function changedesc() {
                            const desctype = document.querySelector('input[name="desc_type"]:checked');
                            const descmain = document.getElementById('desc_main_color');
                            const desctext = document.getElementById('desc_text_color');
                            const defaultPreview = document.getElementById('desc-default-preview');
                            const ramenPreview = document.getElementById('desc-ramen-preview');
                            const networkPreview = document.getElementById('desc-network-preview');
                            const floristPreview = document.getElementById('desc-florist-preview');


                            if (defaultPreview) {
                                defaultPreview.style.backgroundColor = descmain.value;
                                defaultPreview.style.color = desctext.value;
                            }

                            if (ramenPreview) {
                                ramenPreview.style.backgroundColor = descmain.value;
                                ramenPreview.style.color = desctext.value;
                            }
                            if (networkPreview) {
                                networkPreview.style.backgroundColor = descmain.value;
                                networkPreview.style.color = desctext.value;
                            }
                            if (floristPreview) {
                                floristPreview.style.backgroundColor = descmain.value;
                                floristPreview.style.color = desctext.value;
                            }

                            window.dispatchEvent(new CustomEvent('updateDescType', { detail: desctype.value }));
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
