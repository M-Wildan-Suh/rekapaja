import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);

window.Alpine = Alpine;

Alpine.start();

const loadingOverlay = document.getElementById('page-loading-overlay');

const showPageLoader = () => {
    if (!loadingOverlay) {
        return;
    }

    loadingOverlay.classList.add('is-active');
    loadingOverlay.setAttribute('aria-hidden', 'false');
};

const hidePageLoader = () => {
    if (!loadingOverlay) {
        return;
    }

    loadingOverlay.classList.remove('is-active');
    loadingOverlay.setAttribute('aria-hidden', 'true');
};

const shouldHandleAnchor = (anchor) => {
    if (!anchor || !anchor.href) {
        return false;
    }

    if (anchor.target && anchor.target !== '_self') {
        return false;
    }

    if (anchor.hasAttribute('download')) {
        return false;
    }

    if (anchor.hasAttribute('data-no-loader')) {
        return false;
    }

    if (anchor.getAttribute('href')?.startsWith('#') || anchor.getAttribute('href')?.startsWith('javascript:')) {
        return false;
    }

    if (anchor.origin !== window.location.origin) {
        return false;
    }

    if (anchor.pathname === window.location.pathname && anchor.search === window.location.search) {
        return false;
    }

    return true;
};

document.addEventListener('click', (event) => {
    const anchor = event.target.closest('a');

    if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
        return;
    }

    if (!shouldHandleAnchor(anchor)) {
        return;
    }

    showPageLoader();
});

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement) || event.defaultPrevented) {
        return;
    }

    const formTarget = form.getAttribute('target');
    if (formTarget && formTarget !== '_self') {
        return;
    }

    showPageLoader();
});

window.addEventListener('pageshow', hidePageLoader);
window.addEventListener('load', hidePageLoader);

const bannerAutoResizeTargets = () => Array.from(document.querySelectorAll(
    '.banner-auto-resize [data-auto-resize-text]'
));

const autoResizeLineCount = (element) => Math.max(1, Number(element.dataset.autoResizeLines) || 1);

const measureBannerText = (element, fontSize) => {
    const styles = window.getComputedStyle(element);
    const clone = element.cloneNode(true);

    clone.style.cssText += `
        position: fixed !important;
        visibility: hidden !important;
        pointer-events: none !important;
        left: -9999px !important;
        top: 0 !important;
        display: block !important;
        width: ${element.clientWidth}px !important;
        max-width: none !important;
        height: auto !important;
        min-height: 0 !important;
        overflow: visible !important;
        font-size: ${fontSize}px !important;
    `;

    document.body.appendChild(clone);
    const height = clone.getBoundingClientRect().height;
    clone.remove();

    const baseFontSize = Number.parseFloat(styles.fontSize) || fontSize;
    const baseLineHeight = Number.parseFloat(styles.lineHeight) || baseFontSize * 1.2;
    const lineHeight = (baseLineHeight / baseFontSize) * fontSize;

    return height <= (lineHeight * autoResizeLineCount(element)) + 1;
};

const fitBannerText = (element) => {
    if (!element.clientWidth || !element.textContent.trim()) {
        return;
    }

    // Kata panjang tanpa spasi tetap dapat ditampilkan utuh saat ukuran minimum tercapai.
    element.style.overflowWrap = 'anywhere';
    const currentInlineSize = element.style.fontSize;
    element.style.fontSize = '';
    const baseSize = Number.parseFloat(window.getComputedStyle(element).fontSize);
    element.style.fontSize = currentInlineSize;

    if (!baseSize) {
        return;
    }

    // Tetap terbaca pada banner kecil, namun tidak pernah lebih kecil dari 8px.
    const minimumSize = Math.max(8, baseSize * 0.6);
    let low = minimumSize;
    let high = baseSize;

    if (measureBannerText(element, high)) {
        element.style.fontSize = '';
        return;
    }

    for (let index = 0; index < 7; index += 1) {
        const candidate = (low + high) / 2;

        if (measureBannerText(element, candidate)) {
            low = candidate;
        } else {
            high = candidate;
        }
    }

    element.style.fontSize = `${low.toFixed(2)}px`;
};

const initialiseBannerTextAutoResize = () => {
    let frameId;
    const fitAll = () => {
        frameId = undefined;
        bannerAutoResizeTargets().forEach(fitBannerText);
    };
    const scheduleFit = () => {
        if (!frameId) {
            frameId = window.requestAnimationFrame(fitAll);
        }
    };

    const resizeObserver = new ResizeObserver(scheduleFit);
    document.querySelectorAll('.banner-auto-resize').forEach((banner) => resizeObserver.observe(banner));
    window.addEventListener('resize', scheduleFit);
    const contentObserver = new MutationObserver((mutations) => {
        const bannerContentChanged = mutations.some((mutation) => {
            const target = mutation.target.nodeType === Node.ELEMENT_NODE
                ? mutation.target
                : mutation.target.parentElement;

            return target?.closest('.banner-auto-resize')
                || Array.from(mutation.addedNodes).some((node) => node.nodeType === Node.ELEMENT_NODE
                    && node.matches?.('.banner-auto-resize, .banner-auto-resize *'));
        });

        if (bannerContentChanged) {
            scheduleFit();
        }
    });
    contentObserver.observe(document.body, {
        childList: true,
        characterData: true,
        subtree: true,
    });
    scheduleFit();

    // Dapat dipanggil kembali setelah konten banner diubah lewat JavaScript.
    window.resizeBannerText = scheduleFit;
};

initialiseBannerTextAutoResize();
