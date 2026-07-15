<x-app-layout title="Admin - Profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4 space-y-6">
        <div class="max-w-xl mx-auto">
            @if (Auth::user()->role === 'admin')
                <div class="font-bold text-base sm:text-lg w-full py-2 bg-[#ff7100] text-white rounded-md text-center">Anda adalah Admin</div>
            @elseif (Auth::user()->role === 'premium')
                <div class="font-bold text-base sm:text-lg w-full py-2 bg-[#ff7100] text-white rounded-md flex justify-center text-center gap-2">
                    @if (Auth::user()->premium_type === 'lifetime' || Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired)))    
                        <p>Premium Aktif,</p>
                        <p>Expired :</p>
                        <p>{{Auth::user()->expired ?? 'Lifetime'}}</p>
                    @else
                        <p>Premium Unaktif,</p>
                        <p>Expired :</p>
                        <p>{{Auth::user()->expired ?? 'Lifetime'}}</p>
                    @endif
                </div>
            @else
                <a href="{{ route('join') }}">
                    <button class=" font-bold text-base sm:text-lg w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Dapatkan Akun Premium</button>
                </a>
            @endif
        </div>
        <div class="max-w-xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-black shadow rounded-md">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-black shadow rounded-md">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-black shadow rounded-md">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
