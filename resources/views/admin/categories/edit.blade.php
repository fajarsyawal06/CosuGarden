@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Edit Category</h1>

<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="bg-white border p-4 rounded space-y-3">
    @csrf 
    @method('PUT')

    <div>
        <label class="block text-sm mb-1">Name</label>
        <input name="name" value="{{ old('name', $category->name) }}" class="border p-2 w-full rounded">
        <div class="text-xs text-gray-600 mt-1">Slug akan diupdate otomatis jika controller kamu mengubahnya.</div>
    </div>

    <div class="flex gap-2">
        <button class="border p-2 bg-white rounded">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="border p-2 bg-white rounded">Cancel</a>
    </div>
</form>
@endsection