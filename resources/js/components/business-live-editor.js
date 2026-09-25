import { initializeBusinessGalleries, isBusinessGalleryControl } from './business-galleries';

const editor = document.querySelector('[data-business-live-editor]');

if (editor) {
    const preview = editor.querySelector('[data-business-preview]');
    const status = editor.querySelector('[data-preview-status]');
    const design = document.getElementById('business-design');
    const business = document.getElementById('bussiness');
    let timer;
    let pending;
    let revision = 0;
    const renderPreview = (html) => {
        const fragment = document.createElement('template');
        fragment.innerHTML = html;
        // Fragment scripts are not executed: initialize scoped widgets explicitly below.
        fragment.content.querySelectorAll('script').forEach(script => script.remove());
        preview.querySelectorAll('.swiper').forEach(element => element.swiper?.destroy(true, true));
        window.Alpine.mutateDom(() => {
            window.Alpine.destroyTree(preview);
            preview.replaceChildren(fragment.content);
            window.Alpine.initTree(preview);
        });
        initializeWidgets();
    };

    const initializeWidgets = () => {
        initializeBusinessGalleries(preview);
        window.resizeBannerText?.();
    };

    preview.addEventListener('click', event => {
        const edit = event.target.closest('[data-edit-section]');
        if (edit) {
            event.preventDefault();
            window.dispatchEvent(new CustomEvent('open-business-section', { detail: edit.dataset.editSection }));
            return;
        }
        if (isBusinessGalleryControl(event.target, preview)) {
            event.preventDefault();
            return;
        }
        // Keep storefront actions inside the preview from navigating or placing orders.
        if (event.target.closest('a, button, input, select, textarea, label')) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    }, true);
    preview.addEventListener('submit', event => {
        event.preventDefault();
        event.stopImmediatePropagation();
    }, true);

    const refresh = async (version) => {
        pending = new AbortController();
        const payload = new FormData(design);
        // Business inputs live inside the modals but belong to their own form.
        for (const [name, value] of new FormData(business)) payload.set(name, value);
        for (const name of ['order_title', 'product_title', 'price_prefix']) {
            const field = document.querySelector(`[name="${name}"]`);
            if (field) payload.set(name, field.value);
        }
        payload.delete('_method');
        payload.delete('image_gallery[]');
        // Empty file controls must not override the saved images.
        for (const [name, value] of [...payload]) {
            if (value instanceof File && !value.size) payload.delete(name);
        }
        const background = design.querySelector('[name="bg_type_selector"]:checked');
        if (background) payload.set('bg_type', background.value);
        status.className = 'sr-only';
        status.textContent = 'Memperbarui pratinjau...';
        try {
            const response = await fetch(editor.dataset.previewUrl, {
                method: 'POST',
                body: payload,
                signal: pending.signal,
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });
            if (version !== revision) return;
            if (!response.ok) {
                const error = await response.json().catch(() => ({}));
                const message = Object.values(error.errors || {}).flat()[0];
                throw new Error(message || 'Pratinjau gagal dimuat. Ubah input untuk mencoba kembali.');
            }
            const html = await response.text();
            if (version !== revision) return;
            renderPreview(html);
            status.textContent = 'Pratinjau langsung · Gunakan Simpan untuk menerapkan perubahan konten atau desain.';
        } catch (error) {
            if (error.name !== 'AbortError' && version === revision) {
                status.className = 'bg-white px-4 py-2 text-center text-sm text-red-600';
                status.textContent = error.message;
            }
        }
    };

    const schedule = () => {
        clearTimeout(timer);
        pending?.abort();
        const version = ++revision;
        timer = setTimeout(() => refresh(version), 300);
    };

    const onEdit = (event) => {
        const field = event.target;
        if (!field.matches('input, select, textarea')) return;
        if (field.form !== design && field.form !== business
            && !['order_title', 'product_title', 'price_prefix'].includes(field.name)) return;
        if (field.name === 'header') {
            window.dispatchEvent(new CustomEvent('updateHeaderType', { detail: field.value }));
        }
        schedule();
    };
    document.addEventListener('input', onEdit);
    document.addEventListener('change', onEdit);
    document.getElementById('remove-qris-button')?.addEventListener('click', schedule);
    window.addEventListener('business-gallery-updated', schedule);
    const initialize = () => {
        initializeWidgets();
        // Only validation recovery needs a request on load; normal content is already included by Blade.
        if (editor.dataset.restoreDraft === 'true') schedule();
    };
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize, { once: true });
    else queueMicrotask(initialize);
}
