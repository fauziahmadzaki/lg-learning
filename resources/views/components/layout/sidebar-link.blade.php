@props(['active' => false, 'href', 'icon' => null])

@php
    $commonClasses = 'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group';
    $activeClasses = 'bg-indigo-50 text-indigo-600';
    $inactiveClasses = 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';

    $classes = $commonClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
    
    // Icon classes handling: apply colors to the wrapper which SVG will inherit via currentColor
    $iconClasses = 'w-5 h-5 transition-colors ' . ($active ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500');
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <div class="{{ $iconClasses }}">
            {{ $icon }}
        </div>
    @elseif ($slot->isEmpty())
         {{-- Fallback if no icon and no slot (rare) --}}
    @endif

    {{-- If user passes text in slot --}}
    <span class="font-medium text-sm">{{ $slot }}</span>
</a>
