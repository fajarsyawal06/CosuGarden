<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.costume_id' => ['required', 'exists:costumes,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        $user = $request->user();

        $order = DB::transaction(function () use ($data, $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'code' => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $costume = Costume::lockForUpdate()->findOrFail($item['costume_id']);
                $qty = (int) $item['qty'];

                if ($costume->stock < $qty) {
                    abort(422, "Stock tidak cukup untuk {$costume->name}");
                }

                $costume->decrement('stock', $qty);

                $price = (int) $costume->price;
                $subtotal = $price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'costume_id' => $costume->id,
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);

            return $order;
        });

        return redirect()->route('orders.my')->with('success', "Order dibuat: {$order->code}");
    }

    public function myOrders(Request $request)
    {
        $orders = Order::with('items.costume')
            ->where('user_id', $request->user()->id)
            ->latest()->paginate(10);

        return view('orders.my', compact('orders'));
    }

    // admin
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,done,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);
        return back()->with('success', 'Status updated.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.costume']);
        return view('admin.orders.show', compact('order'));
    }
}
