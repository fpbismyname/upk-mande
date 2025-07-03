@props(['iconName' => 'blend', 'size' => 4])

<i data-lucide="{{ $iconName }}" {{ $attributes->merge(['class' => "w-$size h-$size"]) }}></i>
