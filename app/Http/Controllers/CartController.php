<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'total_price' => 'required|integer',
        ]);
        $validated['capital'] = Product::find($validated['product_id'])->buy_price;

        $cart = Cart::create($validated);

        if ($cart) {
            return back()->with('cart_success', 'Berhasil menambahkan product ke keranjang');
        }

        return back()->with('cart_error', 'Gagal menambahkan product ke keranjang');
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart->load('product');
        $validated['total_price'] = $validated['quantity'] * $cart->product->price;
        $validated['capital'] = $validated['quantity'] * $cart->product->buy_price;

        $updated = $cart->update($validated);

        if ($updated) {
            return back()->with('cart_success', 'Berhasil mengubah jumlah product');
        }

        return back()->with('cart_error', 'Gagal mengubah jumlah product');
    }

    public function destroy(Cart $cart)
    {
        $deleted = $cart->delete();

        if ($deleted) {
            return back()->with('cart_success', 'Berhasil menghapus product dari keranjang');
        }

        return back()->with('cart_error', 'Gagal menghapus product dari keranjang');
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
