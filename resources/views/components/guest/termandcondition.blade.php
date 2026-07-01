<div x-data="{ open: false }" class="">
    <button @click="open = true" class=" text-sm hover:underline duration-300">
        Syarat dan Ketentuan
    </button>

    <div x-show="open" class="fixed inset-0 z-40 px-4 bg-black bg-opacity-50 flex items-center justify-center">
        <div
            class="bg-white p-6 rounded shadow-lg w-full max-w-[640px] flex flex-col divide-y divide-neutral-600 gap-4 sm:gap-6">
            <div class=" w-full flex items-center gap-2">
                <div class=" w-14 h-14">
                    <svg viewBox="0 0 48 48" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd"
                            d="M37 47H11a4 4 0 0 1-4-4V5a4 4 0 0 1 4-4h19c.32 0 .593.161.776.395l9.829 9.829A.981.981 0 0 1 41 12v31a4 4 0 0 1-4 4zM31 4.381V11h6.619L31 4.381zM39 13h-9a1 1 0 0 1-1-1V3H11a2 2 0 0 0-2 2v38a2 2 0 0 0 2 2h26a2 2 0 0 0 2-2V13zm-6 26H15a1 1 0 1 1 0-2h18a1 1 0 1 1 0 2zm0-8H15a1 1 0 1 1 0-2h18a1 1 0 1 1 0 2zm0-8H15a1 1 0 1 1 0-2h18a1 1 0 1 1 0 2z"
                            fill-rule="evenodd" fill="currenColor" class="fill-000000"></path>
                    </svg>
                </div>
                <div class="">
                    <h2 class="text-xl font-semibold text-black">Syarat dan Ketentuan</h2>
                    <div class=" text-sm sm:text-base text-neutral-600">Tanggal Berlaku: 23 Januari 2025</div>
                </div>
            </div>
            <div class=" text-sm sm:text-base text-neutral-600 pt-6 space-y-4 overflow-auto max-h-96">
                <p>Selamat datang di rekapaja.webz.biz. Dengan mengakses atau menggunakan website ini, Anda setuju untuk terikat
                    oleh Syarat dan Ketentuan berikut. Jika Anda tidak menyetujui, harap hentikan penggunaan website
                    ini.</p>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">1. Pendahuluan</p>
                    <p>
                        Website rekapaja.webz.biz adalah platform online yang memungkinkan pengguna untuk memposting, membeli,
                        dan menjual produk atau jasa secara mandiri.
                        <br>
                        Kami hanya menyediakan sarana teknologi untuk menghubungkan pembeli dan penjual. Kami tidak
                        terlibat dalam transaksi apa pun yang terjadi antara pengguna dan tidak bertanggung jawab atas
                        segala risiko atau akibat dari transaksi tersebut.
                    </p>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">2. Definisi</p>
                    <ul class=" list-disc pl-4">
                        <li>Marketplace: Platform digital yang menghubungkan pengguna untuk membeli dan menjual
                            produk/jasa.</li>
                        <li>Pengguna: Individu atau entitas yang menggunakan platform ini, baik sebagai penjual maupun
                            pembeli.</li>
                        <li>Transaksi: Kegiatan jual-beli yang dilakukan oleh pengguna melalui platform ini.</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">3. Ketentuan Penggunaan Layanan</p>
                    <ul class=" list-disc pl-4">
                        <li>Pengguna setuju untuk menggunakan layanan hanya untuk tujuan yang sah dan sesuai dengan
                            hukum yang berlaku.</li>
                        <li>Website rekapaja.webz.biz hanya berfungsi sebagai perantara dan tidak menjamin kualitas, keaslian,
                            atau kelayakan barang/jasa yang dijual oleh pengguna.</li>
                        <li>Pengguna bertanggung jawab sepenuhnya atas komunikasi, negosiasi, dan pelaksanaan transaksi
                            dengan pihak lain.Transaksi: Kegiatan jual-beli yang dilakukan oleh pengguna melalui
                            platform ini.</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">4. Pendaftaran Akun</p>
                    <ul class=" list-disc pl-4">
                        <li>Untuk menggunakan layanan, pengguna harus membuat akun dengan informasi yang valid.</li>
                        <li>Pengguna bertanggung jawab untuk menjaga kerahasiaan akun mereka dan bertanggung jawab atas
                            semua aktivitas yang dilakukan menggunakan akun tersebut.</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">5. Kebijakan Transaksi</p>
                    <ul class=" list-disc pl-4">
                        <li>Semua transaksi dilakukan langsung antara pembeli dan penjual tanpa keterlibatan kami
                            sebagai penyedia platform.</li>
                        <li>Kami tidak bertanggung jawab atas :</li>
                        <ul class=" list-disc pl-4">
                            <li>Kegagalan pengiriman atau penerimaan barang/jasa.</li>
                            <li>Penipuan, kesalahan, atau perselisihan dalam transaksi.</li>
                            <li>Kerugian atau kerusakan yang timbul akibat transaksi di antara pengguna.</li>
                        </ul>
                        <li>Pengguna diharapkan untuk berhati-hati dan memastikan kepercayaan pihak lain sebelum
                            menyelesaikan transaksi.</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">6. Pembatasan Tanggung Jawab Developer</p>
                    <ul class=" list-disc pl-4">
                        <li>Kami tidak menjamin kualitas, keamanan, atau legalitas barang/jasa yang ditawarkan oleh
                            pengguna lain.</li>
                        <li>Kami tidak bertanggung jawab atas klaim, tuntutan, atau kerugian yang disebabkan oleh
                            transaksi antara pembeli dan penjual.</li>
                        <li>Pengguna setuju untuk melepaskan kami dari segala tuntutan hukum yang terkait dengan
                            aktivitas mereka di platform.</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">7. Kebijakan Pengguna</p>
                    <ul class=" list-disc pl-4">
                        <li>Pengguna dilarang memposting barang atau jasa yang ilegal, melanggar hak pihak ketiga, atau
                            bertentangan dengan kebijakan platform.</li>
                        <li>Kami berhak untuk menghapus konten yang melanggar atau menonaktifkan akun pengguna yang
                            melanggar aturan ini.</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">8. Perubahan Syarat dan Ketentuan</p>
                    <p>Kami dapat mengubah Syarat dan Ketentuan ini kapan saja tanpa pemberitahuan sebelumnya. Perubahan
                        akan diberitahukan melalui platform, dan keberlanjutan penggunaan layanan dianggap sebagai
                        persetujuan terhadap perubahan tersebut.</p>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">9. Hukum yang Berlaku dan Penyelesaian Sengketa</p>
                    <p>Syarat dan Ketentuan ini diatur oleh hukum Republik Indonesia. Segala sengketa akan diselesaikan
                        melalui mediasi atau, jika diperlukan, di pengadilan yang berwenang di [lokasi].</p>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">10. Force Majeure</p>
                    <p>Kami tidak bertanggung jawab atas gangguan layanan yang disebabkan oleh kejadian di luar kendali
                        kami, termasuk tetapi tidak terbatas pada bencana alam, kerusuhan, atau kebijakan pemerintah.
                    </p>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">11. Kontak dan Bantuan</p>
                    <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi kami melalui:</p>
                    <ul class=" list-disc pl-4">
                        <li>Email: support@namamarketplace.com</li>
                        <li>Telepon: +62 812 3456 7890</li>
                    </ul>
                </div>
                <div class=" space-y-2">
                    <p class=" text-black font-semibold text-lg">12. Penerimaan Syarat dan Ketentuan</p>
                    <p>Dengan menggunakan layanan ini, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh
                        Syarat dan Ketentuan yang berlaku.</p>
                    <ul class="">
                        <li>rekapaja.webz.biz</li>
                        <li>[Alamat Perusahaan]</li>
                    </ul>
                </div>
            </div>
            <div class=" pt-6">
                <button @click="open = false" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
