<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout page.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $fullCart = session()->get('cart', []);
        $selected = session()->get('checkout_items', null);

        if ($selected && is_array($selected) && count($selected) > 0) {
            $cart = [];
            foreach ($selected as $sel) {
                $id = $sel['id'] ?? null;
                $qty = intval($sel['qty'] ?? 1);
                if ($id === null) continue;
                if (isset($fullCart[$id])) {
                    $item = $fullCart[$id];
                    $item['qty'] = $qty;
                    $cart[$id] = $item;
                }
            }
            if (empty($cart)) {
                return Redirect::route('shop.cart')->with('error', 'Item checkout tidak ditemukan. Silakan cek keranjang.');
            }
        } else {
            $cart = $fullCart;
            if (empty($cart)) {
                return Redirect::route('shop.cart')->with('error', 'Keranjang masih kosong.');
            }
        }

        $addresses = $user->addresses()->orderByDesc('is_primary')->get();

        $shippingOptions = [
            ['id' => 'jne_reg', 'label' => 'JNE - Reguler', 'cost' => 15000],
            ['id' => 'jne_yes', 'label' => 'JNE - YES', 'cost' => 30000],
            ['id' => 'jnt_reg', 'label' => 'J&T - Reguler', 'cost' => 14000],
            ['id' => 'cod', 'label' => 'Bayar di Tempat (COD)', 'cost' => 0],
        ];

        $subtotal = collect($cart)->reduce(function ($carry, $item) {
            return $carry + (($item['price'] ?? 0) * ($item['qty'] ?? 1));
        }, 0);

        return view('checkout.index', compact('cart', 'addresses', 'shippingOptions', 'subtotal'));
    }

    /**
     * Start checkout (POST). Accepts items[...] from cart page or mini cart.
     * Stores minimal selection into session('checkout_items') and redirects to checkout page.
     */
    public function start(Request $request)
    {
        $data = $request->input('items', []);

        if (!is_array($data) || empty($data)) {
            return redirect()->route('shop.cart')->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Keranjang kosong.');
        }

        $selected = [];
        foreach ($data as $entry) {
            $id = $entry['id'] ?? null;
            $qty = intval($entry['qty'] ?? 1);
            if ($id === null) continue;
            if (!isset($cart[$id])) {
                continue;
            }
            if ($qty < 1) $qty = 1;
            $selected[] = ['id' => $id, 'qty' => $qty];
        }

        if (empty($selected)) {
            return redirect()->route('shop.cart')->with('error', 'Item terpilih tidak valid atau sudah tidak tersedia.');
        }

        session(['checkout_items' => $selected]);

        if (Route::has('checkout.index')) {
            return redirect()->route('checkout.index');
        }

        if (Route::has('addresses.checkout.index')) {
            return redirect()->route('addresses.checkout.index');
        }

        return redirect()->route('shop.cart')->with('error', 'Route checkout belum terdaftar.');
    }

    /**
     * Place order: validate input, create order & items, clear session cart.
     */
    public function placeOrder(Request $request)
    {
        Log::info('==================== CHECKOUT STARTED ====================');
        
        $user = $request->user();
        Log::info('User Info', ['user_id' => $user->id, 'email' => $user->email]);

        $rules = [
            'address_id' => 'required|exists:addresses,id',
            'shipping_method' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ];

        $data = $request->validate($rules);

        // Rebuild cart
        $fullCart = session()->get('cart', []);
        $selected = session()->get('checkout_items', null);

        $cart = [];
        if ($selected && is_array($selected) && count($selected) > 0) {
            foreach ($selected as $sel) {
                $id = $sel['id'] ?? null;
                $qty = intval($sel['qty'] ?? 1);
                if ($id === null) continue;
                if (isset($fullCart[$id])) {
                    $item = $fullCart[$id];
                    $item['qty'] = $qty;
                    $cart[$id] = $item;
                }
            }
        } else {
            $cart = $fullCart;
        }

        if (empty($cart)) {
            return Redirect::route('shop.cart')->with('error', 'Keranjang kosong atau item tidak tersedia.');
        }

        Log::info('Cart to Process', ['cart' => $cart]);

        // Compute totals
        $subtotal = collect($cart)->reduce(function ($c, $i) {
            return $c + (($i['price'] ?? 0) * ($i['qty'] ?? 1));
        }, 0);

        $shippingCost = floatval($data['shipping_cost']);
        $total = $subtotal + $shippingCost;

        // Start transaction
        DB::beginTransaction();
        
        try {
            // Validasi stok SEBELUM membuat order
            Log::info('=== VALIDASI STOK ===');
            foreach ($cart as $cartKey => $c) {
                $parts = explode(':', $cartKey);
                $productId = intval($parts[0] ?? 0);
                $variantId = isset($parts[1]) && $parts[1] !== '' ? intval($parts[1]) : null;
                $qty = intval($c['qty'] ?? 1);

                Log::info("Validating stock", [
                    'cart_key' => $cartKey,
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'qty' => $qty
                ]);

                if ($variantId) {
                    // Jika ada varian, cek stok varian DAN produk
                    $variant = ProductVariant::find($variantId);
                    if (!$variant) {
                        throw new \Exception("Varian produk tidak ditemukan");
                    }
                    if ($variant->stock < $qty) {
                        throw new \Exception("Stok varian '{$c['name']}' tidak mencukupi. Tersedia: {$variant->stock}, diminta: {$qty}");
                    }
                    
                    $product = Product::find($productId);
                    if (!$product) {
                        throw new \Exception("Produk tidak ditemukan");
                    }
                    if ($product->stock < $qty) {
                        throw new \Exception("Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$product->stock}, diminta: {$qty}");
                    }
                    
                    Log::info("Variant & Product stock OK", [
                        'variant_id' => $variantId,
                        'variant_stock' => $variant->stock,
                        'product_id' => $productId,
                        'product_stock' => $product->stock
                    ]);
                } else {
                    // Jika tidak ada varian, cek stok produk saja
                    $product = Product::find($productId);
                    if (!$product) {
                        throw new \Exception("Produk tidak ditemukan");
                    }
                    if ($product->stock < $qty) {
                        throw new \Exception("Stok '{$c['name']}' tidak mencukupi. Tersedia: {$product->stock}, diminta: {$qty}");
                    }
                    Log::info("Product stock OK", ['product_id' => $productId, 'stock' => $product->stock]);
                }
            }

            // Buat order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $data['address_id'],
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'currency' => 'IDR',
                'status' => 'pending',
                'notes' => $request->input('notes') ?? null,
                'shipping_method' => $data['shipping_method'] ?? null,
            ]);

            Log::info('Order created', ['order_id' => $order->id, 'order_number' => $order->order_number]);

            // Buat order items dan kurangi stok
            Log::info('=== CREATING ORDER ITEMS & REDUCING STOCK ===');
            foreach ($cart as $cartKey => $c) {
                $parts = explode(':', $cartKey);
                $productId = intval($parts[0] ?? 0);
                $variantId = isset($parts[1]) && $parts[1] !== '' ? intval($parts[1]) : null;
                $qty = intval($c['qty'] ?? 1);

                // Buat order item
                $orderItem = $order->items()->create([
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'product_name' => $c['name'] ?? 'Unknown',
                    'product_sku' => $c['sku'] ?? null,
                    'price' => $c['price'] ?? 0,
                    'qty' => $qty,
                    'subtotal' => ($c['price'] ?? 0) * $qty,
                    'meta' => [
                        'image' => $c['image'] ?? null,
                        'variant' => $c['variant'] ?? null,
                    ],
                ]);

                Log::info('Order item created', ['order_item_id' => $orderItem->id]);

                // Kurangi stok
                if ($variantId) {
                    // PENTING: Kurangi KEDUA stok (variant DAN product)
                    
                    // 1. Kurangi stok variant
                    $variantStockBefore = DB::table('product_variants')->where('id', $variantId)->value('stock');
                    
                    DB::table('product_variants')
                        ->where('id', $variantId)
                        ->decrement('stock', $qty);
                    
                    $variantStockAfter = DB::table('product_variants')->where('id', $variantId)->value('stock');
                    
                    Log::info("✅ STOCK VARIANT REDUCED", [
                        'variant_id' => $variantId,
                        'product_name' => $c['name'],
                        'qty_ordered' => $qty,
                        'stock_before' => $variantStockBefore,
                        'stock_after' => $variantStockAfter,
                        'difference' => $variantStockBefore - $variantStockAfter
                    ]);
                    
                    // 2. Kurangi stok product (total stok produk)
                    $productStockBefore = DB::table('products')->where('id', $productId)->value('stock');
                    
                    DB::table('products')
                        ->where('id', $productId)
                        ->decrement('stock', $qty);
                    
                    $productStockAfter = DB::table('products')->where('id', $productId)->value('stock');
                    
                    Log::info("✅ STOCK PRODUCT REDUCED (from variant)", [
                        'product_id' => $productId,
                        'qty_ordered' => $qty,
                        'stock_before' => $productStockBefore,
                        'stock_after' => $productStockAfter,
                        'difference' => $productStockBefore - $productStockAfter
                    ]);
                    
                } else {
                    // Produk tanpa varian: kurangi stok product saja
                    $stockBefore = DB::table('products')->where('id', $productId)->value('stock');
                    
                    DB::table('products')
                        ->where('id', $productId)
                        ->decrement('stock', $qty);
                    
                    $stockAfter = DB::table('products')->where('id', $productId)->value('stock');
                    
                    Log::info("✅ STOCK PRODUCT REDUCED (no variant)", [
                        'product_id' => $productId,
                        'product_name' => $c['name'],
                        'qty_ordered' => $qty,
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockAfter,
                        'difference' => $stockBefore - $stockAfter
                    ]);
                }
            }

            DB::commit();
            Log::info('=== TRANSACTION COMMITTED SUCCESSFULLY ===');

            // Hapus items dari cart
            foreach (array_keys($cart) as $cartKey) {
                unset($fullCart[$cartKey]);
            }
            session()->put('cart', $fullCart);
            session()->forget('checkout_items');

            Log::info('==================== CHECKOUT FINISHED ====================');

            // Redirect ke halaman payment
            if (Route::has('payments.create')) {
                return redirect()->route('payments.create', $order->id)
                    ->with('success', 'Pesanan berhasil dibuat! Nomor: ' . $order->order_number);
            }

            if (Route::has('addresses.payments.create')) {
                return redirect()->route('addresses.payments.create', $order->id)
                    ->with('success', 'Pesanan berhasil dibuat! Nomor: ' . $order->order_number);
            }

            if (Route::has('orders.show')) {
                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'Pesanan berhasil dibuat! Nomor: ' . $order->order_number);
            }

            return redirect('/')->with('success', 'Pesanan berhasil dibuat! Nomor: ' . $order->order_number);
            
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('=== TRANSACTION ROLLED BACK ===');
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,
            ]);
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}