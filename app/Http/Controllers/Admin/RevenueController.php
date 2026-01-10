<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */
        $start = $request->filled('start')
            ? Carbon::parse($request->start)->startOfDay()
            : Carbon::now()->startOfMonth();

        $end = $request->filled('end')
            ? Carbon::parse($request->end)->endOfDay()
            : Carbon::now()->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | GET VALID ORDERS
        |--------------------------------------------------------------------------
        | hanya pesanan selesai / diterima
        */
        $orders = Order::whereIn('status', ['completed', 'received'])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CALCULATION
        |--------------------------------------------------------------------------
        */

        // Barang
        $totalSubtotal = $orders->sum('subtotal');

        // Ongkir (bukan pendapatan toko)
        $totalShipping = $orders->sum('shipping_cost');

        // Diskon
        $totalDiscount = $orders->sum('discount');

        // Biaya admin / payment
        $totalAdmin = $orders->sum('admin_fee');

        // PENJUALAN KOTOR = BARANG + ONGKIR
        $totalGrossSales = $totalSubtotal + $totalShipping;

        // PENDAPATAN BERSIH TOKO
        $netRevenue = $totalSubtotal
            - $totalDiscount
            - $totalAdmin;

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view('admin.revenue.index', compact(
            'orders',
            'start',
            'end',
            'totalGrossSales',
            'totalSubtotal',
            'totalDiscount',
            'totalAdmin',
            'totalShipping',
            'netRevenue'
        ));
    }
}
