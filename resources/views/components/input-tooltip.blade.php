@props(['text'])
<span x-data="{ visible: false, left: 0, top: 0, show() { const rect = this.$refs.trigger.getBoundingClientRect(); this.left = Math.max(8, Math.min(rect.left, window.innerWidth - 264)); this.top = Math.max(8, Math.min(rect.bottom + 8, window.innerHeight - 120)); this.visible = true; } }"
    x-id="['input-help']" @keydown.escape.stop="visible = false" @scroll.window="visible = false" @resize.window="visible = false"
    class="inline-flex items-center font-normal">
    <button x-ref="trigger" type="button" @mouseenter="show()" @mouseleave="visible = false" @focus="show()" @blur="visible = false" @click.stop="show()" @click.outside="visible = false"
        :aria-describedby="$id('input-help')" aria-label="Keterangan input" class="inline-flex h-5 w-5 items-center justify-center rounded-full text-neutral-400 hover:text-[#ff7100] focus:text-[#ff7100] focus:outline-none focus:ring-2 focus:ring-[#ff7100]">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 11v6M12 7h.01"/></svg>
    </button>
    <template x-teleport="body">
        <span x-cloak x-show="visible" :id="$id('input-help')" role="tooltip" :style="{ left: left + 'px', top: top + 'px' }"
            class="pointer-events-none fixed z-[70] w-64 rounded-md bg-neutral-800 px-3 py-2 text-xs font-normal leading-relaxed text-white shadow-lg">{{ $text }}</span>
    </template>
</span>
