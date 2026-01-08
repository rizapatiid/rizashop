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
                'name' => 'PAKAIAN',
                'slug' => 'pakaian',
                'description' => 'Koleksi pakaian pria, wanita, dan anak-anak',
                'is_active' => true,
            ],
            [
                'name' => 'ELEKTRONIK',
                'slug' => 'elektronik',
                'description' => 'Peralatan elektronik dan gadget',
                'is_active' => true,
            ],
            [
                'name' => 'MAKANAN & MINUMAN',
                'slug' => 'makanan-minuman',
                'description' => 'Makanan, minuman, dan camilan',
                'is_active' => true,
            ],
            [
                'name' => 'AKSESORIS',
                'slug' => 'aksesoris',
                'description' => 'Aksesoris fashion dan pelengkap',
                'is_active' => true,
            ],
            [
                'name' => 'OLAHRAGA',
                'slug' => 'olahraga',
                'description' => 'Perlengkapan dan peralatan olahraga',
                'is_active' => true,
            ],
            [
                'name' => 'KESEHATAN',
                'slug' => 'kesehatan',
                'description' => 'Produk kesehatan dan kecantikan',
                'is_active' => true,
            ],
            [
                'name' => 'RUMAH TANGGA',
                'slug' => 'rumah-tangga',
                'description' => 'Peralatan dan perlengkapan rumah tangga',
                'is_active' => true,
            ],
            [
                'name' => 'MAINAN',
                'slug' => 'mainan-hobi',
                'description' => 'Mainan anak dan koleksi hobi',
                'is_active' => true,
            ],
             [
                'name' => 'SMARTPHONE & LAPTOP',
                'slug' => 'handphone',
                'description' => '',
                'is_active' => true,
            ],
             [
                'name' => 'SUKU CADANG',
                'slug' => 'suku-cadang',
                'description' => '',
                'is_active' => true,
            ],
            [
                'name' => 'TICKET',
                'slug' => 'ticket',
                'description' => '',
                'is_active' => true,
            ],
             [
                'name' => 'VOUCHER',
                'slug' => 'voucher',
                'description' => '',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}