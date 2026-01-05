<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'parent_id', // untuk nested categories (optional)
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relasi ke Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Parent category (optional, untuk nested)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Child categories (optional, untuk nested)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get total products in category
    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }
}