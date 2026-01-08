@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Add Costume</h1>

<form method="POST" action="{{ route('admin.costumes.store') }}" enctype="multipart/form-data"
      class="bg-white border p-4 rounded space-y-4">
    @csrf

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Category</label>
            <select name="category_id" class="border p-2 w-full rounded">
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Name</label>
            <input name="name" value="{{ old('name') }}" class="border p-2 w-full rounded" placeholder="Costume name">
        </div>
    </div>

    <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="4" class="border p-2 w-full rounded" placeholder="Detail bahan, ukuran, dll.">{{ old('description') }}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="border p-2 w-full rounded" min="0">
        </div>
        <div>
            <label class="block text-sm mb-1">Price (Rp)</label>
            <input type="number" name="price" value="{{ old('price', 0) }}" class="border p-2 w-full rounded" min="0">
        </div>
    </div>

    <div>
        <label class="block text-sm mb-1">Image</label>
        <input type="file" name="image" class="border p-2 w-full rounded" accept="image/*">
        <div class="text-xs text-gray-600 mt-1">JPG/PNG/WEBP, max 2MB.</div>
    </div>

    <div class="flex gap-2">
        <button class="border p-2 bg-white rounded">Save</button>
        <a href="{{ route('admin.costumes.index') }}" class="border p-2 bg-white rounded">Cancel</a>
    </div>
</form>
@endsection
