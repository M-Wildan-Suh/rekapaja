<div @open-business-section.window="if ($event.detail === 'contact') contact = true" x-data="{contact: false, editorTab: 'content'}" class="">
    @unless ($businessContentEditor ?? false)
    <button @click="contact = true" type="button" class=" absolute right-0 top-0 p-2 aspect-square bg-black/50 hover:bg-black duration-300 rounded-r-md z-10">
        <div class=" w-4 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>
    @endunless

    <!-- Modal -->
    <div x-cloak x-show="contact" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Contact -->
        <div x-data="{tab : 'section'}" @click.away="contact = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative max-h-[90vh] overflow-hidden border-2 border-byolink-1">
            <div class="shrink-0 relative pt-6 pb-3 bg-byolink-1 text-white z-30">
                <h2 class=" px-6 text-2xl font-bold">Edit Contact</h2>
                <button @click="contact = false"
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
                    <x-admin.component.numberinput title="No. WhatsApp (Opsional)" placeholder="Masukkan Nomor..."
                        :value="$product->no_tlp" name="no_tlp" maxlength="20" form="bussiness" />
                    @error('no_tlp') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
            <div @if ($businessContentEditor ?? false) x-show="editorTab === 'design'" @endif class="min-h-0 overflow-y-auto overscroll-contain w-full px-4 sm:px-6">
                <div class=" grid grid-cols-1 gap-4 sm:gap-6">
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="contact_main_color">WhatsApp Color</label>
                            <x-admin.component.colorinput name="contact_main_color" :value="old('contact_main_color', $template->contact_main_color ?? '#000000')" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                            <label for="contact_second_color">Telephone Color</label>
                            <x-admin.component.colorinput name="contact_second_color" :value="old('contact_second_color', $template->contact_second_color ?? '#8E1616')" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="shrink-0 sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="contact = false"
                        @if ($businessContentEditor ?? false) :form="editorTab === 'content' ? 'bussiness' : 'business-design'" @else onclick="changecontact()" @endif
                        type="{{ ($businessContentEditor ?? false) ? 'submit' : 'button' }}"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>
                    <script>
                        function changecontact() {
                            const contactmain = document.getElementById('contact_main_color');
                            const contactsecond = document.getElementById('contact_second_color');
                            const phone = document.getElementById('phone');
                            const wa = document.querySelectorAll("#wa");

                            phone.style.backgroundColor = contactsecond.value;
                            wa.forEach(element => {
                                element.style.backgroundColor = contactmain.value
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
