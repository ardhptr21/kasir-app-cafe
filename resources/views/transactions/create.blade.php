@extends('layouts.base', ['title' => 'Buat Transaksi'])

@section('content')
    <x-dashboard-title title="Buat Transaksi" description="Buat transaksi baru disini" />

    @if (session('cart_success'))
        <x-alert.success closeable>{{ session('cart_success') }}</x-alert.success>
    @elseif (session('cart_error'))
        <x-alert.error closeable>{{ session('cart_error') }}</x-alert.error>
    @endif

    <div class="flex flex-row justify-between w-full gap-3 p-5 my-5 bg-white rounded-md shadow-md"
        x-data="{products: [], loading: false}">
        <div class="w-96">
            <h2 class="mb-3 text-xl font-bold">Pencarian</h2>
            <x-form.input name="product" placeholder="Cari product"
                @keyup.enter="loading = true; products = [];products = await getProducts($el.value, () => loading = false)" />
        </div>
        <div class="w-full">
            <h2 class="mb-3 text-xl font-bold">Hasil pencarian</h2>
            <x-table.container x-show="products.length">
                <x-slot:head>
                    <x-table.th>No</x-table.th>
                    <x-table.th>Nama</x-table.th>
                    <x-table.th>Kategori</x-table.th>
                    <x-table.th>Harga</x-table.th>
                    <x-table.th>Aksi</x-table.th>
                </x-slot:head>
                <x-slot:body>
                    <template x-for="(product, idx) in products" :key="product.id">
                        <tr>
                            <x-table.td x-text="idx + 1"></x-table.td>
                            <x-table.td x-text="product.name"></x-table.td>
                            <x-table.td x-text="product.category.name"></x-table.td>
                            <x-table.td x-text="product.price"></x-table.td>
                            <x-table.td>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" :value="product.id">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="total_price" :value="product.price">
                                    <button class="flex items-center justify-center p-2 text-white bg-green-500 rounded-md"
                                        type="submit">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                            </x-table.td>
                        </tr>
                    </template>
                </x-slot:body>
            </x-table.container>
            <x-alert.info x-show="!products.length">
                <p x-show="!loading">Tidak ada hasil pencarian</p>

                <span x-show="loading">
                    <i class="fa-spin fa-solid fa-circle-notch"></i>
                    <small class="text-sm">Tunggu Sebentar</small>
                </span>
            </x-alert.info>
        </div>
    </div>

    @if ($carts->isNotEmpty())
        <div class="mb-2">
            <form action="{{ route('cart.truncate') }}" method="POST" x-data="{}" x-ref="form">
                @csrf
                @method('DELETE')
                <x-button.danger @click.prevent="if(confirm('Yakin ingin mengosongkan keranjang?')) $refs.form.submit()"><i
                        class="fa-solid fa-cart-arrow-down"></i> Kosongkan</x-button.danger>
            </form>
        </div>
        <x-table.container>
            <x-slot:head>
                <x-table.th>No</x-table.th>
                <x-table.th>Nama Product</x-table.th>
                <x-table.th>Jumlah</x-table.th>
                <x-table.th>Harga</x-table.th>
                <x-table.th>Total</x-table.th>
                <x-table.th>Kasir</x-table.th>
                <x-table.th>Aksi</x-table.th>
            </x-slot:head>
            <x-slot:body>
                @foreach ($carts as $cart)
                    <tr x-data="{quantity: {{ $cart->quantity }}}">
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $cart->product->name }}</x-table.td>
                        <x-table.td>
                            <x-form.input min="1" name="quantity" type="number" placeholder="Jumlah product"
                                ::value="quantity" @change="quantity = $el.value" />
                        </x-table.td>
                        <x-table.td>Rp. {{ number_format($cart->product->price) }}</x-table.td>
                        <x-table.td>Rp.
                            {{ number_format($cart->total_price) }}
                        </x-table.td>
                        <x-table.td>{{ $cart->user->name }}</x-table.td>
                        <x-table.td>
                            <div class="flex gap-2">
                                <form action="{{ route('cart.update', [$cart]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" :value="quantity">
                                    <button
                                        class="flex items-center justify-center p-2 text-white bg-yellow-500 rounded-md">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </form>
                                <form action="{{ route('cart.destroy', [$cart]) }}" method="POST" x-data="{}"
                                    x-ref="form">
                                    @csrf
                                    @method('DELETE')
                                    <button @click.prevent="if(confirm('Yakin ingin menghapus')) $refs.form.submit()"
                                        type="submit"
                                        class="flex items-center justify-center p-2 text-white bg-red-500 rounded-md">
                                        <i class="fa-solid fa-dumpster-fire"></i>
                                    </button>
                                </form>
                            </div>
                        </x-table.td>
                    </tr>
                @endforeach

            </x-slot:body>
        </x-table.container>

        <div class="flex items-start justify-between mt-5">
            <div class="w-full">
                <x-form.input name="total_all" placeholder="Total Semua" :is-edit="false"
                    value="Rp. {{ sum_all_array_key($carts->toArray(), 'total_price') }}" />
            </div>
            <form class="flex items-center justify-center w-full gap-3" action="{{ route('transactions.store') }}"
                method="POST">
                @csrf
                <x-form.input name="cash" placeholder="Uang Pembayaran" type="number" required
                    min="{{ sum_all_array_key($carts->toArray(), 'total_price') }}" />
                <input type="hidden" name="total_all" value="{{ sum_all_array_key($carts->toArray(), 'total_price') }}">
                <x-button.primary class="w-64" type="submit"><i class="fa-solid fa-coins"></i> Bayar
                </x-button.primary>
            </form>
        </div>
    @else
        <x-alert.info>Keranjang transaksi masih kosong</x-alert.info>
    @endif
@endsection
