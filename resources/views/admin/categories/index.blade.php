@extends('layouts.admin')

@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Admin - Categories</h1>
    <a class="border p-2 bg-white rounded" href="{{ route('admin.categories.create') }}">+ Add</a>
</div>

<table class="w-full bg-white border rounded overflow-hidden">
    <thead>
        <tr class="border-b bg-gray-50">
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Slug</th>
            <th class="p-2 text-left">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $c)
            <tr class="border-b">
                <td class="p-2">{{ $c->name }}</td>
                <td class="p-2 text-sm text-gray-600">{{ $c->slug }}</td>
                <td class="p-2 flex gap-2">
                    <a class="underline" href="{{ route('admin.categories.edit', $c) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Delete category?')">
                        @csrf 
                        @method('DELETE')
                        <button class="underline text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td class="p-3" colspan="3">Belum ada kategori.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $categories->links() }}</div>
@endsection
