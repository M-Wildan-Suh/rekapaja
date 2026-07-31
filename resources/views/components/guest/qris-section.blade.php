@if (($data->qris_status ?? 'active') === 'active')
    @php
        $qrisUrl = $data->qris ? asset('storage/images/product/qris/' . $data->qris) : null;
    @endphp

    <div class="w-full max-w-[640px] mx-auto px-4 md:px-0 relative">
        <div class="overflow-hidden rounded-3xl border border-emerald-200 bg-white/95 p-5 shadow-lg shadow-emerald-100/70 backdrop-blur-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="space-y-1">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-emerald-600">QRIS</p>
                    <p class="text-xl font-bold text-slate-900">Pembayaran via QRIS</p>
                    <p class="text-sm leading-6 text-slate-600">Scan atau unduh kode QRIS sebelum memilih produk.</p>
                </div>
                @if ($qrisUrl)
                    <a href="{{ $qrisUrl }}" download="qris"
                        class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 hover:bg-emerald-700">
                        Download QRIS
                    </a>
                @endif
            </div>

            <div class="mt-5 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                @if ($qrisUrl)
                    <div class="mx-auto w-full max-w-[260px] overflow-hidden rounded-2xl bg-white p-3 shadow-sm">
                        <img src="{{ $qrisUrl }}" alt="QRIS" class="w-full rounded-xl object-cover">
                    </div>
                @else
                    <p class="text-center text-sm leading-6 text-emerald-900">QRIS belum tersedia untuk usaha ini.</p>
                @endif
            </div>
        </div>
    </div>
@endif
