<div class="max-w-full min-w-max">
    <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
        <div
            class="p-3 w-14 h-14 flex justify-center items-center text-white {{ $color ? $color : 'bg-indigo-600' }} bg-opacity-75 rounded-full">
            <i class="{{ $icon }} fa-xl"></i>
        </div>

        <div class="mx-5">
            <h4 class="text-3xl font-semibold text-gray-700">{{ $value }}</h4>
            <div class="text-gray-500">{{ $title }}</div>
        </div>
    </div>
</div>
