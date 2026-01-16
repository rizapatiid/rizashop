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
        $status = $request->get('status');

        // langsung query tabel orders berdasarkan user_id
        $query = Order::where('user_id', $user->id)
            ->with(['items', 'payment'])
            ->withCount('items')
            ->orderByDesc('created_at');
        
        // Filter berdasarkan status
        if ($status) {
            switch ($status) {
                case 'belum_bayar':
                    // Menampilkan: Menunggu Pembayaran + Perlu Konfirmasi
                    $query->where(function($q) {
                        // Menunggu Pembayaran: belum upload bukti
                        $q->where(function($subQ) {
                            $subQ->whereIn('status', ['pending', 'waiting_payment'])
                                ->whereDoesntHave('payment', function($paymentQ) {
                                    $paymentQ->whereNotNull('proof_path');
                                });
                        });
                        
                        // Perlu Konfirmasi: ditolak atau need_confirmation
                        $q->orWhere('status', 'need_confirmation')
                          ->orWhereHas('payment', function($paymentQ) {
                              $paymentQ->whereIn('status', ['rejected', 'declined', 'failed'])
                                       ->whereNotNull('proof_path');
                          });
                    });
                    break;
                    
                case 'dikemas':
                    // Menampilkan: Pesanan Diproses (payment confirmed/paid atau COD processing) dan belum dikirim
                    $query->where(function($q) {
                        // Payment confirmed/paid (transfer, VA, QRIS)
                        $q->whereHas('payment', function($paymentQ) {
                            $paymentQ->whereIn('status', ['confirmed', 'paid'])
                                     ->whereNotNull('proof_path');
                        });
                        
                        // COD yang sudah dikonfirmasi (status processing)
                        $q->orWhere(function($codQ) {
                            $codQ->whereHas('payment', function($paymentQ) {
                                $paymentQ->where('method', 'cod')
                                         ->where('status', 'confirmed');
                            })
                            ->where('status', 'processing');
                        });
                    })
                    ->whereNotIn('status', ['terkirim', 'shipped', 'delivered', 'completed', 'received', 'diterima', 'cancelled']);
                    break;
                    
                case 'dikirim':
                    // Menampilkan: Pesanan Dikirimkan
                    $query->whereIn('status', ['terkirim', 'shipped', 'delivered']);
                    break;
                    
                case 'selesai':
                    // Menampilkan: Pesanan Diterima
                    $query->whereIn('status', ['completed', 'received', 'diterima']);
                    break;
                    
                case 'dibatalkan':
                    // Menampilkan: Pesanan Dibatalkan
                    $query->where('status', 'cancelled');
                    break;
            }
        }

        $orders = $query->paginate(12);

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