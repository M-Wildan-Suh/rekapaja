@props(['title', 'name', 'value' => [], 'users' => collect()])
@php
    $selectedValues = collect(old(str_replace('[]', '', $name), $value))
        ->filter(fn ($item) => filled($item))
        ->map(fn ($item) => (string) $item)
        ->values()
        ->all();
@endphp
<div class="flex flex-col gap-2">
    <label class="text-sm sm:text-base font-semibold">{{ $title }}</label>
    <select class="js-access-input" name="{{ $name }}">
        <option value=""></option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected(in_array((string) $user->id, $selectedValues, true))>{{ $user->name }}</option>
        @endforeach
    </select>
    <style>
        .js-access-input + .select2,
        .js-access-input + span .select2 {
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
            border: 2px solid #ff7100;
        }
    </style>
</div>
<script>
    window.addEventListener('load', function () {
        var $j = jQuery.noConflict();
        $j('.js-access-input').select2({
            placeholder: 'Pilih akun pemilik usaha'
        });
        $j('.js-access-input').trigger('change');
    });
</script>
