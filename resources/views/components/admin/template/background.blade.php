<div x-data="{background: false}" class="">
    <button @click="background = true" type="button" class=" absolute left-0 top-0 pl-2 pt-2 pr-3 pb-3 aspect-square bg-black/50 hover:bg-black duration-300 rounded-br-[70%] z-10">
        <div class=" w-5 sm:w-6 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>

    <!-- Modal -->
    <div x-show="background" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Background -->
        <div @click.away="background = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-byolink-1">
            <div class=" pt-6 pb-3 bg-byolink-1 text-white z-30">
                <h2 class=" px-6 text-2xl font-bold">Edit Background</h2>
                <button @click="background = false"
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
            <div x-data="{ bgType: '{{ old('bg_type', $template->bg_type ?? 'normal') }}' }" class="space-y-4">
                <input type="hidden" name="bg_type" id="bg_type" x-model="bgType">

                <div class="w-full px-4 sm:px-6">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1.85fr_1fr] lg:items-start">
                        <div class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-sm sm:text-base font-semibold text-black">Tipe Banner</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <label class="relative flex items-center justify-center rounded-xl border border-neutral-300 bg-white px-3 py-3 text-center text-sm font-medium text-neutral-700 duration-300 hover:border-byolink-1 hover:text-byolink-1">
                                        <input type="radio" name="bg_type_selector" value="normal" class="hidden peer" x-model="bgType">
                                        <span>Normal</span>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-byolink-1 peer-checked:bg-byolink-1/5"></div>
                                    </label>
                                    <label class="relative flex items-center justify-center rounded-xl border border-neutral-300 bg-white px-3 py-3 text-center text-sm font-medium text-neutral-700 duration-300 hover:border-byolink-1 hover:text-byolink-1">
                                        <input type="radio" name="bg_type_selector" value="gradient" class="hidden peer" x-model="bgType">
                                        <span>Gradient</span>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-byolink-1 peer-checked:bg-byolink-1/5"></div>
                                    </label>
                                    <label class="relative flex items-center justify-center rounded-xl border border-neutral-300 bg-white px-3 py-3 text-center text-sm font-medium text-neutral-700 duration-300 hover:border-byolink-1 hover:text-byolink-1">
                                        <input type="radio" name="bg_type_selector" value="image" class="hidden peer" x-model="bgType">
                                        <span>Image</span>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-byolink-1 peer-checked:bg-byolink-1/5"></div>
                                    </label>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="accent_color" class="text-sm sm:text-base font-semibold text-black">Warna Accent</label>
                                <div class="w-full">
                                    <div class="flex items-center justify-center overflow-hidden rounded-md shadow-md shadow-black/20 h-10">
                                        <input type="color" name="accent_color" id="accent_color" class="min-w-[105%] h-14 rounded-md cursor-pointer" value="{{ old('accent_color', $template->accent_color ?? '#A72018') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="min-h-[260px]">
                            <div x-show="bgType === 'normal'" class="space-y-2">
                                <div class="w-full flex items-center justify-center overflow-hidden shadow-md shadow-black/20 rounded-md h-[260px]">
                                    <input type="color" name="bg_normal_color" id="bg_normal_color" class="min-w-[120%] h-96 rounded-md cursor-pointer" value="{{ old('bg_normal_color', $template->bg_main_color ?? '#F5F5F5') }}">
                                </div>
                            </div>

                            <div x-show="bgType === 'gradient'" class="flex h-[260px] flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="w-full flex items-center justify-center overflow-hidden shadow-md shadow-black/20 rounded-md h-[124px]">
                                        <input type="color" name="bg_main_color" id="bg_main_color" class="min-w-[120%] h-80 rounded-md cursor-pointer" value="{{ old('bg_main_color', $template->bg_main_color ?? '#F5F5F5') }}">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="w-full flex items-center justify-center overflow-hidden shadow-md shadow-black/20 rounded-md h-[124px]">
                                        <input type="color" name="bg_second_color" id="bg_second_color" class="min-w-[120%] h-80 rounded-md cursor-pointer" value="{{ old('bg_second_color', $template->bg_second_color ?? '#F5F5F5') }}">
                                    </div>
                                </div>
                            </div>

                            <div x-show="bgType === 'image'" class="space-y-2">
                                <div class="flex h-[260px] items-center justify-center">
                                    <div class="h-[260px] aspect-[3/4] max-w-full overflow-hidden rounded-md shadow-md shadow-black/20">
                                        <x-admin.component.imageinput value="{{ isset($template) && $template->bg_image ? asset('storage/images/template/background/'.$template->bg_image) : '' }}" name="bg_image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class=" sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="background = false"
                        onclick="changebg()"
                        type="button"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>

                    <script>
                        function applyAccentPreview(color) {
                            const headerRamenTitle = document.getElementById("header-ramen-title-preview");
                            const headerRamenPreview = document.getElementById("header-ramen-preview");
                            const ramenAccentTexts = document.querySelectorAll(".ramen-accent-text");
                            const ramenAccentBorders = document.querySelectorAll(".ramen-accent-border");

                            if (headerRamenTitle) {
                                headerRamenTitle.style.color = color;
                            }

                            if (headerRamenPreview) {
                                headerRamenPreview.style.background = `linear-gradient(135deg, #F7EFE5 0%, ${color}22 100%)`;
                            }

                            ramenAccentTexts.forEach((element) => {
                                element.style.color = color;
                            });

                            ramenAccentBorders.forEach((element) => {
                                element.style.borderColor = color;
                            });

                        }

                        function changebg() {
                            const bgType = document.getElementById("bg_type");
                            const bgImageNow = document.getElementById("bg_image-now");
                            const background = document.getElementById("background");
                            if (bgType.value === "normal") {
                                const mainColor = document.getElementById("bg_normal_color");
                                bgImageNow.style.display = "none";
                                background.style.backgroundColor = mainColor.value;
                                background.style.background = mainColor.value;
                            } else if (bgType.value === "gradient") {
                                const bgFrom = document.getElementById("bg_main_color");
                                const bgTo = document.getElementById("bg_second_color");
                                bgImageNow.style.display = "none";
                                background.style.background = `linear-gradient(to bottom, ${bgFrom.value}, ${bgTo.value})`;
                            } else if (bgType.value === "image") {
                                const bgImage = document.getElementById("bg_image-preview");
                                bgImageNow.style.display = "block";
                                bgImageNow.src = bgImage.src;
                            }

                            const accentColor = document.getElementById("accent_color");
                            if (accentColor) {
                                applyAccentPreview(accentColor.value);
                                window.dispatchEvent(new CustomEvent('updateAccentColor', { detail: accentColor.value }));
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
