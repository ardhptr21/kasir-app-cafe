<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Transaksi</title>
    @include('layouts.partials.styles')
</head>

<body>
    <main class="flex flex-col items-center justify-center gap-5 p-12">
        <div class="text-center">
            <h1 class="text-xl font-bold uppercase">{{ get_shop()?->name }}</h1>
            <div>
                <p class="font-medium uppercase">{{ get_shop()?->address }}</p>
                <p>{{ get_shop()?->email }} - {{ get_shop()?->phone }}</p>
            </div>
        </div>

        <div class="w-full lg:w-3/4">
            <x-table.container>
                <x-slot:head>
                    <x-table.th>No</x-table.th>
                    <x-table.th>Nama Product</x-table.th>
                    <x-table.th>Jumlah</x-table.th>
                    <x-table.th>Harga</x-table.th>
                    <x-table.th>Total</x-table.th>
                </x-slot:head>
                <x-slot:body>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <x-table.td>{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $transaction->product->name }}</x-table.td>
                            <x-table.td>{{ $transaction->quantity }}</x-table.td>
                            <x-table.td>{{ $transaction->product->price }}</x-table.td>
                            <x-table.td>{{ $transaction->total_price }}</x-table.td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-table.container>

            <div class="w-full mt-5">
                <x-form.input placeholder="Total Semua" :is-edit="false"
                    value="Rp. {{ number_format(sum_all_array_key($transactions->toArray(), 'total_price')) }}" />

                <x-form.input placeholder="Pembayaran" :is-edit="false" value="Rp. {{ number_format($cash) }}" />

                <x-form.input placeholder="Kembalian" :is-edit="false" value="Rp. {{ number_format($refund) }}" />

                <x-form.input placeholder="Kasir" :is-edit="false" value="{{ auth()->user()->name }}" />
            </div>
        </div>


    </main>
    <script>
        window.print();
    </script>
</body>

</html>
