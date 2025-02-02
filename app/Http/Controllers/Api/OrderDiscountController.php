<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Discount\DiscountService;
use Illuminate\Http\JsonResponse;

class OrderDiscountController extends Controller
{
    private DiscountService $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function calculate(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $discounts = $this->discountService->calculateDiscounts($order);
        return response()->json($discounts);
    }
}
