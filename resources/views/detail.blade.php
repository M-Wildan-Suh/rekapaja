@php
    $hideBusinessProfileSections = in_array(($template->head_type ?? null), ['one', 'two', 'three', 'four', 'ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'], true);
    $metaDescription = $hideBusinessProfileSections
        ? ($data->description ?: $data->subtitle)
        : ($data->subtitle ?: $data->description);
    $canonicalUrl = $data->domain ? rtrim($data->domain, '/') : route('detail', ['slug' => $data->slug]);
@endphp

<x-layout.guest
    :title="$data->name"
    :desc="$metaDescription"
    :tags="$hideBusinessProfileSections ? collect() : $data->productTags"
    :canonical="$canonicalUrl"
    :image="$data->image"
    :robots="($editorPreview ?? false) ? 'noindex,nofollow' : 'index,follow'"
>
    @include('components.guest.business-page')
</x-layout.guest>
