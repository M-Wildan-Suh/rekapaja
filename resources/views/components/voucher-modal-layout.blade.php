@props(['title', 'titleId', 'action' => null, 'submitLabel' => 'Tutup'])
<div data-voucher-modal x-cloak x-show="open" class="fixed flex items-center justify-center inset-0 z-[60] bg-black bg-opacity-50 px-4 py-6"
    role="dialog" aria-modal="true" aria-labelledby="{{ $titleId }}">
    <form action="{{ $action }}" method="POST" @click.outside="if (!$event.target.closest('.select2-container')) open = false"
        @if (!$action) @submit.prevent="open = false" @endif
        class="relative mx-auto flex max-h-[calc(100vh-3rem)] w-full max-w-[720px] flex-col overflow-hidden rounded-md border-2 border-[#ff7100] bg-white">
        @csrf
        <button type="button" @click="open = false" aria-label="Tutup modal"
            class="absolute top-6 right-6 w-6 h-6 text-white hover:text-red-500 duration-300">
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M437.5 386.6 306.9 256l130.6-130.6c14.1-14.1 14.1-36.8 0-50.9-14.1-14.1-36.8-14.1-50.9 0L256 205.1 125.4 74.5c-14.1-14.1-36.8-14.1-50.9 0-14.1 14.1-14.1 36.8 0 50.9L205.1 256 74.5 386.6c-14.1 14.1-14.1 36.8 0 50.9 14.1 14.1 36.8 14.1 50.9 0L256 306.9l130.6 130.6c14.1 14.1 36.8 14.1 50.9 0 14-14.1 14-36.9 0-50.9z" fill="currentColor" />
            </svg>
        </button>
        <div class="shrink-0 pt-6 pb-3 bg-[#ff7100] text-white">
            <h2 id="{{ $titleId }}" class="pl-6 pr-16 text-2xl font-bold">{{ $title }}</h2>
        </div>
        <div class="min-h-0 overflow-y-auto px-6 py-4 space-y-4">
            {{ $slot }}
        </div>
        <div class="flex shrink-0 flex-wrap justify-end gap-2 border-t border-neutral-200 px-6 py-4">
            <button type="{{ $action ? 'submit' : 'button' }}" @if (!$action) @click="open = false" @endif class="px-4 py-2 bg-[#ff7100] text-white rounded hover:bg-[#b95300] duration-300">{{ $submitLabel }}</button>
        </div>
    </form>
</div>
