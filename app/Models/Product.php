<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
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
