<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Member;
use App\Models\Service;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $servicesCount = Service::count();
        $membersCount = Member::count();
        return view('index', compact('categoriesCount', 'servicesCount', 'membersCount'));
    }

    public function user()
    {
        return view('user');
    }
}
