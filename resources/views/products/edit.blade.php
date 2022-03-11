@extends('layouts.base', ['title' => 'Edit Product'])

@section('content')
    <x-dashboard-title title="Edit Product" description="Ubah product atau layanan yang ada" />
    <form class="w-full p-5 space-y-5 bg-white rounded-md" style="flex: 1.5" method="POST"
        action="{{ route('products.update', [$product]) }}">
        @csrf
        @method('PUT')
        <x-form.input label="Nama" name="name" placeholder="Nama product" value="{{ $product->name }}"
            error="{{ $errors->first('name') }}" />
        <x-form.input label="Merk" name="merk" placeholder="Merk product" value="{{ $product->merk }}"
            error="{{ $errors->first('merk') }}" />
        <x-form.select placeholder="PILIH KATEGORI" name="category_id" label="Kategori"
            error="{{ $errors->first('category_id') }}">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected($category->id == $product->category_id)>{{ $category->name }}</option>
            @endforeach
        </x-form.select>
        <x-form.input type="number" label="Harga Beli" name="buy_price" placeholder="Harga beli product"
            value="{{ $product->buy_price }}" error="{{ $errors->first('buy_price') }}" />
        <x-form.input type="number" label="Harga Jual" name="price" placeholder="Harga jual product"
            value="{{ $product->price }}" error="{{ $errors->first('price') }}" />
        <x-form.input type="number" label="Stok" name="stock" placeholder="Stok product" value="{{ $product->stock }}"
            error="{{ $errors->first('stock') }}" />
        <x-form.input label="Satuan" name="unit" placeholder="Satuan product" value="{{ $product->unit }}"
            error="{{ $errors->first('unit') }}" />


        @if (session('product_success'))
            <div class="mb-5">
                <x-alert.success>{{ session('product_success') }}</x-alert.success>
            </div>
        @elseif (session('product_error'))
            <div class="mb-5">
                <x-alert.error>{{ session('product_error') }}</x-alert.error>
            </div>
        @endif

        <div class="flex items-center justify-center w-full gap-3">
            <a href="{{ route('products.index') }}" class="block w-full">
                <x-button.secondary class="w-full">Kembali</x-button.secondary>
            </a>
            <x-button.primary class="w-full" type="submit">Simpan</x-button.primary>
        </div>

    </form>
@endsection
