<div x-data="{ youtubeOpen: false }"
    @open-business-section.window="if ($event.detail === 'youtube') youtubeOpen = true"
    @keydown.escape.window="youtubeOpen = false">
    <div x-cloak x-show="youtubeOpen" role="dialog" aria-modal="true" aria-labelledby="youtube-editor-title"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 px-4"
        @click.self="youtubeOpen = false">
        <div class="w-full max-w-[720px] overflow-hidden rounded-md border-2 border-byolink-1 bg-white text-gray-900">
            <div class="flex items-center justify-between bg-byolink-1 px-6 py-4 text-white">
                <h2 id="youtube-editor-title" class="text-2xl font-bold">Edit YouTube</h2>
                <button type="button" @click="youtubeOpen = false" aria-label="Tutup modal YouTube" class="text-2xl">&times;</button>
            </div>
            <div class="space-y-4 p-6">
                <div class="flex flex-col gap-2">
                    <label for="link" class="font-semibold">Link YouTube (Opsional)</label>
                    <input id="link" name="link" form="bussiness" type="text" maxlength="255"
                        value="{{ old('link', $product->youtube) }}" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full rounded-md border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100]">
                    <p class="text-sm text-gray-500">Kosongkan link untuk menyembunyikan video di halaman usaha.</p>
                    @error('link') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" form="bussiness" class="rounded-md bg-[#ff7100] px-4 py-2 font-semibold text-white">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
