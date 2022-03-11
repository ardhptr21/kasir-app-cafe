@extends('layouts.base', ['title' => 'Informasi Member'])

@section('content')
    <x-dashboard-title :title="'Member - ' . $member->member_code" description="Ubah data dari member" />
    @if (session('member_success'))
        <div class="mb-5">
            <x-alert.success closeable>{{ session('member_success') }}</x-alert.success>
        </div>
    @elseif (session('member_error'))
        <div class="mb-5">
            <x-alert.error closeable>{{ session('member_error') }}</x-alert.error>
        </div>
    @endif
    <div class="w-full">
        <div class="relative p-12 space-y-5 bg-white rounded-lg shadow-lg">
            <form class="space-y-5" method="POST" action="{{ route('members.update', [$member]) }}">
                @csrf
                @method('PUT')

                <x-form.input label="Nama" name="name" placeholder="Nama member" :is-edit="Request::get('edit') == 'true'"
                    :value="$member->name" />
                <x-form.input type="number" label="Telepon" name="phone" placeholder="Telepon member"
                    :is-edit="Request::get('edit') == 'true'" :value="$member->phone" />
                <x-form.textarea label="Alamat" name="address" placeholder="Alamat member" rows="8"
                    :is-edit="Request::get('edit') == 'true'" :value="$member->address" />
                @if (Request::get('edit') != 'true')
                    <x-form.input type="text" name="member_code" placeholder="Kode Member" :value="$member->member_code"
                        :is-edit="false" />
                    <x-form.input type="text" name="member_code" placeholder="Ditambahkan Pada"
                        :value="$member->created_at->format('j F Y')" :is-edit="false" />
                @endif

                <a href="{{ route('members.index') }}">
                    <x-button.secondary>Kembali</x-button.secondary>
                </a>
                @if (Request::get('edit') != 'true')
                    <a href="{{ route('members.show', [$member, 'edit' => 'true']) }}" class="inline-block">
                        <x-button.warning>Edit Member</x-button.warning>
                    </a>
                @else
                    <x-button.primary type="submit">Simpan</x-button.primary>
                @endif
            </form>
        </div>
    </div>
@endsection
