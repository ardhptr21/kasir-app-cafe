@if ($isEdit)
    <div class="w-full space-y-2">
        @if ($label)
            <label for="{{ $name }}" class="font-bold text-indigo-600">{{ $label }}</label>
        @endif
        <input type="{{ $type }}" @if ($name) name="{{ $name }}" @endif
            placeholder="{{ $placeholder }}"
            class="w-full p-3 text-base border rounded-md outline-none read-only:border-none focus-visible:shadow-none focus:border-indigo-600 read-only:cursor-not-allowed read-only:bg-gray-300 read-only:text-gray-500"
            @if ($label) id="{{ $name }}" @endif value="{{ $value }}"
            {{ $attributes }} />
        @if ($error)
            <small class="inline-block text-red-500">* {{ $error }}</small>
        @endif
    </div>
@else
    <div class="flex justify-between gap-5">
        <div class="flex items-center justify-between font-bold" style="flex: 0.5">
            <h3>{{ $placeholder }}</h3>
            <span>:</span>
        </div>
        <p style="flex: 2">{{ $value }}</p>
    </div>
@endif
