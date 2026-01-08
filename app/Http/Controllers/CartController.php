<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function cart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart = $this->cart();
        $ids = array_keys($cart);

        $costumes = empty($ids)
            ? collect()
            : Costume::whereIn('id', $ids)->get()->keyBy('id');


        $items = [];
        $total = 0;

        foreach ($cart as $id => $row) {
            if (!$costumes->has($id)) continue;
            $c = $costumes[$id];

            $qty = (int) $row['qty'];
            $subtotal = $c->price * $qty;

            $items[] = [
                'id' => $c->id,
                'name' => $c->name,
                'price' => $c->price,
                'stock' => $c->stock,
                'image_path' => $c->image_path,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Costume $costume)
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cart();
        $id = (string) $costume->id;

        $cart[$id]['qty'] = ($cart[$id]['qty'] ?? 0) + (int)$data['qty'];

        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', 'Ditambahkan ke cart.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'qty' => ['required', 'array'],
            'qty.*' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cart();
        foreach ($data['qty'] as $id => $qty) {
            if (isset($cart[$id])) $cart[$id]['qty'] = (int)$qty;
        }

        $this->saveCart($cart);

        return back()->with('success', 'Cart diperbarui.');
    }

    public function remove(string $costumeId)
    {
        $cart = $this->cart();
        unset($cart[$costumeId]);
        $this->saveCart($cart);

        return back()->with('success', 'Item dihapus.');
    }

    public function checkout(Request $request)
    {
        $request->validate([]); // auth sudah ditangani middleware

        $cart = $this->cart();
        abort_if(empty($cart), 422, 'Cart kosong.');

        $items = collect($cart)->map(function ($row, $id) {
            return ['costume_id' => (int)$id, 'qty' => (int)$row['qty']];
        })->values()->all();

        // Pakai OrderController::store yang sudah kamu punya, tapi biar simple:
        // kita copy logika store ke sini (lebih rapi nanti bisa di-refactor ke service).
        $user = $request->user();

        $order = DB::transaction(function () use ($items, $user) {
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'code' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $costume = \App\Models\Costume::lockForUpdate()->findOrFail($item['costume_id']);
                $qty = (int) $item['qty'];

                if ($costume->stock < $qty) abort(422, "Stock tidak cukup: {$costume->name}");

                $costume->decrement('stock', $qty);

                $price = (int) $costume->price;
                $subtotal = $price * $qty;

                \App\Models\OrderItem::create([
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

        session()->forget('cart');

        return redirect()->route('orders.my')->with('success', "Checkout sukses. Order: {$order->code}");
    }
}
