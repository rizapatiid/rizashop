@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<div class="order-page container mx-auto p-6 max-w-6xl">
@php
    use Illuminate\Support\Facades\Route;

    $backRoute = Route::has('orders.index') ? route('orders.index') : (Route::has('orders.index') ? route('orders.index') : url('/'));
    $paymentsShowRoute = Route::has('payments.show') ? 'payments.show' : (Route::has('payments.show') ? 'payments.show' : null);
    $paymentsCreateRoute = Route::has('payments.create') ? 'payments.create' : (Route::has('payments.create') ? 'payments.create' : null);
    $ordersCancelRoute = 'orders.cancel';
    $ordersReceiveRoute = Route::has('orders.receive') ? 'orders.receive' : (Route::has('orders.receive') ? 'orders.receive' : null);

    $payment = $order->payment ?? null;
    $hasPaymentProof = ($payment && !empty($payment->proof_path));
    $paymentStatus = $payment->status ?? null;
    $paymentMethod = $payment->method ?? null;
    $orderStatus = $order->status ?? null;

    // Check if COD
    $isCOD = $paymentMethod === 'cod';

    $cancellableStatuses = ['pending', 'waiting_payment', 'waiting_confirm', 'need_confirmation'];
    $shippedStatuses = ['terkirim','shipped','delivered'];
    $receivedStatuses = ['completed','received','diterima'];

    // shipping info (adjust according to your model)
    $shippingCarrier = $order->shipping_carrier ?? ($order->shipment->carrier ?? null) ?? ($order->shipping_courier ?? null);
    $trackingNumber = $order->tracking_number ?? ($order->shipment->tracking_number ?? null) ?? null;

    // build proof URL + extension for modal usage
    $proofUrl = $hasPaymentProof ? asset(ltrim($payment->proof_path, '/')) : null;
    $proofExt = null;
    if ($hasPaymentProof) {
        $proofExt = strtolower(pathinfo($payment->proof_path, PATHINFO_EXTENSION) ?: '');
    }

    // Display label & badge - UPDATED FOR NEW SYSTEM WITH COD
    if ($orderStatus === 'cancelled' || in_array($orderStatus, ['canceled','cancelled_by_user'])) {
        $displayLabel = 'Pesanan Dibatalkan'; 
        $badgeClass = 'badge-cancel'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    } 
    elseif (in_array($orderStatus, $receivedStatuses)) {
        $displayLabel = 'Pesanan Diterima'; 
        $badgeClass = 'badge-success'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
    }
    elseif (in_array($orderStatus, $shippedStatuses)) {
        $displayLabel = 'Pesanan Dikirimkan'; 
        $badgeClass = 'badge-info'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6a1 1 0 0 1-1 1h-1"/><path d="M16 3v4"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="18.5" cy="17.5" r="1.5"/></svg>';
    }
    elseif ($isCOD && $paymentStatus === 'confirmed' && $orderStatus === 'processing') {
        // COD yang sudah dikonfirmasi dan sedang diproses - sama seperti payment biasa
        $displayLabel = 'Pesanan Diproses'; 
        $badgeClass = 'badge-primary'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10v6a2 2 0 0 1-2 2H8"/><path d="M3 6h18"/><path d="M16 3v6"/></svg>';
    }
    elseif ($orderStatus === 'processing' || in_array($paymentStatus, ['confirmed','paid'])) {
        // Processing - payment confirmed
        $displayLabel = 'Pesanan Diproses'; 
        $badgeClass = 'badge-primary'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10v6a2 2 0 0 1-2 2H8"/><path d="M3 6h18"/><path d="M16 3v6"/></svg>';
    }
    elseif ($orderStatus === 'waiting_confirm' || in_array($paymentStatus, ['waiting_confirm','waiting_confirmation','waiting'])) {
        // Menunggu konfirmasi payment
        $displayLabel = 'Menunggu Konfirmasi Pembayaran'; 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h11"/><path d="M17 2v4"/></svg>';
    }
    elseif (in_array($paymentStatus, ['rejected','declined','failed']) || $orderStatus === 'need_confirmation' || $paymentStatus === 'need_confirmation') {
        // Payment ditolak, perlu konfirmasi ulang
        $displayLabel = 'Perlu Konfirmasi'; 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/></svg>';
    }
    elseif (!$hasPaymentProof && !$isCOD) {
        // Belum bayar (non-COD)
        $displayLabel = 'Menunggu Pembayaran'; 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>';
    }
    else {
        // Default fallback
        $displayLabel = ucfirst(str_replace('_',' ',$paymentStatus ?: ($orderStatus?: 'pending'))); 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
    }

    // convenience flags for action rendering - UPDATED FOR COD
    $noProofAndWaitingPayment = !$hasPaymentProof && !$isCOD && in_array($orderStatus, ['pending','waiting_payment']);
    $waitingConfirmation = $hasPaymentProof && in_array($paymentStatus, ['waiting_confirm','waiting_confirmation','waiting']);
    $approved = ($hasPaymentProof && in_array($paymentStatus, ['confirmed','paid'])) || ($isCOD && $paymentStatus === 'confirmed');
    $rejected = ($hasPaymentProof && in_array($paymentStatus, ['rejected','declined','failed'])) || $orderStatus === 'need_confirmation' || $paymentStatus === 'need_confirmation';
    $shipped = in_array($orderStatus, $shippedStatuses);
    $received = in_array($orderStatus, $receivedStatuses);

    // show cancel when explicitly allowed by statuses
    // IMPORTANT: COD yang sudah confirmed tidak bisa dibatalkan
    $showCancel = ( in_array($orderStatus, $cancellableStatuses) || $noProofAndWaitingPayment || $waitingConfirmation || $rejected );
    
    // COD yang sudah confirmed tidak bisa dibatalkan
    if ($isCOD && $paymentStatus === 'confirmed') {
        $showCancel = false;
    }
    
    $nonCancellable = array_merge($shippedStatuses, $receivedStatuses, ['completed','cancelled','canceled','cancelled_by_user','processing']);
    if (in_array($orderStatus, $nonCancellable)) {
        $showCancel = false;
    }

    $showReceive = $shipped;
@endphp

<style>
:root{
  --bg:#f7f8fb;
  --muted:#6b7280;
  --border:#e6eef6;
  --accent:#4f46e5;
  --accent-2:#06b6d4;
  --danger:#ef4444;
  --success:#10b981;
  --warn:#f59e0b;
  --card:#ffffff;
  --radius:12px;
  --shadow: 0 12px 30px rgba(2,6,23,0.06);

  --icon-size:20px;
  --icon-sm-size:14px;
  --btn-height:44px;
  --btn-radius:10px;
  --badge-height:36px;
  --badge-padding:10px 14px;

  font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
}

/* ICON STANDARDS */
.icon{ width:var(--icon-size); height:var(--icon-size); display:block; }
.icon-sm{ width:var(--icon-sm-size); height:var(--icon-sm-size); display:block; }
svg.icon, svg.icon-sm { vertical-align:middle; }

/* Page */
.order-page{ background:var(--bg); padding:28px 18px; min-height:100vh; }
.container{ max-width:1100px; margin:0 auto; }

