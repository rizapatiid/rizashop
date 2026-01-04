<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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
     * Start checkout (POST). Accepts items[...] from cart page.
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
                // skip invalid ids
                continue;
            }
            if ($qty < 1) $qty = 1;
            $selected[] = ['id' => $id, 'qty' => $qty];
        }

        if (empty($selected)) {
            return redirect()->route('shop.cart')->with('error', 'Item terpilih tidak valid atau sudah tidak tersedia.');
        }

        // save minimal selection to session
        session(['checkout_items' => $selected]);

        // redirect to the correct checkout route (try common names, fallback to addresses.checkout.index)
        if (Route::has('checkout.index')) {
            return redirect()->route('checkout.index');
        }

        if (Route::has('addresses.checkout.index')) {
            return redirect()->route('addresses.checkout.index');
        }

        // fallback
        return redirect()->route('shop.cart')->with('error', 'Route checkout belum terdaftar.');
    }

    /**
     * Place order: validate input, create order & items, clear session cart.
     */
    public function placeOrder(Request $request)
    {
        $user = $request->user();

        // log payload for quick debug (remove in production if you want)
        Log::debug('Checkout::placeOrder payload', $request->only(['address_id','shipping_method','shipping_cost','notes']));

        $rules = [
            'address_id' => 'required|exists:addresses,id',
            'shipping_method' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ];

        $data = $request->validate($rules);

        // rebuild cart from checkout_items (if exist) or full cart
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

        // compute totals
        $subtotal = collect($cart)->reduce(function ($c, $i) {
            return $c + (($i['price'] ?? 0) * ($i['qty'] ?? 1));
        }, 0);

        $shippingCost = floatval($data['shipping_cost']);
        $total = $subtotal + $shippingCost;

        // transaction: create order and items
        DB::beginTransaction();
        try {
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

            foreach ($cart as $c) {
                $order->items()->create([
                    'product_id' => $c['id'] ?? null,
                    'product_name' => $c['name'] ?? 'Unknown',
                    'product_sku' => $c['sku'] ?? null,
                    'price' => $c['price'] ?? 0,
                    'qty' => $c['qty'] ?? 1,
                    'subtotal' => ($c['price'] ?? 0) * ($c['qty'] ?? 1),
                    'meta' => ['image' => $c['image'] ?? null],
                ]);
            }

            DB::commit();

            // clear sessions BEFORE redirect
            session()->forget('cart');
            session()->forget('checkout_items');

            // Prefer payments.create if exists (normal flow: upload bukti pembayaran)
            if (Route::has('payments.create')) {
                return redirect()->route('payments.create', $order->id)->with('success', 'Pesanan berhasil dibuat. Silakan unggah bukti pembayaran.');
            }

            // fallback for prefixed routes
            if (Route::has('addresses.payments.create')) {
                return redirect()->route('addresses.payments.create', $order->id)->with('success', 'Pesanan berhasil dibuat. Silakan unggah bukti pembayaran.');
            }

            // fallback to orders.show if payments route missing
            if (Route::has('orders.show')) {
                return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat. Nomor: ' . $order->order_number);
            }

            // final fallback: homepage
            return redirect('/')->with('success', 'Pesanan berhasil dibuat. Nomor: ' . $order->order_number);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Checkout::placeOrder failed: '.$e->getMessage(), [
                'exception' => $e,
            ]);
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
