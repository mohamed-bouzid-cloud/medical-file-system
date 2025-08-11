@props(['title', 'color' => 'text-blue-400'])

<div class="bg-card rounded-2xl shadow-xl p-6 space-y-4">
    <h3 class="text-xl font-semibold {{ $color }} mb-2">{{ $title }}</h3>
    {{ $slot }}
</div>
