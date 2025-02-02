<?php

namespace App\Services\Discount;

use App\Models\Order;
use App\Models\DiscountRule;

class DiscountService
{
    public function calculateDiscounts(Order $order): array
    {
        $discounts = [];
        $remainingTotal = $order->total_amount;
        $totalDiscount = 0;

        $rules = DiscountRule::where('is_active', true)
            ->orderBy('priority')
            ->get();

        foreach ($rules as $rule) {
            $discount = $this->applyRule($rule, $order, $remainingTotal);
            if ($discount) {
                $discountAmount = $discount['rawDiscountAmount'];
                $subtotal = $discount['rawSubtotal'];

                $discounts[] = [
                    'discountReason' => $discount['discountReason'],
                    'discountAmount' => number_format($discountAmount, 2),
                    'subtotal' => number_format($subtotal, 2)
                ];

                $totalDiscount += $discountAmount;
                $remainingTotal = $subtotal;
            }
        }

        return [
            'orderId' => $order->id,
            'discounts' => $discounts,
            'totalDiscount' => number_format($totalDiscount, 2),
            'discountedTotal' => number_format($remainingTotal, 2)
        ];
    }

    private function applyRule(DiscountRule $rule, Order $order, float $currentTotal): ?array
    {
        switch ($rule->type) {
            case 'TOTAL_PRICE':
                if ($currentTotal >= $rule->conditions['min_amount']) {
                    $discountAmount = $currentTotal * ($rule->discount_percent / 100);
                    $subtotal = $currentTotal - $discountAmount;

                    return [
                        'discountReason' => $rule->name,
                        'rawDiscountAmount' => $discountAmount,
                        'rawSubtotal' => $subtotal,
                        'discountAmount' => number_format($discountAmount, 2),
                        'subtotal' => number_format($subtotal, 2)
                    ];
                }
                break;

            case 'CATEGORY_BULK':
                $categoryItems = $order->items()
                    ->whereHas('product', function ($query) use ($rule) {
                        $query->where('category_id', $rule->conditions['category_id']);
                    })
                    ->get();

                $totalQuantity = $categoryItems->sum('quantity');
                if ($totalQuantity >= 6) {
                    $freeItemsCount = floor($totalQuantity / 6);
                    $mostExpensiveItem = $categoryItems->sortByDesc('unit_price')->first();
                    $discountAmount = $mostExpensiveItem->unit_price * $freeItemsCount;
                    $subtotal = $currentTotal - $discountAmount;

                    return [
                        'discountReason' => $rule->name,
                        'rawDiscountAmount' => $discountAmount,
                        'rawSubtotal' => $subtotal,
                        'discountAmount' => number_format($discountAmount, 2),
                        'subtotal' => number_format($subtotal, 2)
                    ];
                }
                break;

            case 'CATEGORY_CHEAPEST':
                if ($rule->conditions['category_id'] === 1) {
                    $categoryItems = $order->items()
                        ->whereHas('product', function ($query) {
                            $query->where('category_id', 1);
                        })
                        ->get();

                    $totalItemsInCategory = $categoryItems->sum('quantity');
                    if ($totalItemsInCategory >= 2) {
                        $cheapestItem = $categoryItems->sortBy('unit_price')->first();
                        $discountAmount = $cheapestItem->unit_price * 0.20;
                        $subtotal = $currentTotal - $discountAmount;

                        return [
                            'discountReason' => $rule->name,
                            'rawDiscountAmount' => $discountAmount,
                            'rawSubtotal' => $subtotal,
                            'discountAmount' => number_format($discountAmount, 2),
                            'subtotal' => number_format($subtotal, 2)
                        ];
                    }
                }
                break;
        }

        return null;
    }
}
