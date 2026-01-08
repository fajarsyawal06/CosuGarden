@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-start mb-4">
    <div>
        <h1 class="text-xl font-bold">{{ $order->code }}</h1>
        <div class="text-sm text-gray-600">
            Created: {{ $order->created_at->format('d M Y H:i') }}
        </div>
    </div>

    <a class="border p-2 bg-white rounded" href="{{ route('admin.orders.index') }}">Back</a>
</div>

<div class="grid md:grid-cols-3 gap-4">
    <div class="md:col-span-2 bg-white border rounded p-4">
        <div class="font-semibold mb-3">Items</div>

        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-2 text-left">Costume</th>
                    <th class="p-2 text-left">Price</th>
                    <th class="p-2 text-left">Qty</th>
                    <th class="p-2 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $it)
                    <tr class="border-b">
                        <td class="p-2">
                            {{ $it->costume->name ?? 'Deleted costume' }}
                        </td>
                        <td class="p-2">Rp {{ number_format($it->price,0,',','.') }}</td>
                        <td class="p-2">{{ $it->qty }}</td>
                        <td class="p-2">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 flex justify-end font-semibold">
            Total: Rp {{ number_format($order->total,0,',','.') }}
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white border rounded p-4">
            <div class="font-semibold mb-2">Customer</div>
            <div class="text-sm">
                <div class="font-semibold">{{ $order->user->name ?? '-' }}</div>
                <div class="text-gray-600">{{ $order->user->email ?? '-' }}</div>
            </div>
        </div>

        <div class="bg-white border rounded p-4">
            <div class="font-semibold mb-2">Status</div>

            <div class="text-sm mb-2">
                Current: <span class="font-semibold">{{ $order->status }}</span>
            </div>

            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-2">
                @csrf
                @method('PATCH')
                <select name="status" class="border p-2 w-full rounded">
                    @foreach(['pending','paid','shipped','done','cancelled'] as $st)
                        <option value="{{ $st }}" @selected($order->status===$st)>{{ $st }}</option>
                    @endforeach
                </select>
                <button class="border p-2 bg-white rounded w-full">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
