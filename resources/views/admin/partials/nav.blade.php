@php
    $is = fn($name) => request()->routeIs($name) ? 'bg-gray-100 font-semibold' : '';
@endphp

<a href="{{ route('admin.costumes.index') }}"
   class="block px-3 py-2 rounded {{ $is('admin.costumes.*') }}">
    Costumes
</a>

<a href="{{ route('admin.categories.index') }}"
   class="block px-3 py-2 rounded {{ $is('admin.categories.*') }}">
    Categories
</a>

<a href="{{ route('admin.orders.index') }}"
   class="block px-3 py-2 rounded {{ $is('admin.orders.*') }}">
    Orders
</a>
