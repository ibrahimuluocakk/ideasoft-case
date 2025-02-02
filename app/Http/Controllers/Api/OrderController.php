<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::with(['items.product', 'user'])
            ->where('user_id', auth()->id())
            ->get();

        return response()->json(OrderResource::collection($orders));
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $user = User::findOrFail($request->user_id);

            $orderData = DB::transaction(function () use ($request, $user) {
                $total_amount = 0;
                $items = [];

                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Insufficient stock for product: {$product->name}");
                    }

                    $item_total = $product->price * $item['quantity'];
                    $total_amount += $item_total;

                    $items[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->price,
                        'total_price' => $item_total
                    ];

                    $product->stock -= $item['quantity'];
                    $product->save();
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => $total_amount,
                    'status' => 'pending'
                ]);

                foreach ($items as $item) {
                    $order->items()->create($item);
                }

                return $order->load(['items.product', 'user']);
            });

            return response()->json(new OrderResource($orderData), Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return response()->json(new OrderResource($order->load(['items.product', 'user'])));
    }

    public function destroy(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }

            $order->delete();
        });

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
