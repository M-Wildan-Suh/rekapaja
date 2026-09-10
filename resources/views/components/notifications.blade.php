@php
    $notifications = [];
    foreach (['success', 'error', 'info', 'warning'] as $type) {
        if (is_string(session($type)) && session($type) !== '') {
            $notifications[] = ['type' => $type, 'message' => session($type)];
        }
    }
    if (is_string(session('status')) && session('status') !== '') {
        $notifications[] = ['type' => 'success', 'message' => [
            'profile-updated' => 'Profil berhasil diperbarui.',
            'password-updated' => 'Password berhasil diperbarui.',
            'verification-link-sent' => 'Link verifikasi baru sudah dikirim ke email Anda.',
        ][session('status')] ?? session('status')];
    }
    $validationMessages = [];
    foreach ($errors->getBags() as $bag) {
        $validationMessages = array_merge($validationMessages, $bag->all());
    }
    foreach (array_unique($validationMessages) as $message) {
        $notifications[] = ['type' => 'error', 'message' => $message];
    }
@endphp
<div x-data="{
    messages: @js($notifications),
    add(detail) {
        if (!detail || !detail.message) return;
        this.messages.push({ type: detail.type || 'info', message: String(detail.message) });
    }
}" @notify.window="add($event.detail)"
    class="pointer-events-none fixed top-24 right-4 z-[80] flex max-h-[calc(100vh-7rem)] w-[calc(100%-2rem)] max-w-sm flex-col gap-3 overflow-y-auto sm:right-6"
    aria-label="Notifikasi">
    <template x-for="(item, index) in messages" :key="index">
        <div x-show="!item.dismissed" class="pointer-events-auto rounded-xl border px-4 py-3 text-sm shadow-lg"
            :class="item.type === 'error' ? 'border-red-200 bg-red-50 text-red-700' : (item.type === 'success' ? 'border-green-200 bg-green-50 text-green-700' : 'border-orange-200 bg-orange-50 text-orange-800')"
            :role="item.type === 'error' ? 'alert' : 'status'">
            <div class="flex items-start gap-3">
                <p class="min-w-0 flex-1 break-words font-medium" x-text="item.message"></p>
                <button type="button" @click="item.dismissed = true" aria-label="Tutup notifikasi" class="shrink-0 text-lg leading-5 hover:opacity-70">&times;</button>
            </div>
        </div>
    </template>
</div>
