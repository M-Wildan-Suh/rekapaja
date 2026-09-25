@php
    $selectedGallery = old('gallery', $template->gallery_type ?? 'square');
@endphp
<div @open-business-section.window="if ($event.detail === 'gallery') gallery = true" x-data="{gallery: false, editorTab: 'content'}" class="">
    @unless ($businessContentEditor ?? false)
    <button @click="gallery = true" type="button" class=" absolute right-0 top-0 pl-3 pt-2 pr-2 pb-3 aspect-square bg-black/50 hover:bg-black duration-300 rounded-bl-[70%] z-10">
        <div class=" w-5 sm:w-6 aspect-square text-white">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z" fill="currentColor" class="fill-000000"></path><path d="M19 19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z" fill="currentColor" class="fill-000000"></path></svg>
        </div>
    </button>
    @endunless

    <!-- Modal -->
    <div x-cloak x-show="gallery" @keydown.escape.window="gallery = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] px-4"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal Gallery -->
        <div x-data="{tab : 'section'}" @click.away="gallery = false" class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative max-h-[90vh] overflow-hidden border-2 border-byolink-1">
            <div class="shrink-0 relative pt-6 pb-3 bg-byolink-1 text-white z-30">
                <h2 class=" px-6 text-2xl font-bold">Edit Galeri</h2>
                <button @click="gallery = false"
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
                    @include('admin.product.component.gallery-content')
                </div>
            @endif
            <div @if ($businessContentEditor ?? false) x-show="editorTab === 'design'" @endif class="min-h-0 overflow-y-auto overscroll-contain">
                <div class="w-full px-4 sm:px-6 min-h-[309px] sm:min-h-[292px]">
                    <div class=" w-full grid grid-cols-2 gap-4">
                        <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center">
                            <input type="radio" name="gallery" value="square" class="hidden peer" {{ $selectedGallery === 'square' ? 'checked' : '' }}>
                            <img src="{{asset('assets/images/template/gallery/square.png')}}" class=" w-full" alt="">
                            <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                            </div>
                        </label>
                        <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center">
                            <input type="radio" name="gallery" value="potrait" class="hidden peer" {{ $selectedGallery === 'potrait' ? 'checked' : '' }}>
                            <img src="{{asset('assets/images/template/gallery/potrait.png')}}" class=" w-full" alt="">
                            <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                            </div>
                        </label>
                        <label class="w-full rounded-md bg-white overflow-hidden relative flex items-center">
                            <input type="radio" name="gallery" value="network" class="hidden peer" {{ $selectedGallery === 'network' ? 'checked' : '' }}>
                            <img src="{{asset('assets/images/template/gallery/network.png')}}" class=" w-full" alt="">
                            <div class=" absolute inset-0 peer-checked:bg-black/50 duration-300">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div @if ($businessContentEditor ?? false) x-show="editorTab === 'design'" @endif class="shrink-0 sm:pt-4">
                <div class=" px-4 sm:px-6 w-full flex justify-end items-center gap-4">
                    <button 
                        @click="gallery = false"
                        @unless ($businessContentEditor ?? false) onclick="changegallery()" @endunless
                        type="{{ ($businessContentEditor ?? false) ? 'submit' : 'button' }}"
                        class="text-sm sm:text-base w-full sm:w-auto py-2 px-4 bg-byolink-2 text-white rounded hover:bg-black duration-300">
                        Simpan
                    </button>
                    <script>
                        function changegallery() {
                            const galleryInput = document.querySelector('input[name="gallery"]:checked');
                            const galleryShow = document.getElementById("gallery");

                            galleryShow.src = `/assets/images/template/gallery/${galleryInput.value}.png`;

                              window.dispatchEvent(new CustomEvent('updateGalleryType', { detail: galleryInput.value }));


                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
