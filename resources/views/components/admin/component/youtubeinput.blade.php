@props(['title', 'name', 'value'])

<div class=" w-full">
    <div x-data="{ open: false, videoUrl: '', iframeSrc: @js($value) }" class="relative flex flex-col text-sm font-medium gap-2 justify-center items-center">
        <!-- Button to open modal -->
        <div class="flex flex-row gap-2 items-center">
            <p>{{$title}}</p>
            <button @click="open = true" type="button" class="w-3 aspect-square text-[#DB9F24] duration-300 hover:scale-110">
                <svg viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 14.2V18h3.8l11-11.1L11 3.1 0 14.2ZM17.7 4c.4-.4.4-1 0-1.4L15.4.3c-.4-.4-1-.4-1.4 0l-1.8 1.8L16 5.9 17.7 4Z" fill="currentColor" fill-rule="evenodd" class="fill-000000"></path>
                </svg>
            </button>
        </div>

        <!-- Modal -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="open = false" class="bg-white p-4 rounded-lg shadow-lg w-80 flex flex-col gap-4">
                <label class="text-base font-semibold">Ganti Video</label>
                <input x-model="videoUrl" type="text" class="flex-grow text-sm rounded-r-md border border-[#DB9F24] focus:ring-0 focus:border-none bg-neutral-100" placeholder="Input Link Youtube">
                <button type="button" @click="iframeSrc = videoUrl.replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/'); open = false" class="rounded-md bg-[#DB9F24] py-2 text-white font-semibold hover:bg-black duration-300">
                    Ubah
                </button>
            </div>
        </div>

        {{-- Input Hidden --}}
        <input type="hidden" name="{{$name}}" x-ref="hiddenInput" :value="iframeSrc">

        <!-- Video -->
        <div class="w-full">
            <div class="w-full aspect-video overflow-hidden rounded">
                <iframe class="w-full h-full" x-bind:src="iframeSrc" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>