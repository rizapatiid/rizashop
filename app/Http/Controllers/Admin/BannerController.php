<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();

        return view('admin.banners.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'product_id'  => 'nullable|exists:products,id',
            'link_url'    => 'nullable|url',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 🧠 Jika pilih produk → link_url dikosongkan
        if (!empty($validated['product_id'])) {
            $validated['link_url'] = null;
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request
                ->file('image')
                ->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit(Banner $banner)
    {
        $products = Product::active()->orderBy('name')->get();

        return view('admin.banners.edit', compact('banner', 'products'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'product_id'  => 'nullable|exists:products,id',
            'link_url'    => 'nullable|url',
            'sort_order'  => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 🧠 Jika pilih produk → link_url dikosongkan
        if (!empty($validated['product_id'])) {
            $validated['link_url'] = null;
        }

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $validated['image_path'] = $request
                ->file('image')
                ->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner berhasil diupdate');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus');
    }
}
