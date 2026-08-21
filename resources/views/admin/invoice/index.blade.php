<x-app-layout title="Admin - Rekap">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Rekap') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4">
        <div class="max-w-xl mx-auto">
            <div x-data="auctionTable()"
                class="w-full p-4 sm:p-8 bg-[#F8FAFC] rounded-md shadow-md shadow-black/20 flex flex-col gap-6">
                <!-- Top Actions -->
                <div class="w-full flex flex-col sm:flex-row gap-2 justify-end items-center">

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
                                <th class=" px-1 sm:px-2 py-1">Kode Rekap</th>
                                <th class=" px-1 sm:px-2 py-1">Tanggal</th>
                                <th class=" px-1 sm:px-2 py-1">Status</th>
                                <th class=" px-1 sm:px-2 py-1">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in paginatedData" :key="index">
                                <tr :class="index % 2 === 0 ? 'bg-neutral-100' : 'bg-neutral-200'"
                                    class="h-10 text-neutral-600 divide-x-2 divide-white">
                                    <td class="px-2 sm:px-4 py-2">
                                        <div class="flex flex-col text-xs text-center">
                                            <span class="font-semibold text-neutral-700" x-text="item.invoice_code"></span>
                                            @if (Auth::user()->role === 'admin')
                                                <span class="text-neutral-700" x-text="item.product?.name || '-'"></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-2">
                                        <div class="text-xs flex flex-col text-right">
                                                <span class="font-semibold text-neutral-700" x-text="item.time"></span>
                                                <span class="text-neutral-700 text-nowrap" x-text="item.date"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-2">
                                        <div x-data="{ open: false }" class="relative flex justify-center">
                                            <button type="button" @click="open = !open"
                                                :class="(item.status || 'Pending') === 'Selesai' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'"
                                                class="inline-flex min-w-[110px] items-center justify-between gap-2 rounded-md px-3 py-1 text-sm font-semibold text-white duration-200">
                                                <span x-text="item.status || 'Pending'"></span>
                                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.21 5.23a.75.75 0 0 1 1.06-.02l4.5 4.25a.75.75 0 0 1 0 1.09l-4.5 4.25a.75.75 0 1 1-1.04-1.09L11.17 10 7.23 6.29a.75.75 0 0 1-.02-1.06Z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div x-cloak x-show="open" @click.outside="open = false" x-transition
                                                class="absolute bottom-0 left-full z-20 ml-2 w-20 overflow-hidden rounded-md border border-neutral-200 bg-white shadow-lg">
                                                <form :action="`{{ route('rekap.update', '') }}/${item.id}`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="Pending"
                                                        class="w-full bg-red-600 px-3 py-2 text-left text-sm font-semibold text-white hover:bg-red-700">Pending</button>
                                                </form>
                                                <form :action="`{{ route('rekap.update', '') }}/${item.id}`" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="Selesai"
                                                        class="w-full bg-green-600 px-3 py-2 text-left text-sm font-semibold text-white hover:bg-green-700">Selesai</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" px-1 sm:px-2">
                                        <div class="flex gap-2 justify-center">
                                            <!-- Open rekap page -->
                                            <a :href="'{{ url('/rekap') }}/' + item.invoice_code" title="Buka halaman rekap"
                                                target="_blank" rel="noopener noreferrer"
                                                class="w-5 h-5 hover:text-[#ff7100] duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-full h-full"><path fill="currentcolor" d="M354.4 83.8C359.4 71.8 371.1 64 384 64L544 64C561.7 64 576 78.3 576 96L576 256C576 268.9 568.2 280.6 556.2 285.6C544.2 290.6 530.5 287.8 521.3 278.7L464 221.3L310.6 374.6C298.1 387.1 277.8 387.1 265.3 374.6C252.8 362.1 252.8 341.8 265.3 329.3L418.7 176L361.4 118.6C352.2 109.4 349.5 95.7 354.5 83.7zM64 240C64 195.8 99.8 160 144 160L224 160C241.7 160 256 174.3 256 192C256 209.7 241.7 224 224 224L144 224C135.2 224 128 231.2 128 240L128 496C128 504.8 135.2 512 144 512L400 512C408.8 512 416 504.8 416 496L416 416C416 398.3 430.3 384 448 384C465.7 384 480 398.3 480 416L480 496C480 540.2 444.2 576 400 576L144 576C99.8 576 64 540.2 64 496L64 240z"/></svg>
                                            </a>
                                            <!-- Detail -->
                                            <button @click="showDetail(item)" class="w-5 h-5 hover:text-blue-500 duration-300">
                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-.5 3A1.5 1.5 0 1 1 10 6.5 1.5 1.5 0 0 1 11.5 5ZM14 18h-1a2 2 0 0 1-2-2v-4a1 1 0 0 1 0-2h1a1 1 0 0 1 1 1v5h1a1 1 0 0 1 0 2Z"
                                                        fill="currentColor" class="fill-464646"></path>
                                                </svg>
                                            </button>
                                            <!-- Edit -->
                                            {{-- <a :href="`{{ route('user.show', '') }}/${item.id}`"
                                                class="w-5 h-5 hover:text-green-500 duration-300">
                                                <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3 17.75A3.25 3.25 0 0 0 6.25 21h4.915l.356-1.423c.162-.648.497-1.24.97-1.712l5.902-5.903a3.279 3.279 0 0 1 2.607-.95V6.25A3.25 3.25 0 0 0 17.75 3H11v4.75A3.25 3.25 0 0 1 7.75 11H3v6.75ZM9.5 3.44 3.44 9.5h4.31A1.75 1.75 0 0 0 9.5 7.75V3.44Zm9.6 9.23-5.903 5.902a2.686 2.686 0 0 0-.706 1.247l-.458 1.831a1.087 1.087 0 0 0 1.319 1.318l1.83-.457a2.685 2.685 0 0 0 1.248-.707l5.902-5.902A2.286 2.286 0 0 0 19.1 12.67Z"
                                                        fill="currentColor" class="fill-212121"></path>
                                                </svg>
                                            </a> --}}

                                            <!-- Delete -->
                                            <button @click="confirmDelete(item)"
                                                class="w-5 h-5 hover:text-red-500 duration-300">
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

                <!-- Detail Modal -->
                <div x-show="showModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[60]">
                    <div class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-[#ff7100]">
                        <button @click="showModal = false"
                            class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                            <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                enable-background="new 0 0 512 512">
                                <path
                                    d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                                    fill="currentColor" class="fill-000000"></path>
                            </svg>
                        </button>
                        <div class=" pt-6 pb-3 pl-6 pr-14 bg-[#ff7100] text-white">
                            <h2 class="text-2xl font-bold">Detail Data</h2>
                        </div>
                        <div class=" w-full px-6 space-y-3 max-h-[calc(100vh-200px)] overflow-auto">
                            <div>
                                <p class=" w-full text-lg font-bold">Rekap orderan</p>
                                <div class="mt-3 grid grid-cols-[110px_1fr] items-start gap-x-4 gap-y-3 text-sm">
                                    <p class="font-semibold text-neutral-600">Id Rekap</p>
                                    <p class="text-right" x-text="modalData.invoice_code"></p>
                                    <p class="font-semibold text-neutral-600">Nama Pemesan</p>
                                    <p class="text-right" x-text="modalData.customer_name || '-'"></p>
                                    <p class="font-semibold text-neutral-600">Status</p>
                                    <p class="text-right">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold"
                                        :class="(modalData.status || 'Pending') === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                        x-text="modalData.status || 'Pending'"></span>
                                    </p>
                                    <p class="font-semibold text-neutral-600">Alamat</p>
                                    <p class="whitespace-pre-line text-right" x-text="modalData.customer_address || '-'"></p>
                                </div>
                                <div class="rekap-detail w-full text-sm sm:text-base">
                                    <div x-html="modalData.invoice_text"></div>
                                    <p class=" text-sm text-neutral-600">*Belum termasuk ongkir</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4 px-6">
                            <button @click="showModal = false"
                                class="px-4 py-1.5 bg-red-600 duration-300 hover:bg-red-900 text-white rounded">Tutup</button>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div x-show="confirmDeleteModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[60]">
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
                        <p class="px-6 text-base">Anda akan menghapus data : <span x-text="modalData.invoice_code"></span></p>
                        <div class="flex justify-end space-x-4 px-6">
                            {{-- <button @click="confirmDeleteModal = false"
                                class="px-4 py-2 bg-neutral-600 duration-300 hover:bg-[#ff7100] text-white rounded">Cancel</button> --}}
                            <form :action="`{{ route('rekap.destroy', '') }}/${modalData.id}`" method="POST"
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
                                (item.invoice_code || '').toLowerCase().includes(keyword) ||
                                (item.status || '').toLowerCase().includes(keyword) ||
                                (item.customer_name || '').toLowerCase().includes(keyword) ||
                                (item.customer_address || '').toLowerCase().includes(keyword) ||
                                (item.product?.name || '').toLowerCase().includes(keyword)
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

                        confirmDelete(item) {
                            this.modalData = item;
                            this.confirmDeleteModal = true;
                        }
                    }
                }
            </script>
        </div>
    </div>
</x-app-layout>

<style>
    .rekap-detail > div > p[style*="font-size"] {
        display: inline-block;
        vertical-align: top;
        width: 45%;
    }

    .rekap-detail > div > p[style*="font-size"] + p,
    .rekap-detail > div > p[style*="font-size"] + b {
        display: inline-block;
        vertical-align: top;
        width: 55%;
        text-align: right;
    }
</style>
