<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Get full image URL
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    // Scope untuk gambar utama
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}