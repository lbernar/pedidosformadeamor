@props(['width' => 300, 'height' => 200, 'text' => 'No Image', 'class' => ''])

<svg class="{{ $class }}" width="{{ $width }}" height="{{ $height }}" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="{{ $text }}">
    <rect width="100%" height="100%" fill="#e5e7eb"/>
    <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="18" fill="#9ca3af">
        {{ $text }}
    </text>
</svg>

