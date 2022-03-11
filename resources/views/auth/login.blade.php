@extends('layouts.auth', ['title' => 'Login'])

@section('content')
    <form class="w-1/3 p-5 space-y-5 bg-white rounded-md shadow-lg" action="{{ route('auth.logged') }}" method="POST">
        @csrf
        <h1 class="text-5xl font-bold text-center text-indigo-600">Login</h1>
        <x-form.input placeholder="Username" name="username" error="{{ $errors->first('username') }}" />
        <x-form.input placeholder="Password" name="password" type="password" error="{{ $errors->first('password') }}" />
        <x-button.primary type="submit" class="w-full">Login</x-button.primary>
        @if (session('logged_error'))
            <x-alert.error>{{ session('logged_error') }}</x-alert.error>
        @endif
    </form>
@endsection
