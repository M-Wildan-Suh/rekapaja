@props(['title', 'placeholder', 'name', 'value' = null, 'xModel' => null])
<div class=" w-full">
    <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
        <label for="{{ $name }}">{{ $title }}</label>
        <div
            class="flex flex-row w-full border border-transparent focus-within:border-byolink-3 focus-within:ring-1 focus-within:ring-byolink-3 rounded-md">
            <label for="{{ $name }}"
                class="py-2 px-3 border border-byolink-1 bg-byolink-1 text-white rounded-l-md">Rp. </label>
            <input type="number" id="{{ $name }}" min="0" name="{{ $name }}"
                placeholder="{{ $placeholder }}" 
                @if ($xModel && !$value)
                    {{ $xModel ? 'x-model=' . $xModel : '' }}
                    x-bind:value="{{ $xModel ? '' : $value }}"
                @endif
                value="{{ $value }}"class="flex-grow min-w-0 text-sm sm:text-base font-normal rounded-r-md border border-byolink-1 focus:ring-0 focus:border-none bg-neutral-100">
        </div>
    </div>
</div>
