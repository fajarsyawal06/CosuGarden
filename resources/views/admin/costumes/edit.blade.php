@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Edit Costume</h1>

<form method="POST" action="{{ route('admin.costumes.update', $costume) }}" enctype="multipart/form-data"
    class="bg-white border p-4 rounded space-y-4">
    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Category</label>
            <select name="category_id" class="border p-2 w-full rounded">
                @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $costume->category_id)==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Name</label>
            <input name="name" value="{{ old('name', $costume->name) }}" class="border p-2 w-full rounded">
        </div>
    </div>

    <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="4" class="border p-2 w-full rounded">{{ old('description', $costume->description) }}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $costume->stock) }}" class="border p-2 w-full rounded" min="0">
        </div>
        <div>
            <label class="block text-sm mb-1">Price (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $costume->price) }}" class="border p-2 w-full rounded" min="0">
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4 items-start">
        <div>
            <label class="block text-sm mb-1">Replace Image (optional)</label>
            <input type="file" name="image" class="border p-2 w-full rounded" accept="image/*">
            <div class="text-xs text-gray-600 mt-1">Kosongkan jika tidak diganti.</div>
        </div>

        <div>
            <div class="text-sm mb-1">Current Image</div>
            @if($costume->image_path)
            <img class="w-full max-w-sm border rounded" src="{{ asset('storage/'.$costume->image_path) }}" alt="{{ $costume->name }}">
            @else
            <div class="text-sm text-gray-600">No image.</div>
            @endif
        </div>
    </div>

    <div class="flex gap-2">
        <button class="border p-2 bg-white rounded">Update</button>
        <a href="{{ route('admin.costumes.index') }}" class="border p-2 bg-white rounded">Cancel</a>
    </div>
</form>
@endsection