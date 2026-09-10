<x-app-layout title="Admin - Voucher">
    <x-slot name="header"><h2 class="text-xl font-semibold text-white">Voucher</h2></x-slot>
    <div class="px-4 py-4">
      <div class="mx-auto max-w-xl">
       <div class="w-full p-4 sm:p-8 bg-[#F8FAFC] rounded-md shadow-md shadow-black/20 flex flex-col gap-6">
        
        <div>
            <button type="button" x-data @click="$dispatch('open-voucher', {})" class="rounded-md bg-[#ff7100] px-4 py-2 font-semibold text-white hover:bg-[#b95300]">Tambah Voucher</button>
        </div>
        <div>
                <table class="w-full table-fixed text-sm rounded-md overflow-hidden">
                    <colgroup><col class="w-1/2"><col class="w-1/4"><col class="w-1/4"></colgroup>
                    @forelse ($vouchers->getCollection()->groupBy('product_id') as $businessVouchers)
                    <tbody>
                        <tr>
                            <th colspan="3" scope="rowgroup" class="bg-[#ff7100] text-white px-3 py-2 text-left font-bold break-words border-b-2 border-white text-base">{{ $businessVouchers->first()->product?->name ?? 'Usaha sudah dihapus' }}</th>
                        </tr>
                        <tr class="h-10 bg-[#ff7100] text-white divide-x-2 divide-white">
                            <th scope="col" class="px-2 py-2">Kode</th>
                            <th scope="col" class="px-2 py-2">Status</th>
                            <th scope="col" class="px-2 py-2">Paket</th>
                        </tr>
                        @foreach ($businessVouchers as $voucher)
                            @php($available = !$voucher->used_at && $voucher->product !== null)
                            <tr class="{{ $loop->even ? 'bg-neutral-200' : 'bg-neutral-100' }} divide-x-2 divide-white text-neutral-600">
                                <td class="px-2 py-1 align-middle"><x-voucher-code :code="$voucher->code" /></td>
                                <td class="px-2 py-1 text-center align-middle">
                                    <span aria-label="{{ $available ? 'Tersedia' : 'Tidak' }}" title="{{ $available ? 'Tersedia' : 'Tidak' }}" class="{{ $available ? 'bg-green-600' : 'bg-red-600' }} inline-flex items-center justify-center w-4 aspect-square sm:w-auto sm:aspect-auto sm:px-2 sm:py-1 font-bold rounded-full text-white"><span class="hidden sm:block">{{ $available ? 'Tersedia' : 'Tidak' }}</span></span>
                                </td>
                                <td class="px-2 py-1 text-center align-middle break-words">
                                    <div class="font-semibold">{{ ucfirst($voucher->role) }}</div>
                                    @if ($voucher->role === 'premium')
                                        <div class="text-xs mt-1">{{ ['month' => 'Bulanan', 'year' => 'Tahunan', 'lifetime' => 'Lifetime'][$voucher->premium_type] ?? $voucher->premium_type }}</div>
                                        @if ($voucher->premium_type !== 'lifetime')
                                            <div class="text-xs mt-1">{{ $voucher->expired?->format('d/m/Y') ?? '-' }}</div>
                                        @endif
                                    @else
                                        <div class="text-xs mt-1">-</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @empty
                        <tbody>
                            <tr><td colspan="3" class="bg-white p-4 text-gray-500">Belum ada voucher.</td></tr>
                        </tbody>
                    @endforelse
                </table>
        </div>
        {{ $vouchers->links() }}
       </div>
      </div>
    </div>
    <x-voucher-create-modal :products="$products" />
</x-app-layout>
