@props(['title', 'placeholder', 'name', 'value'=> null, 'xModel' => null, 'required' => false, 'maxlength' => null, 'helper' => null, 'stripProtocol' => false])

@php
    $fieldValue = old($name, $value);
    if ($stripProtocol && is_string($fieldValue)) {
        $fieldValue = preg_replace('~^https?://~i', '', $fieldValue);
    }
@endphp

<div class="w-full">
    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{ $name }}" class=" font-semibold">{{ $title }}</label>
        <input 
            type="text" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            placeholder="{{ $placeholder }}" 
            @if ($xModel && old($name) === null && blank($value))
                {{ $xModel ? 'x-model='.$xModel : '' }} 
                x-bind:value="{{ $xModel ? '' : $fieldValue }}" 
            @endif
            value="{{ $fieldValue }}"
            @if($stripProtocol) oninput="if (this.value.toLowerCase().startsWith('https://')) this.value = this.value.slice(8); else if (this.value.toLowerCase().startsWith('http://')) this.value = this.value.slice(7)" @endif
            @required($required)
            @if($maxlength) maxlength="{{ $maxlength }}" @endif
            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm">
        @if($helper || $maxlength)
            <p class="text-xs text-neutral-500">{{ $helper ?? 'Maksimal ' . $maxlength . ' karakter.' }}</p>
        @endif
    </div>
</div>
