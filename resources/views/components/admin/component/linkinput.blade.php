@props(['title', 'placeholder', 'link', 'name', 'value', 'xModel' => null, 'required' => false, 'maxlength' => null, 'helper' => null])

@php
    $fieldValue = old($name, $value);
@endphp
<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{$name}}" class=" font-semibold">{{$title}}</label>
        <div class="flex flex-row w-full border border-transparent focus-within:border-[#ff7100] focus-within:ring-1 focus-within:ring-[#ff7100] rounded-md">
            <label for="{{$name}}" class="py-2 px-3 border border-[#ff7100] bg-[#ff7100] text-white rounded-l-md">{{$link}}</label>
            <input type="text" id="{{$name}}" name="{{$name}}" 
                placeholder="{{$placeholder}}"
                @if ($xModel && old($name) === null && blank($value))
                    {{ $xModel ? 'x-model='.$xModel : '' }} 
                    x-bind:value="{{ $xModel ? '' : $fieldValue }}" 
                @endif
                value="{{$fieldValue}}"
                @required($required)
                @if($maxlength) maxlength="{{ $maxlength }}" @endif
                class="flex-grow min-w-0 text-sm sm:text-base font-normal rounded-r-md border border-gray-300 focus:ring-0 focus:border-none">
        </div>
        @if($helper || $maxlength)
            <p class="text-xs text-neutral-500">{{ $helper ?? 'Maksimal ' . $maxlength . ' karakter.' }}</p>
        @endif
    </div>
</div>
