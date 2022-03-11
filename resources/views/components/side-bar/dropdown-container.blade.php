<div class="flex flex-col items-center" x-data="{show: false}">
    <div @click="show = !show"
        class="flex items-center justify-between w-full px-6 py-2 mt-4 text-gray-100 bg-opacity-25 cursor-pointer hover:bg-gray-800">
        <div>
            <i class="{{ $icon }}"></i>
            <span class="mx-3">{{ $name }}</span>

        </div>
        <span :class="`inline-block transform transition duration-300 ${show ? 'rotate-180' : 'rotate-0'}`">
            <i class="fa-solid fa-caret-down"></i>
        </span>
    </div>
    <div :class="`w-3/4 flex flex-col transition duration-300 transform overflow-hidden ${show ? 'h-full' : 'h-0'}`">
        {{ $slot }}
    </div>
</div>
