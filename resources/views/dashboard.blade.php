<x-app-layout title="Admin - Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-4 px-4 space-y-4">
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
        <div class="max-w-xl mx-auto">
            <div x-data="auctionTable()"
                class="w-full p-4 sm:p-8 bg-[#F8FAFC] rounded-md shadow-md shadow-black/20 flex flex-col gap-6">
                <!-- Top Actions -->
                <div class="w-full flex flex-col sm:flex-row gap-2 justify-between items-center">
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('product.create') }}"
                            class=" w-full text-sm sm:text-base sm:w-auto px-4 py-2 bg-[#ff7100] text-white rounded-md font-semibold border border-[#ff7100] hover:border-[#b95300] hover:bg-[#b95300] duration-300">
                            Tambah Usaha
                        </a>
                    @else
                        <div class=" text-xl font-bold">Usaha Anda</div>
                    @endif

                    <!-- Search -->
                    <div class=" w-full sm:w-auto flex flex-row font-semibold duration-300">
                        <input type="text" x-model="search" @input="applySearch()" placeholder="Cari..."
                            class=" w-full text-sm sm:text-base sm:w-auto py-2 px-3 border border-[#ff7100] rounded-md overflow-hidden focus:ring-[#b95300] focus-within:border-[#b95300] font-normal">
                    </div>
                </div>

                @if (Auth::user()->role === 'admin')
                    <!-- WhatsApp Form -->
                    <div class=" w-full">
                        <div class=" flex flex-col gap-2 font-medium">
                            <form action="{{route('no-handphone.store')}}" method="post">
                                @csrf
                                <div class="flex flex-row w-full border border-transparent focus-within:border-[#b95300] focus-within:ring-1 focus-within:ring-[#b95300] rounded-md">
                                    <input type="text" id="no_handphone" name="no_handphone" placeholder="Input Main Phone Number" value="{{$no_tlp}}" class=" text-sm sm:text-base flex-grow rounded-l-md border border-[#ff7100] focus:ring-0 focus:border-none bg-neutral-100">
                                    <button class="py-2 px-3 border border-[#ff7100] bg-[#ff7100] text-white rounded-r hover:bg-[#b95300] hover:border-[#b95300] duration-300 text-sm sm:text-base">Ganti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Table -->
                <div class="w-full">
                    <table class="w-full text-sm sm:text-base rounded-md overflow-hidden">
                        <thead>
                            <tr class="h-10 bg-[#ff7100] text-white divide-x-2 divide-white">
                                <th class=" px-1 sm:px-2 py-1">Nama Usaha</th>
                                <th class=" px-1 sm:px-2 py-1 hidden sm:table-cell">No Tlp</th>
                                <th class=" px-1 sm:px-2 py-1">Status</th>
                                <th class=" px-1 sm:px-2 py-1">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in paginatedData" :key="index">
                                <tr :class="index % 2 === 0 ? 'bg-neutral-100' : 'bg-neutral-200'"
                                    class="h-10 text-neutral-600 divide-x-2 divide-white">
                                    <td class=" px-2 sm:px-4 py-2 text-center font-semibold" x-text="item.name"></td>
                                    <td class=" px-2 sm:px-4 py-2 text-nowrap hidden sm:table-cell" x-text="item.no_tlp"></td>
                                    <td class=" px-2 sm:px-4 py-2 text-nowrap" x-text="item.status"></td>
                                    <td class=" px-1 sm:px-2">
                                        <div class="flex gap-2 justify-center">
                                            <!-- Edit -->
                                            <a :href="`{{ route('product.show', '') }}/${item.id}?return_page=${currentPage}`"
                                                class="w-5 h-5 hover:text-green-500 duration-300">
                                                <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3 17.75A3.25 3.25 0 0 0 6.25 21h4.915l.356-1.423c.162-.648.497-1.24.97-1.712l5.902-5.903a3.279 3.279 0 0 1 2.607-.95V6.25A3.25 3.25 0 0 0 17.75 3H11v4.75A3.25 3.25 0 0 1 7.75 11H3v6.75ZM9.5 3.44 3.44 9.5h4.31A1.75 1.75 0 0 0 9.5 7.75V3.44Zm9.6 9.23-5.903 5.902a2.686 2.686 0 0 0-.706 1.247l-.458 1.831a1.087 1.087 0 0 0 1.319 1.318l1.83-.457a2.685 2.685 0 0 0 1.248-.707l5.902-5.902A2.286 2.286 0 0 0 19.1 12.67Z"
                                                        fill="currentColor" class="fill-212121"></path>
                                                </svg>
                                            </a>

                                            @if (Auth::user()->role === 'admin')
                                                <button type="button" @click="openDomainModal(item)"
                                                    class="w-5 h-5 hover:text-[#16a34a] duration-300">
                                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 16a1 1 0 0 1-.707-.293l-4-4 1.414-1.414L11 12.586V4h2v8.586l2.293-2.293 1.414 1.414-4 4A1 1 0 0 1 12 16Z"
                                                            fill="currentColor"></path>
                                                        <path d="M5 18h14v2H5z" fill="currentColor"></path>
                                                    </svg>
                                                </button>

                                                <!-- Delete -->
                                                <button @click="confirmDelete(item)"
                                                    class="w-5 h-5 hover:text-red-500 duration-300">
                                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M19.5 8.99h-15a.5.5 0 0 0-.5.5v12.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.49a.5.5 0 0 0-.5-.5Zm-9.25 11.5a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0Zm5 0a.75.75 0 0 1-1.5 0v-8.625a.75.75 0 0 1 1.5 0ZM20.922 4.851a11.806 11.806 0 0 0-4.12-1.07 4.945 4.945 0 0 0-9.607 0A12.157 12.157 0 0 0 3.18 4.805 1.943 1.943 0 0 0 2 6.476 1 1 0 0 0 3 7.49h18a1 1 0 0 0 1-.985 1.874 1.874 0 0 0-1.078-1.654ZM11.976 2.01A2.886 2.886 0 0 1 14.6 3.579a44.676 44.676 0 0 0-5.2 0 2.834 2.834 0 0 1 2.576-1.569Z"
                                                            fill="currentColor" class="fill-000000"></path>
                                                    </svg>
                                                </button>
                                            @endif
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

                <!-- Delete Confirmation Modal -->
                <div x-show="confirmDeleteModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40 px-4">
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
                            <form :action="`{{ route('product.destroy', '') }}/${modalData.id}`" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-500 duration-300 hover:bg-red-900 text-white rounded">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @php
                    $cpanelConfigured = filled(config('services.cpanel.base_url'))
                        && filled(config('services.cpanel.username'))
                        && filled(config('services.cpanel.api_token'))
                        && filled(config('services.cpanel.parent_domain'))
                        && filled(config('services.cpanel.home_directory'));
                    $cpanelParentDomain = config('services.cpanel.parent_domain', 'rekapaja.com');
                @endphp
                <div x-show="domainModalOpen"
                    class="fixed flex inset-0 z-40 bg-black bg-opacity-50 px-4 py-20 pb-6">
                    <div @click.outside="closeDomainModal()" class="relative mx-auto flex max-h-[calc(100vh-3rem)] w-full max-w-[720px] flex-col overflow-hidden rounded-md border-2 border-[#ff7100] bg-white">
                        <button @click="closeDomainModal()"
                            class=" absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
                            <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                enable-background="new 0 0 512 512">
                                <path
                                    d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z"
                                    fill="currentColor" class="fill-000000"></path>
                            </svg>
                        </button>
                        <div class=" pt-6 pb-3 bg-[#ff7100] text-white">
                            <h2 class=" px-6 text-2xl font-bold">Atur Domain Usaha</h2>
                        </div>
                        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                            <p class="text-base">Domain untuk <span class="font-semibold" x-text="modalData.name"></span></p>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold">Jenis Domain</label>
                                <div class="grid gap-2 sm:grid-cols-2">
                                    <label class="flex items-start gap-3 rounded-md border border-[#ff7100]/30 px-3 py-3 text-sm">
                                        <input type="radio" x-model="domainTypeForm" value="custom" @change="handleDomainTypeChange()" class="mt-1 border-[#ff7100] text-[#ff7100] focus:ring-[#b95300]">
                                        <span>
                                            <span class="block font-semibold text-neutral-800">Domain Custom</span>
                                            <span class="block text-xs text-neutral-500">Contoh `tokoanda.com` atau `https://tokoanda.com`.</span>
                                        </span>
                                    </label>
                                    <label class="flex items-start gap-3 rounded-md border border-[#ff7100]/30 px-3 py-3 text-sm">
                                        <input type="radio" x-model="domainTypeForm" value="subdomain" @change="handleDomainTypeChange()" class="mt-1 border-[#ff7100] text-[#ff7100] focus:ring-[#b95300]">
                                        <span>
                                            <span class="block font-semibold text-neutral-800">Subdomain RekapAja</span>
                                            <span class="block text-xs text-neutral-500">Contoh `namatoko` untuk `.{{ $cpanelParentDomain }}`.</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div x-show="domainTypeForm === 'custom'" class="space-y-2">
                                <label for="product-domain" class="text-sm font-semibold">Domain Custom</label>
                                <input id="product-domain" type="text" x-model="domainForm"
                                    placeholder="contoh: tokoanda.com"
                                    class="w-full rounded-md border border-[#ff7100] px-3 py-2 text-sm focus:border-[#b95300] focus:ring-[#b95300]">
                                <p class="text-xs text-neutral-500">Isi domain tujuan yang ingin dipakai untuk usaha ini.</p>
                            </div>
                            <div x-show="domainTypeForm === 'subdomain'" class="space-y-2">
                                <label for="product-subdomain" class="text-sm font-semibold">Subdomain RekapAja</label>
                                <div class="flex items-center rounded-md border border-[#ff7100] focus-within:border-[#b95300] focus-within:ring-1 focus-within:ring-[#b95300]">
                                    <input id="product-subdomain" type="text" x-model="domainForm"
                                        placeholder="namatoko"
                                        class="w-full border-0 px-3 py-2 text-sm focus:ring-0">
                                    <span class="border-l border-[#ff7100]/30 px-3 text-sm text-neutral-500">.{{ $cpanelParentDomain }}</span>
                                </div>
                                <p class="text-xs text-neutral-500">Isi nama subdomain saja. Sistem akan membuat `https://nama.{{ $cpanelParentDomain }}`.</p>
                            </div>
                            <div x-show="domainTypeForm === 'subdomain'" class="space-y-3 rounded-md border border-neutral-200 bg-neutral-50 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-800">Isi Folder Subdomain</p>
                                        <p class="text-xs text-neutral-500" x-text="folderPath || 'Folder akan terbaca dari home directory cPanel.'"></p>
                                    </div>
                                    <button type="button" @click="fetchSubdomainFiles()"
                                        :disabled="folderLoading || !domainForm.trim()"
                                        class="px-3 py-2 text-xs font-semibold text-[#ff7100] border border-[#ff7100] rounded hover:bg-[#fff1e8] disabled:opacity-60">
                                        <span x-show="!folderLoading">Refresh</span>
                                        <span x-show="folderLoading">Memuat...</span>
                                    </button>
                                </div>
                                <p x-show="folderMessage" x-text="folderMessage" class="text-xs text-neutral-500"></p>
                                <div x-show="folderEntries.length > 0" class="max-h-52 overflow-y-auto rounded-md border border-neutral-200 bg-white">
                                    <template x-for="entry in folderEntries" :key="`${entry.type}-${entry.name}`">
                                        <div class="flex items-center justify-between gap-3 border-b border-neutral-100 px-3 py-2 text-sm last:border-b-0">
                                            <div class="min-w-0">
                                                <p class="truncate font-medium text-neutral-800" x-text="entry.name"></p>
                                                <p class="text-xs text-neutral-500" x-text="entry.type === 'dir' ? 'Folder' : 'File'"></p>
                                            </div>
                                            <div class="text-right text-xs text-neutral-500">
                                                <p x-text="entry.size || '-'"></p>
                                                <p x-text="entry.modified_at || ''"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <p x-show="!folderLoading && !folderEntries.length && !folderMessage" class="text-xs text-neutral-500">Belum ada file yang terbaca di folder ini.</p>
                            </div>
                            <p x-show="domainError" x-text="domainError" class="text-sm text-red-500"></p>
                            @unless ($cpanelConfigured)
                                <p class="text-sm text-amber-600">Konfigurasi cPanel belum lengkap di `.env`, jadi opsi upload domain belum bisa dipakai.</p>
                            @endunless
                        </div>
                        <div class="flex flex-col-reverse gap-3 border-t border-neutral-200 px-6 py-4 sm:flex-row sm:justify-end">
                            <button type="button" @click="downloadBasicFor(modalData)"
                                class="px-4 py-2 border border-[#ff7100] text-[#ff7100] rounded hover:bg-[#fff1e8]">
                                Download biasa
                            </button>
                            <button type="button" @click="saveDomain()"
                                :disabled="domainLoading"
                                class="px-4 py-2 bg-neutral-200 text-neutral-800 rounded hover:bg-neutral-300 disabled:opacity-60">
                                <span x-show="!domainLoading">Simpan</span>
                                <span x-show="domainLoading">Menyimpan...</span>
                            </button>
                            <button type="button" @click="submitDomainAction()"
                                :disabled="domainLoading"
                                class="px-4 py-2 bg-[#ff7100] text-white rounded hover:bg-[#b95300] disabled:opacity-60">
                                <span x-show="!domainLoading" x-text="domainTypeForm === 'subdomain' ? 'Upload ke .{{ $cpanelParentDomain }}' : 'Simpan domain custom'"></span>
                                <span x-show="domainLoading">Memproses...</span>
                            </button>
                        </div>
                    </div>
                </div>
                <iframe x-ref="downloadFrame" class="hidden" title="download-frame"></iframe>

            </div>
            <script>
                function auctionTable() {
                    return {
                        data: @json($data), // Fetch data from the backend
                        search: '',
                        currentPage: {{ max((int) request('return_page', 1), 1) }},
                        perPage: 15,
                        showModal: false,
                        confirmDeleteModal: false,
                        domainModalOpen: false,
                        domainLoading: false,
                        domainError: '',
                        domainTypeForm: 'custom',
                        domainForm: '',
                        folderLoading: false,
                        folderPath: '',
                        folderMessage: '',
                        folderEntries: [],
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
                            return this.data.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()));
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

                        downloadBasicFor(item) {
                            const downloadUrl = `{{ route('product.download-domain', '') }}/${item.id}?t=${Date.now()}`;
                            this.$refs.downloadFrame.src = downloadUrl;
                        },

                        showDetail(item) {
                            this.modalData = item;
                            this.showModal = true;
                        },

                        confirmDelete(item) {
                            this.modalData = item;
                            this.confirmDeleteModal = true;
                        },

                        inferDomainType(domain) {
                            if (!domain) {
                                return 'custom';
                            }

                            try {
                                const normalized = /^https?:\/\//i.test(domain) ? domain : `https://${domain}`;
                                const hostname = new URL(normalized).hostname.toLowerCase();
                                const suffix = '.{{ $cpanelParentDomain }}';

                                return hostname.endsWith(suffix) ? 'subdomain' : 'custom';
                            } catch (error) {
                                return 'custom';
                            }
                        },

                        extractDomainInputValue(domain) {
                            if (!domain) {
                                return '';
                            }

                            if (this.inferDomainType(domain) !== 'subdomain') {
                                return domain;
                            }

                            try {
                                const normalized = /^https?:\/\//i.test(domain) ? domain : `https://${domain}`;
                                const hostname = new URL(normalized).hostname.toLowerCase();
                                const suffix = '.{{ $cpanelParentDomain }}';

                                return hostname.endsWith(suffix) ? hostname.slice(0, -suffix.length) : domain;
                            } catch (error) {
                                return domain;
                            }
                        },

                        buildDomainValueForSaving() {
                            const value = this.domainForm.trim();

                            if (!value) {
                                return '';
                            }

                            if (this.domainTypeForm === 'subdomain') {
                                return `https://${value.toLowerCase()}.{{ $cpanelParentDomain }}`;
                            }

                            return value;
                        },

                        async fetchSubdomainFiles() {
                            const subdomain = this.domainForm.trim();

                            this.folderLoading = true;
                            this.folderMessage = '';
                            this.folderEntries = [];

                            if (!subdomain) {
                                this.folderLoading = false;
                                this.folderPath = '';
                                this.folderMessage = 'Isi subdomain dulu untuk melihat foldernya.';
                                return;
                            }

                            const query = new URLSearchParams({ subdomain });
                            const response = await fetch(`{{ route('product.domain-folder', '') }}/${this.modalData.id}?${query.toString()}`, {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                },
                            });

                            const result = await response.json().catch(() => ({}));

                            if (!response.ok) {
                                this.folderLoading = false;
                                this.folderPath = '';
                                this.folderMessage = result.message || 'Gagal membaca isi folder subdomain.';
                                return;
                            }

                            this.folderPath = result.path ?? '';
                            this.folderEntries = Array.isArray(result.entries) ? result.entries : [];
                            this.folderMessage = this.folderEntries.length
                                ? ''
                                : (result.message || 'Folder berhasil dibaca, belum ada file di dalamnya.');
                            this.folderLoading = false;
                        },

                        async handleDomainTypeChange() {
                            this.folderPath = '';
                            this.folderMessage = '';
                            this.folderEntries = [];

                            if (this.domainTypeForm === 'subdomain' && this.domainForm.trim()) {
                                await this.fetchSubdomainFiles();
                            }
                        },

                        openDomainModal(item) {
                            this.modalData = item;
                            const existingDomain = item.domain ?? '';
                            const inferredType = existingDomain ? this.inferDomainType(existingDomain) : 'subdomain';

                            this.domainTypeForm = inferredType;
                            this.domainForm = inferredType === 'subdomain'
                                ? (this.inferDomainType(existingDomain) === 'subdomain'
                                    ? this.extractDomainInputValue(existingDomain)
                                    : (item.slug || ''))
                                : (existingDomain ? this.extractDomainInputValue(existingDomain) : '');
                            this.folderPath = '';
                            this.folderMessage = '';
                            this.folderEntries = [];
                            this.domainError = '';
                            this.domainModalOpen = true;

                            if (this.domainTypeForm === 'subdomain' && this.domainForm.trim()) {
                                this.fetchSubdomainFiles();
                            }
                        },

                        closeDomainModal() {
                            this.domainModalOpen = false;
                            this.domainLoading = false;
                            this.folderLoading = false;
                            this.domainError = '';
                        },

                        async submitDomainAction() {
                            await this.uploadToCpanel();
                        },

                        async persistDomain() {
                            this.domainLoading = true;
                            this.domainError = '';

                            const formData = new FormData();
                            formData.append('_method', 'PUT');
                            formData.append('domain', this.buildDomainValueForSaving());

                            const response = await fetch(`{{ route('product.domain', '') }}/${this.modalData.id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            });

                            const result = await response.json().catch(() => ({}));

                            if (!response.ok) {
                                throw new Error(result.message || result.errors?.domain?.[0] || 'Gagal menyimpan domain.');
                            }

                            this.modalData.domain = result.domain ?? '';
                            this.data = this.data.map(item => item.id === this.modalData.id
                                ? { ...item, domain: this.modalData.domain }
                                : item
                            );
                        },

                        async saveDomain() {
                            try {
                                await this.persistDomain();
                                this.closeDomainModal();
                            } catch (error) {
                                this.domainError = error.message;
                                this.domainLoading = false;
                            }
                        },

                        async uploadToCpanel() {
                            try {
                                if (this.domainTypeForm !== 'subdomain') {
                                    await this.persistDomain();
                                    this.closeDomainModal();
                                    return;
                                }

                                await this.persistDomain();
                                this.domainLoading = true;

                                const formData = new FormData();
                                formData.append('subdomain', this.domainForm.trim());

                                const response = await fetch(`{{ route('product.upload-domain', '') }}/${this.modalData.id}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                    },
                                    body: formData,
                                });

                                const result = await response.json().catch(() => ({}));

                                if (!response.ok) {
                                    throw new Error(result.message || 'Gagal upload ke cPanel.');
                                }

                                this.modalData.domain = result.domain ?? '';
                                this.domainTypeForm = 'subdomain';
                                this.domainForm = this.extractDomainInputValue(this.modalData.domain);
                                await this.fetchSubdomainFiles();
                                this.folderMessage = result.message || this.folderMessage;
                                this.data = this.data.map(item => item.id === this.modalData.id
                                    ? { ...item, domain: this.modalData.domain }
                                    : item
                                );
                                this.domainLoading = false;
                            } catch (error) {
                                this.domainError = error.message;
                                this.domainLoading = false;
                            }
                        }
                    }
                }
            </script>
        </div>
    </div>
    @include('components.guest.footer')
    {{-- <div class="py-4 px-4">
        <div class="max-w-[1080px] mx-auto">
            <div class=" w-full p-4 sm:p-8 bg-[#F8FAFC] rounded-md shadow-md shadow-black/20 flex flex-col gap-6">
                <p class=" font-black text-lg">Keuntungan akun Premium</p>

            </div>
        </div>
    </div> --}}
</x-app-layout>
