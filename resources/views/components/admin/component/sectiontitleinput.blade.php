@props(['value', 'placeholder', 'name', 'submit'])
<div class="flex flex-row w-full border border-transparent focus-within:border-[#b95300] focus-within:ring-1 focus-within:ring-[#b95300] rounded-md">
    <input type="text" id="{{$name}}" name="{{$name}}" placeholder="{{$placeholder}}" value="{{$value}}" class="text-sm sm:text-base flex-grow rounded-l-md border border-[#ff7100] focus:ring-0 focus:border-none">
    <button class="py-2 px-3 border border-[#ff7100] bg-[#ff7100] text-white rounded-r hover:bg-[#b95300] hover:border-[#b95300] duration-300 text-sm sm:text-base">{{$submit ?? 'Ganti' }}</button>
</div>