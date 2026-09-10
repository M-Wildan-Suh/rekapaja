<?php

namespace Tests\Feature;

use App\Models\Access;
use App\Models\User;
use App\Services\VoucherService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\VoucherTestCase;

class VoucherTest extends VoucherTestCase
{
    public function test_bulk_generation_uses_automatic_unique_codes_and_displays_results(): void
    {
        $voucher = $this->voucher();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->from(route('dashboard'))->post(route('voucher.store'), [
            'product_id' => $voucher->product_id, 'quantity' => 3, 'code' => 'MANUAL-CODE',
            'role' => 'premium', 'premium_type' => 'lifetime',
        ])->assertRedirect(route('dashboard'))->assertSessionHas('open_generated_vouchers', true);

        $result = session('generated_vouchers');
        $this->assertCount(3, $result['codes']);
        $this->assertCount(3, array_unique($result['codes']));
        $this->assertDatabaseCount('vouchers', 4);
        foreach ($result['codes'] as $code) {
            $this->assertNotSame('MANUAL-CODE', $code);
            $this->assertMatchesRegularExpression('/^RKPJ-[A-Z0-9]{16}$/', $code);
            $this->assertDatabaseHas('vouchers', ['code' => $code, 'product_id' => $voucher->product_id, 'role' => 'premium', 'premium_type' => 'lifetime']);
        }
        $this->get(route('dashboard'))->assertOk()->assertSee('Hasil Generate Voucher')->assertSee($result['codes'][0]);
        $this->get(route('dashboard'))->assertOk()->assertSee('Hasil Voucher (3)');
    }

    public function test_invalid_bulk_quantities_do_not_create_any_vouchers(): void
    {
        $voucher = $this->voucher();
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        foreach ([0, -1, 101, 1.5] as $quantity) {
            $this->post(route('voucher.store'), ['product_id' => $voucher->product_id, 'role' => 'user', 'quantity' => $quantity])
                ->assertSessionHasErrors(['quantity'], null, 'voucherCreate');
        }
        $this->assertDatabaseCount('vouchers', 1);
    }

    public function test_redemption_copies_presentation_and_files_without_deployment_or_payments(): void
    {
        $voucher = $this->voucher();
        $source = $voucher->product;
        $source->forceFill([
            'customer_data' => 'active',
            'home_button' => 'off',
            'order_via_whatsapp' => 'tanya',
            'status' => 'unactive',
        ])->save();
        foreach (['gallery', 'highlight'] as $directory) {
            File::ensureDirectoryExists($this->imageRoot.'/storage/images/product/'.$directory);
            file_put_contents($this->imageRoot.'/storage/images/product/'.$directory.'/source.webp', $directory);
        }
        DB::table('product_galleries')->insert(['product_id' => $source->id, 'image' => 'source.webp']);
        DB::table('highlights')->insert(['product_id' => $source->id, 'image' => 'source.webp', 'title' => 'Produk', 'price' => 12345, 'available' => true]);
        $category = DB::table('categories')->insertGetId(['category' => 'Makanan']);
        $source->category()->attach($category);
        $tag = DB::table('product_tags')->insertGetId(['tag' => 'Enak']);
        DB::table('pivot_product_tags')->insert(['product_id' => $source->id, 'tag_id' => $tag]);
        $user = User::factory()->create();
        $copy = app(VoucherService::class)->redeem(strtolower($voucher->code), $user, true);

        $this->assertSame($source->description, $copy->description);
        $this->assertMatchesRegularExpression('/^'.preg_quote($source->name, '/').' - [A-Z0-9]{4}$/', $copy->name);
        $this->assertNotSame($source->slug, $copy->slug);
        $this->assertNull($copy->domain);
        $this->assertNull($copy->qris);
        $this->assertSame('unactive', $copy->qris_status);
        $copy->refresh();
        $this->assertSame('unactive', $copy->customer_data);
        $this->assertSame('on', $copy->home_button);
        $this->assertSame('instan_rekap', $copy->order_via_whatsapp);
        $this->assertSame('active', $copy->status);
        $this->assertSame('active', $source->fresh()->customer_data);
        $this->assertNotSame($source->image, $copy->image);
        $this->assertFileExists($this->imageRoot.'/storage/images/product/'.$copy->image);
        $this->assertSame('test image', file_get_contents($this->imageRoot.'/storage/images/product/'.$copy->image));
        $this->assertCount(1, $copy->productGallery);
        $this->assertCount(1, $copy->productHighlight);
        $this->assertNotSame('source.webp', $copy->productHighlight->first()->image);
        $this->assertSame(12345, $copy->productHighlight->first()->price);
        $this->assertSame([$category], $copy->category->modelKeys());
        $this->assertSame($tag, $copy->productTags->first()->tag_id);
        $this->assertDatabaseHas('accesses', ['user_id' => $user->id, 'product_id' => $copy->id]);
        $this->assertSame('premium', $user->fresh()->role);
        $this->assertSame($voucher->expired->toDateString(), $user->fresh()->expired->toDateString());
        $this->assertSame($user->id, $voucher->fresh()->used_by);
    }

    public function test_dashboard_redemption_preserves_premium_and_prevents_reuse(): void
    {
        $voucher = $this->voucher();
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->post(route('voucher.redeem'), ['voucher' => $voucher->code])->assertRedirect();
        $this->assertSame('user', $user->fresh()->role);
        $this->assertNull($user->fresh()->premium_type);
        $other = User::factory()->create();
        $this->actingAs($other)->post(route('voucher.redeem'), ['voucher' => $voucher->code])->assertSessionHasErrors('voucher');
        $this->assertFalse(Access::where('user_id', $other->id)->exists());
    }

    public function test_existing_owner_cannot_consume_another_voucher(): void
    {
        $user = User::factory()->create();
        $first = $this->voucher();
        app(VoucherService::class)->redeem($first->code, $user);
        $second = $this->voucher();
        $this->actingAs($user)->post(route('voucher.redeem'), ['voucher' => $second->code])->assertSessionHasErrors('voucher');
        $this->assertNull($second->fresh()->used_at);
    }

    public function test_only_admin_can_manage_vouchers_and_premium_validation_is_enforced(): void
    {
        $voucher = $this->voucher();
        $this->actingAs(User::factory()->create(['role' => 'user']))->get(route('voucher.index'))->assertForbidden();
        $this->post(route('voucher.store'), [])->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->get(route('voucher.index'))->assertOk()->assertSee($voucher->code);
        $this->get(route('dashboard'))->assertOk()->assertSee('Generate Voucher');
        $this->post(route('voucher.store'), ['product_id' => $voucher->product_id, 'role' => 'admin'])->assertSessionHasErrors(['role'], null, 'voucherCreate');
        $this->post(route('voucher.store'), ['product_id' => $voucher->product_id, 'role' => 'premium', 'premium_type' => 'month'])->assertSessionHasErrors(['expired'], null, 'voucherCreate');
        $this->post(route('voucher.store'), ['product_id' => $voucher->product_id, 'role' => 'premium', 'premium_type' => 'lifetime'])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('vouchers', ['premium_type' => 'lifetime', 'expired' => null]);
    }

    public function test_failed_copy_rolls_back_registration_and_keeps_voucher_available(): void
    {
        $voucher = $this->voucher();
        DB::table('highlights')->insert(['product_id' => $voucher->product_id, 'title' => 'Missing', 'image' => 'missing.webp']);
        $this->post('/register', [
            'name' => 'Test', 'email' => 'failed@example.com', 'password' => 'password',
            'password_confirmation' => 'password', 'voucher' => $voucher->code,
        ])->assertSessionHasErrors('voucher');
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('products', 1);
        $this->assertNull($voucher->fresh()->used_at);
        $this->assertCount(1, File::files($this->imageRoot.'/storage/images/product'));
    }

    public function test_deleted_source_is_not_redeemable_and_empty_dashboard_has_form(): void
    {
        $voucher = $this->voucher();
        $voucher->product->delete();
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('dashboard'))->assertOk()->assertSee('Buat Usaha dengan Voucher');
        $this->post(route('voucher.redeem'), ['voucher' => $voucher->code])->assertSessionHasErrors('voucher');
    }
}
