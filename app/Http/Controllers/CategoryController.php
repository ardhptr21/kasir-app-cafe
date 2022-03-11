<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['category']);
        $categories = Category::with('services')->filter($filters)->get();
        return view('kategori', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);

        $category = Category::create($validated);

        if ($category) {
            return back()->with('category_success', "Kategori $category->name berhasil dibuat");
        }

        return back()->with('category_error', "Kategori {$validated['name']} gagal dibuat");
    }

    public function destroy(Category $category)
    {
        $isDeleted = $category->delete();

        if ($isDeleted) {
            return back()->with('category_success', "Kategori $category->name berhasil dihapus");
        }

        return back()->with('category_error', "Kategori $category->name gagal dihapus");
    }
}
