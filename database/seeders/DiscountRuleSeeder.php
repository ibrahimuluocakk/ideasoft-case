<?php

namespace Database\Seeders;

use App\Models\DiscountRule;
use Illuminate\Database\Seeder;

class DiscountRuleSeeder extends Seeder
{
    public function run(): void
    {
        DiscountRule::create([
            'name' => '6 Al 1 Bedava (Kategori 2)',
            'type' => 'CATEGORY_BULK',
            'conditions' => [
                'category_id' => 2,
                'min_quantity' => 6,
                'free_quantity' => 1
            ],
            'priority' => 1
        ]);

        DiscountRule::create([
            'name' => 'En Ucuz Ürüne %20 İndirim (Kategori 1)',
            'type' => 'CATEGORY_CHEAPEST',
            'conditions' => [
                'category_id' => 1,
                'min_items' => 2,
                'discount_percent' => 20
            ],
            'priority' => 2
        ]);

        DiscountRule::create([
            'name' => '1000 TL Üzeri %10 İndirim',
            'type' => 'TOTAL_PRICE',
            'conditions' => [
                'min_amount' => 1000.00
            ],
            'discount_percent' => 10,
            'priority' => 3
        ]);
    }
}
