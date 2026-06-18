@props(['title'])
@props(['placeholder'])
@props(['name'])
@props(['value'])
@props(['required' => false])

@php
    $fieldValue = old($name, $value);
@endphp
<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{$name}}" class=" font-semibold">{{$title}}</label>
        <input type="number" id="{{$name}}" name="{{$name}}" placeholder="{{$placeholder}}" value="{{$fieldValue}}" min="0" @required($required) class=" text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm">
    </div>
</div>
