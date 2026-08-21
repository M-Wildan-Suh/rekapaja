<x-app-layout title="Admin - User">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4">
        <div class="max-w-xl mx-auto">
            <div x-data="auctionTable()"
                class="w-full p-4 sm:p-8 bg-[#F8FAFC] rounded-md shadow-md shadow-black/20 flex flex-col gap-6">
                <!-- Top Actions -->
                <div class="w-full flex flex-col sm:flex-row gap-2 justify-between items-center">
                    <a href="{{ route('user.create') }}"
                        class=" w-full text-sm sm:text-base sm:w-auto px-4 py-2 bg-[#ff7100] text-white rounded-md font-semibold border border-[#ff7100] hover:border-[#b95300] hover:bg-[#b95300] duration-300">
                        Tambah User
                    </a>

                    <!-- Search -->
                    <div class=" w-full sm:w-auto flex flex-row font-semibold duration-300">
                        <input type="text" x-model="search" @input="applySearch()" placeholder="Cari..."
                            class=" w-full text-sm sm:text-base sm:w-auto py-2 px-3 border border-[#ff7100] rounded-md overflow-hidden focus:ring-[#b95300] focus-within:border-[#b95300] font-normal">
                    </div>
                </div>

                <!-- Table -->
                <div class="w-full">
                    <table class="w-full text-sm sm:text-base rounded-md overflow-hidden">
                        <thead>
                            <tr class="h-10 bg-[#ff7100] text-white divide-x-2 divide-white">
                                <th class=" px-1 sm:px-2 py-1">User</th>
                                <th class=" px-1 sm:px-2 py-1">Role</th>
                                <th class=" px-1 sm:px-2 py-1 hidden sm:table-cell">Expired</th>
                                {{-- <th class=" px-1 sm:px-2 py-1">Role</th> --}}
                                <th class=" px-1 sm:px-2 py-1">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in paginatedData" :key="index">
                                <tr :class="index % 2 === 0 ? 'bg-neutral-100' : 'bg-neutral-200'"
                                    class="h-10 text-neutral-600 divide-x-2 divide-white">
                                    <td class="px-2 sm:px-4 py-2">
                                        <div class="flex flex-col text-left">
                                            <span class="font-semibold" x-text="item.name"></span>
                                            <span class="text-xs text-neutral-500" x-text="item.email"></span>
                                        </div>
                                    </td>

                                    <td class="px-2 sm:px-4 py-2 text-nowrap" x-text="item.role"></td>

                                    <td class="px-2 sm:px-4 py-2 text-nowrap hidden sm:table-cell" x-text="item.expired"></td>
                            
                                    <!-- Kolom Role -->
                                    {{-- <td class="px-2 sm:px-4 py-2 text-nowrap">
                                        <form 
                                            :action="`{{ route('user.show', '') }}/${item.id}`" 
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <select 
                                                name="role" 
                                                class="w-full border-gray-300 bg-transparent focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" 
                                                id="user" 
                                                x-bind:value="item.role"
                                                @change="$event.target.closest('form').submit()"
                                            >
                                                <option value="user">User</option>
                                                <option value="premium">Premium User</option>
                                            </select>
                                        </form>
                                    </td> --}}
                            
                                    <!-- Kolom Aksi -->
                                    <td class="px-1 sm:px-2">
                                        <div class="flex gap-2 justify-center">
                                            <div class="">
                                                <button @click="editForm(item)"
                                                    class="w-5 h-5 hover:text-green-500 duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-full h-full"><path fill="currentColor" d="M535.6 85.7C513.7 63.8 478.3 63.8 456.4 85.7L432 110.1L529.9 208L554.3 183.6C576.2 161.7 576.2 126.3 554.3 104.4L535.6 85.7zM236.4 305.7C230.3 311.8 225.6 319.3 222.9 327.6L193.3 416.4C190.4 425 192.7 434.5 199.1 441C205.5 447.5 215 449.7 223.7 446.8L312.5 417.2C320.7 414.5 328.2 409.8 334.4 403.7L496 241.9L398.1 144L236.4 305.7zM160 128C107 128 64 171 64 224L64 480C64 533 107 576 160 576L416 576C469 576 512 533 512 480L512 384C512 366.3 497.7 352 480 352C462.3 352 448 366.3 448 384L448 480C448 497.7 433.7 512 416 512L160 512C142.3 512 128 497.7 128 480L128 224C128 206.3 142.3 192 160 192L256 192C273.7 192 288 177.7 288 160C288 142.3 273.7 128 256 128L160 128z"/></svg>
                                                </button>
                                            </div>
                                            <!-- Tombol Hapus -->
                                            <button 
                                                @click="confirmDelete(item)" 
                                                class="w-5 h-5 hover:text-red-500 duration-300"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-full h-full">
                                                    <path d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z" fill="currentColor"></path><path opacity="0"
                                                        d="M19.5 8.99h-15a.5.5 0 0 0-.5.5v12.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.49a.5.5 0 0 0-.5-.5Zm-9.25 11.5a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0Zm5 0a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0ZM20.922 4.851a11.806 11.806 0 0 0-4.12-1.07 4.945 4.945 0 0 0-9.607 0A12.157 12.157 0 0 0 3.18 4.805 1.943 1.943 0 0 0 2 6.476 1 1 0 0 0 3 7.49h18a1 1 0 0 0 1-.985 1.874 1.874 0 0 0-1.078-1.654ZM11.976 2.01A2.886 2.886 0 0 1 14.6 3.579a44.676 44.676 0 0 0-5.2 0 2.834 2.834 0 0 1 2.576-1.569Z"
                                                        fill="currentColor" class="fill-000000"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>                            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="w-full flex justify-center">
                    <div class="space-y-2">
                        <div class="flex flex-row gap-2 text-neutral-400 font-bold">
                            <!-- Previous button -->
                            <template x-if="currentPage > 1">
                                <div @click="prevPage"
                                    class="w-7 aspect-square flex items-center justify-center rounded-md bg-neutral-300 hover:text-black hover:bg-neutral-400 duration-300">
                                    <div class="w-4">
                                        <svg class="rotate-180 feather feather-chevron-right" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <polyline points="9 18 15 12 9 6" />
                                        </svg>
                                    </div>
                                </div>
                            </template>

                            <!-- Pagination numbers -->
                            <template x-for="page in totalPages" :key="page">
                                <div>
                                    <!-- Current page -->
                                    <template x-if="page === currentPage">
                                        <div class="w-7 aspect-square flex items-center justify-center rounded-md bg-[#ff7100] text-white"
                                            x-text="page"></div>
                                    </template>

                                    <!-- Inactive page -->
                                    <template x-if="page !== currentPage">
                                        <div @click="goToPage(page)"
                                            class="w-7 aspect-square flex items-center justify-center rounded-md bg-neutral-100 hover:text-black hover:bg-neutral-200 duration-300"
                                            x-text="page"></div>
                                    </template>
                                </div>
                            </template>

                            <!-- Next button -->
                            <template x-if="currentPage < totalPages">
                                <div @click="nextPage"
                                    class="w-7 aspect-square flex items-center justify-center rounded-md bg-neutral-300 hover:text-black hover:bg-neutral-400 duration-300">
                                    <div class="w-4">
                                        <svg class="feather feather-chevron-right" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <polyline points="9 18 15 12 9 6" />
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                @include('admin.user.edit')

                <!-- Delete Confirmation Modal -->
                <div x-show="confirmDeleteModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[60] px-4">
                    <div class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-[#ff7100]">
                        <button @click="confirmDeleteModal = false"
                            class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                            <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                enable-background="new 0 0 512 512">
                                <path
                                    d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                                    fill="currentColor" class="fill-000000"></path>
                            </svg>
                        </button>
                        <div class=" pt-6 pb-3 bg-[#ff7100] text-white">
                            <h2 class=" px-6 text-2xl font-bold">Apa anda yakin menghapus data ini?</h2>
                        </div>
                        <p class="px-6 text-base">Anda akan menghapus data : <span x-text="modalData.name"></span></p>
                        <div class="flex justify-end space-x-4 px-6">
                            {{-- <button @click="confirmDeleteModal = false"
                                class="px-4 py-2 bg-neutral-600 duration-300 hover:bg-[#ff7100] text-white rounded">Cancel</button> --}}
                            <form :action="`{{ route('user.destroy', '') }}/${modalData.id}`" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-500 duration-300 hover:bg-red-900 text-white rounded">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <script>
                function auctionTable() {
                    return {
                        data: @json($data), // Fetch data from the backend
                        search: '',
                        currentPage: 1,
                        perPage: 15,
                        showModal: false,
                        confirmDeleteModal: false,
                        editModal: false,
                        editData: {},
                        modalData: {},

                        get paginatedData() {
                            if (this.totalPages === 0) {
                                this.currentPage = 1;
                                return [];
                            }

                            if (this.currentPage > this.totalPages) {
                                this.currentPage = 1;
                            }

                            let start = (this.currentPage - 1) * this.perPage;
                            let end = start + this.perPage;
                            return this.filteredData.slice(start, end);
                        },

                        get filteredData() {
                            if (this.search === '') {
                                return this.data;
                            }
                            const keyword = this.search.toLowerCase();
                            return this.data.filter(item =>
                                (item.name || '').toLowerCase().includes(keyword) ||
                                (item.email || '').toLowerCase().includes(keyword)
                            );
                        },

                        get totalPages() {
                            return Math.ceil(this.filteredData.length / this.perPage); // Menghitung total halaman
                        },

                        nextPage() {
                            if (this.currentPage < this.totalPages) {
                                this.currentPage++;
                            }
                        },

                        prevPage() {
                            if (this.currentPage > 1) {
                                this.currentPage--;
                            }
                        },

                        goToPage(page) {
                            if (page >= 1 && page <= this.totalPages) {
                                this.currentPage = page;
                            }
                        },

                        applySearch() {
                            this.currentPage = 1;
                        },

                        showDetail(item) {
                            this.modalData = item;
                            this.showModal = true;
                        },
                  
                        editForm(item) {
                            this.editData = {
                                ...item,
                                role: item.role ?? 'user',
                                premium_type: item.premium_type ?? '',
                                expired: item.expired ?? ''
                            };
                            this.editModal = true;
                        },

                        confirmDelete(item) {
                            this.modalData = item;
                            this.confirmDeleteModal = true;
                        }
                    }
                }
            </script>
        </div>
        @include('components.guest.footer')
    </div>
</x-app-layout>
