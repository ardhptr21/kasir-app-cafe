@extends('layouts.base', ['title' => 'Services'])

@section('content')
    <x-dashboard-title title="Service" description="Lihat dan kelola service" />

    @if (session('service_success'))
        <div class="mb-5">
            <x-alert.success>
                {{ session('service_success') }}
            </x-alert.success>
        </div>
    @elseif (session('service_error'))
        <div class="mb-5">
            <x-alert.error>
                {{ session('service_error') }}
            </x-alert.error>
        </div>
    @endif

    <div class="flex items-center justify-start w-full gap-3 mb-5" x-init="showModal = false" x-data="{showModal: false}">

        {{-- Modal Box --}}
        <button @click="showModal = true"
            class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
        <div x-show="showModal"
            class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center overflow-auto text-gray-500 bg-black bg-opacity-40"
            x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div x-show="showModal" class="p-6 mx-10 bg-white shadow-2xl rounded-xl sm:w-8/12"
                @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease duration-100 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-1">

                <form class="space-y-5" action="{{ route('services.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <x-form.input label="Nama" name="name" placeholder="Nama service" />
                    <x-form.select placeholder="PILIH KATEGORI" name="category_id" label="Kategori">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.input type="number" label="Harga" name="price" placeholder="Harga service" />

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
            <x-form.input name="service" placeholder="Cari service" :is-edit="true" autocomplete="off"
                value="{{ Request::get('service') ?? '' }}"
                @keyup.enter="addUrlSearchParams({key: $el.name, value: $el.value})" />
        </div>

        <div class="w-full" style="flex: 1">
            <x-form.select placeholder="PILIH KATEGORI" name="category"
                @change="addUrlSearchParams({key: $el.name, value: $el.value})">

                <option value="" selected>Semua</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->name }}" @selected(Request::get('category')==$category->
                        name)>{{ $category->name }}</option>
                @endforeach
            </x-form.select>
        </div>

        <a href="{{ route('services.index') }}">
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

    @if ($services->isNotEmpty())
        <x-table.container>
            <x-slot:head>
                <x-table.th>No</x-table.th>
                <x-table.th>Nama</x-table.th>
                <x-table.th>Kategori</x-table.th>
                <x-table.th>Harga</x-table.th>
                <x-table.th>Ditambahkan Pada</x-table.th>
                <x-table.th>Aksi</x-table.th>
            </x-slot:head>
            <x-slot:body>
                @foreach ($services as $service)
                    <tr>
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $service->name }}</x-table.td>
                        <x-table.td>{{ $service->category->name }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($service->price, 2) }}</x-table.td>
                        <x-table.td>{{ $service->created_at->format('j F Y') }}</x-table.td>
                        <x-table.td>
                            <x-table.action-data :with-detail="false"
                                edit-action="{{ route('services.edit', [$service]) }}"
                                remove-action="{{ route('services.destroy', [$service]) }}" />
                        </x-table.td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table.container>
    @else
        <x-alert.info>
            Tidak ada service yang tersedia saat ini
        </x-alert.info>
    @endif

@endsection
