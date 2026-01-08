@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Orders</h1>
</div>

<table class="w-full bg-white border rounded overflow-hidden">
    <thead class="bg-gray-50 border-b">
        <tr>
            <th class="p-2 text-left">Code</th>
            <th class="p-2 text-left">Customer</th>
            <th class="p-2 text-left">Total</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2 text-left">Created</th>
            <th class="p-2 text-left">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $o)
            <tr class="border-b">
                <td class="p-2 font-semibold">
                    <a class="underline" href="{{ route('admin.orders.show', $o) }}">{{ $o->code }}</a>
                </td>
                <td class="p-2">{{ $o->user->name ?? '-' }}</td>
                <td class="p-2">Rp {{ number_format($o->total,0,',','.') }}</td>
                <td class="p-2">{{ $o->status }}</td>
                <td class="p-2 text-sm text-gray-600">{{ $o->created_at->format('d M Y H:i') }}</td>
                <td class="p-2">
                    <a class="underline" href="{{ route('admin.orders.show', $o) }}">Detail</a>
                </td>
            </tr>
        @empty
            <tr><td class="p-3" colspan="6">Belum ada order.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $orders->links() }}</div>
@endsection
