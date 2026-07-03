@props(['title', 'name', 'value', 'defaultvalue', 'xModel'=> null, 'required' => false, 'form' => null])
@php
    $selectedValue = old($name, $defaultvalue);
@endphp
<div class="w-full">
    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{$name}}" class=" font-semibold">{{$title}}</label>
        <div class="grid grid-cols-2 gap-3">
            @foreach ($value as $item)
                <div class="flex flex-row gap-2 items-center">
                    <input 
                        type="radio" 
                        class="text-[#ff7100] ring-0 focus:ring-[#ff7100] checked:ring-[#ff7100]" 
                        name="{{$name}}" 
                        id="{{$name}}-{{$loop->index}}" 
                        @if ($form)
                            form="{{$form}}"
                        @endif
                        @if ($xModel && old($name) === null)
                            {{ $xModel ? 'x-model='.$xModel : '' }} 
                            x-bind:value="{{ $xModel ? '' : $selectedValue }}" 
                        @endif
                        value="{{$item['value']}}" 
                        @required($required && $loop->first)
                        @checked($item['value'] == $selectedValue || ($loop->first && blank($selectedValue)))
                    >
                    <label for="{{$name}}-{{$loop->index}}">{{$item['label']}}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
