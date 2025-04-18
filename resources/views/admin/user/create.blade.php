<x-app-layout title="Admin - Tambah User">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4">
        <div class="max-w-xl mx-auto">
            <div class="bg-[#F8FAFC] overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" p-4 md:p-6 text-gray-900">
                    <form method="POST" action="{{route('user.store')}}">
                        @csrf
                        <div class="w-full space-y-6">
                            <!-- Name -->
                            <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                <label for="name">Nama User</label>
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Masukkan Username" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                <label for="email">Email</label>
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Masukkan Email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                <label for="password">Password</label>

                                <x-text-input id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                placeholder="Masukkan Password"
                                                required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                <label for="password_confirmation">Konfirmasi Password</label>

                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                placeholder="Konfirmasi Password"
                                                name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class=" w-full">
                                <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                    <label for="user_id">Role</label>
                                    <select 
                                        name="role" 
                                        class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" 
                                        id="user" >
                                        <option value="" selected disabled>Pilih Role</option>
                                        <option value="user">User</option>
                                        <option value="premium">Premium User</option>
                                    </select>
                                </div>
                            </div>
                            <div x-data="premiumSelector()" class=" w-full grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                    <label for="premium_type">Paket Premium</label>
                                    <select 
                                        name="premium_type" 
                                        class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" 
                                        id="premium_type"
                                        x-model="premiumType"
                                        @change="updateDate">
                                        <option value="" selected disabled>Pilih Paket Premium</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                        <option value="lifetime">Lifetime</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                                    <label for="expired">Tanggal Expired</label>
                                    <input 
                                        type="date" 
                                        name="expired" 
                                        id="expired" 
                                        class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                                        x-model="expiredDate"
                                        x-bind:disabled="premiumType === 'lifetime'">
                                    <span x-show="premiumType === 'lifetime'" class="text-sm italic text-gray-500">Unlimited</span>
                                </div>
                            </div>
            
                            <script>
                                function premiumSelector() {
                                    return {
                                        premiumType: '',
                                        expiredDate: '',
                                        updateDate() {
                                            const currentDate = new Date();
                                            if (this.premiumType === 'month') {
                                                currentDate.setMonth(currentDate.getMonth() + 1);
                                            } else if (this.premiumType === 'year') {
                                                currentDate.setFullYear(currentDate.getFullYear() + 1);
                                            } else if (this.premiumType === 'lifetime') {
                                                this.expiredDate = '';
                                                return;
                                            }
                                            this.expiredDate = currentDate.toISOString().split('T')[0];
                                        },
                                        init() {
                                            this.updateDate(); // Initialize with default value
                                        }
                                    };
                                }
                            </script>

                            <div class="">
                                <button class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>