<?php

namespace Tests\Unit;

use App\Models\Template;
use PHPUnit\Framework\TestCase;

class TemplateSectionTest extends TestCase
{
    public function test_existing_form_fields_are_stored_only_in_section_json(): void
    {
        $template = new Template;
        $template->bg_type = 'image';
        $template->bg_image = 'background.webp';
        $template->head_type = 'skincare';
        $template->gallery_type = 'square';
        $template->desc_main_color = '#FFFFFF';
        $template->product_type = 'grid3';
        $template->contact_main_color = '#112233';

        $stored = $template->getAttributes();
        $this->assertArrayNotHasKey('bg_type', $stored);
        $this->assertArrayNotHasKey('head_type', $stored);
        $this->assertSame('background.webp', json_decode($stored['background'], true)['image']);
        $this->assertSame('#A72018', $template->background['accent_color']);
        $this->assertSame('default', $template->desc_type);
        $this->assertSame('skincare', $template->head['type']);
        $this->assertSame('square', $template->gallery['type']);
        $this->assertSame('grid3', $template->product['type']);
        $this->assertSame('#112233', $template->contact['main_color']);
    }

    public function test_hydrated_json_supports_existing_views_and_preserves_extra_settings(): void
    {
        $template = (new Template)->newFromBuilder([
            'id' => 1,
            'background' => '{"type":"image","image":"old.webp","custom":{"opacity":0.5}}',
            'product' => '{"type":"grid2","text_color":"#112233"}',
        ]);

        $this->assertSame('image', $template->bg_type);
        $this->assertTrue(isset($template->bg_image));
        $template->bg_type = 'gradient';
        $template->bg_main_color = '#FFFFFF';
        $template->product_type = 'grid3';

        $this->assertSame('old.webp', $template->bg_image);
        $this->assertSame(['opacity' => 0.5], $template->background['custom']);
        $this->assertSame('#112233', $template->product_text_color);
        $this->assertArrayNotHasKey('bg_type', $template->toArray());
        $this->assertSame('gradient', $template->toArray()['background']['type']);
        $this->assertArrayHasKey('background', $template->getDirty());
    }
}
