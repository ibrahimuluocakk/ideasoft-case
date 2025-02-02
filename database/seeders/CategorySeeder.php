<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'id' => 1,
            'name' => 'E-commerce Packages2'
        ]);

        Category::create([
            'id' => 2,
            'name' => 'E-commerce Packages'
        ]);
    }
}
