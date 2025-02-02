<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'id' => 1,
            'name' => 'Lite',
            'category_id' => 1,
            'price' => 1500.00,
            'stock' => 3,
            'created_at' => '2025-02-02 15:47:46',
            'updated_at' => '2025-02-02 15:49:20'
        ]);

        Product::create([
            'id' => 2,
            'name' => 'Lite',
            'category_id' => 1,
            'price' => 1000.00,
            'stock' => 10,
            'created_at' => '2025-02-02 15:47:50',
            'updated_at' => '2025-02-02 15:47:50'
        ]);

        Product::create([
            'id' => 3,
            'name' => 'Lite3',
            'category_id' => 2,
            'price' => 1000.00,
            'stock' => 3,
            'created_at' => '2025-02-02 15:47:54',
            'updated_at' => '2025-02-02 15:48:04'
        ]);
    }
}
