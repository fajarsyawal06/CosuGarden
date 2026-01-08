<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin - CosuGarden' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 text-gray-900">
@php
    $is = fn($name) => request()->routeIs($name);
@endphp

<div class="min-h-screen flex">
    <!-- Sidebar desktop -->
    <aside class="hidden md:flex w-72 flex-col bg-white/80 backdrop-blur border-r border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gray-900 text-white grid place-items-center font-bold">C</div>
                <div>
                    <div class="font-extrabold leading-none">CosuGarden</div>
                    <div class="text-xs text-gray-500">Admin Panel</div>
                </div>
            </div>
        </div>

        <nav class="p-3 space-y-1">
            <a href="{{ route('admin.costumes.index') }}"
               class="block px-4 py-3 rounded-2xl font-semibold transition {{ $is('admin.costumes.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                Costumes
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="block px-4 py-3 rounded-2xl font-semibold transition {{ $is('admin.categories.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                Categories
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="block px-4 py-3 rounded-2xl font-semibold transition {{ $is('admin.orders.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                Orders
            </a>
        </nav>

        <div class="mt-auto p-4 border-t border-gray-200">
            <a class="text-sm font-semibold underline" href="{{ route('shop.index') }}">View Shop</a>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1">
        <!-- Topbar -->
        <header class="sticky top-0 z-40 bg-white/70 backdrop-blur border-b border-gray-200">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <!-- Mobile menu button -->
                    <button id="btnSidebar" class="md:hidden px-3 py-2 rounded-xl hover:bg-gray-100 font-semibold">
                        Menu
                    </button>
                    <div class="font-extrabold">
                        {{ $header ?? 'Admin' }}
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-sm text-gray-600">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button variant="ghost" size="sm" type="submit">Logout</x-button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Mobile sidebar overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 z-50 hidden md:hidden">
            <div class="absolute inset-0 bg-black/30" id="overlayBg"></div>
            <div class="absolute left-0 top-0 h-full w-72 bg-white border-r border-gray-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="font-extrabold">Admin Panel</div>
                    <button id="btnClose" class="px-3 py-2 rounded-xl hover:bg-gray-100 font-semibold">Close</button>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('admin.costumes.index') }}"
                       class="block px-4 py-3 rounded-2xl font-semibold {{ $is('admin.costumes.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                        Costumes
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                       class="block px-4 py-3 rounded-2xl font-semibold {{ $is('admin.categories.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                        Categories
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                       class="block px-4 py-3 rounded-2xl font-semibold {{ $is('admin.orders.*') ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                        Orders
                    </a>
                </div>

                <div class="mt-6">
                    <a class="text-sm font-semibold underline" href="{{ route('shop.index') }}">View Shop</a>
                </div>
            </div>
        </div>

        <main class="max-w-6xl mx-auto px-4 py-6">
            @include('partials.flash')
            @include('partials.errors')
            @yield('content')
        </main>
    </div>
</div>

<script>
    const overlay = document.getElementById('sidebarOverlay');
    const btn = document.getElementById('btnSidebar');
    const closeBtn = document.getElementById('btnClose');
    const bg = document.getElementById('overlayBg');

    function openSidebar(){ overlay.classList.remove('hidden'); }
    function closeSidebar(){ overlay.classList.add('hidden'); }

    if(btn) btn.addEventListener('click', openSidebar);
    if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if(bg) bg.addEventListener('click', closeSidebar);
</script>
</body>
</html>
