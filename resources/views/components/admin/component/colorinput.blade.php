@props(['name', 'value', 'label' => null])

<div data-template-color class="space-y-2 min-w-0">
    <input data-color-submitted type="hidden" disabled name="{{ $name }}" value="{{ $value }}">
    <div class="flex items-center gap-3">
        <input data-color-picker type="color" name="{{ $name }}" id="{{ $name }}"
            value="{{ $value }}" aria-label="{{ $label ?? $name }}"
            class="h-11 w-12 shrink-0 cursor-pointer overflow-hidden rounded-lg border border-slate-300 p-0">
        <input data-color-hex type="text" value="{{ strtoupper($value) }}"
            aria-label="Kode hex {{ $label ?? $name }}" maxlength="7" spellcheck="false" autocomplete="off"
            placeholder="#FFFFFF" class="h-11 min-w-0 w-full rounded-lg border-slate-300 font-mono text-sm uppercase text-slate-800 focus:border-blue-500 focus:ring-blue-500">
    </div>
    <p data-color-note class="text-xs font-normal text-slate-500">Warna yang digunakan</p>
    <div data-color-palette class="flex flex-wrap gap-1.5"></div>
    <template data-color-swatch>
        <button type="button" class="h-6 w-6 rounded border border-slate-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"></button>
    </template>
</div>
