<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auth{{ $title ? " - $title" : '' }}</title>
    @include('layouts.partials.styles')
</head>

<body>

    <main class="flex items-center justify-center min-h-screen bg-slate-200">
        @yield('content')
    </main>

    @include('layouts.partials.script')
</body>

</html>
