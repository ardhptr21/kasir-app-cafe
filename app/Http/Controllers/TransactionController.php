<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Transaction;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->search != 'day' && $request->search != 'month' && isset($request->search)) {
            return to_route('transactions.index');
        }

        $filters = $request->only(['date', 'search']);
        if (!isset($filters['search']) || !isset($filters['date'])) {
            $filters['date'] = today();
            $filters['search'] = 'day';
        }


        $transactions = Transaction::with(['service', 'user'])->filter($filters)->get();
        return view('transactions.index', compact('transactions'));
    }


    public function create(Request $request)
    {
        $carts = Cart::with(['service', 'user'])->get();
        $member = null;
        if ($request->member) {
            $member = Member::where('member_code', $request->member)->first();

            if (!$member) {
                return redirect($request->fullUrlWithoutQuery('member'));
            }
        }
        return view('transactions.create', compact('carts', 'member'));
    }

    public function show()
    {
        $transaction_code = session('transaction_code');
        if (!$transaction_code) {
            abort(404);
        }
        $transactions = Transaction::with(['service', 'user'])->where('transaction_code', $transaction_code)->get();

        return view('transactions.show', compact('transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_all' => 'required|integer|min:0',
            'cash' => "required|integer|min:$request->total_all",
            'member' => 'string|nullable',
        ]);

        $member = null;
        if (isset($validated['member'])) {
            $member = Member::where('member_code', $validated['member'])->first();
            if (!$member) {
                return back()->with('cart_error', "Member dengan kode '{$validated['member']}' tidak ditemukan");
            }
        }

        $merger = ['transaction_code' => random_alnum(8), 'period' => date('m-Y'), 'user_id' => auth()->user()->id];
        $carts = array_map(function ($v) use ($merger, $member) {
            unset($v['id']);
            $v['created_at'] = now();
            $v['updated_at'] = now();

            if ($member?->point == env('APP_MAX_MEMBER_POINT')) {
                $v['total_price'] = 0;
            }

            return array_merge($v, $merger);
        }, Cart::all()->toArray());

        $transactions = Transaction::insert($carts);

        if ($transactions) {
            if ($member) {
                if ($member->point == env('APP_MAX_MEMBER_POINT')) {
                    $member->point = 0;
                    $member->save();
                } else {
                    $member->point += 1;
                    $member->save();
                }
            }

            $carts = Cart::truncate();
            return to_route('transactions.show')->with([
                'message' => 'Transaksi berhasil dilakukan',
                'cash' => $validated['cash'],
                'total_all' => $validated['total_all'],
                'refund' => $validated['cash'] - $validated['total_all'],
                'transaction_code' => $merger['transaction_code'],
            ]);
        }

        return back()->with('cart_error', 'Transaksi gagal dilakukan');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['date', 'search']);
        $transactions = Transaction::with(['service', 'user'])->filter($filters)->get();
        $date = null;
        if ($filters['search'] == 'day') {
            $date = DateTime::createFromFormat('Y-m-d', $filters['date'])->getTimestamp();
            $date = 'Hari ' . parse_day(date('N', $date)) . ' ' . date('j', $date) . ' ' . parse_month(date('n', $date)) . ' ' . date('Y', $date);
        } else if ($filters['search'] == 'month') {
            $date = DateTime::createFromFormat('m-Y', $filters['date']);
            $date = 'Bulan ' . parse_month($date->format('n')) . ' ' . $date->format('Y');
        }


        $filename = 'Laporan Transaksi Pada ' . $date;

        return Excel::download(new TransactionsExport($transactions), "$filename.xlsx");
    }

    public function print(Request $request)
    {
        $cash = $request->cash ?? 0;
        $refund = $request->refund ?? 0;
        $transactions = Transaction::with(['service'])->where('transaction_code', $request->transaction_code)->get();
        return view('transactions.print', compact('transactions', 'cash', 'refund'));
    }
}
