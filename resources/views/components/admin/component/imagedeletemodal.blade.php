<div x-data="{ showModal: false }" class="">
    <button @click="showModal = true" 
            class="text-sm w-full py-2 rounded-md bg-[#db2a24] text-white font-semibold hover:bg-black duration-300">
        Hapus
    </button>
    <div x-show="showModal" 
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 px-4" 
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="transition ease-in duration-300" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0">
        
        <div @click.outside="showModal = false" class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Konfirmasi Penghapusan</h2>
            <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menghapus gambar yang dipilih?</p>
            <div class="flex justify-end">
                <button @click="showModal = false" 
                        class="bg-black text-white py-2 px-4 rounded-md hover:bg-gray-400 mr-2 duration-300">
                    Batal
                </button>
                <button @click="document.getElementById('galleryForm').submit()" 
                        class="bg-[#db2a24] text-white py-2 px-4 rounded-md hover:bg-black duration-300">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>