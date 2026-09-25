export function isBusinessGalleryControl(target, root) {
    const control = target.closest('[data-business-gallery-control]');
    return Boolean(control && root.contains(control));
}

// Shared by the public landing page and every live-editor render.
export function initializeBusinessGalleries(root = document) {
    if (!window.Swiper) return;
    root.querySelectorAll('[data-business-gallery]').forEach(element => {
        if (element.swiper) {
            element.swiper.update();
            return;
        }
        const network = element.dataset.businessGallery === 'network';
        const container = element.closest('[data-business-gallery-section]') || element.parentElement;
        new window.Swiper(element, {
            observer: true,
            observeParents: true,
            resizeObserver: true,
            slidesPerView: 2,
            spaceBetween: network ? 10 : 16,
            loop: element.querySelectorAll('.swiper-slide').length > 3,
            speed: network ? 600 : 500,
            autoplay: { delay: network ? 3000 : 6000, disableOnInteraction: false },
            breakpoints: { 640: { slidesPerView: network ? 2 : 3, spaceBetween: network ? 12 : 16 } },
            navigation: {
                nextEl: container.querySelector(network ? '.gallery-next' : '.next'),
                prevEl: container.querySelector(network ? '.gallery-prev' : '.prev'),
            },
            pagination: network ? { el: container.querySelector('.gallery-pagination'), clickable: true } : undefined,
        });
    });
}

if (document.readyState === 'complete') initializeBusinessGalleries();
else window.addEventListener('load', () => initializeBusinessGalleries(), { once: true });
