{{-- @props(['color' => null, 'data', 'text' => null]) --}}
<div class=" w-full max-w-[600px] mx-auto px-4 sm:px-0 relative">
    <!-- Accordion Item 1 -->
    <div style="background-color: {{$template->desc_main_color ?? 'white'}}; color: {{$template->desc_text_color ?? 'black'}}" class="p-4 space-y-2 rounded-md">
        
        <p class="w-full font-bold tracking-wide text-lg sm:text-xl">Tags/Keywords</p>
        
        <div class=" w-full flex flex-wrap gap-2 text-xs sm:text-sm">
            @foreach ($data->productTags as $item)
                <div class=" px-3 py-1 border rounded-full cursor-default">{{$item->productTag->tag}}</div>
            @endforeach
        </div>
    </div>
</div>