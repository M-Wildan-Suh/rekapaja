@props([
    'item',
    'class' => '',
    'label' => 'Detail',
    'style' => '',
])

@php
    $priceLabel = $item->price ? 'Rp' . number_format($item->price, 0, ',', '.') : null;
    $productDetail = [
        'title' => $item->title,
        'description' => $item->description,
        'image' => $item->image,
        'price' => $priceLabel,
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
