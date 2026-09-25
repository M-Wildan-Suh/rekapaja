import test from 'node:test';
import assert from 'node:assert/strict';

globalThis.document = { readyState: 'loading' };
globalThis.window = { addEventListener() {} };
const { initializeBusinessGalleries, isBusinessGalleryControl } = await import('../../resources/js/components/business-galleries.js');

test('gallery controls are allowed only inside the live preview', () => {
    const control = {};
    const target = { closest: () => control };
    assert.equal(isBusinessGalleryControl(target, { contains: () => true }), true);
    assert.equal(isBusinessGalleryControl(target, { contains: () => false }), false);
    assert.equal(isBusinessGalleryControl({ closest: () => null }, { contains: () => true }), false);
});

test('network gallery finds pagination outside the slider parent and updates existing instances', () => {
    const controls = { '.gallery-next': {}, '.gallery-prev': {}, '.gallery-pagination': {} };
    const section = { querySelector: selector => controls[selector] };
    let options;
    let created = 0;
    let updated = 0;
    const element = {
        dataset: { businessGallery: 'network' },
        closest: () => section,
        querySelectorAll: () => Array(5).fill({}),
    };
    window.Swiper = class {
        constructor(node, settings) {
            created++;
            options = settings;
            node.swiper = this;
        }
        update() { updated++; }
    };
    const root = { querySelectorAll: () => [element] };
    initializeBusinessGalleries(root);
    assert.equal(options.navigation.nextEl, controls['.gallery-next']);
    assert.equal(options.pagination.el, controls['.gallery-pagination']);
    assert.equal(options.observer, true);
    assert.equal(options.observeParents, true);
    assert.equal(options.resizeObserver, true);
    initializeBusinessGalleries(root);
    assert.equal(created, 1);
    assert.equal(updated, 1);
});
