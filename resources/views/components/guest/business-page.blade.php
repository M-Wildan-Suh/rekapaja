@php
    $hideBusinessProfileSections = in_array(($template->head_type ?? null), ['one', 'two', 'three', 'four', 'ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'], true);
@endphp
    <div data-business-page class="mx-auto rounded-md min-h-screen relative">
        <div class=" space-y-6">
            <div class="background min-h-screen pt-6 relative space-y-4 bg-gradient-to-b">
                @if ($editorPreview ?? false)
                    <button type="button" data-edit-section="background" aria-label="Edit latar" class="absolute right-0 top-0 z-20 rounded-bl-[70%] bg-black/50 pl-3 pt-2 pr-2 pb-3 text-white hover:bg-black">
                        <svg class="w-5 sm:w-6 aspect-square" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z"/><path d="M19 19H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z"/></svg>
                    </button>
                @endif
                <x-guest.editor-section section="header" :editing="$editorPreview ?? false">
                    @includeFirst(['components.guest.banner.' . $template->head_type, 'components.guest.banner.one'])
                </x-guest.editor-section>

                @if ($data->productGallery->isNotEmpty() || ($editorPreview ?? false))
                    <x-guest.editor-section section="gallery" :editing="$editorPreview ?? false">
                    @if ($data->productGallery->isNotEmpty())
                        @includeFirst(['components.guest.gallery.' . $template->gallery_type, 'components.guest.gallery.square'])
                    @else
                        <div class="p-8 text-center text-gray-500">Tambahkan foto galeri</div>
                    @endif
                </x-guest.editor-section>
                @endif

                @include('components.guest.youtube')

                @unless($hideBusinessProfileSections)
                    <x-guest.editor-section section="article" :editing="$editorPreview ?? false">
                    @includeFirst(['components.guest.description-' . ($template->desc_type ?? 'default'), 'components.guest.description'])
                </x-guest.editor-section>
                @endunless

                @include('components.guest.qris-section')

                <x-guest.editor-section section="product" :editing="$editorPreview ?? false">
                    @includeFirst(['components.guest.product.' . $template->product_type, 'components.guest.product.grid2'])
                </x-guest.editor-section>

                @unless($hideBusinessProfileSections)
                    @includeFirst(['components.guest.tags-' . $template->product_type, 'components.guest.tags'])
                @endunless

                <x-guest.editor-section section="contact" :editing="$editorPreview ?? false">
                    @include('components.guest.contact')
                </x-guest.editor-section>
            </div>
        </div>
    </div>
    <style>
        body:has([data-business-page]),
        body:has([data-business-live-editor]) [data-app-shell] {
            background: none;
            background-attachment: fixed;
            @if ($template->bg_type === 'normal')
                background-color: {{ $template->bg_main_color }};
            @elseif ($template->bg_type === 'gradient')
                background-image: linear-gradient(to bottom, {{ $template->bg_main_color }}, {{ $template->bg_second_color }});
            @elseif ($template->bg_type === 'image')
                background-image: url('{{ $previewImages['bg_image'] ?? asset('storage/images/template/background/'.$template->bg_image) }}');
                background-size: cover;
                background-position: center;
            @endif
        }
        [data-business-page] .background { background: transparent; }
    </style>
    
