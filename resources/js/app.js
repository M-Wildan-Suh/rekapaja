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

const bannerClampTargets = () => Array.from(document.querySelectorAll(
    '.banner-clamp-safe [class*="line-clamp-"]:not(.banner-clamp-description)'
));

const clampLineCount = (element) => {
    const className = Array.from(element.classList).find((name) => /^line-clamp-\d+$/.test(name));

    return className ? Number(className.replace('line-clamp-', '')) : 1;
};

const measureBannerClamp = (element, fontSize) => {
    const styles = window.getComputedStyle(element);
    const clone = element.cloneNode(true);

    clone.classList.remove('line-clamp-1', 'line-clamp-2', 'line-clamp-3', 'line-clamp-4');
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
        -webkit-line-clamp: unset !important;
        -webkit-box-orient: initial !important;
        font-size: ${fontSize}px !important;
    `;

    document.body.appendChild(clone);
    const height = clone.getBoundingClientRect().height;
    clone.remove();

    const baseFontSize = Number.parseFloat(styles.fontSize) || fontSize;
    const baseLineHeight = Number.parseFloat(styles.lineHeight) || baseFontSize * 1.2;
    const lineHeight = (baseLineHeight / baseFontSize) * fontSize;

    return height <= (lineHeight * clampLineCount(element)) + 1;
};

const fitBannerClamp = (element) => {
    if (!element.clientWidth || !element.textContent.trim()) {
        return;
    }

    const currentInlineSize = element.style.fontSize;
    element.style.fontSize = '';
    const baseSize = Number.parseFloat(window.getComputedStyle(element).fontSize);
    element.style.fontSize = currentInlineSize;

    if (!baseSize) {
        return;
    }

    const minimumSize = baseSize * 0.72;
    let low = minimumSize;
    let high = baseSize;

    if (measureBannerClamp(element, high)) {
        element.style.fontSize = '';
        return;
    }

    for (let index = 0; index < 7; index += 1) {
        const candidate = (low + high) / 2;

        if (measureBannerClamp(element, candidate)) {
            low = candidate;
        } else {
            high = candidate;
        }
    }

    element.style.fontSize = `${low.toFixed(2)}px`;
};

const initialiseBannerClampAutoResize = () => {
    const targets = bannerClampTargets();

    if (!targets.length) {
        return;
    }

    const fitAll = () => targets.forEach(fitBannerClamp);
    const observer = new ResizeObserver(() => window.requestAnimationFrame(fitAll));

    targets.forEach((target) => observer.observe(target));
    fitAll();
};

initialiseBannerClampAutoResize();
