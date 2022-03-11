@extends('layouts.base', ['title' => 'Laporan Transaksi'])

@section('content')
    <x-dashboard-title title="Laporan Transaksi" description="Lihat semua transaksi yang telah terjadi" />

    <div class="w-full p-5 mb-5 space-y-5 bg-white rounded-md shadow-md">
        <div class="flex gap-5">
            <div class="w-full">
                <h2 class="mb-3 text-lg font-bold">Laporan Per Hari</h2>
                <div class="flex items-center justify-center w-full gap-3" x-init="date = now()" x-data="{date: null}">
                    <x-form.input type="date" placeholder="Cari berdasarkan hari" ::value="date"
                        @change="date = $el.value" />
                    <x-button.primary class="w-48"
                        @click="addUrlSearchParams([{ key: 'search', value: 'day'},{ key: 'date', value: date}])"><i
                            class="fa-solid fa-magnifying-glass"></i>
                        Cari
                    </x-button.primary>
                </div>
            </div>
            <div class="w-full">
                <h2 class="mb-3 text-lg font-bold">Laporan Per Bulan</h2>
                <div class="flex items-center justify-center w-full gap-3" x-data="{}">
                    <x-form.select placeholder="BULAN" @change="month = $el.value" x-ref="month">
                        <option value="01" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            Januari
                        </option>
                        <option value="02" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            Februari
                        </option>
                        <option value="03" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            Maret
                        </option>
                        <option value="04" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            April
                        </option>
                        <option value="05" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">Mei
                        </option>
                        <option value="06" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">Juni
                        </option>
                        <option value="07" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">Juli
                        </option>
                        <option value="08" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            Agustus
                        </option>
                        <option value="09" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            September
                        </option>
                        <option value="10" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            Oktober
                        </option>
                        <option value="11" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            November
                        </option>
                        <option value="12" :selected="getParam('date')?.replace(/-\d+/g, '') == $el.value">
                            Desember
                        </option>
                    </x-form.select>
                    <x-form.select placeholder="TAHUN" @change="year = $el.value" x-ref="year">
                        @for ($year = (int) date('Y') - 10; $year <= (int) date('Y'); $year++)
                            <option value="{{ $year }}"
                                :selected="$el.value == getParam('date')?.match(/(-)(\d+)/)[2]">
                                {{ $year }}</option>
                        @endfor
                    </x-form.select>
                    <x-button.primary class="w-48"
                        @click="addUrlSearchParams([{ key: 'search', value: 'month'},{ key: 'date', value: `${$refs.month.selectedOptions[0].value}-${$refs.year.selectedOptions[0].value}`}])">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Cari
                    </x-button.primary>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('transactions.index') }}">
                <x-button.secondary>Reset</x-button.secondary>
            </a>

            @if ($transactions->isNotEmpty())
                <a
                    href="{{ route('transactions.export', ['search' => Request::get('search') ?? 'day','date' => Request::get('date') ?? date('Y-m-d')]) }}">
                    <x-button.success><i class="mr-2 fa-solid fa-lg fa-file-excel"></i> Export</x-button.success>
                </a>
            @endif
        </div>
    </div>

    @if ($transactions->isNotEmpty())
        <x-table.container>
            <x-slot:head>
                <x-table.th>No</x-table.th>
                <x-table.th>Nama Product</x-table.th>
                <x-table.th>Kode Transaksi</x-table.th>
                <x-table.th>Jumlah</x-table.th>
                <x-table.th>Modal</x-table.th>
                <x-table.th>Total Harga</x-table.th>
                <x-table.th>Kasir</x-table.th>
            </x-slot:head>
            <x-slot:body>
                @foreach ($transactions as $transaction)
                    <tr>
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $transaction->product->name }}</x-table.td>
                        <x-table.td>{{ $transaction->transaction_code }}</x-table.td>
                        <x-table.td>{{ $transaction->quantity }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($transaction->capital) }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($transaction->total_price) }}</x-table.td>
                        <x-table.td>{{ $transaction->user->name }}</x-table.td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table.container>

        <div class="w-full mt-5 border-t-2 border-black">
            <div class="flex justify-between gap-5 mt-3">
                <div class="flex items-center justify-between font-bold" style="flex: 0.5">
                    <h3>Total Product</h3>
                    <span>:</span>
                </div>
                <p style="flex: 2">{{ array_sum(array_map(fn($v) => $v['quantity'], $transactions->toArray())) }} Product
                </p>
            </div>
            <div class="flex justify-between gap-5">
                <div class="flex items-center justify-between font-bold" style="flex: 0.5">
                    <h3>Total Pendapatan</h3>
                    <span>:</span>
                </div>
                <p style="flex: 2">Rp. {{ number_format(sum_all_array_key($transactions->toArray(), 'total_price')) }}
                </p>
            </div>
            <div class="flex justify-between gap-5">
                <div class="flex items-center justify-between font-bold" style="flex: 0.5">
                    <h3>Total Modal</h3>
                    <span>:</span>
                </div>
                <p style="flex: 2">Rp. {{ number_format(sum_all_array_key($transactions->toArray(), 'capital')) }}
                </p>
            </div>
            <div class="flex justify-between gap-5">
                <div class="flex items-center justify-between font-bold" style="flex: 0.5">
                    <h3>Total Keuntungan</h3>
                    <span>:</span>
                </div>
                <p style="flex: 2">Rp.
                    {{ number_format(sum_all_array_key($transactions->toArray(), 'total_price') - sum_all_array_key($transactions->toArray(), 'capital')) }}
                </p>
            </div>
        </div>
    @else
        <x-alert.info>
            Tidak ada transaksi yang tersedia
        </x-alert.info>
    @endif

@endsection
