@props(['title'])
@props(['placeholder'])
@props(['name'])
@props(['value'])
@props(['required' => false])
@props(['maxlength' => null])

@php
    $fieldValue = old($name, $value);
@endphp
<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{$name}}" class=" font-semibold">{{$title}}</label>
        <input type="text" id="{{$name}}" name="{{$name}}" placeholder="{{$placeholder}}" value="{{$fieldValue}}" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" @required($required) @if($maxlength) maxlength="{{ $maxlength }}" @endif class=" text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm">
        @if($maxlength)
            <p class="text-xs text-neutral-500">Maksimal {{ $maxlength }} digit.</p>
        @endif
    </div>
</div>
