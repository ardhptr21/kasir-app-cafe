<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $servicesCount = Service::count();
        return view('index', compact('categoriesCount', 'servicesCount'));
    }

    public function user()
    {
        return view('user');
    }
}
