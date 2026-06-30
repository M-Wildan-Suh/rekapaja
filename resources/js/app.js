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
