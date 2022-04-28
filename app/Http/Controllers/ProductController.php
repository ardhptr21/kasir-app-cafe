<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'product']);
        $products = Product::with('category')->filter($filters);
        $categories = Category::all();
        if ($request->get('type') == 'json') {
            $products = $products->where('stock', '>', 0)->get();
            return response()->json($products);
        }
        if (!auth()->user()->isAdmin() && !auth()->user()->isOwner()) {
            abort(403);
        }
        $products = $products->get();
        return view('products.index', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
            'buy_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'merk' => 'required|string',
        ]);
        $validated['product_code'] = random_alnum();

        $product = Product::create($validated);

        if ($product) {
            return back()->with('product_success', 'Product baru berhasil ditambahkan');
        }

        return back()->with('product_error', 'Product baru gagal ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
            'buy_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'merk' => 'required|string',
        ]);

        $updated = $product->update($validated);

        if ($updated) {
            return back()->with('product_success', 'Product berhasil diubah');
        }

        return back()->with('product_error', 'Product gagal diubah');
    }

    public function destroy(Product $product)
    {
        $deleted = $product->delete();

        if ($deleted) {
            return back()->with('product_success', 'Product berhasil dihapus');
        }

        return back()->with('product_error', 'Product gagal dihapus');
    }
}
