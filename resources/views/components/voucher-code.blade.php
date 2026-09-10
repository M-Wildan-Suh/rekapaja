@props(['code'])
<div x-data="{
    copied: false, busy: false, error: '',
    async copy() {
        this.busy = true; this.copied = false; this.error = '';
        const value = this.$refs.code.textContent.trim();
        try {
            try {
                await navigator.clipboard.writeText(value);
            } catch (clipboardError) {
                const input = document.createElement('textarea');
                input.value = value;
                input.style.cssText = 'position:fixed;opacity:0';
                input.readOnly = true;
                document.body.appendChild(input);
                try {
                    input.select();
                    if (!document.execCommand('copy')) throw new Error('Copy gagal');
                } finally {
                    input.remove();
                    this.$refs.button.focus();
                }
            }
            this.copied = true;
        } catch (error) {
            this.error = 'Gagal menyalin. Silakan salin kode secara manual.';
        } finally { this.busy = false; }
    }
}" class="min-w-0">
    <div class="flex items-center gap-2">
        <code x-ref="code" class="min-w-0 break-all select-all text-xs sm:text-sm">{{ $code }}</code>
        <button x-ref="button" type="button" @click="copy()" :disabled="busy" aria-label="Salin kode {{ $code }}"
            :title="copied ? 'Tersalin' : 'Copy kode'" :class="copied ? 'text-green-600' : 'text-[#ff7100]'"
            class="shrink-0 rounded p-1 hover:bg-orange-50 focus:ring-2 focus:ring-[#ff7100] disabled:opacity-60">
            <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
            <svg x-cloak x-show="copied" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
        </button>
    </div>
    <span x-cloak x-show="copied" role="status" class="text-xs text-green-600">Tersalin</span>
    <p x-cloak x-show="error" x-text="error" role="alert" class="text-xs text-red-600"></p>
</div>
