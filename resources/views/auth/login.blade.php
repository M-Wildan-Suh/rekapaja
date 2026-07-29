<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 space-y-4">
            <div class=" flex w-full sm:w-auto gap-3 justify-between">
                <label for="remember_me" class="inline-flex items-center gap-1">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#ff7100] shadow-sm focus:ring-[#ff7100]" name="remember">
                    <span class=" text-sm text-white">Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white hover:text-[#ff7100] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ff7100]" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
                <a class=" absolute top-4 right-4 underline text-sm text-white hover:text-[#ff7100] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ff7100]" href="{{ route('register') }}">
                    {{ __('Daftar') }}
                </a>
            </div>
            <x-primary-button class=" w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class=" w-full flex items-center gap-2 mt-4">
            <div class="flex-1 h-[1px] bg-gray-300"></div>
            <span class="text-white text-sm sm:text-base">Atau</span>
            <div class="flex-1 h-[1px] bg-gray-300"></div>
        </div>

        <div class="mt-4">
            <a href="{{ route('google.login') }}">
                <button type="button" type="button" class=" w-full font-bold flex items-center px-4 py-2 gap-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-[#F8FAFC] rounded-md">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                    </svg>
                    <p>Login dengan google</p>
                </button>
            </a>
        </div>
    </form>
</x-guest-layout>
