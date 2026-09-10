@php($result = session('generated_vouchers'))
@if ($result && (int) $result['owner_id'] === (int) Auth::id() && in_array(Auth::user()->role, ['admin', 'superadmin']))
    <div x-data="{ open: @js((bool) session('open_generated_vouchers')), launcherVisible: true }" @keydown.escape.window="open = false">
        <div x-cloak x-show="launcherVisible" class="fixed bottom-6 right-6 z-40 flex divide-x divide-white/40 overflow-hidden rounded-md bg-[#ff7100] text-white shadow-lg">
            <button type="button" @click="open = true" aria-label="Buka hasil generate voucher"
                class="px-4 py-3 font-semibold hover:bg-[#b95300]">
                Hasil Voucher ({{ count($result['codes']) }})
            </button>
            <button type="button" @click="launcherVisible = false" aria-label="Sembunyikan tombol hasil voucher" title="Sembunyikan"
                class="flex items-center justify-center px-3 hover:bg-[#b95300]">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m6 6 12 12M6 18 18 6" /></svg>
            </button>
        </div>
        <x-voucher-modal-layout title="Hasil Generate Voucher" title-id="voucher-results-title">
            <p class="text-sm">{{ count($result['codes']) }} voucher berhasil dibuat untuk <span class="font-semibold">{{ $result['product_name'] }}</span>.</p>
            <div class="flex items-center gap-1">
                <h3 class="text-sm font-semibold">Kode Voucher</h3>
                <x-input-tooltip text="Klik Copy di kanan kode untuk menyalinnya. Indikator Tersalin muncul setelah berhasil. Setiap kode hanya bisa digunakan sekali." />
            </div>
            <ul class="divide-y divide-neutral-200 rounded-md border border-[#ff7100]">
                @foreach ($result['codes'] as $code)
                    <li x-data="{
                        copied: false, copying: false, error: '',
                        async copyCode() {
                            this.copying = true;
                            this.error = '';
                            this.copied = false;
                            const code = this.$refs.code.textContent.trim();
                            try {
                                try {
                                    await navigator.clipboard.writeText(code);
                                } catch (clipboardError) {
                                    const input = document.createElement('textarea');
                                    input.value = code;
                                    input.style.position = 'fixed';
                                    input.style.opacity = '0';
                                    input.setAttribute('readonly', '');
                                    document.body.appendChild(input);
                                    try {
                                        input.select();
                                        if (!document.execCommand('copy')) throw new Error('Copy gagal');
                                    } finally {
                                        input.remove();
                                        this.$refs.copyButton.focus();
                                    }
                                }
                                this.copied = true;
                            } catch (error) {
                                this.error = 'Gagal menyalin. Pilih kode dan salin secara manual.';
                            } finally {
                                this.copying = false;
                            }
                        }
                    }" class="px-3 py-3">
                        <div class="flex items-center justify-between gap-3">
                            <code x-ref="code" class="min-w-0 break-all select-all text-sm">{{ $code }}</code>
                            <button x-ref="copyButton" type="button" @click="copyCode()" :disabled="copying"
                                aria-label="Salin kode {{ $code }}"
                                :class="copied ? 'border-green-600 text-green-700 bg-green-50' : 'border-[#ff7100] text-[#ff7100] hover:bg-[#fff1e8]'"
                                class="shrink-0 rounded border px-3 py-2 text-sm font-semibold disabled:opacity-60">
                                <span aria-live="polite" x-text="copying ? 'Menyalin...' : (copied ? '✓ Tersalin' : 'Copy')">Copy</span>
                            </button>
                        </div>
                        <p x-cloak x-show="error" x-text="error" role="alert" class="mt-2 text-xs text-red-600"></p>
                    </li>
                @endforeach
            </ul>
        </x-voucher-modal-layout>
    </div>
@endif
