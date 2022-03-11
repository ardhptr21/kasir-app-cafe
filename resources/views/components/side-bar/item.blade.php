<a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-opacity-25 hover:bg-gray-800 {{ $attributes->has('rounded') ? 'rounded-md' : '' }}"
    href="{{ $link }}">
    <i class="{{ $icon }}"></i>

    <span class="mx-3">{{ $name }}</span>
</a>
