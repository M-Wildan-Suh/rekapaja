@props(['section', 'editing' => false])
@if ($editing)
    <section class="relative w-full" data-editor-section="{{ $section }}">
        <div class="absolute inset-x-0 top-0 z-30 w-full max-w-xl mx-auto">
        <button type="button" data-edit-section="{{ $section }}" aria-label="Edit {{ $section }}"
            class="absolute right-0 top-0 z-20 rounded-bl-[70%] bg-black/50 pl-3 pt-2 pr-2 pb-3 text-white hover:bg-black">
            <svg class="w-5 sm:w-6 aspect-square" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m18.988 2.012 3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287-3-3L8 13z"/><path d="M19 19H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z"/></svg>
        </button>
        </div>
        {{ $slot }}
    </section>
@else
    {{ $slot }}
@endif
