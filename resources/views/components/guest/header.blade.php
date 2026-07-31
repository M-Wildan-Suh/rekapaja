<div class=" fixed bg-black w-full top-0 left-0 p-4 sm:px-6 backdrop-blur-md z-50">
    <div class=" max-w-xl mx-auto flex justify-between gap-2 sm:gap-6">
        <div class=" min-w-10 w-10 aspect-square">
            <img src="{{asset('assets/images/logo.webp')}}" alt="">
        </div>
        <div class=" flex-grow">
            <form action="{{ route('allproduct') }}" method="get">
                <div class=" flex items-center justify-between h-10 rounded-full bg-white overflow-hidden">
                    <input type="text" name="search" value="{{ request('search') }}" @input="document.querySelector('form').submit()" class=" min-w-0 sm:flex-grow text-sm px-4 sm:px-6 bg-transparent border-none ring-0 focus:border-none focus:ring-0" placeholder="Cari Bisnis....">
                    <button class=" px-4 sm:px-6 hover:bg-[#ff7100] hover:text-white duration-300 h-full">
                        <div class=" w-[18px] aspect-square overflow-hidden">
                            <svg aria-hidden="true" class="e-font-icon-svg e-fas-search" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open" 
                :class="open ? 'text-[#ff7100]' : 'text-white hover:text-[#ff7100]'"
                class="min-w-6 w-6 h-10 aspect-square py-1.5 duration-300">
                <svg aria-hidden="true" class="e-font-icon-svg e-far-user-circle" viewBox="0 0 496 512" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path>
                </svg>
            </button>
            
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 text-sm bg-white rounded-md shadow-lg overflow-hidden z-10">
                @auth
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a>
                <hr class="border-gray-300">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-200">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Login</a>
                @endauth
            </div>
        </div>
    </div>
    @if (Route::has('login'))
        {{-- @auth
            <a href="{{ route('dashboard') }}" class=" absolute top-1/2 -translate-y-1/2 right-4 sm:right-10 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class=" absolute top-1/2 -translate-y-1/2 right-4 sm:right-10 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
            @endif
        @endauth --}}
    @endif
</div>