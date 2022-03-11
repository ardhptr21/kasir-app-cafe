@extends('layouts.base', ['title' => 'Barang'])

@section('content')
    <x-dashboard-title title="Barang" description="Lihat dan kelola barang" />
    @if (session('category_success'))
        <x-alert.success closeable>{{ session('category_success') }}</x-alert.success>
    @elseif (session('category_error'))
        <x-alert.error closeable>{{ session('category_error') }}</x-alert.error>
    @endif
    <div class="my-5">
        <form class="flex items-start justify-start w-full gap-3 mb-3" action="{{ route('categories.store') }}"
            method="POST">
            @csrf
            <x-form.input name="name" placeholder="Tambah kategori" :is-edit="true" autocomplete="off"
                error="{{ $errors->first('name') }}" />
            <x-button.primary type="submit">Tambah</x-button.primary>
        </form>
        <div class="flex items-center justify-center gap-3">
            <input type="text" name="category"
                class="w-full p-3 text-base border rounded-md outline-none focus-visible:shadow-none focus:border-indigo-600"
                placeholder="Cari kategori" autocomplete="off" x-data
                @keyup.enter="addUrlSearchParams({key: $el.name, value: $el.value})"
                value="{{ Request::get('category') }}" />
            <a href="{{ route('users.index') }}">
                <x-button.secondary>Reset</x-button.secondary>
            </a>
        </div>
    </div>

    @if ($categories->isNotEmpty())
        <x-table.container>
            <x-slot:head>
                <x-table.th>No</x-table.th>
                <x-table.th>Nama</x-table.th>
                <x-table.th>Digunakan</x-table.th>
                <x-table.th>Ditambahkan Pada</x-table.th>
                <x-table.th>Aksi</x-table.th>
            </x-slot:head>
            <x-slot:body>
                @foreach ($categories as $category)
                    <tr>
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $category->name }}</x-table.td>
                        <x-table.td>{{ $category->products->count() }}</x-table.td>
                        <x-table.td>{{ $category->created_at->format('j F Y') }}</x-table.td>
                        <x-table.td>
                            <x-table.action-data
                                remove-action="{{ route('categories.destroy', ['category' => $category->id]) }}"
                                :with-detail="false" :with-edit="false" />
                        </x-table.td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table.container>
    @else
        <x-alert.info>Tidak kategori tersedia</x-alert.info>
    @endif

@endsection
