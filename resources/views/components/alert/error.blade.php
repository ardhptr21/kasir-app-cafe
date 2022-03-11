<div class="flex flex-row items-center p-3 bg-red-200 border-b-2 border-red-300 rounded alert" x-data="{remove: false}"
    x-if="remove && $el.remove()">
    <div
        class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-red-500 bg-red-100 border-2 border-red-600 rounded-full alert-icon">
        <i class="fa-solid fa-bomb"></i>
    </div>
    <div class="w-full ml-4 alert-content">
        <div class="text-lg font-semibold text-red-800 alert-title">
            Error
        </div>
        <div class="text-sm text-red-600 alert-description">
            {{ $slot }}
        </div>
    </div>
    @if ($attributes->has('closeable'))
        <div class="w-full mr-5 text-right text-red-800 hover:text-red-700">
            <i class="cursor-pointer fa-solid fa-xmark fa-2x" @click="remove=true"></i>
        </div>
    @endif
</div>
