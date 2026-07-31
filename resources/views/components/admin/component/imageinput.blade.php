@props(['name', 'value', 'status', 'xModel' => null])
<div class="w-full h-full flex flex-col text-sm font-medium gap-2 justify-center items-center">
    <div class="w-full h-full relative flex justify-center overflow-hidden">
        <img id="{{$name}}-preview" class="object-cover w-full" 
            {{ $xModel ? 'x-bind:src='.$xModel : '' }} 
            src="{{$value == '' ? asset('assets/images/placeholder.jpg') : $value  }}" 
            alt="Logo">
        <div class="w-full h-full absolute z-10 top-0 opacity-0 hover:opacity-100 duration-300">
            <label for="{{$name}}-input" class="relative">
                <div class="w-full h-full bg-black opacity-60 flex justify-center items-center text-neutral-400">
                    <div class="w-12 aspect-square">
                        <svg viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M0 14.2V18h3.8l11-11.1L11 3.1 0 14.2ZM17.7 4c.4-.4.4-1 0-1.4L15.4.3c-.4-.4-1-.4-1.4 0l-1.8 1.8L16 5.9 17.7 4Z" fill="currentColor" fill-rule="evenodd" class="fill-000000"></path></svg>
                    </div>
                </div>
                <input accept="image/*" type="file" name="{{$name}}" 
                       class="absolute bottom-0 left-0 z-0 w-40 opacity-0" 
                       id="{{$name}}-input" 
                       {{($status ?? '') != '' ? 'required' : ''}}
                       onchange="handleImagePreview(this, '{{$name}}-preview')" />
            </label>
        </div>
    </div>
</div>


<script>
    function handleImagePreview(input, previewId) {
        const previewImage = document.getElementById(previewId);
        const [file] = input.files;
        if (file) {
            previewImage.src = URL.createObjectURL(file);
        }
    }

    // Paste event to handle all image inputs
    window.addEventListener('paste', e => {
        const [file] = e.clipboardData.files;
        if (file) {
            document.querySelectorAll('img[id$="-preview"]').forEach(img => {
                img.src = URL.createObjectURL(file);
            });
        }
    });
</script>
