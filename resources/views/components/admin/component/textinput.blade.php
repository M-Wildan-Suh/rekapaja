@props(['title', 'placeholder', 'name', 'value'=> null, 'xModel' => null])

<div class="w-full">
    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{ $name }}" class=" font-semibold">{{ $title }}</label>
        <input 
            type="text" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}" 
            @if ($xModel && !$value)
                {{ $xModel ? 'x-model='.$xModel : '' }} 
                x-bind:value="{{ $xModel ? '' : $value }}" 
            @endif
            value="{{ $value }}" 
            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm">
    </div>
</div>
