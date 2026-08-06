@php
    $hideBusinessProfileSections = in_array(($template->head_type ?? null), ['ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'], true);
@endphp

<x-layout.guest
    :title="$data->name"
    :desc="$hideBusinessProfileSections ? null : $data->subtitle"
    :tags="$hideBusinessProfileSections ? collect() : $data->productTags"
>
    <div class=" mx-auto rounded-md bg-white min-h-screen relative">
        <div class=" space-y-6">
            <div class=" background min-h-screen pt-6 relative space-y-4 bg-gradient-to-b">
                @includeFirst(['components.guest.banner.' . $template->head_type, 'components.guest.banner.one'])

                @if ($data->productGallery->isNotEmpty())
                    @includeFirst(['components.guest.gallery.' . $template->gallery_type, 'components.guest.gallery.square'])
                @endif

                @include('components.guest.youtube')

                @unless($hideBusinessProfileSections)
                    @includeFirst(['components.guest.description-' . ($template->desc_type ?? 'default'), 'components.guest.description'])
                @endunless

                @includeFirst(['components.guest.product.' . $template->product_type, 'components.guest.product.grid2'])

                @unless($hideBusinessProfileSections)
                    @includeFirst(['components.guest.tags-' . $template->product_type, 'components.guest.tags'])
                @endunless

                @include('components.guest.contact')
            </div>
        </div>
    </div>
    <style>
        .background {
            @if ($template->bg_type === 'normal')
                background-color: {{ $template->bg_main_color }};
            @elseif ($template->bg_type === 'gradient')
                background: linear-gradient(to bottom, {{ $template->bg_main_color }}, {{ $template->bg_second_color }});
            @elseif ($template->bg_type === 'image')
                background-image: url('{{ asset('storage/images/template/background/'.$template->bg_image) }}');
                background-size: cover;
                background-position: center;
            @endif
        };
    </style>
    
</x-layout.guest>
