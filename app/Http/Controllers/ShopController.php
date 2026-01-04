<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // daftar produk untuk user
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('shop.index', compact('products'));
    }

    // tampilkan keranjang
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return view('shop.cart', compact('cart', 'total'));
    }

    // tambah ke keranjang
    public function addToCart(Request $request, Product $product)
    {
        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) $qty = 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'qty'   => $qty,
                'image' => $product->image_path,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            $total = collect($cart)->reduce(function ($c, $i) {
                return $c + ($i['price'] * $i['qty']);
            }, 0);
            return response()->json([
                'success' => true,
                'count' => collect($cart)->sum('qty'),
                'total' => $total,
                'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            ]);
        }

        return redirect()->route('shop.cart')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    // hapus 1 item dari keranjang (form non-AJAX)
    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    // checkout sederhana: hanya mengosongkan keranjang
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Keranjang masih kosong.');
        }

        // Di sini nanti bisa disimpan ke tabel orders & order_items

        session()->forget('cart');

        return redirect()->route('shop.index')->with('success', 'Checkout berhasil (simulasi).');
    }

    /*
     * AJAX: update qty untuk item (dipanggil oleh mini-cart & halaman cart via fetch)
     * Route: PATCH /keranjang/item/{product}
     */
    public function updateItem(Request $request, Product $product)
    {
        $qty = intval($request->input('qty', 1));
        if ($qty < 1) $qty = 1;

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return response()->json(['message' => 'Item tidak ditemukan di keranjang'], 404);
        }

        // update qty
        $cart[$product->id]['qty'] = $qty;
        session()->put('cart', $cart);

        // hitung subtotal baris, total cart, count
        $rowSubtotal = ($cart[$product->id]['price'] ?? 0) * $cart[$product->id]['qty'];
        $total = collect($cart)->reduce(fn($c, $i) => $c + (($i['price'] ?? 0) * ($i['qty'] ?? 1)), 0);
        $count = collect($cart)->sum('qty');

        return response()->json([
            'success' => true,
            'row_subtotal' => $rowSubtotal,
            'row_subtotal_formatted' => 'Rp ' . number_format($rowSubtotal, 0, ',', '.'),
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            'count' => $count,
        ]);
    }

    /*
     * AJAX: delete item (dipanggil oleh mini-cart via fetch)
     * Route: DELETE /keranjang/item/{product}
     */
    public function deleteItem(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        $total = collect($cart)->reduce(fn($c, $i) => $c + (($i['price'] ?? 0) * ($i['qty'] ?? 1)), 0);
        $count = collect($cart)->sum('qty');

        return response()->json([
            'success' => true,
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            'count' => $count,
        ]);
    }
}
