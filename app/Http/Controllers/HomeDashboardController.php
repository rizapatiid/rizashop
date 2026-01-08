<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class HomeDashboardController extends Controller
{
    /**
     * Display homepage dashboard with banner slider
     */
    public function index()
    {
        // ===== BANNER =====
        $banners = Banner::active()->ordered()->get();

        // ===== STAT =====
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalUsers    = User::count();

        // ===== KATEGORI + 6 PRODUK PER KATEGORI =====
        $categories = Category::with([
    'products' => function ($q) {
        $q->where('is_active', 1)
          ->latest()
          ->take(6);
    }
])
->whereHas('products')
->orderBy('name')
->get();


        return view('dashboard', compact(
            'banners',
            'categories',
            'totalProducts',
            'totalOrders',
            'totalUsers'
        ));
    }
}
