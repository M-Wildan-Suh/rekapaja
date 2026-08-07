@props([
    'item',
    'class' => '',
    'label' => 'Detail',
    'style' => '',
])

@php
    $priceLabel = $item->price ? 'Rp' . number_format($item->price, 0, ',', '.') : null;
    $productDetail = [
        'id' => $item->id,
        'title' => $item->title,
        'description' => $item->description,
        'image' => $item->image,
        'price' => $priceLabel,
        'canOrder' => (bool) $item->available,
    ];
@endphp

<button
    type="button"
    x-data='@json(['product' => $productDetail])'
    @click='window.dispatchEvent(new CustomEvent("open-product-detail", { detail: product }))'
    class="{{ $class }}"
    style="{{ $style }}"
>
    {{ $label }}
</button>
