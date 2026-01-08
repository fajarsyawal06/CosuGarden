@extends('layouts.admin')

@section('content')
<div class="flex flex-wrap gap-3 items-end justify-between mb-4">
    <div>
        <div class="text-sm text-gray-500">Admin</div>
        <h1 class="text-2xl font-extrabold">Costumes</h1>
    </div>
    <a href="{{ route('admin.costumes.create') }}">
        <x-button>+ Add Costume</x-button>
    </a>
</div>

<x-card class="p-5 mb-4">
    <form class="grid md:grid-cols-5 gap-2">
        <input
            name="search"
            value="{{ request('search') }}"
            class="border border-gray-200 p-2.5 rounded-xl focus:ring-2 focus:ring-gray-200"
            placeholder="Search..."
        >

        <select
            name="category_id"
            class="border border-gray-200 p-2.5 rounded-xl focus:ring-2 focus:ring-gray-200"
        >
            <option value="">All</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected((string)request('category_id')===(string)$c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        <input
            name="min_price"
            value="{{ request('min_price') }}"
            class="border border-gray-200 p-2.5 rounded-xl focus:ring-2 focus:ring-gray-200"
            placeholder="Min price"
        >

        <input
            name="max_price"
            value="{{ request('max_price') }}"
            class="border border-gray-200 p-2.5 rounded-xl focus:ring-2 focus:ring-gray-200"
            placeholder="Max price"
        >

        <x-button type="submit" variant="secondary">Filter</x-button>
    </form>
</x-card>

<x-card class="overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-3 text-left text-sm font-extrabold">Name</th>
                    <th class="p-3 text-left text-sm font-extrabold">Category</th>
                    <th class="p-3 text-left text-sm font-extrabold">Stock</th>
                    <th class="p-3 text-left text-sm font-extrabold">Price</th>
                    <th class="p-3 text-left text-sm font-extrabold">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach($costumes as $item)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="p-3">
                            <div class="font-extrabold">{{ $item->name }}</div>
                            <div class="text-xs text-gray-500">{{ $item->slug }}</div>
                        </td>

                        <td class="p-3">
                            <x-badge tone="blue">{{ $item->category->name }}</x-badge>
                        </td>

                        <td class="p-3">
                            @if($item->stock > 0)
                                <x-badge tone="green">{{ $item->stock }}</x-badge>
                            @else
                                <x-badge tone="red">0</x-badge>
                            @endif
                        </td>

                        <td class="p-3 font-semibold">
                            Rp {{ number_format($item->price,0,',','.') }}
                        </td>

                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.costumes.edit', $item) }}">
                                    <x-button variant="secondary" size="sm">Edit</x-button>
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.costumes.destroy', $item) }}"
                                      onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">Delete</x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>

<div class="mt-6">
    {{ $costumes->links() }}
</div>
@endsection
