<div class="flex flex-row items-center p-3 bg-blue-200 border-b-2 border-blue-300 rounded alert" x-data="{remove: false}"
    {{ $attributes }} x-if="remove && $el.remove()">
    <div
        class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-blue-500 bg-blue-100 border-2 border-blue-600 rounded-full alert-icon">
        <i class="fa-solid fa-bullhorn"></i>
    </div>
    <div class="w-full ml-4 alert-content">
        <div class="text-lg font-semibold text-blue-800 alert-title">
            Info
        </div>
        <div class="text-sm text-blue-600 alert-description">
            {{ $slot }}
        </div>
    </div>
    @if ($attributes->has('closeable'))
        <div class="w-full mr-5 text-right text-blue-800 hover:text-blue-700">
            <i class="cursor-pointer fa-solid fa-xmark fa-2x" @click="remove=true"></i>
        </div>
    @endif
</div>
