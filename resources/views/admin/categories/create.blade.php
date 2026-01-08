@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Add Category</h1>

<form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white border p-4 rounded space-y-3">
    @csrf

    <div>
        <label class="block text-sm mb-1">Name</label>
        <input name="name" value="{{ old('name') }}" class="border p-2 w-full rounded" placeholder="Anime, Game, ...">
    </div>

    <div class="flex gap-2">
        <button class="border p-2 bg-white rounded">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="border p-2 bg-white rounded">Cancel</a>
    </div>
</form>
@endsection
