@if (filled($data->embed) || ($editorPreview ?? false))
    <x-guest.editor-section section="youtube" :editing="$editorPreview ?? false">
    <div class=" w-full px-4">
        <div class=" w-full max-w-xl mx-auto">
            <div class=" w-full bg-white aspect-video rounded-md overflow-hidden">
                @if (filled($data->embed))
                <iframe class="w-full h-full" src="{{$data->embed}}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                @else
                    <div data-youtube-placeholder class="flex h-full w-full flex-col items-center justify-center gap-3 bg-gray-900 text-white opacity-30">
                        <svg class="h-12 w-12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                        <p class="text-sm font-semibold">Tambahkan link video YouTube</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </x-guest.editor-section>
@endif
