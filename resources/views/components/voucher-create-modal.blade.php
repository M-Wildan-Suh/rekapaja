@props(['products', 'fromBusiness' => false])
<div x-data="{
    open: @js($errors->voucherCreate->any()),
    productId: @js((string) old('product_id', '')),
    role: @js(old('role', 'user')),
    premiumType: @js(old('premium_type', 'month'))
}" @open-voucher.window="productId = String($event.detail.productId || ''); open = true"
    @keydown.escape.window="open = false">
    <x-voucher-modal-layout title="Tambah Voucher" title-id="voucher-modal-title" :action="route('voucher.store')" submit-label="Generate Voucher">
            
            @if ($fromBusiness)
                <input type="hidden" name="product_id" :value="productId">
            @else
                <x-admin.component.accessinput title="Usaha Asal" name="product_id" :users="$products"
                    :value="old('product_id', '')" placeholder="Pilih usaha" search-placeholder="Cari usaha"
                    :show-id="true" data-voucher-business />
            @endif
            <div class="text-sm font-semibold">
                <div class="flex items-center gap-1">
                    <label for="voucher-quantity">Jumlah Voucher</label>
                    <x-input-tooltip text="Kode dibuat otomatis. Maksimal 100 voucher dalam satu proses. Setiap voucher hanya bisa dipakai sekali." />
                </div>
                <input id="voucher-quantity" type="number" name="quantity" value="{{ old('quantity', 1) }}" required min="1" max="100" step="1" class="mt-1 w-full rounded-md border border-[#ff7100] px-3 py-2 text-sm focus:border-[#b95300] focus:ring-[#b95300]">
            </div>
            <div class="text-sm font-semibold">
                <div class="flex items-center gap-1">
                    <label for="voucher-role">Tipe User</label>
                    <x-input-tooltip text="Saat register, premium mengikuti voucher dan berlaku sampai tanggal yang dipilih, atau selamanya untuk Lifetime." />
                </div>
                <select id="voucher-role" name="role" x-model="role" class="mt-1 w-full rounded-md border border-[#ff7100] px-3 py-2 text-sm focus:border-[#b95300] focus:ring-[#b95300]">
                    <option value="user">User</option>
                    <option value="premium">Premium</option>
                </select>
            </div>
            <div x-show="role === 'premium'" class="space-y-4">
                <label class="block text-sm font-semibold">Tipe Premium
                    <select name="premium_type" x-model="premiumType" :disabled="role !== 'premium'" class="mt-1 w-full rounded-md border border-[#ff7100] px-3 py-2 text-sm focus:border-[#b95300] focus:ring-[#b95300]">
                        <option value="month">Bulanan</option>
                        <option value="year">Tahunan</option>
                        <option value="lifetime">Lifetime</option>
                    </select>
                </label>
                <label x-show="premiumType !== 'lifetime'" class="block text-sm font-semibold">Premium Berakhir Pada
                    <input type="date" name="expired" value="{{ old('expired') }}" :required="role === 'premium' && premiumType !== 'lifetime'" :disabled="role !== 'premium' || premiumType === 'lifetime'" class="mt-1 w-full rounded-md border border-[#ff7100] px-3 py-2 text-sm focus:border-[#b95300] focus:ring-[#b95300]">
                </label>
            </div>
    </x-voucher-modal-layout>
</div>
