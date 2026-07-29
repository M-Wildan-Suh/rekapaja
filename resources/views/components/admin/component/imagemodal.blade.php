@props(['title', 'name', 'route'])
<div x-data="{ open: false }">
    <!-- Button to open modal -->
    <button @click="open = true" type="button" :class="open ? 'bg-black' : 'bg-[#DB9F24]'" class="text-sm w-full py-2 rounded-md text-white font-semibold hover:bg-black duration-300">
        Tambah
    </button>

    <!-- Modal Background -->
    <div @keydown.escape.window="open = false" x-show="open" 
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex justify-center items-center bg-black/30 z-10">

        <!-- Modal Content -->
        <div @click.outside="open = false" class="bg-white w-60 p-4 rounded-lg shadow-lg">
            <form action="{{$route}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4">
                    <!-- Logo Input -->
                    <x-admin.component.imageinput :title="$title" value="" :name="$name"></x-admin-component.imageinput>
                    <!-- Submit Button -->
                    <x-admin.component.submitbutton title="Simpan"></x-admin.component.submitbutton>
                </div>
            </form>
        </div>
    </div>
    
</div>
