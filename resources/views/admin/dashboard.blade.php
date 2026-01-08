@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Dashboard</h1>

<div class="grid md:grid-cols-3 gap-4">
    <div class="bg-white border rounded p-4">
        <div class="text-sm text-gray-600">Quick Link</div>
        <a class="underline font-semibold" href="{{ route('admin.costumes.index') }}">Manage Costumes</a>
    </div>

    <div class="bg-white border rounded p-4">
        <div class="text-sm text-gray-600">Quick Link</div>
        <a class="underline font-semibold" href="{{ route('admin.categories.index') }}">Manage Categories</a>
    </div>

    <div class="bg-white border rounded p-4">
        <div class="text-sm text-gray-600">Quick Link</div>
        <a class="underline font-semibold" href="{{ route('admin.orders.index') }}">View Orders</a>
    </div>
</div>
@endsection
