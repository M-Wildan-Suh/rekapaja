// Keep native inputs (and their IDs) as the source for existing previews/submission.
document.querySelectorAll('[data-template-color]').forEach((field) => {
    const form = field.closest('form');
    if (!form || form.dataset.colorInputsReady) return;
    form.dataset.colorInputsReady = 'true';

    const fields = Array.from(form.querySelectorAll('[data-template-color]')).map((root) => ({
        root,
        picker: root.querySelector('[data-color-picker]'),
        hex: root.querySelector('[data-color-hex]'),
        palette: root.querySelector('[data-color-palette]'),
    }));
    const normalize = (value) => {
        const hex = value.trim().replace(/^#/, '');
        return /^[\da-f]{6}$/i.test(hex) ? `#${hex.toUpperCase()}` : null;
    };

    const refresh = () => {
        const header = form.querySelector('input[name="header"]:checked')?.value;
        const noAbout = ['ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'].includes(header);
        const fixedProduct = ['skincare', 'pudding_putih'].includes(header);
        const colors = [...new Set(fields.map(({ picker }) => picker.value.toUpperCase()))];
        fields.forEach(({ root, picker, hex, palette }) => {
            const reason = noAbout && picker.name.startsWith('desc_')
                ? 'Tidak tersedia: tanpa Tentang Kami'
                : fixedProduct && picker.name.startsWith('product_')
                    ? 'Dikunci oleh preset header' : '';
            picker.disabled = hex.disabled = Boolean(reason);
            picker.style.cursor = reason ? 'not-allowed' : '';
            hex.style.textTransform = reason ? 'none' : '';
            const submitted = root.querySelector('[data-color-submitted]');
            submitted.disabled = !reason;
            submitted.value = picker.value;
            hex.title = reason || 'Kode warna hex';
            if (reason || document.activeElement !== hex) hex.value = reason || picker.value.toUpperCase();
            root.querySelector('[data-color-note]').textContent = reason
                ? `${reason}. Warna tersimpan: ${picker.value.toUpperCase()}` : 'Warna yang digunakan';
            root.style.opacity = reason ? '0.6' : '';
            // Avoid replacing focused palette buttons when only the selected color changed.
            if (palette.dataset.colors !== colors.join(',')) {
                palette.dataset.colors = colors.join(',');
                palette.replaceChildren(...colors.map((color) => {
                    const button = root.querySelector('[data-color-swatch]').content.firstElementChild.cloneNode(true);
                    button.style.backgroundColor = color;
                    button.title = color;
                    button.setAttribute('aria-label', `Gunakan warna ${color}`);
                    button.dataset.color = color;
                    button.addEventListener('click', () => {
                        if (picker.disabled) return;
                        picker.value = color;
                        hex.value = color;
                        picker.dispatchEvent(new Event('input', { bubbles: true }));
                        picker.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                    return button;
                }));
            }
            palette.querySelectorAll('button').forEach((button) => {
                button.disabled = Boolean(reason);
                button.setAttribute('aria-pressed', String(button.dataset.color === picker.value.toUpperCase()));
            });
        });
    };

    fields.forEach(({ picker, hex }) => {
        picker.addEventListener('input', refresh);
        picker.addEventListener('change', refresh);
        hex.addEventListener('input', () => {
            const color = normalize(hex.value);
            hex.setAttribute('aria-invalid', String(!color));
            if (!color) return;
            picker.value = color;
            picker.dispatchEvent(new Event('input', { bubbles: true }));
        });
        hex.addEventListener('blur', () => {
            if (picker.disabled) return;
            hex.value = picker.value.toUpperCase();
            hex.setAttribute('aria-invalid', 'false');
            picker.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });
    // Header presets assign input values programmatically before these events.
    window.addEventListener('updateProductType', refresh);
    window.addEventListener('updateHeaderType', () => queueMicrotask(refresh));
    form.addEventListener('reset', () => setTimeout(refresh, 0));
    refresh();
});
