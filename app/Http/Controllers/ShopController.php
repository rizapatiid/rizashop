<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOP INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Product::active()
            ->with('category')
            ->latest();

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('shop.index', compact('products', 'categories'));
    }

 /*
|--------------------------------------------------------------------------
| SHOP SHOW
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

    // ✅ TAMBAHAN: Rekomendasi produk acak (6 item)
    $recommends = Product::active()
        ->where('id', '!=', $product->id)
        ->inRandomOrder()
        ->limit(6)
        ->get();

    return view('shop.show', compact('product', 'recommends'));
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
    | ADD TO CART (SUPPORT MULTI VARIANT)
    | ✅ UPDATED: Return cart_key untuk "Beli Sekarang"
    |--------------------------------------------------------------------------
    */
    public function addToCart(Request $request, Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $qty = max(1, (int) $request->input('qty', 1));
        $variantInput = $request->input('variant_id');

        $variants = collect();
        $variantPrice = 0;
        $variantLabels = [];

        if ($product->variants()->where('is_active', true)->exists()) {

            if (!$variantInput) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan pilih semua varian terlebih dahulu'
                ], 422);
            }

            $variantIds = collect(explode(',', $variantInput))
                ->map(fn ($v) => (int) trim($v))
                ->filter()
                ->unique();

            $variants = ProductVariant::whereIn('id', $variantIds)
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->get();

            // 🔴 VALIDASI: 1 VARIAN PER KATEGORI
            $requiredGroups = $product->variants
                ->where('is_active', true)
                ->groupBy('variant_name')
                ->keys();

            $selectedGroups = $variants->groupBy('variant_name')->keys();

            if ($requiredGroups->diff($selectedGroups)->isNotEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Semua varian wajib dipilih'
                ], 422);
            }

            foreach ($variants as $v) {
                if ($v->stock < $qty) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok varian tidak mencukupi'
                    ], 422);
                }

                $variantPrice += $v->price_modifier;
                $variantLabels[] = $v->variant_name . ': ' . $v->variant_value;
            }

        } else {
            if ($product->stock < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi'
                ], 422);
            }
        }

        $cart = session()->get('cart', []);

        // 🔑 CART KEY UNIK (product_id:variant1-variant2)
        $cartKey = $variants->isNotEmpty()
            ? $product->id . ':' . $variants->pluck('id')->implode('-')
            : (string) $product->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id'            => $cartKey,
                'product_id'    => $product->id,
                'variant_ids'   => $variants->pluck('id')->all(),
                'name'          => $product->name,
                'variant'       => $variantLabels,
                'sku'           => $product->sku,
                'price'         => (float) $product->price + $variantPrice,
                'qty'           => $qty,
                'image'         => $product->main_image,
            ];
        }

        session()->put('cart', $cart);

        // ✅ UPDATE: Tambahkan wantsJson() check dan return cart_key
        if ($request->ajax() || $request->wantsJson()) {
            $total = collect($cart)->reduce(
                fn ($c, $i) => $c + ($i['price'] * $i['qty']),
                0
            );

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang',
                'cart_key' => $cartKey, // ✅ PENTING: Return cart_key untuk "Beli Sekarang"
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
    | REMOVE FROM CART
    |--------------------------------------------------------------------------
    */
    public function removeFromCart(Request $request, Product $product)
    {
        $cartKey = $request->input('cart_key');
        $cart = session()->get('cart', []);

        if ($cartKey && isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ITEM
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
    | DELETE ITEM
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