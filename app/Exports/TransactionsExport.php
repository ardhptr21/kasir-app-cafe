<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ['Nama Product', 'Kode Transaksi', 'Jumlah', 'Total Harga', 'Kasir', 'Tanggal'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->product->name,
            $transaction->transaction_code,
            $transaction->quantity,
            $transaction->total_price,
            $transaction->user->name,
            $transaction->created_at->format('d F Y - h:i')
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
