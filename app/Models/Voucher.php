<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'product_id', 'role', 'premium_type', 'expired'];

    protected $casts = ['expired' => 'date', 'used_at' => 'datetime'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function usedBy()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}