/* Top header */
.order-top{ display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:22px; flex-wrap:wrap; }
.breadcrumb{ display:flex; gap:12px; align-items:center; color:var(--muted); text-decoration:none; }
.back-box{ width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#fff,#fbfdff);border:1px solid var(--border); }
.header-title{ font-weight:800; font-size:20px; color:#0f172a; display:flex; gap:10px; align-items:center; }
.order-no{ color:var(--accent); font-weight:900; font-size:20px; }
.header-sub{ color:var(--muted); font-size:13px; }

/* Grid */
.grid-two{ display:grid; grid-template-columns: 1fr 380px; gap:22px; align-items:start; }
@media(max-width:1024px){ .grid-two{ grid-template-columns: 1fr; } }

/* Cards: effects removed (no hover transform, no shadows) */
.card{ background:var(--card); border:1px solid var(--border); border-radius:var(--radius); padding:18px; box-shadow:none; }
.card--hover{ transition:none; }
.card--hover:hover{ transform:none; box-shadow:none; }

/* Badge */
.badge{ display:inline-flex; align-items:center; gap:8px; padding:var(--badge-padding); border-radius:999px; color:#fff; font-weight:800; font-size:13px; height:var(--badge-height); box-shadow:none; }
.badge svg{ flex-shrink:0; width:var(--icon-sm-size); height:var(--icon-sm-size); }
.badge-warn{ background:linear-gradient(90deg,#f59e0b,#f97316); }
.badge-primary{ background:linear-gradient(90deg,var(--accent-2),#06b6d4); }
.badge-info{ background:linear-gradient(90deg,var(--accent),#7c3aed); }
.badge-cancel{ background:linear-gradient(90deg,#ef4444,#fb7185); }

/* BADGE SUCCESS */
.badge-success{
  background: linear-gradient(90deg,#16a34a,#10b981);
  color: #fff;
  box-shadow: none;
  height: var(--badge-height);
  padding: var(--badge-padding);
  font-weight: 800;
  border-radius: 999px;
}
.badge-success svg { stroke: white; }

/* Receiver */
.receiver{ display:flex; gap:16px; align-items:flex-start; }
.avatar-box{ width:72px;height:72px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#f0f7ff,#fff);border:1px solid var(--border); }
.meta{ display:flex; flex-direction:column; gap:6px; min-width:0; }
.addr-label{ font-weight:700; color:#0f172a; font-size:13px; }
.addr-name{ font-weight:800; font-size:15px; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.addr-phone{ color:var(--muted); font-size:13px; }
.addr-full{ color:var(--muted); font-size:13px; line-height:1.45; }

/* Items */
.items-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; gap:8px; }
.items-list{ display:flex; flex-direction:column; gap:12px; }
.item{ display:flex; justify-content:space-between; gap:12px; align-items:center; padding:12px; border-radius:10px; border:1px solid #f3f6fb; background:linear-gradient(180deg,#fff,#fbfdff); }
.item-left{ display:flex; gap:12px; align-items:center; min-width:0; }
.thumb{ width:72px; height:72px; border-radius:10px; overflow:hidden; background:#f8fafc; border:1px solid #eef2f7; display:flex; align-items:center; justify-content:center; flex:0 0 72px; }
.thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
.item-name{ font-weight:800; color:#0f172a; font-size:14px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.item-meta{ color:var(--muted); font-size:13px; margin-top:6px; }
.item-qty{ background:#f3f6fb; border-radius:8px; padding:6px 8px; font-weight:700; font-size:13px; color:#0f172a; }

/* History */
.history-head{ display:flex; justify-content:space-between; align-items:center; gap:12px; }
.history-controls{ display:flex; gap:8px; align-items:center; }
/* icon-btn: remove rotation/hover effect per request (no animation) */
.icon-btn{ width:40px; height:40px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--border); background:linear-gradient(180deg,#fff,#fbfdff); cursor:pointer; padding:6px; box-shadow:none; transition:none; }
.icon-btn:focus{ outline:3px solid rgba(79,70,229,0.12); outline-offset:2px; }
.history-list{ display:flex; flex-direction:column; gap:12px; margin-top:12px; padding-left:6px; }
/* improved history item layout */
.history-item{ display:flex; gap:12px; align-items:center; padding:12px; border-radius:10px; border:1px solid #f3f6fb; background:#fff; }
.h-icon{ width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#fff,#fbfdff);border:1px solid #eef2f7; flex:0 0 44px; }
.history-label{ font-weight:700; color:#0f172a; }
.history-ts{ color:var(--muted); font-size:13px; margin-left:auto; text-align:right; }

/* history header appearance */
.riwayat-header{ display:flex; gap:12px; align-items:center; }
.riwayat-title{ font-weight:900; font-size:15px; color:#0f172a; }
.riwayat-sub{ color:var(--muted); font-size:13px; }

/* Timeline for wide */
@media(min-width:900px){
  .history-list{ position:relative; padding-left:26px; }
  .history-list::before{ content:""; position:absolute; left:22px; top:16px; bottom:16px; width:3px; background:linear-gradient(180deg, rgba(79,70,229,0.12), rgba(6,182,212,0.08)); border-radius:2px; }
  .history-item{ padding-left:26px; position:relative; }
  .history-item::before{ content:""; position:absolute; left:-4px; width:12px; height:12px; border-radius:50%; background:#fff; border:3px solid var(--accent-2); top:calc(50% - 9px); box-shadow:none; }
}

/* Summary */
.summary{ position:sticky; top:86px; display:flex; flex-direction:column; gap:12px; min-width:300px; width:100%; }
.summary-row{ display:flex; justify-content:space-between; gap:8px; align-items:center; }
.summary-total{ font-weight:900; font-size:20px; color:#0f172a; }
.actions{ display:flex; gap:12px; align-items:center; margin-top:12px; }

/* Shipping card */
.shipping-card{ margin-bottom:12px; display:flex; flex-direction:column; gap:8px; }
.shipping-row{ display:flex; align-items:center; justify-content:space-between; gap:8px; }
.ship-left{ display:flex; gap:10px; align-items:center; min-width:0; }
.ship-icon{ width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; background:linear-gradient(180deg,#fff,#fbfdff); border:1px solid var(--border); flex:0 0 44px; }
.ship-meta{ display:flex; flex-direction:column; min-width:0; }
.ship-title{ font-weight:800; color:#0f172a; font-size:14px; }
.ship-sub{ color:var(--muted); font-size:13px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

/* copy button */
.copy-btn{ border:0; background:transparent; cursor:pointer; display:inline-flex; align-items:center; gap:8px; padding:8px; border-radius:8px; }
.copy-btn:focus{ outline:3px solid rgba(79,70,229,0.12); outline-offset:3px; }

/* Button system */
.btn{ height:var(--btn-height); padding:0 16px; border-radius:var(--btn-radius); font-weight:800; cursor:pointer; border:0; display:inline-flex; gap:8px; align-items:center; text-decoration:none; transition:none; font-size:14px; }
.btn svg.icon-sm{ margin-right:6px; width:var(--icon-sm-size); height:var(--icon-sm-size); }
.btn-primary{ background:linear-gradient(90deg,var(--accent-2),#06b6d4); color:white; box-shadow:none; }
.btn-indigo{ background:linear-gradient(90deg,var(--accent),#7c3aed); color:white; box-shadow:none; }
.btn-ghost{ background:white; border:1px solid var(--border); color:#0f172a; }
.btn-danger{ background:linear-gradient(90deg,#ef4444,#fb7185); color:white; }
.btn-success{ background: linear-gradient(90deg,#16a34a,#10b981); color:white; }

/* small text */
.muted{ color:var(--muted); font-size:13px; }
.sep{ height:1px;background:#f3f6fb;margin:10px 0;border-radius:4px; }

/* responsive */
@media(max-width:640px){
  .actions{ flex-direction:column-reverse; width:100%; align-items:stretch; }
  .summary{ position:static; }
  .thumb{ width:64px; height:64px; flex:0 0 64px; }
  .avatar-box{ width:64px;height:64px; }
}

/* focus */
a:focus, button:focus { outline:3px solid rgba(79,70,229,0.12); outline-offset:3px; }

/* spinner inside buttons when processing */
.btn .loader{ width:16px; height:16px; border-radius:50%; border:2px solid rgba(255,255,255,0.2); border-top-color:rgba(255,255,255,0.9); animation:spin .9s linear infinite; }
@keyframes spin{ to{ transform:rotate(360deg); } }

/* proof modal */
.proof-modal-overlay{ position:fixed; inset:0; background:rgba(2,6,23,0.6); display:none; align-items:center; justify-content:center; z-index:1100; padding:24px; }
.proof-modal{ background:#fff; border-radius:12px; max-width:800px; width:100%; max-height:70vh; height:70vh; overflow:hidden; box-shadow:0 30px 80px rgba(2,6,23,0.4); display:flex; flex-direction:column; }
.proof-modal-header{ display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid #f3f6fb; flex:0 0 56px; }
.proof-modal-body{ padding:12px; display:flex; align-items:center; justify-content:center; flex:1 1 auto; overflow:hidden; background:linear-gradient(180deg,#f8fafc,#fff); }
.proof-modal-body img{ max-width:100%; max-height:calc(70vh - 120px); width:auto; height:auto; object-fit:contain; display:block; border-radius:8px; box-shadow:0 8px 30px rgba(2,6,23,0.06); }
.proof-modal-body iframe{ width:100%; height:100%; border:0; display:block; border-radius:6px; }
.proof-modal-caption{ font-size:13px; color:var(--muted); padding:8px 16px; border-top:1px solid #f3f6fb; flex:0 0 44px; display:none; }
.proof-modal-close{ background:transparent; border:0; cursor:pointer; padding:8px; border-radius:8px; }
#proofDownload{ text-decoration:none; display:none; align-items:center; }
@media(max-width:640px){ .proof-modal{ max-width:92%; height:78vh; max-height:78vh; } .proof-modal-body img{ max-height:calc(78vh - 120px); } .proof-modal-caption{ flex:0 0 56px; } }

/* receive modal */
.receive-modal-overlay{ position:fixed; inset:0; background:rgba(2,6,23,0.45); display:none; align-items:center; justify-content:center; z-index:1200; padding:20px; }
.receive-modal{ width:100%; max-width:520px; background:#fff; border-radius:12px; box-shadow:0 30px 60px rgba(2,6,23,0.25); padding:18px; display:flex; flex-direction:column; gap:12px; }
.receive-modal h3{ margin:0; font-size:18px; font-weight:800; color:#0f172a; }
.receive-modal p{ margin:0; color:var(--muted); font-size:14px; line-height:1.45; }
.receive-actions{ display:flex; gap:10px; justify-content:flex-end; margin-top:8px; }
.receive-actions .btn{ min-width:120px; }
.receive-modal .btn-cancel{ background:#fff; border:1px solid var(--border); color:#0f172a; }
@media(max-width:480px){ .receive-modal{ max-width:92%; padding:14px; } .receive-actions .btn{ min-width:100px; } }

/* upload modal (new) */
.upload-modal-overlay{ position:fixed; inset:0; background:rgba(2,6,23,0.6); display:none; align-items:center; justify-content:center; z-index:1300; padding:20px; }
.upload-modal{ width:100%; max-width:640px; background:#fff; border-radius:12px; box-shadow:0 30px 80px rgba(2,6,23,0.35); padding:18px; display:flex; flex-direction:column; gap:12px; }
.upload-modal h3{ margin:0; font-size:18px; font-weight:800; color:#0f172a; }
.upload-row{ display:flex; gap:12px; align-items:center; }
.file-preview{ width:120px; height:84px; border-radius:8px; border:1px dashed var(--border); display:flex; align-items:center; justify-content:center; background:#fbfdff; overflow:hidden; }
.file-meta{ flex:1; display:flex; flex-direction:column; gap:6px; }
.file-name{ font-weight:700; font-size:14px; color:#0f172a; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.file-hint{ color:var(--muted); font-size:13px; }
.upload-actions{ display:flex; gap:8px; justify-content:flex-end; margin-top:8px; }
.upload-modal .btn { min-width:120px; }

/* small helpers */
.hidden{ display:none !important; }
</style>

<!-- Top header -->
<div class="order-top">
  <div style="display:flex;align-items:center;gap:12px;">
    <a href="{{ $backRoute }}" class="breadcrumb" aria-label="Kembali ke daftar pesanan">
      <div class="back-box" aria-hidden="true">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      </div>
      <div style="min-width:0;">
        <div class="header-title">
          <span>Order</span>
          <span class="order-no">#{{ $order->order_number }}</span>
        </div>
        <div class="header-sub">{{ $order->created_at->format('d M Y, H:i') }}</div>
      </div>
    </a>
  </div>

  <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <span class="badge {{ $badgeClass ?? 'badge-warn' }}" role="status" aria-live="polite">
        {!! $badgeIcon ?? '' !!} <span>{{ $displayLabel }}</span>
      </span>
    </div>
  </div>
</div>

<div class="grid-two">
  <!-- LEFT -->
  <div style="display:flex;flex-direction:column;gap:16px;">

    <!-- Receiver -->
    <div class="card receiver" role="region" aria-label="Detail Penerima">
      <div class="avatar-box" aria-hidden="true">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#0ea5e9" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/><path d="M6 20c0-3.31 2.69-6 6-6s6 2.69 6 6"/></svg>
      </div>

      <div class="meta">
        <div class="addr-label">Detail & Alamat Penerima</div>
        @php $addr = $order->address; @endphp
        @if($addr)
          <div class="addr-name" title="{{ $addr->recipient_name }}">{{ $addr->recipient_name }} <span class="kv">· {{ $addr->label ?? '' }}</span></div>
          <div class="addr-phone">{{ trim(($addr->phone_country ?? '') . ' ' . ($addr->phone ?? '')) }}</div>
          <div class="addr-full">{!! e($addr->address_full) !!}{{ $addr->village ? ', '.$addr->village : '' }}{{ $addr->subdistrict ? ', '.$addr->subdistrict : '' }}{{ $addr->city ? ', '.$addr->city : '' }}{{ $addr->province ? ', '.$addr->province : '' }}{{ $addr->postal_code ? ' - ' . $addr->postal_code : '' }}</div>
        @else
          <div class="muted">Tidak ada alamat pengiriman pada pesanan ini.</div>
        @endif
      </div>
    </div>

    <!-- Items -->
    <div class="card" aria-labelledby="itemsHeading">
      <div class="items-head">
        <div style="font-weight:800;font-size:15px;" id="itemsHeading">Produk <span class="kv">({{ count($order->items) }})</span></div>
        <div class="small-muted">Ringkasan item pesanan</div>
      </div>

      <div class="items-list" role="list" aria-label="Daftar produk">
        @foreach($order->items as $it)
          <div class="item" role="listitem" aria-label="{{ $it->product_name }}">
            <div class="item-left">
              <div class="thumb" aria-hidden="true">
                @if(!empty($it->meta['image']))
                  <img src="{{ asset('storage/'.ltrim($it->meta['image'],'/')) }}" alt="{{ $it->product_name }}">
                @else
                  <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 14s1.5-2 4-2 4 2 4 2"/><circle cx="9" cy="9" r="1"/></svg>
                @endif
              </div>

              <div style="min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;">
                  <div class="item-name" title="{{ $it->product_name }}">{{ $it->product_name }}</div>
                  <div class="item-qty">x{{ $it->qty }}</div>
                </div>
                <div class="item-meta">Rp {{ number_format($it->price,0,',','.') }} /pcs · <span class="small-muted">Berat: {{ $it->meta['weight'] ?? '-' }}</span></div>
              </div>
            </div>

            <div style="text-align:right; min-width:140px;">
              <div style="font-weight:800;">Rp {{ number_format($it->subtotal,0,',','.') }}</div>
              <div class="muted" style="font-size:13px;">Subtotal</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- History & Catatan -->
    <div class="card" aria-live="polite" aria-labelledby="statusHeading">
      <div class="history-head">
        <div style="font-weight:800;" id="statusHeading">Status & Catatan</div>
      </div>

      <div style="margin-top:12px;">
        <!-- NEW Riwayat header (cleaner) -->
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
          <div class="riwayat-header" style="display:flex;align-items:center;">
            <button id="toggleHistoryBtn" class="icon-btn" aria-expanded="true" aria-controls="historyList" title="Tutup riwayat" aria-label="Tutup riwayat" style="margin-left:0;">
              <!-- no rotation/hover effect -->
              <svg id="chevIcon" class="icon" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div style="display:flex;flex-direction:column;">
              <div class="riwayat-title">Riwayat Pesanan</div>
              <div class="riwayat-sub">Ringkasan perubahan status & catatan terbaru</div>
            </div>
          </div>

          <!-- <div class="small-muted">Klik ikon untuk tampil/sembunyi riwayat.</div> -->
        </div>

        <div id="historyList" class="history-list" style="margin-top:12px;">
          @php
            $history = [];
            if ($order->created_at) {
                $history[] = ['label' => 'Pesanan Dibuat', 'at' => $order->created_at, 'icon' => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18"/><path d="M12 3v4"/><path d="M5 21h14"/></svg>'];
            }
            if ($payment && $payment->created_at) {
                $history[] = ['label' => 'Bukti Pembayaran Diunggah', 'at' => $payment->created_at, 'icon' => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3v4"/></svg>'];
            }
            if ($payment && in_array($payment->status, ['confirmed','paid']) && $payment->updated_at) {
                $history[] = ['label' => 'Pembayaran Dikonfirmasi', 'at' => $payment->updated_at, 'icon' => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>'];
            }
            if (property_exists($order, 'previous_status') && !empty($order->previous_status)) {
                $history[] = ['label' => 'Status Sebelumnya: ' . $order->previous_status, 'at' => null, 'icon' => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/></svg>'];
            }
            if ($order->updated_at && $order->updated_at->ne($order->created_at)) {
                $already = false;
                foreach ($history as $h) {
                    if ($h['at'] && $order->updated_at && $h['at']->eq($order->updated_at)) { $already = true; break; }
                }
                if (!$already) {
                    $label = 'Status diubah: ' . ($order->status ? ucfirst(str_replace('_',' ',$order->status)) : 'Updated');
                    $history[] = ['label' => $label, 'at' => $order->updated_at, 'icon' => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v4l3 3"/></svg>'];
                }
            }
            usort($history, function($a,$b){
                if ($a['at'] && $b['at']) {
                    if ($a['at']->eq($b['at'])) return 0;
                    return $a['at']->gt($b['at']) ? -1 : 1;
                } elseif ($a['at']) return -1;
                elseif ($b['at']) return 1;
                return 0;
            });
          @endphp

          @forelse($history as $h)
            <div class="history-item" role="listitem">
              <div class="h-icon" aria-hidden="true">
                {!! $h['icon'] ?? '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>' !!}
              </div>

              <div style="min-width:0;">
                <div class="history-label">{{ $h['label'] }}</div>
                <div class="small-muted" style="margin-top:6px;">@if(!empty($h['at'])) {{ $h['at']->format('d M Y, H:i') }} @else — @endif</div>
              </div>

              <div class="history-ts" aria-hidden="true">@if(!empty($h['at'])) {{ $h['at']->format('d M Y, H:i') }} @else — @endif</div>
            </div>
          @empty
            <div class="muted">Tidak ada riwayat tersedia.</div>
          @endforelse
        </div>

        @if($order->updated_at && $order->updated_at->ne($order->created_at))
          <div style="margin-top:12px;color:var(--muted);font-size:13px;"><strong>Terakhir Diperbarui:</strong> {{ $order->updated_at->format('d M Y, H:i') }}</div>
        @endif

        <div style="margin-top:12px;">
          <div style="font-weight:800;">Catatan</div>
          <div style="margin-top:6px;color:var(--muted);">
            @php
              // show latest note only
              $latestNote = null;
              $rawNotes = $order->notes ?? null;
              if (is_null($rawNotes) || $rawNotes === '') $latestNote = null;
              elseif(is_array($rawNotes) || $rawNotes instanceof \Illuminate\Support\Collection) {
                $arr = is_array($rawNotes) ? $rawNotes : $rawNotes->toArray();
                $arr = array_values(array_filter($arr, function($v){ return $v !== null && $v !== ''; }));
                $latestNote = count($arr) ? end($arr) : null;
              } elseif(is_string($rawNotes)) {
                $decoded = json_decode($rawNotes, true);
                if (is_array($decoded)) {
                  $decoded = array_values(array_filter($decoded, function($v){ return $v !== null && $v !== ''; }));
                  $latestNote = count($decoded) ? end($decoded) : null;
                } else {
                  $lines = preg_split('/\r\n|\r|\n/', trim($rawNotes));
                  $lines = array_values(array_filter(array_map('trim', $lines), function($v){ return $v !== ''; }));
                  $latestNote = count($lines) ? end($lines) : trim($rawNotes);
                }
              } elseif(is_object($rawNotes)) {
                if (property_exists($rawNotes, 'note')) $latestNote = $rawNotes->note;
                else {
                  $props = get_object_vars($rawNotes);
                  $vals = array_values(array_filter($props, function($v){ return $v !== null && $v !== ''; }));
                  $latestNote = count($vals) ? end($vals) : null;
                }
              }
            @endphp

            @if($latestNote)
              {{ is_array($latestNote) || is_object($latestNote) ? json_encode($latestNote, JSON_UNESCAPED_UNICODE) : $latestNote }}
            @else
              Tidak ada catatan
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- RIGHT -->
  <aside>
    <!-- NEW: Shipping info card (above summary) -->
    <div class="card shipping-card" role="region" aria-label="Informasi Pengiriman">
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <div style="font-weight:900;">Informasi Pengiriman</div>
        <!-- <div class="small-muted">Detail pengiriman & resi</div> -->
      </div>

      <div style="margin-top:12px; display:flex; flex-direction:column; gap:10px;">
        <div class="shipping-row">
          <div class="ship-left">
            <div class="ship-icon" aria-hidden="true">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h13l4 4v5h-1a2 2 0 0 1-2-2"/></svg>
            </div>
            <div class="ship-meta">
              <div class="ship-title">Jasa Kirim</div>
              <div class="ship-sub">{{ $shippingCarrier ? e($shippingCarrier) : '-' }}</div>
            </div>
          </div>

          <div style="text-align:right;">
            <div class="small-muted">Status</div>
            <div style="font-weight:700;">{{ in_array($orderStatus, $shippedStatuses) ? 'Dikirim' : (in_array($orderStatus, $receivedStatuses) ? 'Diterima' : ucfirst(str_replace('_',' ',$orderStatus ?: '-'))) }}</div>
          </div>
        </div>

        <div class="shipping-row" style="align-items:center;">
          <div style="display:flex;align-items:center;gap:10px;min-width:0;">
            <div style="font-weight:700;">Nomor Resi</div>
            <div class="small-muted" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:220px;">
              {{ $trackingNumber ?? '-' }}
            </div>
          </div>

          <div style="display:flex;gap:8px;">
            @if($trackingNumber)
              <button class="copy-btn" type="button" data-copy="{{ $trackingNumber }}" aria-label="Salin nomor resi">
                <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="10" height="10" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="small-muted">Salin</span>
              </button>
            @else
              <div class="small-muted">-</div>
            @endif
          </div>
        </div>

      </div>
    </div>

    <div class="card summary" role="complementary" aria-labelledby="summaryHeading">
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <div style="font-weight:900;" id="summaryHeading">Ringkasan Pesanan</div>
        <div class="small-muted">Invoice</div>
      </div>

      <div style="margin-top:12px;display:flex;flex-direction:column;gap:10px;">
        <div class="summary-row"><div class="small-muted">Subtotal</div><div>Rp {{ number_format($order->subtotal,0,',','.') }}</div></div>
        <div class="summary-row"><div class="small-muted">Ongkos Kirim</div><div>Rp {{ number_format($order->shipping_cost,0,',','.') }}</div></div>
        <div class="summary-row"><div class="small-muted">Diskon</div><div>Rp {{ number_format($order->discount ?? 0,0,',','.') }}</div></div>
        <div class="sep" aria-hidden="true"></div>
        <div class="summary-row"><div style="font-weight:800;">Total</div><div class="summary-total">Rp {{ number_format($order->total,0,',','.') }}</div></div>
      </div>

      <div style="margin-top:14px;">
        <div class="actions" role="group" aria-label="Aksi pesanan">
          <div style="flex:1;">
            {{-- Primary action area (Pay / View / Upload) --}}
            @if($noProofAndWaitingPayment)
              @if($paymentsCreateRoute)
                {{-- Button now opens upload modal; action set via data-action attribute --}}
                <button type="button"
                        class="btn btn-primary open-upload-btn"
                        data-action="{{ route($paymentsCreateRoute, $order->id) }}"
                        aria-label="Bayar sekarang">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                  Bayar
                </button>
              @else
                <button class="btn btn-ghost" disabled style="width:100%;">Pembayaran tidak tersedia</button>
              @endif

            @elseif($waitingConfirmation)
              @if($hasPaymentProof)
                <button type="button" class="btn btn-indigo open-proof-btn" data-proof-url="{{ $proofUrl }}" data-proof-ext="{{ $proofExt }}" aria-label="Lihat bukti pembayaran">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                  Lihat Bukti Pembayaran
                </button>
              @else
                @if($paymentsShowRoute)
                  <a class="btn btn-indigo" href="{{ route($paymentsShowRoute, $order->id) }}" aria-label="Lihat bukti pembayaran">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                    Lihat Bukti Pembayaran
                  </a>
                @else
                  <button class="btn btn-indigo" disabled>Lihat Bukti</button>
                @endif
              @endif

            @elseif($approved)
              @if($hasPaymentProof)
                <button type="button" class="btn btn-indigo open-proof-btn" data-proof-url="{{ $proofUrl }}" data-proof-ext="{{ $proofExt }}" aria-label="Lihat bukti pembayaran">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                  Lihat Bukti Pembayaran
                </button>
              @else
                @if($paymentsShowRoute)
                  <a class="btn btn-indigo" href="{{ route($paymentsShowRoute, $order->id) }}" aria-label="Lihat bukti pembayaran">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                    Lihat Bukti Pembayaran
                  </a>
                @else
                  <button class="btn btn-indigo" disabled>Lihat Bukti</button>
                @endif
              @endif

            @elseif($rejected)
              @if($paymentsCreateRoute)
                <button type="button"
                        class="btn btn-primary open-upload-btn"
                        data-action="{{ route($paymentsCreateRoute, $order->id) }}"
                        aria-label="Unggah bukti pembayaran">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8"/><path d="M7 12h10"/><path d="M12 7v10"/></svg>
                  Upload Bukti Pembayaran
                </button>
              @else
                <button class="btn btn-primary" disabled>Upload Bukti</button>
              @endif

            @elseif($shipped)
              @if($hasPaymentProof)
                <button type="button" class="btn btn-indigo open-proof-btn" data-proof-url="{{ $proofUrl }}" data-proof-ext="{{ $proofExt }}" aria-label="Lihat bukti pembayaran">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                  Lihat Bukti Pembayaran
                </button>
              @else
                <button class="btn btn-indigo" disabled>Lihat Bukti</button>
              @endif

            @elseif($received)
              @if($hasPaymentProof)
                <button type="button" class="btn btn-indigo open-proof-btn" data-proof-url="{{ $proofUrl }}" data-proof-ext="{{ $proofExt }}" aria-label="Lihat bukti pembayaran">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                  Lihat Bukti Pembayaran
                </button>
              @else
                <button class="btn btn-indigo" disabled>Lihat Bukti</button>
              @endif

            @else
              @if($hasPaymentProof)
                <button type="button" class="btn btn-indigo open-proof-btn" data-proof-url="{{ $proofUrl }}" data-proof-ext="{{ $proofExt }}" aria-label="Lihat bukti pembayaran">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                  Lihat Bukti Pembayaran
                </button>
              @else
                @if($paymentsCreateRoute)
                  <button type="button"
                          class="btn btn-primary open-upload-btn"
                          data-action="{{ route($paymentsCreateRoute, $order->id) }}"
                          aria-label="Bayar sekarang">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                    Bayar
                  </button>
                @else
                  <button class="btn btn-ghost" disabled>Pembayaran tidak tersedia</button>
                @endif
              @endif
            @endif
          </div>

          <div style="flex:1;text-align:right;">
            {{-- receive button triggers modal confirmation --}}
            @if($showReceive)
              @if($ordersReceiveRoute)
                <button type="button" class="btn btn-success open-receive-modal" data-order-id="{{ $order->id }}" aria-label="Konfirmasi pesanan diterima">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                  Pesanan Diterima
                </button>

                {{-- hidden form used to submit the POST when user confirms in modal --}}
                <form id="receiveForm" action="{{ route($ordersReceiveRoute, $order->id) }}" method="POST" style="display:none;">
                  @csrf
                </form>
              @else
                <button class="btn btn-success" disabled>Pesanan Diterima</button>
              @endif
            @elseif($showCancel)
              @if($ordersCancelRoute)
                <form action="{{ route($ordersCancelRoute, $order->id) }}" method="POST" style="margin:0;" onsubmit="return confirmCancel(this);">
                  @csrf
                  <button type="submit" class="btn btn-danger" aria-label="Batalkan pesanan">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    Batalkan Pesanan
                  </button>
                </form>
              @else
                <button class="btn btn-danger" disabled>Batalkan</button>
              @endif
            @endif
          </div>
        </div>
      </div>

      <div class="muted" style="margin-top:10px;font-size:13px;">Jika ada kendala, kamu bisa hubungi penjual untuk mengatasinya.</div>
    </div>
  </aside>
</div>

<!-- Upload / Pay Modal (sesuai form di file 2, dipanggil dari tombol .open-upload-btn) -->
<div id="uploadModalOverlay" class="upload-modal-overlay" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="uploadModalTitle" style="display:none;">
  <div class="upload-modal" role="document" aria-describedby="uploadModalDesc">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h3 id="uploadModalTitle">Pembayaran – Unggah Bukti</h3>
      <button id="uploadModalClose" class="proof-modal-close" aria-label="Tutup unggah">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    <p id="uploadModalDesc" class="small-muted">Isi formulir berikut lalu unggah bukti pembayaran. Maks 4MB. Format: JPG/PNG.</p>

    {{-- action akan diset dinamis dari tombol yang membuka modal (data-action) --}}
    @php
      $storeRoute = \Illuminate\Support\Facades\Route::has('payments.store') ? 'payments.store' : ( \Illuminate\Support\Facades\Route::has('payments.store') ? 'payments.store' : null );
    @endphp

    <form action="{{ route('payments.store', ['order' => $order->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <input type="hidden" name="from_popup" value="1">

      <div class="mb-4">
        <label class="block mb-1 font-medium">Metode Pembayaran</label>
        <select name="method" class="w-full border rounded p-2" required>
            <option value="bank_transfer">Bank Transfer</option>
            <option value="manual_transfer">Manual Transfer</option>
            <option value="cod">Cash on Delivery (COD)</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block mb-1 font-medium">Jumlah yang dibayar (Rp)</label>
        <input type="number" min="0" step="1" name="amount" id="uploadAmount" value="{{ old('amount', $order->total) }}" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1 font-medium">Unggah Bukti Pembayaran</label>
        <input id="proofFile" type="file" name="proof" accept="image/*" required>
        <div class="muted text-sm mt-1">Maks 4MB. Format: JPG/PNG.</div>
      </div>

      {{-- hidden order id (otomatis terisi) --}}
      <input type="hidden" name="order_id" id="uploadOrderId" value="{{ $order->id }}">

      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
        <div class="small-muted">Anda dapat menambahkan catatan di halaman konfirmasi pembayaran jika diperlukan.</div>
        <div class="upload-actions">
          <button type="button" id="uploadCancelBtn" class="btn btn-cancel" style="background:#fff;border:1px solid var(--border);color:#0f172a;">Batal</button>
          <button type="submit" id="uploadSubmitBtn" class="btn btn-primary">
            <span id="uploadSubmitLabel">Kirim Bukti Pembayaran</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Proof modal (existing) -->
<div id="proofModalOverlay" class="proof-modal-overlay" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="proofModalTitle">
  <div class="proof-modal" role="document" aria-describedby="proofModalCaption">
    <div class="proof-modal-header">
      <div id="proofModalTitle" style="font-weight:800;">Bukti Pembayaran</div>
      <div style="display:flex;gap:8px;align-items:center;">
        <a id="proofDownload" class="btn btn-ghost" href="#" target="_blank" rel="noopener" style="display:none;">
          <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
          Download
        </a>
        <button id="proofModalClose" class="proof-modal-close" aria-label="Tutup bukti">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
    </div>

    <div class="proof-modal-body" id="proofModalBody">
      <div id="proofLoader" style="display:none;">Memuat...</div>
      <img id="proofImg" alt="Bukti pembayaran" style="display:none;">
      <iframe id="proofIframe" title="Bukti pembayaran" style="display:none;"></iframe>
    </div>

    <div id="proofModalCaption" class="proof-modal-caption" style="display:none"></div>
  </div>
</div>

<!-- Receive confirmation modal -->
<div id="receiveModalOverlay" class="receive-modal-overlay" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="receiveModalTitle">
  <div class="receive-modal" role="document" aria-describedby="receiveModalDesc">
    <h3 id="receiveModalTitle">Konfirmasi Penerimaan Pesanan</h3>
    <p id="receiveModalDesc">Apakah kamu yakin pesanan ini sudah diterima? Setelah konfirmasi, status pesanan akan diperbarui menjadi <strong>Pesanan Diterima</strong>.</p>

    <div style="display:flex;justify-content:space-between;align-items:center;">
      <div class="small-muted" id="receiveOrderInfo" style="font-size:13px;"></div>
      <div class="receive-actions">
        <button id="receiveCancelBtn" class="btn btn-cancel" type="button">Batal</button>
        <button id="receiveConfirmBtn" class="btn btn-success" type="button">
          <span id="receiveConfirmLabel">Konfirmasi</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Optional preview box (ringkas) -->
<style>
  /* minimal styling preview agar tidak bergantung ke bagian lain */
  .upload-modal-overlay{ position:fixed; inset:0; background:rgba(2,6,23,0.6); display:flex; align-items:center; justify-content:center; z-index:1300; padding:20px; }
  .upload-modal{ width:100%; max-width:640px; background:#fff; border-radius:12px; box-shadow:0 30px 80px rgba(2,6,23,0.35); padding:18px; display:flex; flex-direction:column; gap:12px; }
</style>

<!-- Script: buka modal dari tombol .open-upload-btn, set action & order id otomatis, preview + validasi ukuran/tipe, disable tombol saat submit -->
<script>
(function(){
  const uploadOverlay = document.getElementById('uploadModalOverlay');
  const uploadCloseBtn = document.getElementById('uploadModalClose');
  const uploadCancelBtn = document.getElementById('uploadCancelBtn');
  const uploadForm = document.getElementById('uploadProofForm');
  const proofFileInput = document.getElementById('proofFile');
  const uploadSubmitBtn = document.getElementById('uploadSubmitBtn');
  const uploadAmountInput = document.getElementById('uploadAmount');
  const uploadOrderIdInput = document.getElementById('uploadOrderId');

  // buka modal: tombol harus punya attribute data-action (opsional) dan data-order-id (opsional)
  document.querySelectorAll('.open-upload-btn').forEach(function(btn){
    btn.addEventListener('click', function(ev){
      ev.preventDefault();
      if(!uploadOverlay) return;

      // set action jika disediakan oleh tombol (data-action)
      const action = btn.getAttribute('data-action');
      if(action && uploadForm){
        uploadForm.action = action;
      }

      // jika tombol membawa order id, isi; jika tidak, biarkan nilai blade default
      const orderId = btn.getAttribute('data-order-id') || btn.getAttribute('data-order') || null;
      if(orderId && uploadOrderIdInput){
        uploadOrderIdInput.value = orderId;
        // jika route memerlukan parameter di URL Anda mungkin sudah set data-action; pastikan backend menerima order_id juga
      }

      // set jumlah default jika data-total diberikan atau gunakan value blade (order total)
      const dataTotal = btn.getAttribute('data-total');
      if(dataTotal && uploadAmountInput){
        uploadAmountInput.value = dataTotal;
      } else {
        // already filled from blade with {{ $order->total }}
      }

      // reset file input
      if(uploadForm) uploadForm.reset();
      // show modal
      uploadOverlay.style.display = 'flex';
      uploadOverlay.setAttribute('aria-hidden','false');
      setTimeout(()=> proofFileInput.focus(), 120);
      document.body.style.overflow = 'hidden';
    });
  });

  function closeUploadModal(){
    if(!uploadOverlay) return;
    uploadOverlay.style.display = 'none';
    uploadOverlay.setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
  }

  if(uploadCloseBtn) uploadCloseBtn.addEventListener('click', function(){ if(!uploadFormSubmitting) closeUploadModal(); });
  if(uploadCancelBtn) uploadCancelBtn.addEventListener('click', function(){ if(!uploadFormSubmitting) closeUploadModal(); });

  if(uploadOverlay){
    uploadOverlay.addEventListener('click', function(ev){
      if(ev.target === uploadOverlay && !uploadFormSubmitting) closeUploadModal();
    });
  }

  // basic client-side validation for file (image & <=4MB)
  if(proofFileInput){
    proofFileInput.addEventListener('change', function(){
      const file = proofFileInput.files && proofFileInput.files[0];
      if(!file) return;
      const maxBytes = 4 * 1024 * 1024;
      if(file.size > maxBytes){
        alert('Ukuran file terlalu besar. Maksimal 4MB.');
        proofFileInput.value = '';
        return;
      }
      if(!file.type.startsWith('image/')){
        alert('Tipe file tidak didukung. Gunakan JPG/PNG gambar.');
        proofFileInput.value = '';
        return;
      }
    });
  }

  // submit: non-AJAX (normal POST) — hanya disable tombol & tampilkan teks proses
  let uploadFormSubmitting = false;
  if(uploadForm){
    uploadForm.addEventListener('submit', function(ev){
      if(uploadFormSubmitting) {
        ev.preventDefault();
        return false;
      }
      // ensure file chosen
      const f = proofFileInput.files && proofFileInput.files[0];
      if(!f){
        ev.preventDefault();
        alert('Silakan pilih file bukti pembayaran terlebih dahulu.');
        proofFileInput.focus();
        return false;
      }

      uploadFormSubmitting = true;
      uploadSubmitBtn.disabled = true;
      uploadCancelBtn.disabled = true;
      uploadSubmitBtn.innerHTML = '<span class="loader" aria-hidden="true"></span> Mengunggah';
      // biarkan form submit normal (server akan redirect)
      return true;
    });
  }

  // esc close
  document.addEventListener('keydown', function(ev){
    if(ev.key === 'Escape'){
      const vis = uploadOverlay && uploadOverlay.style.display === 'flex';
      if(vis && !uploadFormSubmitting) closeUploadModal();
    }
  });
})();
</script>

<script>
(function(){
  // History toggle (no animation)
  const toggleBtn = document.getElementById('toggleHistoryBtn');
  const historyList = document.getElementById('historyList');

  if(toggleBtn && historyList){
    let open = true;
    function setState(){
      if(open){
        historyList.style.display = 'flex';
        toggleBtn.setAttribute('aria-expanded','true');
        toggleBtn.title = 'Tutup riwayat';
      } else {
        historyList.style.display = 'none';
        toggleBtn.setAttribute('aria-expanded','false');
        toggleBtn.title = 'Tampilkan riwayat';
      }
    }
    setState();
    toggleBtn.addEventListener('click', function(){ open = !open; setState(); });
    document.addEventListener('keydown', function(ev){ if(ev.key === 'Escape'){ if(open){ open = false; setState(); } } });
  }

  // Confirm cancel (kept)
  window.confirmCancel = function(form){
    if(!confirm('Yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')) return false;
    const btn = form.querySelector('button');
    if(btn){
      btn.disabled = true;
      const original = btn.innerHTML;
      btn.innerHTML = '<span class="loader" aria-hidden="true"></span> Memproses';
      setTimeout(function(){ try{ btn.innerHTML = original; btn.disabled = false; }catch(e){} }, 8000);
    }
    return true;
  };

  // --- Proof modal logic (existing) ---
  const proofOverlay = document.getElementById('proofModalOverlay');
  const proofCloseBtn = document.getElementById('proofModalClose');
  const imgEl = document.getElementById('proofImg');
  const iframeEl = document.getElementById('proofIframe');
  const loader = document.getElementById('proofLoader');
  const caption = document.getElementById('proofModalCaption');
  const downloadBtn = document.getElementById('proofDownload');

  function openProofModal(url, ext){
    if(!proofOverlay) return;
    proofOverlay.style.display = 'flex';
    proofOverlay.setAttribute('aria-hidden','false');
    imgEl.style.display = 'none';
    iframeEl.style.display = 'none';
    caption.style.display = 'none';
    downloadBtn.style.display = 'none';
    loader.style.display = 'block';
    setTimeout(function(){
      loader.style.display = 'none';
      const isPdf = ext === 'pdf';
      if(isPdf){
        iframeEl.src = url;
        iframeEl.style.display = 'block';
        caption.textContent = 'Menampilkan PDF bukti pembayaran. Jika tidak tampil, klik Download.';
        caption.style.display = 'block';
        downloadBtn.href = url;
        downloadBtn.style.display = 'inline-flex';
      } else {
        imgEl.src = url;
        imgEl.onload = function(){ imgEl.style.display = 'block'; caption.style.display = 'none'; };
        imgEl.onerror = function(){
          caption.textContent = 'Gagal memuat gambar. Silakan klik Download untuk membuka di tab baru.';
          caption.style.display = 'block';
          downloadBtn.href = url;
          downloadBtn.style.display = 'inline-flex';
        };
        downloadBtn.href = url;
        downloadBtn.style.display = 'inline-flex';
      }
    }, 180);
    setTimeout(()=> proofCloseBtn.focus(), 250);
    document.body.style.overflow = 'hidden';
  }

  function closeProofModal(){
    if(!proofOverlay) return;
    proofOverlay.style.display = 'none';
    proofOverlay.setAttribute('aria-hidden','true');
    iframeEl.src = '';
    imgEl.src = '';
    caption.style.display = 'none';
    downloadBtn.style.display = 'none';
    document.body.style.overflow = '';
  }

  document.querySelectorAll('.open-proof-btn').forEach(function(btn){
    btn.addEventListener('click', function(ev){
      ev.preventDefault();
      const url = btn.getAttribute('data-proof-url');
      const ext = (btn.getAttribute('data-proof-ext') || '').toLowerCase();
      if(!url){
        alert('Bukti pembayaran tidak tersedia.');
        return;
      }
      openProofModal(url, ext);
    });
  });

  if(proofCloseBtn) proofCloseBtn.addEventListener('click', closeProofModal);
  if(proofOverlay) proofOverlay.addEventListener('click', function(ev){
    if(ev.target === proofOverlay) closeProofModal();
  });
  document.addEventListener('keydown', function(ev){
    if(ev.key === 'Escape'){
      const vis = proofOverlay && proofOverlay.style.display === 'flex';
      if(vis) closeProofModal();
    }
  });

  // --- Receive modal logic (NEW) ---
  const receiveOverlay = document.getElementById('receiveModalOverlay');
  const receiveCancelBtn = document.getElementById('receiveCancelBtn');
  const receiveConfirmBtn = document.getElementById('receiveConfirmBtn');
  const receiveOrderInfo = document.getElementById('receiveOrderInfo');
  const receiveForm = document.getElementById('receiveForm');
  let receiveSubmitting = false;

  function openReceiveModal(orderId){
    if(!receiveOverlay) return;
    receiveOrderInfo.textContent = 'Order #' + (orderId || '{{ $order->order_number }}');
    receiveOverlay.style.display = 'flex';
    receiveOverlay.setAttribute('aria-hidden','false');
    setTimeout(()=> receiveConfirmBtn.focus(), 180);
    document.body.style.overflow = 'hidden';
  }

  function closeReceiveModal(){
    if(!receiveOverlay) return;
    receiveOverlay.style.display = 'none';
    receiveOverlay.setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('.open-receive-modal').forEach(function(btn){
    btn.addEventListener('click', function(ev){
      ev.preventDefault();
      const orderId = btn.getAttribute('data-order-id') || '{{ $order->id }}';
      openReceiveModal(orderId);
    });
  });

  if(receiveCancelBtn) receiveCancelBtn.addEventListener('click', function(){ if(!receiveSubmitting) closeReceiveModal(); });

  if(receiveConfirmBtn){
    receiveConfirmBtn.addEventListener('click', function(){
      if(receiveSubmitting) return;
      if(!receiveForm){
        alert('Form untuk konfirmasi tidak ditemukan.');
        return;
      }
      receiveSubmitting = true;
      const orig = receiveConfirmBtn.innerHTML;
      receiveConfirmBtn.innerHTML = '<span class="loader" aria-hidden="true"></span> Memproses';
      receiveConfirmBtn.disabled = true;
      try{
        receiveForm.submit();
      } catch(e){
        console.error(e);
        receiveConfirmBtn.innerHTML = orig;
        receiveConfirmBtn.disabled = false;
        receiveSubmitting = false;
        closeReceiveModal();
      }
    });
  }

  if(receiveOverlay) receiveOverlay.addEventListener('click', function(ev){
    if(ev.target === receiveOverlay && !receiveSubmitting) closeReceiveModal();
  });

  document.addEventListener('keydown', function(ev){
    if(ev.key === 'Escape'){
      const vis = receiveOverlay && receiveOverlay.style.display === 'flex';
      if(vis && !receiveSubmitting) closeReceiveModal();
    }
  });

  // --- Copy tracking number ---
  document.querySelectorAll('.copy-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
      const toCopy = btn.getAttribute('data-copy') || '';
      if(!toCopy) return;
      // Use navigator.clipboard if available
      if(navigator.clipboard && navigator.clipboard.writeText){
        navigator.clipboard.writeText(toCopy).then(function(){
          const old = btn.innerHTML;
          btn.innerHTML = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/></svg><span class="small-muted">Tersalin</span>';
          setTimeout(function(){ btn.innerHTML = old; }, 1500);
        }).catch(function(){
          alert('Gagal menyalin. Silakan salin manual.');
        });
      } else {
        // fallback
        const ta = document.createElement('textarea');
        ta.value = toCopy;
        document.body.appendChild(ta);
        ta.select();
        try{
          document.execCommand('copy');
          btn.innerHTML = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/></svg><span class="small-muted">Tersalin</span>';
          setTimeout(function(){ btn.innerHTML = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="10" height="10" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg><span class=\"small-muted\">Salin</span>'; }, 1500);
        }catch(e){
          alert('Gagal menyalin. Silakan salin manual.');
        }
        document.body.removeChild(ta);
      }
    });
  });

  // --- Upload modal logic (NEW) ---
  const uploadOverlay = document.getElementById('uploadModalOverlay');
  const uploadCloseBtn = document.getElementById('uploadModalClose');
  const uploadCancelBtn = document.getElementById('uploadCancelBtn');
  const uploadForm = document.getElementById('uploadProofForm');
  const proofFileInput = document.getElementById('proofFile');
  const uploadPreview = document.getElementById('uploadPreview');
  const uploadSubmitBtn = document.getElementById('uploadSubmitBtn');
  const uploadSubmitLabel = document.getElementById('uploadSubmitLabel');

  // open upload modal from buttons with class .open-upload-btn
  document.querySelectorAll('.open-upload-btn').forEach(function(btn){
    btn.addEventListener('click', function(ev){
      ev.preventDefault();
      if(!uploadOverlay) return;
      // set form action dynamically if data-action provided
      const action = btn.getAttribute('data-action');
      if(action && uploadForm){
        uploadForm.action = action;
      }
      // reset
      uploadForm.reset();
      clearPreview();
      uploadOverlay.style.display = 'flex';
      uploadOverlay.setAttribute('aria-hidden','false');
      setTimeout(()=> proofFileInput.focus(), 120);
      document.body.style.overflow = 'hidden';
    });
  });

  function closeUploadModal(){
    if(!uploadOverlay) return;
    uploadOverlay.style.display = 'none';
    uploadOverlay.setAttribute('aria-hidden','true');
    document.body.style.overflow = '';
  }

  function clearPreview(){
    uploadPreview.innerHTML = '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 14s1.5-2 4-2 4 2 4 2"/><circle cx="9" cy="9" r="1"/></svg>';
  }

  function setImagePreview(file){
    clearPreview();
    if(!file) return;
    const ext = (file.name || '').split('.').pop().toLowerCase();
    if(ext === 'pdf'){
      // show pdf icon + filename
      uploadPreview.innerHTML = '<div style="text-align:center;padding:8px;"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 14s1.5-2 4-2 4 2 4 2"/></svg><div style="font-size:12px;margin-top:6px;max-width:110px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + (file.name || '') + '</div></div>';
      return;
    }
    // image preview
    const reader = new FileReader();
    reader.onload = function(e){
      const img = document.createElement('img');
      img.src = e.target.result;
      img.style.maxWidth = '100%';
      img.style.maxHeight = '100%';
      img.alt = 'Preview bukti';
      uploadPreview.innerHTML = '';
      uploadPreview.appendChild(img);
    };
    reader.readAsDataURL(file);
  }

  if(proofFileInput){
    proofFileInput.addEventListener('change', function(){
      const file = proofFileInput.files && proofFileInput.files[0];
      if(!file){
        clearPreview();
        return;
      }
      // validate size (5MB)
      const maxBytes = 5 * 1024 * 1024;
      if(file.size > maxBytes){
        alert('Ukuran file terlalu besar. Maksimal 5MB.');
        proofFileInput.value = '';
        clearPreview();
        return;
      }
      // validate type
      const allowed = ['image/jpeg','image/png','application/pdf','image/jpg'];
      if(allowed.indexOf(file.type) === -1){
        // allow by extension fallback
        const ext = (file.name || '').split('.').pop().toLowerCase();
        if(['jpg','jpeg','png','pdf'].indexOf(ext) === -1){
          alert('Tipe file tidak didukung. Gunakan jpg, png, atau pdf.');
          proofFileInput.value = '';
          clearPreview();
          return;
        }
      }
      setImagePreview(file);
    });
  }

  if(uploadCloseBtn) uploadCloseBtn.addEventListener('click', function(){ if(!uploadFormSubmitting) closeUploadModal(); });
  if(uploadCancelBtn) uploadCancelBtn.addEventListener('click', function(){ if(!uploadFormSubmitting) closeUploadModal(); });

  // close on overlay click
  if(uploadOverlay) uploadOverlay.addEventListener('click', function(ev){
    if(ev.target === uploadOverlay && !uploadFormSubmitting) closeUploadModal();
  });

  // submit handler: normal form submit (not ajax) but disable button and show loader
  let uploadFormSubmitting = false;
  if(uploadForm){
    uploadForm.addEventListener('submit', function(ev){
      // basic client-side validation
      const file = proofFileInput.files && proofFileInput.files[0];
      if(!file){
        ev.preventDefault();
        alert('Silakan pilih file bukti pembayaran terlebih dahulu.');
        proofFileInput.focus();
        return false;
      }
      if(uploadFormSubmitting) {
        ev.preventDefault();
        return false;
      }
      uploadFormSubmitting = true;
      // disable buttons
      uploadSubmitBtn.disabled = true;
      uploadCancelBtn.disabled = true;
      uploadSubmitBtn.innerHTML = '<span class="loader" aria-hidden="true"></span> Mengunggah';
      // allow normal submit to proceed
      return true;
    });
  }

  document.addEventListener('keydown', function(ev){
    if(ev.key === 'Escape'){
      const vis = uploadOverlay && uploadOverlay.style.display === 'flex';
      if(vis && !uploadFormSubmitting) closeUploadModal();
    }
  });

})();
</script>

</div>
@endsection
