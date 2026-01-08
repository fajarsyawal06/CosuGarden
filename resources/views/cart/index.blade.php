@extends('layouts.app')

@section('content')
<div class="flex items-end justify-between mb-6">
    <div>
        <div class="text-sm text-gray-500">Cart</div>
        <h1 class="text-2xl font-extrabold">Keranjang Belanja</h1>
    </div>
    <a href="{{ route('shop.index') }}" class="text-sm font-semibold underline text-gray-700">
        Continue shopping
    </a>
</div>

@if (empty($items))
<x-card class="p-6 text-center">
    <div class="font-extrabold text-lg">Cart kosong</div>
    <div class="text-sm text-gray-600 mt-1">Pilih costume dulu dari katalog.</div>
    <div class="mt-4">
        <a href="{{ route('shop.index') }}"><x-button>Browse Catalog</x-button></a>
    </div>
</x-card>
@else
<div class="grid lg:grid-cols-3 gap-6 items-start">

    {{-- LEFT --}}
    <div class="lg:col-span-2">
        <x-card class="overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <div class="font-extrabold">Items</div>

                {{-- tombol update submit ke form update --}}
                <x-button variant="secondary" size="sm" type="submit" form="cartUpdateForm">
                    Update Cart
                </x-button>
            </div>

            {{-- FORM UPDATE (PATCH /cart) --}}
            <form id="cartUpdateForm" method="POST" action="{{ route('cart.update') }}">
                @csrf
                @method('PATCH')

                <div class="divide-y divide-gray-200">
                    @foreach ($items as $it)
                    @php $removeFormId = 'remove_'.$it['id']; @endphp

                    <div class="p-4 flex gap-4">
                        {{-- IMAGE --}}
                        @if ($it['image_path'])
                        <img
                            class="w-24 h-24 object-cover rounded-2xl border border-gray-200"
                            src="{{ asset('storage/'.$it['image_path']) }}"
                            alt="{{ $it['name'] }}">
                        @else
                        <div class="w-24 h-24 rounded-2xl bg-gray-100 grid place-items-center text-gray-500">
                            No image
                        </div>
                        @endif

                        <div class="flex-1">
                            <div class="flex justify-between gap-3">
                                <div>
                                    <div class="font-extrabold">{{ $it['name'] }}</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        Rp {{ number_format($it['price'],0,',','.') }} · Stock {{ $it['stock'] }}
                                    </div>
                                </div>
                                <div class="font-extrabold">
                                    Rp {{ number_format($it['subtotal'],0,',','.') }}
                                </div>
                            </div>

                            <div class="mt-3 flex flex-wrap gap-3 items-center">
                                <div>
                                    <label class="text-xs font-semibold text-gray-600">Qty</label>
                                    <input
                                        type="number"
                                        name="qty[{{ $it['id'] }}]"
                                        value="{{ $it['qty'] }}"
                                        min="1"
                                        class="mt-1 border border-gray-200 p-2 w-28 rounded-xl focus:ring-2 focus:ring-gray-200">
                                </div>

                                {{-- REMOVE LINK: submit form remove (yang ADA DI LUAR form update) --}}
                                <a href="#"
                                    class="text-sm font-semibold text-red-600 hover:underline"
                                    onclick="event.preventDefault(); if(confirm('Hapus item ini?')) document.getElementById('{{ $removeFormId }}').submit();">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </x-card>

        {{-- FORM REMOVE HARUS DI LUAR form update (NO NESTED FORM!) --}}
        @foreach ($items as $it)
        <form id="remove_{{ $it['id'] }}" method="POST" action="{{ url('/cart/'.$it['id']) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        @endforeach
    </div>

    {{-- RIGHT --}}
    <x-card class="p-5 lg:sticky lg:top-24">
        <div class="font-extrabold text-lg">Summary</div>

        <div class="mt-3 flex justify-between text-sm text-gray-600">
            <span>Subtotal</span>
            <span>Rp {{ number_format($total,0,',','.') }}</span>
        </div>

        <div class="mt-2 flex justify-between text-sm text-gray-600">
            <span>Shipping</span>
            <span>—</span>
        </div>

        <div class="mt-4 border-t border-gray-200 pt-4 flex justify-between items-center">
            <span class="font-extrabold">Total</span>
            <span class="font-extrabold">Rp {{ number_format($total,0,',','.') }}</span>
        </div>

        <div class="mt-4">
            @auth
            <form method="POST" action="{{ route('cart.checkout') }}" onsubmit="return confirm('Checkout sekarang?')">
                @csrf
                <x-button class="w-full" type="submit">Checkout</x-button>
            </form>
            <div class="text-xs text-gray-500 mt-2">
                Order akan dibuat sebagai <b>pending</b>.
            </div>
            @else
            <a href="{{ route('login') }}">
                <x-button class="w-full">Login to Checkout</x-button>
            </a>
            @endauth
        </div>
    </x-card>
</div>
@endif
@endsection