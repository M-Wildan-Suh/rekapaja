<?php

namespace Tests\Feature;

use App\Models\Access;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Highlight;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\VoucherTestCase;

class OperatorAccessTest extends VoucherTestCase
{
    public function test_admin_can_create_and_assign_operator_role(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->post(route('user.store'), [
            'name' => 'Operator Baru', 'email' => 'operator@example.com', 'role' => 'operator',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertSessionHasNoErrors()->assertRedirect(route('user.index'));
        $operator = User::where('email', 'operator@example.com')->firstOrFail();
        $this->assertSame('operator', $operator->role);
        $this->get(route('user.create'))->assertOk()->assertSee('value="operator"', false);
        $user = User::factory()->create(['role' => 'premium', 'premium_type' => 'lifetime']);
        $this->put(route('user.update', $user), ['name' => $user->name, 'email' => $user->email, 'role' => 'operator'])
            ->assertSessionHasNoErrors();
        $this->assertSame('operator', $user->fresh()->role);
        $this->assertNull($user->fresh()->premium_type);
    }

    private function operator(): User
    {
        return User::factory()->create(['role' => 'operator']);
    }

    public function test_operator_can_create_multiple_businesses_and_cannot_forge_creator_or_owner(): void
    {
        $operator = $this->operator();
        $other = User::factory()->create();
        $this->actingAs($operator)->get(route('product.create'))->assertOk();
        foreach (['Usaha Operator Satu', 'Usaha Operator Dua'] as $name) {
            $this->post(route('product.store'), [
                'name' => $name, 'subtitle' => 'Tagline', 'description' => 'Deskripsi',
                'product_title' => 'Produk Kami', 'order_title' => 'Beli',
                'thumbnail' => UploadedFile::fake()->image('usaha.png'),
                'created_by' => $other->id, 'access' => $other->id,
            ])->assertSessionHasNoErrors()->assertRedirect();
            $business = Product::where('name', $name)->firstOrFail();
            $this->assertSame($operator->id, (int) $business->created_by);
            $this->assertFalse(Access::where('product_id', $business->id)->exists());
            $this->get(route('product.show', $business))->assertOk();
        }
        $this->get(route('dashboard'))->assertOk()->assertSee('Tambah Usaha')->assertSee('Buat Usaha dengan Voucher')
            ->assertDontSee('aria-label="Opsi upload dan voucher"', false)->assertDontSee('>Generate Voucher<', false);
    }

    public function test_creator_scope_protects_businesses_and_their_children_even_if_access_was_assigned(): void
    {
        $operator = $this->operator();
        $own = $this->voucher()->product;
        $own->forceFill(['created_by' => $operator->id])->save();
        $foreign = $this->voucher()->product;
        Access::create(['user_id' => $operator->id, 'product_id' => $foreign->id]);
        $gallery = (new ProductGallery)->forceFill(['product_id' => $foreign->id, 'image' => 'photo.webp']);
        $gallery->save();
        $highlight = (new Highlight)->forceFill(['product_id' => $foreign->id, 'title' => 'Produk', 'image' => 'photo.webp']);
        $highlight->save();
        $this->actingAs($operator);
        $this->get(route('dashboard'))->assertOk()->assertViewHas('data', fn ($items) => $items->modelKeys() === [$own->id]);
        $this->get(route('product.show', $foreign))->assertForbidden();
        $this->put(route('product.update', $foreign), [])->assertForbidden();
        $this->delete(route('product.destroy', $foreign))->assertForbidden();
        $this->post(route('product.template.preview', $foreign), [])->assertForbidden();
        $this->put(route('product.template.update', $foreign), [])->assertForbidden();
        $this->put(route('highlight.bulk-update', $foreign), [])->assertForbidden();
        $this->delete(route('highlight.destroy', $highlight))->assertForbidden();
        $this->delete(route('product-gallery.destroy', $gallery))->assertForbidden();
        $this->post(route('product-gallery.store'), ['product_id' => $foreign->id])->assertForbidden();
        $this->put(route('product.update', $own), ['name' => 'Usaha Milik Operator', 'subtitle' => 'Tagline', 'description' => 'Deskripsi'])
            ->assertSessionHasNoErrors();
        $this->assertSame($operator->id, (int) $own->fresh()->created_by);
        $this->delete(route('product.destroy', $own))->assertRedirect();
        $this->assertNull($own->fresh());
        $this->assertNotNull($foreign->fresh());
    }

    public function test_operator_can_redeem_multiple_vouchers_without_gaining_premium_or_source_access(): void
    {
        $operator = $this->operator();
        $this->actingAs($operator);
        foreach (range(1, 2) as $index) {
            $voucher = $this->voucher();
            $this->post(route('voucher.redeem'), ['voucher' => $voucher->code])->assertSessionHasNoErrors()->assertRedirect();
            $copy = Product::where('created_by', $operator->id)->latest('id')->firstOrFail();
            $this->get(route('product.show', $copy))->assertOk();
            $this->get(route('product.show', $voucher->product))->assertForbidden();
        }
        $this->assertSame(2, Product::where('created_by', $operator->id)->count());
        $this->assertSame('operator', $operator->fresh()->role);
    }

    public function test_operator_cannot_access_other_pages_or_deployment_or_generate_vouchers(): void
    {
        $operator = $this->operator();
        $business = $this->voucher()->product;
        $business->forceFill(['created_by' => $operator->id])->save();
        $this->actingAs($operator);
        foreach (['user.index', 'access.index', 'package.index', 'rekap.index', 'voucher.index', 'profile.edit', 'premium.index', 'home'] as $name) {
            $this->get(route($name))->assertForbidden();
        }
        $this->post(route('voucher.store'), [])->assertForbidden();
        $this->post(route('user.store'), [])->assertForbidden();
        foreach (['product.upload-domain', 'product.upload-custom-domain', 'product.upload-domain-sitemap', 'product.upload-custom-domain-sitemap'] as $name) {
            $this->post(route($name, $business), [])->assertForbidden();
        }
        $this->get(route('product.download-domain', $business))->assertForbidden();
        $this->get(route('product.domain-folder', $business))->assertForbidden();
        $this->put(route('product.domain', $business), [])->assertForbidden();
        $this->get('/clear-cache')->assertForbidden();
    }
}
