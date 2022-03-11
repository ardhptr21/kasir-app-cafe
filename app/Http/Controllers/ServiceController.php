<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'service']);
        $services = Service::with('category')->filter($filters)->get();
        $categories = Category::all();
        if ($request->get('type') == 'json') {
            return response()->json($services);
        }
        return view('services.index', compact('categories', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
        ]);

        $service = Service::create($validated);

        if ($service) {
            return back()->with('service_success', 'Service baru berhasil ditambahkan');
        }

        return back()->with('service_error', 'Service baru gagal ditambahkan');
    }

    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|numeric',
        ]);

        $updated = $service->update($validated);

        if ($updated) {
            return back()->with('service_success', 'Service berhasil diubah');
        }

        return back()->with('service_error', 'Service gagal diubah');
    }

    public function destroy(Service $service)
    {
        $deleted = $service->delete();

        if ($deleted) {
            return back()->with('service_success', 'Service berhasil dihapus');
        }

        return back()->with('service_error', 'Service gagal dihapus');
    }
}
