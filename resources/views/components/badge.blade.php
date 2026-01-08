@props(['tone' => 'gray'])
{{-- tone: gray|green|yellow|blue|red --}}

@php
$base = "inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold border";

$clr = match($tone) {
    'green' => "bg-green-50 text-green-700 border-green-200",
    'yellow' => "bg-yellow-50 text-yellow-700 border-yellow-200",
    'blue' => "bg-blue-50 text-blue-700 border-blue-200",
    'red' => "bg-red-50 text-red-700 border-red-200",
    default => "bg-gray-50 text-gray-700 border-gray-200",
};
@endphp

<span {{ $attributes->merge(['class' => "$base $clr"]) }}>
    {{ $slot }}
</span>
