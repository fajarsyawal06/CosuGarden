<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CosuGarden Shop' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 text-gray-900">
    <nav class="sticky top-0 z-40 bg-white/70 backdrop-blur border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-gray-900 text-white grid place-items-center font-bold">C</div>
                <div>
                    <div class="font-extrabold leading-none">CosuGarden</div>
                    <div class="text-xs text-gray-500">Costume shop for cosplayers</div>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('cart.index') }}" class="px-3 py-2 rounded-xl hover:bg-gray-100 text-sm font-semibold">
                    Cart
                </a>

                @auth
                    <a href="{{ route('orders.my') }}" class="px-3 py-2 rounded-xl hover:bg-gray-100 text-sm font-semibold">
                        My Orders
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.costumes.index') }}" class="px-3 py-2 rounded-xl hover:bg-gray-100 text-sm font-semibold">
                            Admin
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button variant="ghost" size="sm" type="submit">Logout</x-button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-xl hover:bg-gray-100 text-sm font-semibold">Login</a>
                    <a href="{{ route('register') }}">
                        <x-button size="sm">Register</x-button>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @include('partials.flash')
        @include('partials.errors')
        @yield('content')
    </main>

    <footer class="border-t border-gray-200 mt-10">
        <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-gray-500 flex justify-between">
            <span>© {{ date('Y') }} CosuGarden</span>
            <span class="hidden sm:block">Built with Laravel + Blade</span>
        </div>
    </footer>
</body>
</html>
