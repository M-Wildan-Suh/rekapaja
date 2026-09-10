<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\VoucherTestCase;

class ProductDomainUpdateTest extends VoucherTestCase
{
    public function test_edit_without_domain_preserves_it_and_domain_settings_can_still_update_it(): void
    {
        $product = $this->voucher()->product;
        $templateId = DB::table('templates')->insertGetId([
            'name' => 'Test', 'bg_type' => 'color', 'head_type' => 'default',
            'gallery_type' => 'default', 'desc_main_color' => '#ffffff',
            'desc_text_color' => '#000000', 'product_type' => 'list',
            'product_main_color' => '#ffffff', 'product_second_color' => '#ffffff',
            'product_text_color' => '#000000', 'contact_main_color' => '#ffffff',
            'contact_second_color' => '#ffffff',
        ]);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->put(route('product.update', $product), [
            'name' => $product->name, 'subtitle' => 'Tagline baru',
            'template_id' => $templateId, 'description' => 'Deskripsi baru',
        ])->assertSessionHasNoErrors()->assertRedirect(route('product.show', $product));
        $this->assertSame('https://source.example.com', $product->fresh()->domain);
        $this->assertSame('Deskripsi baru', $product->fresh()->description);

        $this->putJson(route('product.domain', $product), ['domain' => 'updated.example.com'])->assertOk();
        $this->assertSame('https://updated.example.com', $product->fresh()->domain);
        $this->putJson(route('product.domain', $product), ['domain' => ''])->assertOk();
        $this->assertNull($product->fresh()->domain);
    }
}
