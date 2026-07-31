<!-- Modal -->
<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-30 px-4 max-h-screen py-4"
x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <!-- Modal EditModal -->
    <div class="w-full max-w-[720px] max-h-[calc(100vh-16px)] bg-white pb-6 text-left rounded-md flex flex-col gap-4 relative border-2 border-[#ff7100]">
        <div class=" pt-6 pb-3 bg-[#ff7100] text-white z-30">
            <h2 class=" px-6 text-2xl font-bold">Edit User</h2>
            <button @click="editModal = false"
                class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                    enable-background="new 0 0 512 512">
                    <path
                        d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                        fill="currentColor" class="fill-000000"></path>
                </svg>
            </button>
        </div>
        <form :action="`{{ route('user.update', ['user' => '/']) }}/${editData.id}`" method="POST">
            @csrf
            @method('PUT')
            <div x-data="editUserPremiumForm()" x-effect="syncFromEditData(editData)" class=" space-y-3 px-6">
                <div class="w-full">
                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                        <label for="name">Nama</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                            x-model="name"
                            placeholder="Masukkan nama user"
                            required>
                    </div>
                </div>
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                        <label for="password">Password Baru</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                            placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                            placeholder="Ulangi password baru">
                    </div>
                </div>
                <div class=" w-full">
                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                        <label for="user_role">Role</label>
                        <select 
                            name="role" 
                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" 
                            id="user_role"
                            x-model="role"
                            @change="handleRoleChange">
                            <option value="user">User</option>
                            <option value="premium">Premium User</option>
                        </select>
                    </div>
                </div>
                <div x-show="role === 'premium'" x-cloak class=" w-full grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                        <label for="premium_type">Premium Type</label>
                        <select 
                            name="premium_type" 
                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" 
                            id="premium_type"
                            x-model="premiumType"
                            @change="handlePremiumTypeChange">
                            <option value="" disabled>Pilih Paket Premium</option>
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                            <option value="lifetime">Lifetime</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2 text-sm sm:text-base font-medium">
                        <label for="expired">Expired Date</label>
                        <input 
                            type="date" 
                            name="expired" 
                            id="expired" 
                            class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm"
                            :class="{'opacity-50': premiumType === 'lifetime'}"
                            x-model="expiredDate"
                            x-bind:disabled="premiumType === 'lifetime'">
                        <span x-show="premiumType === 'lifetime'" class="text-sm italic text-gray-500">Unlimited</span>
                    </div>
                </div>

                <script>
                    function editUserPremiumForm() {
                        return {
                            syncedUserId: null,
                            name: '',
                            role: 'user',
                            premiumType: '',
                            expiredDate: '',
                            syncFromEditData(editData) {
                                if (!editData?.id || this.syncedUserId === editData.id) {
                                    return;
                                }

                                this.syncedUserId = editData.id;
                                this.name = editData.name ?? '';
                                this.role = editData.role ?? 'user';
                                this.premiumType = editData.premium_type ?? '';
                                this.expiredDate = editData.expired ?? '';
                            },
                            handlePremiumTypeChange() {
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
                            handleRoleChange() {
                                if (this.role !== 'premium') {
                                    this.premiumType = '';
                                    this.expiredDate = '';
                                }
                            }
                        };
                    }
                </script>
            </div>

            <div class=" pt-4">
                <div class=" px-6 w-full flex justify-end items-center gap-4">
                    <button class="font-bold px-4 py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
