@extends('layouts.app')

@section('content')
<div class="grid lg:grid-cols-3 gap-6 items-start">
    <!-- LEFT: FILTER -->
    <x-card class="p-5 lg:sticky lg:top-24">
        <div class="font-extrabold text-lg mb-3">Filter</div>

        <form method="GET" action="{{ route('shop.index') }}" class="space-y-3">
            {{-- SEARCH --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Search</label>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="mt-1 border border-gray-200 p-2.5 w-full rounded-xl focus:ring-2 focus:ring-gray-200"
                    placeholder="Misal: uniform, kimono, armor...">
            </div>

            {{-- CATEGORY --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Category</label>
                <select
                    name="category"
                    class="mt-1 border border-gray-200 p-2.5 w-full rounded-xl focus:ring-2 focus:ring-gray-200">
                    <option value="">All</option>
                    @foreach($categories as $c)
                    <option
                        value="{{ $c->slug }}"
                        @selected(request('category')===$c->slug)
                        >
                        {{ $c->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- BUTTONS --}}
            <div class="flex gap-2">
                <x-button type="submit" class="w-full">
                    Apply
                </x-button>

                <a href="{{ route('shop.index') }}" class="w-full">
                    <x-button variant="secondary" class="w-full">
                        Reset
                    </x-button>
                </a>
            </div>
        </form>

        <div class="mt-5 text-xs text-gray-500">
            Tip: gunakan kata kunci “set”, “uniform”, “wig”, dll.
        </div>
    </x-card>

    <!-- RIGHT: PRODUCTS -->
    <div class="lg:col-span-2">
        <div class="flex items-end justify-between mb-4">
            <div>
                <div class="text-sm text-gray-500">Catalog</div>
                <h1 class="text-2xl font-extrabold">Costume untuk Cosplayer</h1>
            </div>
            <div class="text-sm text-gray-600">
                {{ $costumes->total() }} items
            </div>
        </div>

        @if($costumes->isEmpty())
        <x-card class="p-6 text-center">
            <div class="font-extrabold text-lg">Tidak ada costume</div>
            <div class="text-sm text-gray-600 mt-1">
                Coba ubah filter atau reset pencarian.
            </div>
        </x-card>
        @else
        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($costumes as $item)
            <a href="{{ route('shop.show', $item->slug) }}" class="group">
                <x-card class="overflow-hidden">
                    <div class="relative">
                        @if($item->image_path)
                        <img
                            class="w-full h-44 object-cover group-hover:scale-[1.02] transition"
                            src="{{ asset('storage/'.$item->image_path) }}"
                            alt="{{ $item->name }}">
                        @else
                        <div class="w-full h-44 bg-gray-100 grid place-items-center text-gray-500">
                            No image
                        </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <x-badge tone="blue">{{ $item->category->name }}</x-badge>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="font-extrabold leading-snug group-hover:underline">
                            {{ $item->name }}
                        </div>

                        <div class="mt-2 flex items-center justify-between">
                            <div class="font-semibold">
                                Rp {{ number_format($item->price,0,',','.') }}
                            </div>

                            @if($item->stock > 0)
                            <x-badge tone="green">In stock</x-badge>
                            @else
                            <x-badge tone="red">Out</x-badge>
                            @endif
                        </div>
                    </div>
                </x-card>
            </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $costumes->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection