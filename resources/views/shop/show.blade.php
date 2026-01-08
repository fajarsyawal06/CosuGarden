@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('shop.index') }}" class="text-sm font-semibold underline text-gray-700">← Back to catalog</a>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- IMAGE CARD --}}
    <div class="bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-sm p-4">
        @if ($costume->image_path)
            <img
                class="w-full h-[520px] object-cover rounded-2xl"
                src="{{ asset('storage/'.$costume->image_path) }}"
                alt="{{ $costume->name }}"
            >
        @else
            <div class="h-[520px] rounded-2xl bg-gray-100 grid place-items-center text-gray-500">
                No image
            </div>
        @endif
    </div>

    <div class="space-y-4">
        {{-- BADGES (no component, pure HTML) --}}
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold border bg-blue-50 text-blue-700 border-blue-200">
                {{ $costume->category->name }}
            </span>

            @if ($costume->stock > 0)
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold border bg-green-50 text-green-700 border-green-200">
                    Ready
                </span>
            @else
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold border bg-red-50 text-red-700 border-red-200">
                    Out of stock
                </span>
            @endif
        </div>

        <div>
            <h1 class="text-3xl font-extrabold leading-tight">{{ $costume->name }}</h1>
            <div class="mt-2 text-2xl font-extrabold">
                Rp {{ number_format($costume->price, 0, ',', '.') }}
            </div>
            <div class="text-sm text-gray-600 mt-1">
                Stock tersedia: <span class="font-semibold">{{ $costume->stock }}</span>
            </div>
        </div>

        {{-- DESCRIPTION CARD --}}
        <div class="bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-sm p-5">
            <div class="font-extrabold mb-2">Deskripsi</div>
            <div class="text-sm text-gray-700 whitespace-pre-line">
                {{ $costume->description ?: 'Belum ada deskripsi.' }}
            </div>
        </div>

        {{-- ACTION CARD --}}
        <div class="bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-sm p-5">
            <form method="POST" action="{{ route('cart.add', $costume) }}" class="flex flex-wrap gap-3 items-end">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-gray-700">Qty</label>
                    <input
                        type="number"
                        name="qty"
                        min="1"
                        value="1"
                        class="mt-1 border border-gray-200 p-2.5 w-28 rounded-xl focus:ring-2 focus:ring-gray-200"
                        {{ $costume->stock === 0 ? 'disabled' : '' }}
                    >
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2.5 text-sm
                           bg-gray-900 text-white hover:bg-gray-800 focus:ring-gray-300 disabled:opacity-60 disabled:cursor-not-allowed"
                    {{ $costume->stock === 0 ? 'disabled' : '' }}
                >
                    Add to Cart
                </button>

                <a href="{{ route('cart.index') }}"
                   class="inline-flex items-center justify-center rounded-xl font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2.5 text-sm
                          bg-white border border-gray-200 text-gray-900 hover:bg-gray-50 focus:ring-gray-200">
                    View Cart
                </a>
            </form>

            <div class="text-xs text-gray-500 mt-3">
                Order akan dibuat sebagai <b>pending</b> (admin bisa update status).
            </div>
        </div>
    </div>
</div>
@endsection
