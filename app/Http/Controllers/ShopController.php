<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOP INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $products = Product::active()
            ->with('category')
            ->latest()
            ->paginate(12);

        return view('shop.index', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOP SHOW (DETAIL PRODUK + VARIANT)
    |--------------------------------------------------------------------------
    */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $product->load([
            'category',
            'images',
            'variants' => fn ($q) => $q->where('is_active', true)
        ]);

        return view('shop.show', compact('product'));
    }

    /*
    |--------------------------------------------------------------------------
    | CART PAGE
    |--------------------------------------------------------------------------
    */
    public function cart()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->reduce(
            fn ($c, $i) => $c + ($i['price'] * $i['qty']),
            0
        );

        return view('shop.cart', compact('cart', 'total'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADD TO CART (SUPPORT VARIANT)
    | Route: POST /keranjang/tambah/{product}
    |--------------------------------------------------------------------------
    */
    public function addToCart(Request $request, Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $qty = max(1, (int) $request->input('qty', 1));
        $variantId = $request->input('variant_id');

        $variant = null;

        // 🔹 Jika produk punya variant → wajib pilih
        if ($product->variants()->where('is_active', true)->exists()) {
            if (!$variantId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan pilih varian terlebih dahulu'
                ], 422);
            }

            $variant = ProductVariant::where('id', $variantId)
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->firstOrFail();

            if ($variant->stock < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok varian tidak mencukupi'
                ], 422);
            }
        } else {
            // 🔹 Produk tanpa variant
            if ($product->stock < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi'
                ], 422);
            }
        }

        $cart = session()->get('cart', []);

        // 🔑 CART KEY (product_id atau product_id:variant_id)
        $cartKey = $variant
            ? $product->id . ':' . $variant->id
            : (string) $product->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id'         => $cartKey, // tambahkan id untuk identifikasi di frontend
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name'       => $product->name,
                'variant'    => $variant
                    ? $variant->variant_name . ' - ' . $variant->variant_value
                    : null,
                'sku'        => $variant
                    ? $product->sku . '-' . $variant->variant_value
                    : $product->sku,
                'price'      => (float) $product->price + ($variant->price_modifier ?? 0),
                'qty'        => $qty,
                'image'      => $product->main_image,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            $total = collect($cart)->reduce(
                fn ($c, $i) => $c + ($i['price'] * $i['qty']),
                0
            );

            return response()->json([
                'success' => true,
                'count'   => collect($cart)->sum('qty'),
                'total'   => $total,
                'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            ]);
        }

        return redirect()
            ->route('shop.cart')
            ->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE FROM CART (FORM NON-AJAX)
    | Route: DELETE /keranjang/hapus/{product}
    |--------------------------------------------------------------------------
    */
    public function removeFromCart(Request $request, Product $product)
    {
        $cartKey = $request->input('cart_key'); // dikirim dari form

        $cart = session()->get('cart', []);

        if ($cartKey && isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ITEM (AJAX)
    | Route: PATCH /keranjang/item
    |--------------------------------------------------------------------------
    */
    public function updateItem(Request $request)
    {
        $cartKey = $request->input('cart_key');
        $qty = max(1, (int) $request->input('qty', 1));

        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return response()->json(['message' => 'Item tidak ditemukan'], 404);
        }

        $cart[$cartKey]['qty'] = $qty;
        session()->put('cart', $cart);

        $rowSubtotal = $cart[$cartKey]['price'] * $qty;
        $total = collect($cart)->reduce(
            fn ($c, $i) => $c + ($i['price'] * $i['qty']),
            0
        );

        return response()->json([
            'success' => true,
            'row_subtotal' => $rowSubtotal,
            'row_subtotal_formatted' => 'Rp ' . number_format($rowSubtotal, 0, ',', '.'),
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            'count' => collect($cart)->sum('qty'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ITEM (AJAX)
    | Route: DELETE /keranjang/item
    |--------------------------------------------------------------------------
    */
    public function deleteItem(Request $request)
    {
        $cartKey = $request->input('cart_key');
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        $total = collect($cart)->reduce(
            fn ($c, $i) => $c + ($i['price'] * $i['qty']),
            0
        );

        return response()->json([
            'success' => true,
            'total' => $total,
            'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
            'count' => collect($cart)->sum('qty'),
        ]);
    }
}