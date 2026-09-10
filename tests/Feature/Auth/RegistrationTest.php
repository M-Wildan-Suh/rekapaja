<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Tests\VoucherTestCase;

class RegistrationTest extends VoucherTestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $voucher = $this->voucher();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'voucher' => $voucher->code,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'role' => 'premium', 'premium_type' => 'year']);
        $this->assertNotNull($voucher->fresh()->used_at);
    }

    public function test_registration_requires_a_valid_unused_voucher(): void
    {
        $payload = ['name' => 'Test', 'email' => 'test@example.com', 'password' => 'password', 'password_confirmation' => 'password'];
        $this->post('/register', $payload)->assertSessionHasErrors('voucher');
        $this->post('/register', $payload + ['voucher' => 'INVALID'])->assertSessionHasErrors('voucher');
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_registration_applies_lifetime_and_regular_user_vouchers(): void
    {
        foreach (['premium', 'user'] as $role) {
            $voucher = $this->voucher(['role' => $role, 'premium_type' => $role === 'premium' ? 'lifetime' : null, 'expired' => null]);
            $this->post('/register', [
                'name' => 'Test', 'email' => $role.'@example.com', 'password' => 'password',
                'password_confirmation' => 'password', 'voucher' => $voucher->code,
            ])->assertSessionHasNoErrors()->assertRedirect(RouteServiceProvider::HOME);
            $this->assertDatabaseHas('users', ['email' => $role.'@example.com', 'role' => $role, 'premium_type' => $role === 'premium' ? 'lifetime' : null, 'expired' => null]);
            $this->post('/logout');
        }
    }

    public function test_new_google_account_must_complete_registration_with_voucher(): void
    {
        $googleUser = new \Laravel\Socialite\Two\User;
        $googleUser->map(['id' => 'google-test', 'name' => 'Google Test', 'email' => 'google@example.com']);
        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver->user')->once()->andReturn($googleUser);
        $this->get('/auth/google/callback')->assertRedirect(route('register'));
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }
}
