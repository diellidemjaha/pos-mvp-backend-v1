<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   public function store(Request $request)
{
    $data = $request->validate([
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.qty' => 'required|integer|min:1',
    ]);

    return DB::transaction(function () use ($data, $request) {

        // 1️⃣ Create order FIRST
        $order = Order::create([
            'user_id'  => $request->user()->id,
            'order_no' => 'ORD-' . time(),
            'total'    => 0, // temporary
        ]);

        $total = 0;

        // 2️⃣ Loop items
        foreach ($data['items'] as $row) {

            $product = Product::lockForUpdate()->findOrFail($row['product_id']);

            if ($product->stock < $row['qty']) {
                abort(422, "Not enough stock for {$product->name}");
            }

            // Reduce stock
            $product->decrement('stock', $row['qty']);

            $lineTotal = $product->price * $row['qty'];
            $total += $lineTotal;

            // 3️⃣ Create order item
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id'=> $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'qty'        => $row['qty'],
                'line_total' => $lineTotal,
            ]);
        }

        // 4️⃣ Update order total AFTER items
        $order->update([
            'total' => $total
        ]);

        return $order;
    });
}

public function index()
{
    return Order::with('items')
        ->orderBy('created_at', 'desc')
        ->limit(100)
        ->get();
}
}
