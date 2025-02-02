<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customerId' => $this->user_id,
            'items' => $this->items->map(function ($item) {
                return [
                    'productId' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unitPrice' => number_format($item->unit_price, 2),
                    'total' => number_format($item->total_price, 2)
                ];
            }),
            'total' => number_format($this->total_amount, 2)
        ];
    }
}
