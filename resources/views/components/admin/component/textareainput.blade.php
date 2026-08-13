@props(['title', 'placeholder', 'name', 'value'=> null, 'xModel' => null, 'required' => false, 'maxlength' => null, 'helper' => null])

@php
    $fieldValue = old($name, $value);
@endphp

<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{$name}}" class=" font-semibold">{{$title}}</label>
        <textarea name="{{$name}}" id="{{$name}}" placeholder="{{$placeholder}}" 
        @if ($xModel && old($name) === null && blank($value))
            {{ $xModel ? 'x-model='.$xModel : '' }} 
            x-bind:textContent="{{ $xModel ? '' : $fieldValue }}" 
        @endif 
        @required($required)
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        class="text-sm sm:text-base w-full min-h-[80px] border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] resize-none rounded-md shadow-sm overflow-hidden" cols="30" rows="2">{{$fieldValue}}</textarea>
        @if($helper || $maxlength)
            <div class="flex items-center justify-between gap-3 text-xs text-neutral-500">
                <p>{{ $helper ?? 'Maksimal ' . $maxlength . ' karakter.' }}</p>
                @if($maxlength)
                    <span id="{{ $name }}-counter">{{ mb_strlen((string) $fieldValue) }}/{{ $maxlength }}</span>
                @endif
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('{{ $name }}');
            if (!textarea) {
                return;
            }

            const counter = document.getElementById('{{ $name }}-counter');

            const syncTextareaState = () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';

                if (counter) {
                    counter.textContent = textarea.value.length + '/{{ $maxlength }}';
                }
            };
    
            textarea.addEventListener('input', function () {
                syncTextareaState();
            });
    
            syncTextareaState();
        });
    </script>
</div>
