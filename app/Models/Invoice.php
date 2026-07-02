<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'invoice_code',
        'invoice_text',
        'customer_name',
        'customer_address',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'business_id');
    }
}
