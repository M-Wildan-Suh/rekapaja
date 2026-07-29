@props(['title'])
@props(['placeholder'])
@props(['name'])
@props(['value'])
<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm font-medium">
        <label for="{{$name}}">{{$title}}</label>
        <input type="email" id="{{$name}}" name="{{$name}}" placeholder="{{$placeholder}}" value="{{$value}}" class=" text-sm rounded-md border border-[#DB9F24] focus:ring-black focus:border-black bg-neutral-100">
    </div>
</div>