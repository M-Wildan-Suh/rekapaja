@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#ff7100] text-start text-base font-medium text-[#ff7100] bg-[#ff7100]/10 focus:outline-none focus:text-[#b95300] focus:bg-[#ff7100]/20 focus:border-[#b95300] transition duration-300 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-white hover:bg-[#ff7100]/50 hover:border-[#ff7100] focus:outline-none focus:text-white focus:bg-[#ff7100] focus:border-[#ff7100] transition duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
