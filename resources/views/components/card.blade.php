@props(['class' => ''])

<div {{ $attributes->merge(['class' => "bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-sm $class"]) }}>
    {{ $slot }}
</div>
