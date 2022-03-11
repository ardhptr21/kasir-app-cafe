@extends('layouts.base')

@section('content')
    <x-dashboard-title title="Ringkasan" description="Ringkasan beberapa hal dalam kasir" />

    <div class="grid grid-cols-4 gap-5">
        <x-card.overview title="Total Barang" value="{{ $productsCount }}" color="bg-red-500" icon="fa-solid fa-box" />
        <x-card.overview title="Total Kategori" value="{{ $categoriesCount }}" color="bg-blue-500"
            icon="fa-solid fa-cubes" />
    </div>
@endsection
