<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index()
    {
        $shop = Shop::first();
        return view('toko', compact('shop'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255',
            'owner' => 'required|string|max:255',
        ]);

        $shop = Shop::where('id', $request->id)->first();
        if ($shop) {
            $shop = Shop::where('id', $request->id)->update($validated);
        } else {
            $shop = Shop::create($validated);
        }

        if ($shop) {
            return to_route('shop.index')->with('shop_success', 'Toko berhasil diubah');
        }

        return back()->with('shop_error', 'Toko gagal diubah');
    }
}
