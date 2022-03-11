<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        return view('index', compact('categoriesCount', 'productsCount'));
    }

    public function user()
    {
        return view('user');
    }
}
