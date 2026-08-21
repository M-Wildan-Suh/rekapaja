<x-app-layout title="Admin - Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4 space-y-4">
        <div class="max-w-xl mx-auto">
            @if (Auth::user()->role === 'admin')
                <div class="font-bold text-base sm:text-lg w-full py-2 bg-[#ff7100] text-white rounded-md text-center">
                    Anda adalah Admin</div>
            @elseif (Auth::user()->role === 'premium')
                <div
                    class="font-bold text-base sm:text-lg w-full py-2 bg-[#ff7100] text-white rounded-md flex justify-center text-center gap-2">
                    @if (Auth::user()->premium_type === 'lifetime' ||
                            Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired)))
                        <p>Premium Aktif,</p>
                        <p>Expired :</p>
                        <p>{{ Auth::user()->expired ?? 'Lifetime' }}</p>
                    @else
                        <p>Premium Unaktif,</p>
                        <p>Expired :</p>
                        <p>{{ Auth::user()->expired ?? 'Lifetime' }}</p>
                    @endif
                </div>
            @else
                <a href="{{ route('join') }}">
                    <button
                        class=" font-bold text-base sm:text-lg w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Dapatkan
                        Akun Premium</button>
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
                            <form action="{{ route('no-handphone.store') }}" method="post">
                                @csrf
                                <div
                                    class="flex flex-row w-full border border-transparent focus-within:border-[#b95300] focus-within:ring-1 focus-within:ring-[#b95300] rounded-md">
                                    <input type="text" id="no_handphone" name="no_handphone"
                                        placeholder="Input Main Phone Number" value="{{ $no_tlp }}"
                                        class=" text-sm sm:text-base flex-grow rounded-l-md border border-[#ff7100] focus:ring-0 focus:border-none bg-neutral-100">
                                    <button
                                        class="py-2 px-3 border border-[#ff7100] bg-[#ff7100] text-white rounded-r hover:bg-[#b95300] hover:border-[#b95300] duration-300 text-sm sm:text-base">Ganti</button>
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
                                    <td class=" px-2 sm:px-4 py-2 text-nowrap hidden sm:table-cell"
                                        x-text="item.no_tlp"></td>
                                    <td class=" px-2 sm:px-4 py-2 text-nowrap" x-text="item.status"></td>
                                    <td class=" px-1 sm:px-2">
                                        <div class="flex gap-2 justify-center">
                                            <!-- Edit -->
                                            <a :href="`{{ route('product.show', '') }}/${item.id}?return_page=${currentPage}`"
                                                class="w-5 h-5 hover:text-green-500 duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-full h-full"><path fill="currentColor" d="M535.6 85.7C513.7 63.8 478.3 63.8 456.4 85.7L432 110.1L529.9 208L554.3 183.6C576.2 161.7 576.2 126.3 554.3 104.4L535.6 85.7zM236.4 305.7C230.3 311.8 225.6 319.3 222.9 327.6L193.3 416.4C190.4 425 192.7 434.5 199.1 441C205.5 447.5 215 449.7 223.7 446.8L312.5 417.2C320.7 414.5 328.2 409.8 334.4 403.7L496 241.9L398.1 144L236.4 305.7zM160 128C107 128 64 171 64 224L64 480C64 533 107 576 160 576L416 576C469 576 512 533 512 480L512 384C512 366.3 497.7 352 480 352C462.3 352 448 366.3 448 384L448 480C448 497.7 433.7 512 416 512L160 512C142.3 512 128 497.7 128 480L128 224C128 206.3 142.3 192 160 192L256 192C273.7 192 288 177.7 288 160C288 142.3 273.7 128 256 128L160 128z"/></svg>
                                            </a>

                                            @if (Auth::user()->role === 'admin')
                                                <button type="button" @click="openDomainModal(item)"
                                                    class="w-5 h-5 hover:text-[#16a34a] duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                                        class="w-full h-full">
                                                        <path fill="currentColor"
                                                            d="M352 173.3L352 384C352 401.7 337.7 416 320 416C302.3 416 288 401.7 288 384L288 173.3L246.6 214.7C234.1 227.2 213.8 227.2 201.3 214.7C188.8 202.2 188.8 181.9 201.3 169.4L297.3 73.4C309.8 60.9 330.1 60.9 342.6 73.4L438.6 169.4C451.1 181.9 451.1 202.2 438.6 214.7C426.1 227.2 405.8 227.2 393.3 214.7L352 173.3zM320 464C364.2 464 400 428.2 400 384L480 384C515.3 384 544 412.7 544 448L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 448C96 412.7 124.7 384 160 384L240 384C240 428.2 275.8 464 320 464zM464 488C477.3 488 488 477.3 488 464C488 450.7 477.3 440 464 440C450.7 440 440 450.7 440 464C440 477.3 450.7 488 464 488z" />
                                                    </svg>
                                                </button>

                                                <!-- Delete -->
                                                <button @click="confirmDelete(item)"
                                                    class="w-5 h-5 hover:text-red-500 duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                                                        class="w-full h-full">
                                                        <path fill="currentColor"
                                                            d="M232.7 69.9L224 96L128 96C110.3 96 96 110.3 96 128C96 145.7 110.3 160 128 160L512 160C529.7 160 544 145.7 544 128C544 110.3 529.7 96 512 96L416 96L407.3 69.9C402.9 56.8 390.7 48 376.9 48L263.1 48C249.3 48 237.1 56.8 232.7 69.9zM512 208L128 208L149.1 531.1C150.7 556.4 171.7 576 197 576L443 576C468.3 576 489.3 556.4 490.9 531.1L512 208z" />
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
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[60] px-4">
                    <div
                        class="w-full max-w-[720px] bg-white pb-6 rounded-md flex flex-col gap-4 relative overflow-hidden border-2 border-[#ff7100]">
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
                    $cpanelConfigured =
                        filled(config('services.cpanel.base_url')) &&
                        filled(config('services.cpanel.username')) &&
                        filled(config('services.cpanel.api_token')) &&
                        filled(config('services.cpanel.parent_domain')) &&
                        filled(config('services.cpanel.home_directory'));
                    $cpanelParentDomain = config('services.cpanel.parent_domain', 'rekapaja.com');
                @endphp
                <div x-show="domainModalOpen" class="fixed flex inset-0 z-[60] bg-black bg-opacity-50 px-4 py-20 pb-6">
                    <div @click.outside="closeDomainModal()"
                        class="relative mx-auto flex max-h-[calc(100vh-3rem)] w-full max-w-[720px] flex-col overflow-hidden rounded-md border-2 border-[#ff7100] bg-white">
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
                            <p class="text-base">Domain untuk <span class="font-semibold"
                                    x-text="modalData.name"></span></p>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold">Jenis Domain</label>
                                <div class="grid gap-2 sm:grid-cols-2">
                                    <label
                                        class="flex items-start gap-3 rounded-md border border-[#ff7100]/30 px-3 py-3 text-sm">
                                        <input type="radio" x-model="domainTypeForm" value="custom"
                                            @change="handleDomainTypeChange()"
                                            class="mt-1 border-[#ff7100] text-[#ff7100] focus:ring-[#b95300]">
                                        <span>
                                            <span class="block font-semibold text-neutral-800">Domain Custom</span>
                                            <span class="block text-xs text-neutral-500">Contoh `tokoanda.com` atau
                                                `https://tokoanda.com`.</span>
                                        </span>
                                    </label>
                                    <label
                                        class="flex items-start gap-3 rounded-md border border-[#ff7100]/30 px-3 py-3 text-sm">
                                        <input type="radio" x-model="domainTypeForm" value="subdomain"
                                            @change="handleDomainTypeChange()"
                                            class="mt-1 border-[#ff7100] text-[#ff7100] focus:ring-[#b95300]">
                                        <span>
                                            <span class="block font-semibold text-neutral-800">Subdomain
                                                RekapAja</span>
                                            <span class="block text-xs text-neutral-500">Contoh `namatoko` untuk
                                                `.{{ $cpanelParentDomain }}`.</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div x-show="domainTypeForm === 'custom'" class="space-y-2">
                                <label for="product-domain" class="text-sm font-semibold">Domain Custom</label>
                                <input id="product-domain" type="text" x-model="domainForm"
                                    placeholder="contoh: tokoanda.com"
                                    class="w-full rounded-md border border-[#ff7100] px-3 py-2 text-sm focus:border-[#b95300] focus:ring-[#b95300]">
                                <p class="text-xs text-neutral-500">Isi domain tujuan yang ingin dipakai untuk usaha
                                    ini. Saat di-upload, sistem akan mencoba mendaftarkan domain sebagai addon domain di
                                    cPanel lalu mengunggah file website, `sitemap.xml`, dan `robots.txt`.</p>
                                <p class="text-xs text-amber-600">Pastikan DNS domain sudah diarahkan ke server hosting
                                    ini agar website bisa diakses publik.</p>
                            </div>
                            <div x-show="domainTypeForm === 'subdomain'" class="space-y-2">
                                <label for="product-subdomain" class="text-sm font-semibold">Subdomain
                                    RekapAja</label>
                                <div
                                    class="flex items-center rounded-md border border-[#ff7100] focus-within:border-[#b95300] focus-within:ring-1 focus-within:ring-[#b95300]">
                                    <input id="product-subdomain" type="text" x-model="domainForm"
                                        placeholder="namatoko" class="w-full border-0 px-3 py-2 text-sm focus:ring-0">
                                    <span
                                        class="border-l border-[#ff7100]/30 px-3 text-sm text-neutral-500">.{{ $cpanelParentDomain }}</span>
                                </div>
                                <p class="text-xs text-neutral-500">Isi nama subdomain saja. Sistem akan membuat
                                    `https://nama.{{ $cpanelParentDomain }}`.</p>
                            </div>
                            <div class="space-y-3 rounded-md border border-neutral-200 bg-neutral-50 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-800"
                                            x-text="domainTypeForm === 'subdomain' ? 'Isi Folder Subdomain' : 'Isi Folder Custom Domain'">
                                        </p>
                                        <p class="text-xs text-neutral-500"
                                            x-text="folderPath || 'Folder akan terbaca dari home directory cPanel.'">
                                        </p>
                                    </div>
                                    <button type="button" @click="fetchDomainFiles()"
                                        :disabled="folderLoading || !domainForm.trim()"
                                        class="px-3 py-2 text-xs font-semibold text-[#ff7100] border border-[#ff7100] rounded hover:bg-[#fff1e8] disabled:opacity-60">
                                        <span x-show="!folderLoading">Refresh</span>
                                        <span x-show="folderLoading">Memuat...</span>
                                    </button>
                                </div>
                                <p x-show="folderMessage" x-text="folderMessage" class="text-xs text-neutral-500">
                                </p>
                                <div x-show="folderEntries.length > 0"
                                    class="max-h-52 overflow-y-auto rounded-md border border-neutral-200 bg-white">
                                    <template x-for="entry in folderEntries" :key="`${entry.type}-${entry.name}`">
                                        <div
                                            class="flex items-center justify-between gap-3 border-b border-neutral-100 px-3 py-2 text-sm last:border-b-0">
                                            <div class="min-w-0">
                                                <p class="truncate font-medium text-neutral-800" x-text="entry.name">
                                                </p>
                                                <p class="text-xs text-neutral-500"
                                                    x-text="entry.type === 'dir' ? 'Folder' : 'File'"></p>
                                            </div>
                                            <div class="text-right text-xs text-neutral-500">
                                                <p x-text="entry.size || '-'"></p>
                                                <p x-text="entry.modified_at || ''"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <p x-show="!folderLoading && !folderEntries.length && !folderMessage"
                                    class="text-xs text-neutral-500">Belum ada file yang terbaca di folder ini.</p>
                            </div>
                            <p x-show="domainError" x-text="domainError" class="text-sm text-red-500"></p>
                            @unless ($cpanelConfigured)
                                <p class="text-sm text-amber-600">Konfigurasi cPanel belum lengkap di `.env`, jadi opsi
                                    upload domain belum bisa dipakai.</p>
                            @endunless
                        </div>
                        <div
                            class="flex flex-col-reverse gap-3 border-t border-neutral-200 px-6 py-4 sm:flex-row sm:justify-end">
                            <button type="button" @click="downloadBasicFor(modalData)"
                                class="px-4 py-2 border border-[#ff7100] text-[#ff7100] rounded hover:bg-[#fff1e8]">
                                Download biasa
                            </button>
                            <button type="button" @click="uploadSeoFiles()" :disabled="domainLoading"
                                class="px-4 py-2 border border-[#ff7100] text-[#ff7100] rounded hover:bg-[#fff1e8] disabled:opacity-60">
                                <span x-show="!domainLoading">Upload Sitemap SEO</span>
                                <span x-show="domainLoading">Mengunggah...</span>
                            </button>
                            <button type="button" @click="saveDomain()" :disabled="domainLoading"
                                class="px-4 py-2 bg-neutral-200 text-neutral-800 rounded hover:bg-neutral-300 disabled:opacity-60">
                                <span x-show="!domainLoading">Simpan</span>
                                <span x-show="domainLoading">Menyimpan...</span>
                            </button>
                            <button type="button" @click="submitDomainAction()" :disabled="domainLoading"
                                class="px-4 py-2 bg-[#ff7100] text-white rounded hover:bg-[#b95300] disabled:opacity-60">
                                <span x-show="!domainLoading"
                                    x-text="domainTypeForm === 'subdomain' ? 'Upload ke .{{ $cpanelParentDomain }}' : 'Buat & Upload Custom Domain'"></span>
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

                        async fetchDomainFiles() {
                            const value = this.domainForm.trim();

                            this.folderLoading = true;
                            this.folderMessage = '';
                            this.folderEntries = [];

                            if (!value) {
                                this.folderLoading = false;
                                this.folderPath = '';
                                this.folderMessage = this.domainTypeForm === 'subdomain' ?
                                    'Isi subdomain dulu untuk melihat foldernya.' :
                                    'Isi custom domain dulu untuk melihat foldernya.';
                                return;
                            }

                            const query = new URLSearchParams({
                                type: this.domainTypeForm,
                                ...(this.domainTypeForm === 'subdomain' ?
                                    {
                                        subdomain: value
                                    } :
                                    {
                                        domain: value
                                    }),
                            });
                            const response = await fetch(
                                `{{ route('product.domain-folder', '') }}/${this.modalData.id}?${query.toString()}`, {
                                    method: 'GET',
                                    headers: {
                                        'Accept': 'application/json',
                                    },
                                });

                            const result = await response.json().catch(() => ({}));

                            if (!response.ok) {
                                this.folderLoading = false;
                                this.folderPath = '';
                                this.folderMessage = result.message || 'Gagal membaca isi folder domain.';
                                return;
                            }

                            this.folderPath = result.path ?? '';
                            this.folderEntries = Array.isArray(result.entries) ? result.entries : [];
                            this.folderMessage = this.folderEntries.length ?
                                '' :
                                (result.message || 'Folder berhasil dibaca, belum ada file di dalamnya.');
                            this.folderLoading = false;
                        },

                        async handleDomainTypeChange() {
                            this.folderPath = '';
                            this.folderMessage = '';
                            this.folderEntries = [];

                            if (this.domainForm.trim()) {
                                await this.fetchDomainFiles();
                            }
                        },

                        openDomainModal(item) {
                            this.modalData = item;
                            const existingDomain = item.domain ?? '';
                            const inferredType = existingDomain ? this.inferDomainType(existingDomain) : 'subdomain';

                            this.domainTypeForm = inferredType;
                            this.domainForm = inferredType === 'subdomain' ?
                                (this.inferDomainType(existingDomain) === 'subdomain' ?
                                    this.extractDomainInputValue(existingDomain) :
                                    (item.slug || '')) :
                                (existingDomain ? this.extractDomainInputValue(existingDomain) : '');
                            this.folderPath = '';
                            this.folderMessage = '';
                            this.folderEntries = [];
                            this.domainError = '';
                            this.domainModalOpen = true;

                            if (this.domainForm.trim()) {
                                this.fetchDomainFiles();
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
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value ||
                                        '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            });

                            const result = await response.json().catch(() => ({}));

                            if (!response.ok) {
                                throw new Error(result.message || result.errors?.domain?.[0] || 'Gagal menyimpan domain.');
                            }

                            this.modalData.domain = result.domain ?? '';
                            this.data = this.data.map(item => item.id === this.modalData.id ?
                                {
                                    ...item,
                                    domain: this.modalData.domain
                                } :
                                item
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
                                if (this.domainTypeForm === 'custom') {
                                    await this.persistDomain();
                                    this.domainLoading = true;

                                    const formData = new FormData();
                                    formData.append('domain', this.buildDomainValueForSaving());

                                    const response = await fetch(
                                        `{{ route('product.upload-custom-domain', '') }}/${this.modalData.id}`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value ||
                                                    '{{ csrf_token() }}',
                                                'Accept': 'application/json',
                                            },
                                            body: formData,
                                        });

                                    const result = await response.json().catch(() => ({}));

                                    if (!response.ok) {
                                        throw new Error(result.message || 'Gagal membuat custom domain di cPanel.');
                                    }

                                    this.modalData.domain = result.domain ?? this.modalData.domain;
                                    this.domainForm = this.extractDomainInputValue(this.modalData.domain);
                                    this.data = this.data.map(item => item.id === this.modalData.id ?
                                        {
                                            ...item,
                                            domain: this.modalData.domain
                                        } :
                                        item
                                    );
                                    await this.fetchDomainFiles();
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
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value ||
                                            '{{ csrf_token() }}',
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
                                await this.fetchDomainFiles();
                                this.folderMessage = result.message || this.folderMessage;
                                this.data = this.data.map(item => item.id === this.modalData.id ?
                                    {
                                        ...item,
                                        domain: this.modalData.domain
                                    } :
                                    item
                                );
                                this.domainLoading = false;
                            } catch (error) {
                                this.domainError = error.message;
                                this.domainLoading = false;
                            }
                        },

                        async uploadSeoFiles() {
                            try {
                                await this.persistDomain();
                                this.domainLoading = true;
                                this.domainError = '';

                                const formData = new FormData();
                                if (this.domainTypeForm === 'subdomain') {
                                    formData.append('subdomain', this.domainForm.trim());
                                } else {
                                    formData.append('domain', this.buildDomainValueForSaving());
                                }

                                const response = await fetch(
                                    `${this.domainTypeForm === 'subdomain'
                                    ? `{{ route('product.upload-domain-sitemap', '') }}`
                                    : `{{ route('product.upload-custom-domain-sitemap', '') }}`}/${this.modalData.id}`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value ||
                                                '{{ csrf_token() }}',
                                            'Accept': 'application/json',
                                        },
                                        body: formData,
                                    });

                                const result = await response.json().catch(() => ({}));

                                if (!response.ok) {
                                    throw new Error(result.message || 'Gagal upload sitemap ke cPanel.');
                                }

                                this.modalData.domain = result.domain ?? this.modalData.domain;
                                this.domainForm = this.extractDomainInputValue(this.modalData.domain);
                                await this.fetchDomainFiles();
                                this.folderMessage = result.message || this.folderMessage;
                                this.data = this.data.map(item => item.id === this.modalData.id ?
                                    {
                                        ...item,
                                        domain: this.modalData.domain
                                    } :
                                    item
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
