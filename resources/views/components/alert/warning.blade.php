<div class="flex flex-row items-center p-3 bg-yellow-200 border-b-2 border-yellow-300 rounded alert"
    x-data="{remove: false}" x-if="remove && $el.remove()">
    <div
        class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-yellow-500 bg-yellow-100 border-2 border-yellow-600 rounded-full alert-icon">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <div class="w-full ml-4 alert-content">
        <div class="text-lg font-semibold text-yellow-800 alert-title">
            Warning
        </div>
        <div class="text-sm text-yellow-600 alert-description">
            {{ $slot }}
        </div>
    </div>
    @if ($attributes->has('closeable'))
        <div class="w-full mr-5 text-right text-yellow-800 hover:text-yellow-700">
            <i class="cursor-pointer fa-solid fa-xmark fa-2x" @click="remove=true"></i>
        </div>
    @endif
</div>
