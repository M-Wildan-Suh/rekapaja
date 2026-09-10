@props(['title', 'name', 'value' => [], 'users' => collect(), 'placeholder' => 'Pilih akun pemilik usaha', 'searchPlaceholder' => 'Cari akun pemilik usaha', 'showId' => false])
@php
    $selectedValues = collect(old(str_replace('[]', '', $name), $value))
        ->filter(fn ($item) => filled($item))
        ->map(fn ($item) => (string) $item)
        ->values()
        ->all();
@endphp
<div class="flex flex-col gap-2">
    <label class="text-sm sm:text-base font-semibold">{{ $title }}</label>
    <select class="js-access-input" name="{{ $name }}" data-placeholder="{{ $placeholder }}" data-search-placeholder="{{ $searchPlaceholder }}" {{ $attributes }}>
        <option value=""></option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected(in_array((string) $user->id, $selectedValues, true))>{{ $user->name }}</option>
        @endforeach
    </select>
    <style>
        .js-access-input + .select2 .select2-selection--single {
            position: relative;
            height: 42px;
        }
        .js-access-input + .select2 .select2-selection__rendered {
            line-height: 24px;
            padding-left: 0;
        }
        .js-access-input + .select2 .select2-selection__arrow {
            height: 40px;
        }
        .js-access-input + .select2 .select2-selection__clear {
            position: absolute;
            right: 24px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            width: 20px;
            height: 20px;
            margin: 0;
            padding: 0;
            line-height: 20px;
        }
        .js-access-input + .select2 .select2-selection--clearable .select2-selection__rendered {
            padding-right: 40px;
        }
        .js-access-input + .select2 .access-search-active .select2-selection__rendered {
            visibility: hidden;
        }
        .js-access-input + .select2 .select2-search--dropdown {
            position: absolute;
            inset: 0 48px 0 0;
            padding: 0;
        }
        .js-access-input + .select2 .select2-search__field {
            height: 100%;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 0 !important;
            background: transparent;
            box-shadow: none !important;
            outline: none;
            font: inherit;
        }
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
        $j('.js-access-input').each(function () {
            var $select = $j(this);
            if ($select.hasClass('select2-hidden-accessible')) return;
            var $modal = $select.closest('[data-voucher-modal]');
            $select.select2({
                placeholder: $select.attr('data-placeholder'),
                width: '100%',
                dropdownParent: $modal.length ? $modal : $j(document.body),
                allowClear: true,
                minimumResultsForSearch: 0
            });
            var instance = $select.data('select2');
            var $selection = instance.$container.find('.select2-selection');
            var $search = instance.dropdown.$search;
            var $searchContainer = $search.parent();
            var $searchParent = $searchContainer.parent();

            // Keep Select2's own search and keyboard handlers, but show it in the field.
            $search.attr('placeholder', $select.attr('data-search-placeholder'));
            if ($select.is('[data-voucher-business]')) {
                window.addEventListener('open-voucher', function (event) {
                    $select.val(String(event.detail.productId || '')).trigger('change');
                });
                $modal.closest('[x-data]').get(0)?.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') $select.select2('close');
                });
            }
            $search.on('mousedown.accessSearch click.accessSearch', function (event) {
                event.stopPropagation();
            });
            $search.on('keydown.accessSearch', function (event) {
                // The dropdown already handles this key; avoid handling it twice in selection.
                event.stopPropagation();
            });
            $select.on('select2:open.accessSearch', function () {
                $selection.addClass('access-search-active');
                $searchContainer.appendTo($selection);
                $search.trigger('focus');
            });
            $select.on('select2:close.accessSearch', function () {
                $searchContainer.prependTo($searchParent);
                $selection.removeClass('access-search-active');
            });
        });
        $j('.js-access-input').trigger('change');
    });
</script>
