<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotProductTag extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function productTag()
    {
        return $this->belongsTo(ProductTag::class, 'tag_id');
    }
    public function productWithTag()
    {
        return $this->product->load('productTags'); // Assuming Product model has relation `productTags`
    }
}
