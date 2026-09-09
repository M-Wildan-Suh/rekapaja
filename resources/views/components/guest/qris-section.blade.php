@if (filled($data->qris) && ($data->qris_status ?? 'active') === 'active')
    @php
        $qrisUrl = $data->qris ? asset('storage/images/product/qris/' . $data->qris) : null;
        $qrisBackground = in_array(($template->head_type ?? null), ['skincare', 'pudding_putih'], true)
            ? '#FFFFFF'
            : ($template->product_main_color ?: '#FFFFFF');
        $qrisText = $template->desc_text_color ?: '#0F172A';
        $qrisaccent = $template->accent_color ?: '#0F172A';
    @endphp

    <div x-data="{}" class="w-full max-w-[600px] mx-auto px-4 md:px-0 relative">
        <div class="overflow-hidden rounded-[2rem] p-5 shadow-lg backdrop-blur-sm"
            style="background-color: {{ $qrisBackground }}; color: {{ $qrisText }};">
            <div class="flex flex-col gap-4 sm:flex-row items-center sm:justify-between">
                <div class="">
                    <p class="text-xs font-bold uppercase tracking-[0.24em]" style="color: {{ $qrisaccent }}">QRIS</p>
                    <p class="text-xl font-bold">Pembayaran via QRIS</p>
                </div>
                @if ($qrisUrl)
                    <div class="flex items-center gap-2">
                        <button type="button" @click="$refs.qrisDialog.showModal()" aria-haspopup="dialog"
                            style="background-color: {{ $qrisaccent }}; color: {{ $qrisBackground }};"
                            class="inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold transition duration-300 hover:opacity-80">
                            Lihat
                        </button>
                        <a href="{{ $qrisUrl }}" download="qris"
                            style="background-color: {{ $qrisaccent }}; color: {{ $qrisBackground }};"
                            class="inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold transition duration-300 hover:opacity-80">
                            Download
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if ($qrisUrl)
            <dialog x-ref="qrisDialog" aria-label="QRIS {{ $data->name }}"
                @click="if ($event.target === $el && ($event.clientX < $el.getBoundingClientRect().left || $event.clientX > $el.getBoundingClientRect().right || $event.clientY < $el.getBoundingClientRect().top || $event.clientY > $el.getBoundingClientRect().bottom)) $el.close()"
                class="qris-preview-dialog rounded-[2rem] p-5 shadow-lg"
                style="margin: auto; width: calc(100% - 2rem); max-width: 420px; max-height: 90vh; overflow-y: auto; background-color: {{ $qrisBackground }}; color: {{ $qrisText }};">
                <div class="flex items-center justify-between gap-4">
                    <p class="text-xl font-bold">QRIS {{ $data->name }}</p>
                    <button type="button" autofocus @click="$refs.qrisDialog.close()" aria-label="Tutup modal QRIS"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-2xl hover:opacity-80"
                        style="flex-shrink: 0; background-color: {{ $qrisText }}; color: {{ $qrisBackground }};">&times;</button>
                </div>
                <div class="mt-5 rounded-2xl bg-white p-3">
                    <img src="{{ $qrisUrl }}" alt="Kode QRIS {{ $data->name }}" class="w-full" style="height: auto; object-fit: contain;">
                </div>
            </dialog>
            <style>
                .qris-preview-dialog::backdrop { background: rgba(0, 0, 0, 0.65); }
            </style>
        @endif
    </div>
@endif
