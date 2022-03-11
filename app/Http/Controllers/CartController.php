<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'total_price' => 'required|integer',
        ]);

        $cart = Cart::create($validated);

        if ($cart) {
            return back()->with('cart_success', 'Berhasil menambahkan service ke keranjang');
        }

        return back()->with('cart_error', 'Gagal menambahkan service ke keranjang');
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $validated['total_price'] = $validated['quantity'] * $cart->service->price;

        $updated = $cart->update($validated);

        if ($updated) {
            return back()->with('cart_success', 'Berhasil mengubah jumlah service');
        }

        return back()->with('cart_error', 'Gagal mengubah jumlah service');
    }

    public function destroy(Cart $cart)
    {
        $deleted = $cart->delete();

        if ($deleted) {
            return back()->with('cart_success', 'Berhasil menghapus service dari keranjang');
        }

        return back()->with('cart_error', 'Gagal menghapus service dari keranjang');
    }

    public function truncate()
    {
        $truncated = Cart::truncate();

        if ($truncated) {
            return back()->with('cart_success', 'Berhasil mengosongkan keranjang');
        }

        return back()->with('cart_error', 'Gagal mengosongkan keranjang');
    }
}
