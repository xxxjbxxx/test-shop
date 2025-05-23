<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = ['customer_name', 'status', 'comment', 'product_id', 'quantity'];
    
    protected $attributes = [
        'status' => 'new',
        'quantity' => 1
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }
}