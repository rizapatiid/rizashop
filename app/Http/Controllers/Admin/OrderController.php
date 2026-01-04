<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // list orders (simple)
    public function index()
    {
        $orders = Order::withCount('items')->orderByDesc('created_at')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    // show order detail
    public function show(Order $order)
    {
        $order->load('items', 'payment', 'address', 'user');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status action handler (approve/reject/payment flows)
     *
     * Accepts:
     * - action = 'approve_payment' | 'reject_payment' (from proof modal)
     * - OR status = <one of allowed statuses> (from dropdown)
     * - note = optional admin note
     *
     * Behavior:
     * - approve_payment -> set order.status = 'processing' and payment.status = 'confirmed'
     * - reject_payment -> set order.status = 'waiting_payment' and payment.status = 'rejected'
     * - if status param provided, update order->status accordingly (and optionally payment)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'nullable|string',
            'status' => 'nullable|string',
            'note' => 'nullable|string|max:2000',
        ]);

        $action = $request->input('action');
        $note = $request->input('note', null);
        $requestedStatus = $request->input('status', null);

        DB::beginTransaction();
        try {
            // store previous status
            $order->previous_status = $order->status ?? null;

            // If explicit action (approve / reject)
            if ($action === 'approve_payment') {

                // mark payment if exists
                if ($order->payment) {
                    $order->payment->status = 'confirmed';
                    $order->payment->save();
                } else {
                    // optional: create payment record if you want; or skip
                }

                // change order status -> processing
                $order->status = 'processing';

                // append admin note if provided
                if ($note) {
                    $order->notes = $this->appendNote($order->notes, "[Admin] Approve: ".$note);
                } else {
                    $order->notes = $this->appendNote($order->notes, "[Admin] Pembayaran disetujui.");
                }

                $order->save();

                DB::commit();
                return Redirect::back()->with('success', 'Pembayaran disetujui — status diperbarui menjadi Pesanan Diproses.');
            }

            if ($action === 'reject_payment') {
                // mark payment if exists
                if ($order->payment) {
                    $order->payment->status = 'rejected';
                    $order->payment->save();
                }

                // set order back to waiting_payment
                $order->status = 'waiting_payment';

                // append note: include reject reason if provided
                if ($note) {
                    $order->notes = $this->appendNote($order->notes, "[Admin] Pembayaran ditolak: ".$note);
                } else {
                    $order->notes = $this->appendNote($order->notes, "[Admin] Pembayaran ditolak.");
                }

                $order->save();

                DB::commit();
                return Redirect::back()->with('success', 'Pembayaran ditolak — status dikembalikan ke Menunggu Pembayaran.');
            }

            // Otherwise: if admin chose arbitrary status from dropdown
            if ($requestedStatus) {
                // allow only certain statuses (safety)
                $allowed = ['pending','waiting_payment','waiting_confirm','processing','shipped','completed','cancelled'];
                if (!in_array($requestedStatus, $allowed)) {
                    DB::rollBack();
                    return Redirect::back()->with('error', 'Status tidak dikenali.');
                }

                // Handle transitions with side-effects:
                if ($requestedStatus === 'processing') {
                    // if moving to processing, also mark payment confirmed (if exists)
                    if ($order->payment) {
                        $order->payment->status = 'confirmed';
                        $order->payment->save();
                    }
                }

                if ($requestedStatus === 'waiting_payment') {
                    // if forcing to waiting_payment, mark payment rejected/cleared
                    if ($order->payment) {
                        $order->payment->status = 'rejected';
                        $order->payment->save();
                    }
                }

                if ($requestedStatus === 'cancelled') {
                    // nothing special beyond status
                }

                // set and save
                $order->status = $requestedStatus;

                if ($note) {
                    $order->notes = $this->appendNote($order->notes, "[Admin] ".$note);
                }

                $order->save();

                DB::commit();
                return Redirect::back()->with('success', 'Status pesanan berhasil diperbarui menjadi: '.$requestedStatus);
            }

            // if no actionable input
            DB::rollBack();
            return Redirect::back()->with('error', 'Tidak ada aksi yang dilakukan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            // optional: log the error
            \Log::error('admin.orders.updateStatus failed: '.$e->getMessage(), ['order_id'=>$order->id]);
            return Redirect::back()->with('error', 'Gagal memperbarui status: '.$e->getMessage());
        }
    }

    /**
     * Set tracking / mark shipped.
     *
     * Expected inputs: courier, tracking_number
     * Behavior: set courier/tracking_number, set order.status = 'shipped' and save
     */
    public function setTracking(Request $request, Order $order)
    {
        $request->validate([
            'courier' => 'nullable|string|max:255',
            'tracking_number' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $order->previous_status = $order->status ?? null;
            $order->shipping_courier = $request->input('courier') ?: $order->shipping_courier;
            $order->tracking_number = $request->input('tracking_number');
            $order->status = 'shipped';
            // append note
            $order->notes = $this->appendNote($order->notes, "[Admin] Mengirim pesanan. Resi: ".$order->tracking_number);
            $order->save();

            DB::commit();
            return Redirect::back()->with('success', 'Resi tersimpan dan status diubah menjadi Pesanan Dikirimkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('admin.orders.setTracking failed: '.$e->getMessage(), ['order_id'=>$order->id]);
            return Redirect::back()->with('error', 'Gagal menyimpan resi: '.$e->getMessage());
        }
    }

    /**
     * helper: append note with timestamp
     */
    protected function appendNote($existing, $text)
    {
        $now = now()->format('d M Y H:i');
        $entry = "[$now] ".$text;
        if (empty($existing)) return $entry;
        return $existing . "\n" . $entry;
    }
}
