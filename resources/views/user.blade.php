@extends('layouts.base', ['title' => 'User'])

@section('content')
    <x-dashboard-title title="Data Diri Anda" description="Kelola data diri anda" />

    @if (session('users_success'))
        <div class="mb-5">
            <x-alert.success>{{ session('users_success') }}</x-alert.success>
        </div>
    @elseif (session('users_error'))
        <div class="mb-5">
            <x-alert.error>{{ session('users_error') }}</x-alert.error>
        </div>
    @endif

    <div class="flex items-start justify-center w-full gap-5">
        <form action="{{ route('users.update', [auth()->user(), 'ref' => 'user']) }}"
            class="w-full p-5 space-y-5 bg-white rounded-md" style="flex: 1.5" method="POST">
            @csrf
            @method('PUT')
            <h2 class="text-3xl font-bold">Profil Pengguna</h2>

            @if (Request::get('edit') != 'true' ||
    auth()->user()->isOwner())
                <x-form.input :is-edit="Request::get('edit') == 'true'" placeholder="Nama" name="name" autocomplete="off"
                    value="{{ auth()->user()->name }}" error="{{ $errors->first('name') }}" />
            @endif

            <x-form.input :is-edit="Request::get('edit') == 'true'" type="email" name="email" placeholder="Email"
                autocomplete="off" value="{{ auth()->user()->email }}" error="{{ $errors->first('email') }}"
                label="Email" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" name="phone" placeholder="Telepon" autocomplete="off"
                value="{{ auth()->user()->phone }}" error="{{ $errors->first('phone') }}" label="Telepon" />

            @if (auth()->user()->isOwner())
                <x-form.input :is-edit="Request::get('edit') == 'true'" placeholder="NIK" name="nik" autocomplete="off"
                    value="{{ auth()->user()->nik }}" error="{{ $errors->first('nik') }}" label="NIK" />
            @endif

            @if (Request::get('edit') != 'true')
                <x-form.select placeholder="PILIH ROLE" name="role" :is-edit="Request::get('edit') == 'true'"
                    value="{{ auth()->user()->role }}" disabled>
                    @if (auth()->user()->isOwner())
                        <option selected>Owner</option>
                    @else
                        <option @selected(auth()->user()->role == 'user') value="user">User</option>
                        <option @selected(auth()->user()->role == 'admin') value="admin">Admin</option>
                    @endif
                </x-form.select>
            @endif


            @if (Request::get('edit') != 'true')
                <a href="{{ route('user', ['edit' => 'true']) }}" class="block">
                    <x-button.warning class="w-full">Edit</x-button.warning>
                </a>
            @else
                <div class="flex items-center justify-center w-full gap-3">
                    <a href="{{ route('user', ['user' => auth()->user()->id]) }}" class="block w-full">
                        <x-button.secondary class="w-full">Batal</x-button.secondary>
                    </a>
                    <x-button.primary class="w-full" type="submit">Simpan</x-button.primary>
                </div>
            @endif
        </form>
        <form style="flex: 1" class="w-full p-5 space-y-5 bg-white rounded-md" method="POST"
            action="{{ route('users.change-password', [auth()->user(), 'ref' => 'user']) }}">
            @csrf
            @method('PUT')
            <h2 class="text-3xl font-bold">Ganti Password</h2>
            <x-form.input placeholder="Username" name="username" autocomplete="off"
                value="{{ auth()->user()->username }}" :is-edit="auth()->user()->isOwner()" />
            <x-form.input type="password" name="password" placeholder="Password" autocomplete="off" :is-edit="true"
                error="{{ $errors->first('password') }}" />
            <x-button.primary type="submit" class="w-full">Simpan</x-button.primary>
        </form>
    </div>
@endsection
