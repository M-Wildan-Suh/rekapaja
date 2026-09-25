<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $casts = [
        'background' => 'array',
        'head' => 'array',
        'gallery' => 'array',
        'desc' => 'array',
        'product' => 'array',
        'contact' => 'array',
    ];

    protected $attributes = [
        'background' => '{"accent_color":"#A72018"}',
        'desc' => '{"type":"default"}',
    ];

    // Keep existing forms and Blade components compatible with section JSON.
    public const SECTION_FIELDS = [
        'bg_type' => ['background', 'type'],
        'bg_image' => ['background', 'image'],
        'bg_main_color' => ['background', 'main_color'],
        'bg_second_color' => ['background', 'second_color'],
        'accent_color' => ['background', 'accent_color'],
        'head_type' => ['head', 'type'],
        'gallery_type' => ['gallery', 'type'],
        'desc_type' => ['desc', 'type'],
        'desc_main_color' => ['desc', 'main_color'],
        'desc_text_color' => ['desc', 'text_color'],
        'product_type' => ['product', 'type'],
        'product_main_color' => ['product', 'main_color'],
        'product_second_color' => ['product', 'second_color'],
        'product_text_color' => ['product', 'text_color'],
        'contact_main_color' => ['contact', 'main_color'],
        'contact_second_color' => ['contact', 'second_color'],
    ];

    public static function defaultSettings(): array
    {
        return [
            'background' => ['type' => 'normal', 'main_color' => '#FFFFFF', 'second_color' => '#FFFFFF', 'accent_color' => '#A72018'],
            'head' => ['type' => 'one'],
            'gallery' => ['type' => 'square'],
            'desc' => ['type' => 'default', 'main_color' => '#FFFFFF', 'text_color' => '#111827'],
            'product' => ['type' => 'grid2', 'main_color' => '#FFFFFF', 'second_color' => '#A72018', 'text_color' => '#111827'],
            'contact' => ['main_color' => '#25D366', 'second_color' => '#111827'],
        ];
    }

    public function settings(): array
    {
        return array_replace_recursive(self::defaultSettings(), array_filter(
            $this->only(array_keys(self::defaultSettings())),
            fn ($section) => is_array($section)
        ));
    }

    public function getAttribute($key)
    {
        if (isset(self::SECTION_FIELDS[$key])) {
            [$section, $field] = self::SECTION_FIELDS[$key];

            return (parent::getAttribute($section) ?? [])[$field] ?? null;
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (isset(self::SECTION_FIELDS[$key])) {
            [$section, $field] = self::SECTION_FIELDS[$key];
            $data = parent::getAttribute($section) ?? [];
            $data[$field] = $value;

            return parent::setAttribute($section, $data);
        }

        return parent::setAttribute($key, $value);
    }

    public function templateGallery()
    {
        return $this->hasMany(TemplateGallery::class);
    }
    public function templateHighlight()
    {
        return $this->hasMany(TemplateHighlight::class);
    }
}
