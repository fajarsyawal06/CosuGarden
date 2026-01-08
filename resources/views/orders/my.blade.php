@extends('layouts.app')

@section('content')
<div class="flex items-end justify-between mb-4">
    <div>
        <div class="text-sm text-gray-500">Account</div>
        <h1 class="text-2xl font-extrabold">My Orders</h1>
    </div>
</div>

@php
$tone = fn($s) => match($s){
'paid' => 'blue',
'shipped' => 'yellow',
'done' => 'green',
'cancelled' => 'red',
default => 'gray'
};
@endphp

@if($orders->isEmpty())
<x-card class="p-6">
    <div class="font-extrabold text-lg">Belum ada order</div>
    <div class="text-sm text-gray-600 mt-1">Mulai belanja dari katalog.</div>
    <div class="mt-4">
        <a href="{{ route('shop.index') }}"><x-button>Browse Catalog</x-button></a>
    </div>
</x-card>
@else
<div class="space-y-4">
    @foreach($orders as $o)
    @php
    $countItems = $o->items->count();
    @endphp

    <x-card class="p-5">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <div class="font-extrabold text-lg">{{ $o->code }}</div>
                <div class="text-sm text-gray-600">{{ $o->created_at->format('d M Y H:i') }}</div>
            </div>

            <div class="flex items-center gap-2">
                <x-badge :tone="$tone($o->status)">{{ $o->status }}</x-badge>
                <div class="font-extrabold">Rp {{ number_format($o->total,0,',','.') }}</div>
            </div>
        </div>

        <div class="mt-4 border-t border-gray-200 pt-4">
            <div class="text-sm font-extrabold mb-3">
                Items
                <span class="text-gray-500 font-semibold">({{ $countItems }})</span>
            </div>

            {{-- ITEMS: tampil bertumpuk ke bawah (model single) --}}
            <div class="space-y-3">
                @foreach($o->items as $it)
                @php
                $c = $it->costume;
                @endphp

                <div class="flex gap-4 items-center">
                    {{-- THUMB --}}
                    <div class="w-16 h-16 rounded-2xl border border-gray-200 overflow-hidden bg-gray-100 grid place-items-center text-gray-500">
                        @if($c && $c->image_path)
                        <img
                            src="{{ asset('storage/'.$c->image_path) }}"
                            alt="{{ $c->name }}"
                            class="w-full h-full object-cover">
                        @else
                        No image
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="flex-1 min-w-0">
                        @if($c)
                        <a href="{{ route('shop.show', $c->slug) }}"
                            class="font-extrabold leading-snug truncate hover:underline">
                            {{ $c->name }}
                        </a>
                        @else
                        <div class="font-extrabold leading-snug text-gray-400">
                            Deleted costume
                        </div>
                        @endif

                        <div class="text-sm text-gray-600 mt-1">
                            Qty: <span class="font-semibold">{{ $it->qty }}</span>
                        </div>
                    </div>

                    {{-- SUBTOTAL --}}
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Subtotal</div>
                        <div class="font-extrabold">
                            Rp {{ number_format($it->subtotal,0,',','.') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </x-card>
    @endforeach
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection