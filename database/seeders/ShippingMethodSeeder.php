<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'code' => 'jne',
                'name' => 'JNE',
                'description' => 'REG • YES • OKE',
                'is_active' => true,
            ],
            [
                'code' => 'jnt',
                'name' => 'J&T Express',
                'description' => 'Reguler • Cargo',
                'is_active' => true,
            ],
            [
                'code' => 'sicepat',
                'name' => 'SiCepat',
                'description' => 'REG • BEST • HALU',
                'is_active' => true,
            ],
            [
                'code' => 'anteraja',
                'name' => 'AnterAja',
                'description' => 'Regular • Next Day • Same Day',
                'is_active' => true,
            ],
            [
                'code' => 'ninja',
                'name' => 'Ninja Express',
                'description' => 'Standard • Express',
                'is_active' => true,
            ],
            [
                'code' => 'idexpress',
                'name' => 'ID Express',
                'description' => 'Regular • Kilat',
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            ShippingMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
