@props(['title', 'name', 'value', 'tag' => null])
@php
    $selectedValues = collect(old(str_replace('[]', '', $name), isset($value) ? collect($value)->pluck('tag')->all() : []))
        ->filter(fn ($item) => filled($item))
        ->values()
        ->all();
@endphp
<div class="flex flex-col gap-2">
    <label class=" text-sm sm:text-base font-semibold">{{$title}}</label>
    <select class="js-example-basic-single" name="{{$name}}" multiple="multiple">
        @if (isset($tag))
            @foreach($tag as $item)
                <option value="{{ $item->tag }}" @selected(in_array($item->tag, $selectedValues, true))>{{ $item->tag }}</option>
            @endforeach
        @endif
        @foreach($selectedValues as $selectedValue)
            @if (!isset($tag) || !$tag->contains('tag', $selectedValue))
                <option value="{{ $selectedValue }}" selected>{{ $selectedValue }}</option>
            @endif
        @endforeach
    </select>
    <style>
        .select2 {
            width: 100% !important;
        }

        .selection .select2-selection {
            width: 100% !important;
            border-color: #d1d5db !important;
            min-height: 36px !important;
            padding: 0.5rem 0.75rem !important;
            border-radius: 0.375rem !important;
        }

        .selection .select2-selection:focus,
        .selection .select2-selection:focus-within {
            border: 2px solid;
            border-radius: 0.375rem !important;
            border-color: #ff7100 !important;
        }
        .selection li {
            margin-top: 0px !important;
            margin-left: 0px !important;
            margin-right: 0.25rem !important;
            line-height: 1.25rem !important;
        }
        .selection textarea {
            margin-top: 0px !important;
            margin-left: 0px !important;
            margin-bottom: 2px !important;
            line-height: 1.25rem !important;
        }
        .select2-dropdown {
            overflow: hidden;
            border-radius: 0.375rem !important;
            border: 2px solid #ff7100
        }
    </style>
</div>
<script>
    window.addEventListener('load', function() {
        var $j = jQuery.noConflict();
        $j('.js-example-basic-single').select2({
            tags: true,
            tokenSeparators: [','],
            // maximumSelectionLength: 10,
        });
        $j('.js-example-basic-single').trigger('change');
    });
</script>
