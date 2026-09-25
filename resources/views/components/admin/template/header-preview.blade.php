@php
    $previewHeader = old('header', $template->head_type ?? 'one');
    $headerImages = [
        'one' => 'one.jpg',
        'two' => 'two.jpg',
        'three' => 'three.jpg',
        'four' => 'four.jpg',
        'ramen' => 'Template-Ramen.webp',
        'network' => 'Template-Network.webp',
        'donut' => 'Template-Donat.webp',
        'skincare' => 'Template-Skincare.webp',
        'pudding_putih' => 'Template-Puding.webp',
        'sembako' => 'Template-Sembako.webp',
    ];
@endphp
<img id="header" src="{{ asset('assets/images/template/header/' . ($headerImages[$previewHeader] ?? 'one.jpg')) }}"
    class="w-full h-full object-cover duration-300" alt="Preview header {{ $previewHeader }}">
