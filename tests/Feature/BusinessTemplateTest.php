<?php

namespace Tests\Feature;

use App\Models\Access;
use App\Models\Product;
use App\Models\Template;
use App\Models\User;
use App\Services\VoucherService;
use Illuminate\Support\Facades\DB;
use Tests\VoucherTestCase;

class BusinessTemplateTest extends VoucherTestCase
{
    public function test_public_page_initial_editor_and_live_refresh_use_the_same_sections(): void
    {
        $product = $this->voucher()->product;
        $product->forceFill(['no_tlp' => '081234567890'])->save();
        (new \App\Models\ProductGallery)->forceFill(['product_id' => $product->id, 'image' => 'gallery.webp'])->save();
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $rendered = [];
        \Illuminate\Support\Facades\View::composer('components.guest.*', function ($view) use (&$rendered) {
            if (preg_match('/^components\.guest\.(banner\.|gallery\.|product\.|contact$|youtube$|qris-section$|business-page$)/', $view->name())) {
                $rendered[] = $view->name();
            }
        });

        foreach ([['one', 'square', 'grid2'], ['network', 'potrait', 'list'], ['pudding_putih', 'network', 'grid3']] as [$header, $gallery, $layout]) {
            $input = array_replace($this->designInput(), ['header' => $header, 'gallery' => $gallery, 'product_type' => $layout]);
            $product->template_settings = app(\App\Services\BusinessTemplateService::class)->preview($input, $product)->settings();
            $product->save();

            $rendered = [];
            $this->get(route('domain.preview', ['product' => $product, 'domain_preview' => 1]))
                ->assertOk()->assertDontSee('data-edit-section=', false);
            $publicSections = $rendered;
            $this->assertContains('components.guest.banner.'.$header, $publicSections);
            $this->assertContains('components.guest.gallery.'.$gallery, $publicSections);

            $rendered = [];
            $this->get(route('product.show', $product))->assertOk()->assertSee('data-edit-section="header"', false);
            $this->assertSame($publicSections, $rendered, 'Initial Blade include must use the public sections.');

            $rendered = [];
            $this->post(route('product.template.preview', $product), $input)->assertOk();
            $this->assertSame($publicSections, $rendered, 'Live refresh must use the public sections.');
        }
    }

    public function test_live_preview_renders_draft_content_without_persisting_it(): void
    {
        $product = $this->voucher()->product;
        $product->forceFill(['domain' => 'https://custom.example.com', 'no_tlp' => '081234567890'])->save();
        $original = $product->fresh()->getAttributes();
        $owner = User::factory()->create();
        Access::create(['user_id' => $owner->id, 'product_id' => $product->id]);

        $this->actingAs($owner)->post(route('product.template.preview', $product), array_replace($this->designInput(), [
            'name' => 'Nama Draft Live',
            'description' => 'Deskripsi draft langsung',
            'header' => 'one',
            'thumbnail' => \Illuminate\Http\UploadedFile::fake()->image('draft.png'),
        ]))->assertOk()->assertSee('Nama Draft Live')->assertSee('Deskripsi draft langsung')
            ->assertSee('data:image/png;base64,', false)->assertSee('#ABCDEF', false)
            ->assertSee('data-edit-section="header"', false)
            ->assertDontSee('<html', false);

        $this->assertSame($original, $product->fresh()->getAttributes());
        $this->assertFileDoesNotExist(public_path('storage/images/product/draft.png'));
    }

    public function test_live_preview_requires_product_access_and_valid_design(): void
    {
        $product = $this->voucher()->product;
        $this->actingAs(User::factory()->create())->postJson(route('product.template.preview', $product), $this->designInput())
            ->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->postJson(route('product.template.preview', $product), array_replace($this->designInput(), ['header' => '../invalid']))
            ->assertUnprocessable()->assertJsonValidationErrors('header');
    }

    private function designInput(): array
    {
        $template = (new Product)->designTemplate();
        $input = [];
        foreach (Template::SECTION_FIELDS as $field => $path) {
            $input[$field] = $template->{$field};
        }
        $input['header'] = 'ramen';
        $input['gallery'] = 'square';
        $input['bg_normal_color'] = '#ABCDEF';
        $input['active_tab'] = 'design';

        return $input;
    }

