<header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
    <div class="flex flex-col justify-center gap-1">
        <p class="font-bold">{{ auth()->user()->name }}</p>
        <small class="inline-block -mt-2 font-semibold text-indigo-500">{{ str(auth()->user()->role)->title }}</small>
    </div>
    <div class="text-center">
        <?php $shop = App\Models\Shop::first(); ?>
        <h5 class="text-lg font-bold uppercase">{{ $shop?->name }}</h5>
        <p class="text-xs font-medium uppercase">{{ $shop?->address }}</p>
        <p class="text-xs">{{ $shop?->email }} - {{ $shop?->phone }}</p>
    </div>
    <a href="{{ route('auth.logout') }}">
        <x-button.primary>Logout</x-button.primary>
    </a>
</header>
