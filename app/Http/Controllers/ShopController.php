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

        return redirect()->route('shop.cart')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    // hapus 1 item dari keranjang
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
}
