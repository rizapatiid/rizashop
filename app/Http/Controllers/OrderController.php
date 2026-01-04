<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List orders for current user (direct query).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // langsung query tabel orders berdasarkan user_id
        $orders = Order::where('user_id', $user->id)
            ->withCount('items')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show one order details.
     */
    public function show(Request $request, Order $order)
    {
        // ownership check
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items', 'payment', 'address');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order by the owner (user).
     *
     * Allowed only when order in cancellable statuses.
     */
    public function cancel(Request $request, Order $order)
    {
        // pastikan pemilik pesanan
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        // daftar status yang boleh dibatalkan oleh user
        $cancellableStatuses = ['pending', 'waiting_payment', 'waiting_confirm'];

        if (!in_array($order->status, $cancellableStatuses)) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status saat ini.');
        }

        // simpan previous status (jika ada) lalu batalkan
        $order->previous_status = $order->status ?? null;
        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Mark order as received (user confirms they've received the goods).
     *
     * Only allowed when order was shipped.
     */
    public function receive(Request $request, Order $order)
    {
        // ownership
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        // allow when order was shipped (accept some common shipped labels)
        $shippedStatuses = ['shipped', 'terkirim', 'delivered'];

        if (!in_array($order->status, $shippedStatuses)) {
            return back()->with('error', 'Pesanan belum dikirimkan atau tidak dapat diterima saat ini.');
        }

        $order->previous_status = $order->status ?? null;
        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'Terima kasih — pesanan ditandai sebagai diterima.');
    }
}
