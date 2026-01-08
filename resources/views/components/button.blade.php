@props([
'variant' => 'primary', // primary|secondary|danger|ghost
'size' => 'md', // sm|md|lg
])
{{-- variant: primary|secondary|danger|ghost --}}
{{-- size: sm|md|lg --}}

@php
$base = "inline-flex items-center justify-center rounded-xl font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed";
$sz = match($size) {
'sm' => "px-3 py-2 text-sm",
'lg' => "px-5 py-3 text-base",
default => "px-4 py-2.5 text-sm",
};
$vr = match($variant) {
'secondary' => "bg-white border border-gray-200 text-gray-900 hover:bg-gray-50 focus:ring-gray-200",
'danger' => "bg-red-600 text-white hover:bg-red-700 focus:ring-red-300",
'ghost' => "bg-transparent text-gray-900 hover:bg-gray-100 focus:ring-gray-200",
default => "bg-gray-900 text-white hover:bg-gray-800 focus:ring-gray-300",
};
@endphp

<button
    type="{{ $attributes->get('type', 'button') }}"
    {{ $attributes->except('type')->merge(['class' => "$base $sz $vr"]) }}>
    {{ $slot }}
</button>