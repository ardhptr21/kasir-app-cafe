<x-side-bar.container title="Dashboard">
    <x-side-bar.item name="Ringkasan" icon="fa-solid fa-bars-progress" link="{{ route('index') }}" />

    <x-side-bar.item name="Transaksi" icon="fa-solid fa-receipt" link="{{ route('transactions.create') }}" />
    <x-side-bar.item name="Laporan" icon="fa-solid fa-table" link="{{ route('transactions.index') }}" />

    @can('admin')
        <x-side-bar.dropdown-container name="Data" icon="fa-solid fa-database">
            <x-side-bar.item name="Member" icon="fa-solid fa-user-check" link="{{ route('members.index') }}" rounded />
            <x-side-bar.item name="Service" icon="fa-solid fa-bell-concierge" link="{{ route('services.index') }}"
                rounded />
            <x-side-bar.item name="Kategori" icon="fa-solid fa-cubes" link="{{ route('categories.index') }}" rounded />
        </x-side-bar.dropdown-container>
    @endcan
    <x-side-bar.dropdown-container name="Settings" icon="fa-solid fa-gear">
        @can('owner')
            <x-side-bar.item name="Toko" icon="fa-solid fa-store" link="{{ route('shop.index') }}" rounded />
            <x-side-bar.item name="Users" icon="fa-solid fa-users" link="{{ route('users.index') }}" rounded />
        @endcan
        <x-side-bar.item name="Anda" icon="fa-solid fa-user" link="{{ route('user') }}" />
    </x-side-bar.dropdown-container>
</x-side-bar.container>
