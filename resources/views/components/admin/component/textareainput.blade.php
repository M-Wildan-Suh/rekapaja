@props(['title', 'placeholder', 'name', 'value'=> null, 'xModel' => null])

<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{$name}}" class=" font-semibold">{{$title}}</label>
        <textarea name="{{$name}}" id="{{$name}}" placeholder="{{$placeholder}}" 
        @if ($xModel && !$value)
            {{ $xModel ? 'x-model='.$xModel : '' }} 
            x-bind:textContent="{{ $xModel ? '' : $value }}" 
        @endif 
        class="text-sm sm:text-base w-full min-h-[80px] border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] resize-none rounded-md shadow-sm overflow-hidden" cols="30" rows="2">{{$value}}</textarea>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('{{ $name }}');
    
            textarea.addEventListener('input', function () {
                this.style.height = 'auto'; // Reset height
                this.style.height = this.scrollHeight + 'px'; // Set new height based on content
            });
    
            // Initialize height based on initial content
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        });
    </script>
</div>