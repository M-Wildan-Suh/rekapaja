<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Tests\VoucherTestCase;

class NotificationTest extends VoucherTestCase
{
    public function test_dashboard_shows_flash_and_errors_from_every_validation_bag(): void
    {
        $errors = new ViewErrorBag;
        $errors->put('default', new MessageBag(['name' => 'Nama usaha wajib diisi.']));
        $errors->put('voucherCreate', new MessageBag(['quantity' => 'Jumlah voucher tidak valid.']));
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->withSession(['success' => 'Berhasil disimpan.', 'error' => 'Gagal memproses.', 'errors' => $errors])
            ->get(route('dashboard'))->assertOk()
            ->assertSee('aria-label="Notifikasi"', false)
            ->assertSee('Berhasil disimpan.')->assertSee('Gagal memproses.')
            ->assertSee('Nama usaha wajib diisi.')->assertSee('Jumlah voucher tidak valid.');
    }

    public function test_guest_layout_shows_errors_and_profile_status_is_readable(): void
    {
        $this->withSession(['error' => 'Gagal login dengan Google'])
            ->get(route('login'))->assertOk()->assertSee('Gagal login dengan Google');
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->withSession(['status' => 'profile-updated'])
            ->get(route('dashboard'))->assertOk()->assertSee('Profil berhasil diperbarui.');
    }
}