    public function test_owner_edits_only_their_business_design_and_editor_is_embedded(): void
    {
        $first = $this->voucher()->product;
        $second = $this->voucher()->product;
        $original = $second->template_settings;
        $owner = User::factory()->create();
        Access::create(['user_id' => $owner->id, 'product_id' => $first->id]);
        $this->actingAs($owner);

        $this->get(route('product.show', $first))->assertOk()
            ->assertSee(route('product.template.update', $first), false)
            ->assertSee('<div data-business-preview', false)
            ->assertSee('data-edit-section="header"', false)
            ->assertSee('banner-auto-resize', false)
            ->assertDontSee('<iframe data-business-preview', false)
            ->assertDontSee('name="template_id"', false);
        $this->put(route('product.template.update', $first), $this->designInput())
            ->assertSessionHasNoErrors()->assertRedirect(route('product.show', $first))
            ->assertSessionHas('highlight', 'design');
        $this->assertSame('ramen', $first->fresh()->designTemplate()->head_type);
        $this->assertSame('#ABCDEF', $first->fresh()->designTemplate()->bg_main_color);
        $this->assertSame($original, $second->fresh()->template_settings);
        $this->put(route('product.template.update', $second), $this->designInput())->assertForbidden();
        $this->assertSame($original, $second->fresh()->template_settings);
    }

    public function test_invalid_design_is_rejected_without_changing_saved_settings(): void
    {
        $product = $this->voucher()->product;
        $original = $product->template_settings;
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->put(route('product.template.update', $product), array_replace($this->designInput(), [
            'header' => '../invalid', 'accent_color' => 'red',
        ]))->assertSessionHasErrors(['header', 'accent_color']);
        $this->assertSame($original, $product->fresh()->template_settings);
        $this->put(route('product.template.update', $product), array_replace($this->designInput(), [
            'bg_type' => 'image',
        ]))->assertSessionHasErrors('bg_image');
    }

    public function test_migration_preserves_shared_legacy_design_as_independent_settings(): void
    {
        $first = $this->voucher()->product;
        $second = $this->voucher()->product;
        $legacy = (new Template)->forceFill(Template::defaultSettings());
        $legacy->name = 'Legacy shared';
        $legacy->head_type = 'network';
        $legacy->bg_image = 'existing-background.webp';
        $legacy->save();
        DB::table('products')->update(['template_id' => $legacy->id]);

        $migration = require database_path('migrations/2026_09_24_000001_add_template_settings_to_products_table.php');
        $migration->down();
        $migration->up();
        $this->assertSame($legacy->settings(), $first->fresh()->template_settings);
        $this->assertSame($legacy->settings(), $second->fresh()->template_settings);
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->put(route('product.template.update', $first), $this->designInput())->assertSessionHasNoErrors();
        $this->assertSame('network', $second->fresh()->designTemplate()->head_type);
        $this->assertSame('network', $legacy->fresh()->head_type);
    }

    public function test_voucher_copies_design_without_sharing_subsequent_edits(): void
    {
        $voucher = $this->voucher();
        $settings = Template::defaultSettings();
        $settings['head']['type'] = 'donut';
        $voucher->product->template_settings = $settings;
        $voucher->product->save();
        $owner = User::factory()->create();
        $copy = app(VoucherService::class)->redeem($voucher->code, $owner);
        $this->assertSame($settings, $copy->template_settings);
        $this->actingAs($owner)->put(route('product.template.update', $copy), $this->designInput())
            ->assertSessionHasNoErrors();
        $this->assertSame('donut', $voucher->product->fresh()->designTemplate()->head_type);
    }

    public function test_new_business_has_a_design_without_a_template_catalog(): void
    {
        $this->assertSame('one', $this->voucher()->product->designTemplate()->head_type);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $this->get(route('product.create'))->assertOk()->assertDontSee('name="template_id"', false);
        $this->get('/admin/template')->assertNotFound();
        $this->assertFalse(\Illuminate\Support\Facades\Route::has('alltemplate'));
    }

    public function test_public_page_uses_business_settings_for_every_header(): void
    {
        $product = $this->voucher()->product;
        $product->no_tlp = '081234567890';
        foreach (['one', 'two', 'three', 'four', 'ramen', 'network', 'donut', 'skincare', 'pudding_putih', 'sembako'] as $header) {
            $settings = Template::defaultSettings();
            $settings['head']['type'] = $header;
            $product->template_settings = $settings;
            $product->save();
            $this->get(route('domain.preview', ['product' => $product, 'domain_preview' => 1]))
                ->assertOk()->assertSee($product->description)
                ->assertSee('line-clamp-3', false)->assertDontSee('data-edit-section=', false);
        }
    }

    public function test_background_upload_is_preserved_when_other_design_settings_change(): void
    {
        $product = $this->voucher()->product;
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $input = array_replace($this->designInput(), [
            'bg_type' => 'image',
            'bg_image' => \Illuminate\Http\UploadedFile::fake()->image('background.png'),
        ]);
        $this->put(route('product.template.update', $product), $input)->assertSessionHasNoErrors();
        $image = $product->fresh()->designTemplate()->bg_image;
        $this->assertFileExists(public_path('storage/images/template/background/'.$image));
        unset($input['bg_image']);
        $input['header'] = 'two';
        $this->put(route('product.template.update', $product), $input)->assertSessionHasNoErrors();
        $this->assertSame($image, $product->fresh()->designTemplate()->bg_image);
    }
}
