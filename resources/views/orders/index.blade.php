@extends('layouts.app')
@section('content')

@php
use Illuminate\Support\Facades\Route;
@endphp

<style>
:root{
  --bg:#f7f8fb;
  --border:#e6eef6;
  --muted:#6b7280;
  --accent:#4f46e5;
  --accent2:#06b6d4;
  --danger:#ef4444;
  --success:#10b981;
  --warn:#f59e0b;
  --card:#fff;
  --radius:12px;
  font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial;
}
.page{ background:var(--bg); min-height:100vh; padding:24px 16px; }
.wrap{ max-width:980px; margin:0 auto; display:flex; flex-direction:column; gap:14px; }
.card{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:var(--radius);
  padding:16px;
  display:flex;
  flex-direction:column;
  gap:14px;
}
.top{ display:flex; justify-content:space-between; align-items:center; gap:12px; }
.order-no{ font-weight:900; color:var(--accent); }
.muted{ color:var(--muted); font-size:13px; }

/* badge */
.badge-wrap{ display:flex; align-items:center; gap:8px; }
.badge{
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 14px; border-radius:999px;
  font-weight:800; font-size:13px; color:#fff;
}
.badge svg{ width:14px;height:14px; }
.badge-warn{ background:linear-gradient(90deg,#f59e0b,#f97316); }
.badge-primary{ background:linear-gradient(90deg,#06b6d4,#22d3ee); }
.badge-info{ background:linear-gradient(90deg,#4f46e5,#7c3aed); }
.badge-success{ background:linear-gradient(90deg,#16a34a,#10b981); }
.badge-cancel{ background:linear-gradient(90deg,#ef4444,#fb7185); }

/* goto show icon */
.goto-show{
  width:36px;height:36px;border-radius:999px;
  display:inline-flex;align-items:center;justify-content:center;
  background:#fff;border:1px solid var(--border);
  color:#0f172a;text-decoration:none;
}
.goto-show svg{ width:18px;height:18px; }

/* shipping */
.ship{ display:flex; justify-content:space-between; gap:12px; font-size:13px; }

/* footer */
.footer{ display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; }
.total{ font-weight:900; font-size:16px; }

/* buttons */
.actions{ display:flex; gap:8px; flex-wrap:wrap; }
.btn{
  height:40px; padding:0 14px; border-radius:10px;
  font-weight:800; border:0; font-size:13px;
  display:inline-flex; align-items:center; gap:6px;
  text-decoration:none; cursor:pointer;
}
.btn-primary{ background:linear-gradient(90deg,#06b6d4,#22d3ee); color:#fff; }
.btn-indigo{ background:linear-gradient(90deg,#4f46e5,#7c3aed); color:#fff; }
.btn-success{ background:linear-gradient(90deg,#16a34a,#10b981); color:#fff; }
.btn-danger{ background:linear-gradient(90deg,#ef4444,#fb7185); color:#fff; }
</style>

<div class="page">
<div class="wrap">

<h2 style="font-weight:900;font-size:20px;">Pesanan Saya</h2>

@forelse($orders as $order)

@php
$payment = $order->payment ?? null;
$hasProof = $payment && !empty($payment->proof_path);
$paymentStatus = $payment->status ?? null;
$orderStatus = $order->status ?? null;

/* STATUS GROUP (WAJIB URUT INI) */
$shippedStatuses  = ['terkirim','shipped','delivered'];
$receivedStatuses = ['completed','received','diterima'];

/* FLAG UTAMA */
$isShipped  = in_array($orderStatus, $shippedStatuses);
$isReceived = in_array($orderStatus, $receivedStatuses);

/* FLAG LOGIKA TOMBOL (SAMA SHOW) */
$noProofAndWaitingPayment = !$hasProof && in_array($orderStatus, ['pending','waiting_payment']);
$waitingConfirmation = $hasProof && in_array($paymentStatus, ['waiting_confirm','waiting']);
$approved = $hasProof && in_array($paymentStatus, ['confirmed','paid']);
$rejected = ($hasProof && in_array($paymentStatus, ['rejected','declined','failed'])) || $orderStatus === 'need_confirmation';

/* BADGE */
if ($orderStatus === 'cancelled') {
  $label='Pesanan Dibatalkan'; $badge='badge-cancel';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
}
elseif ($isShipped) {
  $label='Pesanan Dikirimkan'; $badge='badge-info';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 7h13l4 4v6"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="18.5" cy="17.5" r="1.5"/></svg>';
}
elseif ($isReceived) {
  $label='Pesanan Diterima'; $badge='badge-success';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><polyline points="20 6 9 17 4 12"/></svg>';
}
elseif (!$hasProof) {
  $label='Menunggu Pembayaran'; $badge='badge-warn';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>';
}
elseif ($waitingConfirmation) {
  $label='Menunggu Konfirmasi Pembayaran'; $badge='badge-warn';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12v7"/><path d="M17 2v4"/></svg>';
}
elseif ($approved) {
  $label='Pesanan Diproses'; $badge='badge-primary';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 10v6"/><path d="M3 6h18"/></svg>';
}
elseif ($rejected) {
  $label='Perlu Konfirmasi'; $badge='badge-warn';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 5v14"/></svg>';
}
else {
  $label=ucfirst(str_replace('_',' ',$orderStatus)); $badge='badge-warn';
  $icon='<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="10"/></svg>';
}

/* shipping */
$carrier = $order->shipping_carrier ?? '-';
$resi = $order->tracking_number ?? '-';
@endphp

<div class="card">

  <div class="top">
    <div>
      <div class="order-no">Order #{{ $order->order_number }}</div>
      <div class="muted">{{ $order->created_at->format('d M Y, H:i') }}</div>
    </div>

    <div class="badge-wrap">
      <span class="badge {{ $badge }}">{!! $icon !!} {{ $label }}</span>
      <a href="{{ route('orders.show',$order->id) }}" class="goto-show" aria-label="Lihat detail">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18l6-6-6-6"/></svg>
      </a>
    </div>
  </div>

  <div class="ship">
    <div><span class="muted">Jasa Kirim</span><br><strong>{{ $carrier }}</strong></div>
    <div style="text-align:right;"><span class="muted">No Resi</span><br><strong>{{ $resi }}</strong></div>
  </div>

  <div class="footer">
    <div class="total">Rp {{ number_format($order->total,0,',','.') }}</div>

    <div class="actions">

      {{-- MENUNGGU PEMBAYARAN --}}
      @if($noProofAndWaitingPayment)
        <a href="{{ route('payments.create',$order->id) }}" class="btn btn-primary">Bayar</a>
        <form action="{{ route('orders.cancel',$order->id) }}" method="POST">@csrf
          <button class="btn btn-danger" type="submit">Batalkan Pesanan</button>
        </form>

      {{-- MENUNGGU KONFIRMASI --}}
      @elseif($waitingConfirmation)
        <a href="{{ route('payments.show',$order->id) }}" class="btn btn-indigo">Lihat Bukti Pembayaran</a>
        <form action="{{ route('orders.cancel',$order->id) }}" method="POST">@csrf
          <button class="btn btn-danger" type="submit">Batalkan Pesanan</button>
        </form>

      {{-- DISETUJUI ADMIN --}}
      @elseif($approved)
        <a href="{{ route('payments.show',$order->id) }}" class="btn btn-indigo">Lihat Bukti Pembayaran</a>

      {{-- DITOLAK ADMIN --}}
      @elseif($rejected)
        <a href="{{ route('payments.create',$order->id) }}" class="btn btn-primary">Upload Bukti Pembayaran</a>
        <form action="{{ route('orders.cancel',$order->id) }}" method="POST">@csrf
          <button class="btn btn-danger" type="submit">Batalkan Pesanan</button>
        </form>

      {{-- 🔥 PESANAN DIKIRIM (INI FIX UTAMA) --}}
      @elseif($isShipped)
        <a href="{{ route('payments.show',$order->id) }}" class="btn btn-indigo">Lihat Bukti Pembayaran</a>
        <form action="{{ route('orders.receive',$order->id) }}" method="POST">@csrf
          <button class="btn btn-success" type="submit">Pesanan Diterima</button>
        </form>

      {{-- PESANAN DITERIMA --}}
      @elseif($isReceived)
        <a href="{{ route('payments.show',$order->id) }}" class="btn btn-indigo">Lihat Bukti Pembayaran</a>
      @endif

    </div>
  </div>

</div>

@empty
<div class="card">
  <div class="muted">Belum ada pesanan.</div>
</div>
@endforelse

{{ $orders->links() }}

</div>
</div>
@endsection
