<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = ['template_settings' => 'array'];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->template_settings ??= Template::defaultSettings();
        });
    }

    public function designTemplate(): Template
    {
        return (new Template)->forceFill(array_replace_recursive(
            Template::defaultSettings(), $this->template_settings ?? []
        ));
    }
    public function productGallery()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function productTags()
    {
        return $this->hasMany(PivotProductTag::class)->with('productTag');
    }
    public function productHighlight()
    {
        return $this->hasMany(Highlight::class);
    }
    public function access()
    {
        return $this->hasMany(Access::class);
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'pivot_product_categories');
    }
}
