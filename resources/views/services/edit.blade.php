@extends('layouts.base', ['title' => 'Edit Service'])

@section('content')
    <x-dashboard-title title="Edit Service" description="Ubah service atau layanan yang ada" />
    <form class="w-full p-5 space-y-5 bg-white rounded-md" style="flex: 1.5" method="POST"
        action="{{ route('services.update', [$service]) }}">
        @csrf
        @method('PUT')
        <x-form.input label="Nama" name="name" placeholder="Nama service" value="{{ $service->name }}"
            error="{{ $errors->first('name') }}" />
        <x-form.select placeholder="PILIH KATEGORI" name="category_id" label="Kategori"
            error="{{ $errors->first('category_id') }}">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected($category->id ==
                    $service->category_id)>{{ $category->name }}</option>
            @endforeach
        </x-form.select>
        <x-form.input type="number" label="Harga" name="price" placeholder="Harga service" value="{{ $service->price }}"
            error="{{ $errors->first('price') }}" />


        @if (session('service_success'))
            <div class="mb-5">
                <x-alert.success>{{ session('service_success') }}</x-alert.success>
            </div>
        @elseif (session('service_error'))
            <div class="mb-5">
                <x-alert.error>{{ session('service_error') }}</x-alert.error>
            </div>
        @endif

        <div class="flex items-center justify-center w-full gap-3">
            <a href="{{ route('services.index') }}" class="block w-full">
                <x-button.secondary class="w-full">Kembali</x-button.secondary>
            </a>
            <x-button.primary class="w-full" type="submit">Simpan</x-button.primary>
        </div>

    </form>
@endsection
