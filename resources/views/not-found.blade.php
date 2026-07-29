<x-layout.guest>
    @include('components.guest.header')
    <div class=" w-full pt-16 h-[calc(100vh-140px)]">
        <div class=" w-full h-full flex items-center justify-center">
            <div class=" space-y-3 text-center text-black font-black">
                <p class=" text-8xl tracking-wide">404</p>
                <p class=" text-4xl">Page not Found</p>
            </div>
        </div>
    </div>
    @include('components.guest.footer')
    @include('components.admin.mobile-navbar')
</x-layout.guest>
