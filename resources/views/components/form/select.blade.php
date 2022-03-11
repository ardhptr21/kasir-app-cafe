@if ($isEdit)
    <div class="w-full space-y-3">
        @if ($label)
            <label for="{{ $name }}" class="font-bold text-indigo-600">{{ $label }}</label>
        @endif
        <select @if ($name) name="{{ $name }}" @endif
            class="w-full p-3 text-base border rounded-md outline-none focus-visible:shadow-none disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-500"
            @if ($label) id="{{ $name }}" @endif {{ $attributes }}>
            <option value="" hidden disabled selected>-- {{ $placeholder }} --</option>
            {{ $slot }}
        </select>
    </div>
@else
    <div class="flex justify-between gap-5">
        <div class="flex items-center justify-between font-bold" style="flex: 0.5">
            <h3>{{ explode(' ', str($placeholder)->title)[1] }}</h3>
            <span>:</span>
        </div>
        <p style="flex: 2">{{ str($value)->title }}</p>
    </div>
@endif
