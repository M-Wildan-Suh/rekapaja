<span class="pointer-events-none absolute bottom-1 left-1 right-1 z-10 flex flex-wrap gap-1 text-[10px] leading-tight text-white">
    <span class="inline-flex items-center gap-1 rounded bg-slate-900/90 px-1.5 py-1" title="Header ini tidak menampilkan bagian Tentang Kami">
        <svg aria-hidden="true" class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4zM8 8h8M8 12h8M3 3l18 18"/></svg>
        Tanpa Tentang Kami
    </span>
    @if ($lockedColors)
        <span class="inline-flex items-center gap-1 rounded bg-amber-900/95 px-1.5 py-1" title="Warna produk mengikuti preset header dan tipe produk otomatis Grid 3">
            <svg aria-hidden="true" class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/></svg>
            Warna produk tetap
        </span>
    @endif
</span>
