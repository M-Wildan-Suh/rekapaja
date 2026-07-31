<button {{ $attributes->merge(['type' => 'submit', 'class' => 'font-bold px-3 py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md text-center']) }}>
    {{ $slot }}
</button>
