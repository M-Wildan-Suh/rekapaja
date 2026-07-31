@if (Route::has('login'))
    <div class=" bg-[#F8FAFC] backdrop-blur fixed w-full top-0 left-0 p-4 text-right z-50">
        <div class=" flex justify-center items-center font-black text-2xl gap-2">
            <div class=" w-8 h-8">
                <img src="{{asset('assets/images/logo.webp')}}" alt="">
            </div>
            <a href="{{route('home')}}">Byoo.link</a>
        </div>
        {{-- @auth
            <a href="{{ route('dashboard') }}" class=" absolute top-1/2 -translate-y-1/2 right-4 sm:right-10 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class=" absolute top-1/2 -translate-y-1/2 right-4 sm:right-10 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
            @endif
        @endauth --}}
    </div>
@endif