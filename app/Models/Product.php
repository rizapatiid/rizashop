<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'stock',
        'is_active',
        'category_id',
        'product_type',
        'image_path', // main image (backward compatibility)
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Product Images (Multiple Images)
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Relasi ke Product Variants
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Helper method untuk mendapatkan gambar utama
    public function getMainImageAttribute()
    {
        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->image_path : $this->image_path;
    }

    // Helper method untuk mendapatkan semua gambar URLs
    public function getAllImagesAttribute()
    {
        return $this->images->pluck('image_path')->toArray();
    }

    // Scope untuk filter produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter by category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Scope untuk filter by product type
    public function scopeByType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    // Check if product has stock
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
}