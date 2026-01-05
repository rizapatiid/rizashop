<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'variant_name',      // Ukuran, Warna, Rasa, dll
        'variant_value',     // S, M, L, XL / Merah, Biru / Original, Pedas
        'price_modifier',    // Tambahan harga (+ atau -)
        'stock',
        'sku',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_modifier' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Get final price (product price + modifier)
    public function getFinalPriceAttribute()
    {
        return $this->product->price + $this->price_modifier;
    }

    // Check if variant has stock
    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    // Reduce stock
    public function reduceStock($quantity)
    {
        if ($this->hasStock($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    // Increase stock
    public function increaseStock($quantity)
    {
        $this->increment('stock', $quantity);
    }

    // Scope untuk varian aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get variant display name
    public function getDisplayNameAttribute()
    {
        return "{$this->variant_name}: {$this->variant_value}";
    }
}