<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Dashboard Kasir' }}</title>
    @include('layouts.partials.styles')
</head>

<body>

    <div class="flex justify-center">
        <aside>
            @include('layouts.partials.sidebar')
        </aside>
        <div class="flex flex-col flex-1 flex-grow max-h-screen overflow-hidden">
            @include('layouts.partials.header')
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-200">
                <div class="container px-6 py-8 mx-auto">
                    @yield('content')
                </div>
            </main>
            @include('layouts.partials.footer')
        </div>
    </div>



    @include('layouts.partials.script')
</body>

</html>
