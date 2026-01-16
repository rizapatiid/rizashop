<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show upload form for a given order.
     * Akses langsung /payments/{order}/create
     */
    public function create(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        // Jika sudah selesai / sudah dibayar / sudah dikonfirmasi
        if (
            $order->status === 'completed' ||
            ($order->payment && in_array($order->payment->status, ['confirmed', 'paid']))
        ) {
            if (Route::has('payments.show')) {
                return redirect()->route('payments.show', $order->id);
            }
            if (Route::has('addresses.payments.show')) {
                return redirect()->route('addresses.payments.show', $order->id);
            }
            if (Route::has('orders.show')) {
                return redirect()->route('orders.show', $order->id);
            }
            return redirect('/');
        }

        return view('payments.create', compact('order'));
    }

    /**
     * Store uploaded proof (create/update Payment record).
     *
     * POPUP:
     * - reload halaman yang sama (redirect back)
     *
     * PAGE /payments/{id}/create:
     * - redirect ke /payments/{id}
     */
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        // Validasi berbeda untuk COD dan non-COD
        $rules = [
            'method' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ];

        // Jika bukan COD, proof wajib diupload
        if ($request->method !== 'cod') {
            $rules['proof'] = 'required|image|max:8192';
        }

        $request->validate($rules);

        // Simpan file (jika ada)
        $publicPath = null;
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $path = $file->store('public/payments');
            $publicPath = Storage::url($path);
        }

        // Tentukan status berdasarkan metode pembayaran
        if ($request->method === 'cod') {
            // COD langsung diproses, tidak perlu konfirmasi admin
            $paymentStatus = 'confirmed';
            $orderStatus = 'processing';
        } else {
            // Metode lain (VA, Transfer, QRIS) menunggu konfirmasi admin
            $paymentStatus = 'waiting_confirm';
            $orderStatus = 'waiting_confirm';
        }

        // Create / Update payment
        $payment = $order->payment;
        if (!$payment) {
            Payment::create([
                'order_id'   => $order->id,
                'method'     => $request->method,
                'amount'     => $request->amount,
                'status'     => $paymentStatus,
                'proof_path' => $publicPath,
            ]);
        } else {
            $payment->update([
                'method'     => $request->method,
                'amount'     => $request->amount,
                'status'     => $paymentStatus,
                'proof_path' => $publicPath,
            ]);
        }

        // Update status order
        $order->update([
            'status' => $orderStatus,
        ]);

        // Pesan sukses berbeda untuk COD
        $successMessage = $request->method === 'cod' 
            ? 'Pesanan berhasil dikonfirmasi! Status pesanan Anda sudah diproses. Siapkan pembayaran tunai saat barang tiba.'
            : 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.';

        /**
         * ===============================
         * POPUP MODE
         * ===============================
         * Jika submit dari modal popup,
         * cukup reload halaman yang sama
         */
        if ($request->has('from_popup')) {
            return redirect()->back()
                ->with('success', $successMessage);
        }

        /**
         * ===============================
         * DEFAULT MODE (SISTEM LAMA)
         * ===============================
         * Akses dari /payments/{order}/create
         */
        if (Route::has('payments.show')) {
            return Redirect::route('payments.show', $order->id)
                ->with('success', $successMessage);
        }

        if (Route::has('addresses.payments.show')) {
            return Redirect::route('addresses.payments.show', $order->id)
                ->with('success', $successMessage);
        }

        if (Route::has('orders.show')) {
            return Redirect::route('orders.show', $order->id)
                ->with('success', $successMessage);
        }

        return Redirect::to('/')
            ->with('success', $successMessage);
    }

    /**
     * Display the payment / order details (user only).
     */
    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('payment', 'items', 'address');

        return view('payments.show', compact('order'));
    }
}