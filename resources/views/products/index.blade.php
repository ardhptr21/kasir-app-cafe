@extends('layouts.base', ['title' => 'Products'])

@section('content')
    <x-dashboard-title title="Product" description="Lihat dan kelola product" />

    @if (session('product_success'))
        <div class="mb-5">
            <x-alert.success>
                {{ session('product_success') }}
            </x-alert.success>
        </div>
    @elseif (session('product_error'))
        <div class="mb-5">
            <x-alert.error>
                {{ session('product_error') }}
            </x-alert.error>
        </div>
    @endif

    <div class="flex items-center justify-start w-full gap-3 mb-5" x-init="showModal = false" x-data="{showModal: false}">

        {{-- Modal Box --}}
        <button @click="showModal = true"
            class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
        <div x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-5 overflow-auto text-gray-500 bg-black bg-opacity-40"
            x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div x-show="showModal" class="w-8/12 max-h-full p-6 overflow-y-auto bg-white shadow-2xl rounded-xl"
                @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease duration-100 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-1">

                <form class="space-y-5" action="{{ route('products.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <x-form.input label="Nama" name="name" placeholder="Nama product" />
                    <x-form.input label="Merk" name="merk" placeholder="Merk product" />
                    <x-form.select placeholder="PILIH KATEGORI" name="category_id" label="Kategori">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.input type="number" label="Harga Beli" name="buy_price" placeholder="Harga beli product" />
                    <x-form.input type="number" label="Harga Jual" name="price" placeholder="Harga jual product" />
                    <x-form.input type="number" label="Stok" name="stock" placeholder="Stok product" />
                    <x-form.input label="Satuan" name="unit" placeholder="Satuan product" />

                    <div class="mt-5 space-x-5 text-right">
                        <button type="submit"
                            class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
                        <button type="button" @click="showModal = false"
                            class="px-5 py-3 text-sm text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-gray-100">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full" style="flex: 2">
            <x-form.input name="product" placeholder="Cari product" :is-edit="true" autocomplete="off"
                value="{{ Request::get('product') ?? '' }}"
                @keyup.enter="addUrlSearchParams({key: $el.name, value: $el.value})" />
        </div>

        <div class="w-full" style="flex: 1">
            <x-form.select placeholder="PILIH KATEGORI" name="category"
                @change="addUrlSearchParams({key: $el.name, value: $el.value})">

                <option value="" selected>Semua</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected(Request::get('category') == $category->name)>{{ $category->name }}</option>
                @endforeach
            </x-form.select>
        </div>

        <a href="{{ route('products.index') }}">
            <x-button.secondary>Reset</x-button.secondary>
        </a>
    </div>
    @if ($errors->count() > 0)
        <ul class="inline-block p-5 mb-5 text-white bg-red-500 rounded-md">
            @foreach ($errors->all() as $error)
                <li>* {{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if ($products->isNotEmpty())
        <x-table.container>
            <x-slot:head>
                <x-table.th>No</x-table.th>
                <x-table.th>Nama</x-table.th>
                <x-table.th>Merk</x-table.th>
                <x-table.th>Kategori</x-table.th>
                <x-table.th>Harga Beli</x-table.th>
                <x-table.th>Harga Jual</x-table.th>
                <x-table.th>Stok</x-table.th>
                <x-table.th>Satuan</x-table.th>
                <x-table.th>Ditambahkan</x-table.th>
                <x-table.th>Aksi</x-table.th>
            </x-slot:head>
            <x-slot:body>
                @foreach ($products as $product)
                    <tr>
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $product->name }}</x-table.td>
                        <x-table.td>{{ $product->merk }}</x-table.td>
                        <x-table.td>{{ $product->category->name }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($product->buy_price) }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($product->price) }}</x-table.td>
                        <x-table.td>{{ $product->stock }}</x-table.td>
                        <x-table.td>{{ $product->unit }}</x-table.td>
                        <x-table.td>{{ $product->created_at->format('j F Y') }}</x-table.td>
                        <x-table.td>
                            <x-table.action-data :with-detail="false"
                                edit-action="{{ route('products.edit', [$product]) }}"
                                remove-action="{{ route('products.destroy', [$product]) }}" />
                        </x-table.td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table.container>
    @else
        <x-alert.info>
            Tidak ada product yang tersedia saat ini
        </x-alert.info>
    @endif

@endsection
