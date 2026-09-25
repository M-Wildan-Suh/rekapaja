<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\VoucherTestCase;

class BusinessEditInputsTest extends VoucherTestCase
{
    public function test_product_tab_fields_belong_to_the_submitted_form_and_are_saved(): void
    {
        $product = $this->voucher()->product;
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $response = $this->get(route('product.show', $product))->assertOk();
        $dom = new \DOMDocument;
        @$dom->loadHTML($response->getContent());
        $xpath = new \DOMXPath($dom);
        foreach (['order_title', 'price_prefix'] as $field) {
            $this->assertSame(1, $xpath->query('//input[@name="'.$field.'" and @form="highlight-form"]')->length);
        }
        $this->assertSame(1, $xpath->query('//input[@name="product_title" and @form="bussiness"]')->length);
        $this->put(route('highlight.bulk-update', $product), [
            'order_title' => 'Pesan Sekarang', 'product_title' => 'Jasa Kami', 'price_prefix' => 'Mulai dari',
        ])->assertSessionHasNoErrors()->assertRedirect(route('product.show', $product));
        $this->assertSame('Pesan Sekarang', $product->fresh()->order_title);
        $this->assertSame('Jasa Kami', $product->fresh()->product_title);
        $this->assertSame('Mulai dari', $product->fresh()->price_prefix);

        $this->put(route('product.update', $product), ['name' => $product->name, 'subtitle' => 'Tagline usaha', 'description' => $product->description, 'order_via_whatsapp' => 'tanya', 'product_title' => 'Judul dari modal'])
            ->assertSessionHasNoErrors();
        $this->assertSame('Mulai dari', $product->fresh()->price_prefix);
        $this->assertSame('Pesan Sekarang', $product->fresh()->order_title);
        $this->assertSame('tanya', $product->fresh()->order_via_whatsapp);
        $this->assertSame('Judul dari modal', $product->fresh()->product_title);
    }

    public function test_product_tab_rejects_invalid_labels_and_allows_clearing_price_prefix(): void
    {
        $product = $this->voucher()->product;
        $product->forceFill(['order_title' => 'Beli', 'price_prefix' => 'Mulai dari'])->save();
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->put(route('highlight.bulk-update', $product), ['order_title' => str_repeat('x', 256)])
            ->assertSessionHasErrors('order_title');
        $this->assertSame('Beli', $product->fresh()->order_title);
        $this->put(route('highlight.bulk-update', $product), ['price_prefix' => ''])->assertSessionHasNoErrors();
        $this->assertNull($product->fresh()->price_prefix);
        $this->assertSame('Beli', $product->fresh()->order_title);
    }
}
