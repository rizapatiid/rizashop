<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pakaian',
                'slug' => 'pakaian',
                'description' => 'Koleksi pakaian pria, wanita, dan anak-anak',
                'is_active' => true,
            ],
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Peralatan elektronik dan gadget',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'description' => 'Makanan, minuman, dan camilan',
                'is_active' => true,
            ],
            [
                'name' => 'Aksesoris',
                'slug' => 'aksesoris',
                'description' => 'Aksesoris fashion dan pelengkap',
                'is_active' => true,
            ],
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga',
                'description' => 'Perlengkapan dan peralatan olahraga',
                'is_active' => true,
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'slug' => 'kesehatan-kecantikan',
                'description' => 'Produk kesehatan dan kecantikan',
                'is_active' => true,
            ],
            [
                'name' => 'Rumah Tangga',
                'slug' => 'rumah-tangga',
                'description' => 'Peralatan dan perlengkapan rumah tangga',
                'is_active' => true,
            ],
            [
                'name' => 'Mainan & Hobi',
                'slug' => 'mainan-hobi',
                'description' => 'Mainan anak dan koleksi hobi',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}