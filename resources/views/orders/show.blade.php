@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<div class="order-page">
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
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    } 
    elseif (in_array($orderStatus, $receivedStatuses)) {
        $displayLabel = 'Pesanan Diterima'; 
        $badgeClass = 'badge-success'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
    }
    elseif (in_array($orderStatus, $shippedStatuses)) {
        $displayLabel = 'Pesanan Dikirimkan'; 
        $badgeClass = 'badge-info'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6a1 1 0 0 1-1 1h-1"/><path d="M16 3v4"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="18.5" cy="17.5" r="1.5"/></svg>';
    }
    elseif ($isCOD && $paymentStatus === 'confirmed' && $orderStatus === 'processing') {
        $displayLabel = 'Pesanan Diproses'; 
        $badgeClass = 'badge-primary'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10v6a2 2 0 0 1-2 2H8"/><path d="M3 6h18"/><path d="M16 3v6"/></svg>';
    }
    elseif ($orderStatus === 'processing' || in_array($paymentStatus, ['confirmed','paid'])) {
        $displayLabel = 'Pesanan Diproses'; 
        $badgeClass = 'badge-primary'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10v6a2 2 0 0 1-2 2H8"/><path d="M3 6h18"/><path d="M16 3v6"/></svg>';
    }
    elseif ($orderStatus === 'waiting_confirm' || in_array($paymentStatus, ['waiting_confirm','waiting_confirmation','waiting'])) {
        $displayLabel = 'Menunggu Konfirmasi Pembayaran'; 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h11"/><path d="M17 2v4"/></svg>';
    }
    elseif (in_array($paymentStatus, ['rejected','declined','failed']) || $orderStatus === 'need_confirmation' || $paymentStatus === 'need_confirmation') {
        $displayLabel = 'Perlu Konfirmasi'; 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/></svg>';
    }
    elseif (!$hasPaymentProof && !$isCOD) {
        $displayLabel = 'Menunggu Pembayaran'; 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>';
    }
    else {
        $displayLabel = ucfirst(str_replace('_',' ',$paymentStatus ?: ($orderStatus?: 'pending'))); 
        $badgeClass = 'badge-warn'; 
        $badgeIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
    }

    // convenience flags for action rendering - UPDATED FOR COD
    $noProofAndWaitingPayment = !$hasPaymentProof && !$isCOD && in_array($orderStatus, ['pending','waiting_payment']);
    $waitingConfirmation = $hasPaymentProof && in_array($paymentStatus, ['waiting_confirm','waiting_confirmation','waiting']);
    $approved = ($hasPaymentProof && in_array($paymentStatus, ['confirmed','paid'])) || ($isCOD && $paymentStatus === 'confirmed');
    $rejected = ($hasPaymentProof && in_array($paymentStatus, ['rejected','declined','failed'])) || $orderStatus === 'need_confirmation' || $paymentStatus === 'need_confirmation';
    $shipped = in_array($orderStatus, $shippedStatuses);
    $received = in_array($orderStatus, $receivedStatuses);

    // show cancel when explicitly allowed by statuses
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
:root {
  --primary: #0EA5E9;
  --primary-dark: #0284C7;
  --secondary: #06B6D4;
  --info: #3B82F6;
  --success: #10B981;
  --warning: #F59E0B;
  --danger: #EF4444;
  
  --text-primary: #212121;
  --text-secondary: #757575;
  --text-disabled: #9E9E9E;
  
  --bg-page: #F5F5F5;
  --bg-card: #FFFFFF;
  --border: #E0E0E0;
  --border-light: #EEEEEE;
  
  --shadow-sm: 0 1px 2px rgba(0,0,0,0.08);
  --shadow: 0 2px 4px rgba(0,0,0,0.1);
  --shadow-md: 0 4px 8px rgba(0,0,0,0.12);
  
  --radius: 8px;
  --radius-sm: 4px;
  
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  background: var(--bg-page);
  color: var(--text-primary);
  line-height: 1.6;
}

.order-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 16px;
  min-height: 100vh;
}

/* Icons */
.icon { width: 20px; height: 20px; }
.icon-sm { width: 16px; height: 16px; }
.icon-lg { width: 24px; height: 24px; }

/* Top Navigation */
.top-nav {
  background: var(--bg-card);
  border-radius: var(--radius);
  padding: 16px;
  margin-bottom: 12px;
  box-shadow: var(--shadow-sm);
  display: flex;
  align-items: center;
  gap: 12px;
}

.back-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: var(--text-primary);
  font-weight: 500;
  gap: 8px;
  padding: 8px;
  border-radius: var(--radius-sm);
  transition: background 0.2s;
}

.back-link:hover {
  background: var(--bg-page);
}

.back-link svg {
  stroke: var(--text-secondary);
}

.divider-vertical {
  width: 1px;
  height: 20px;
  background: var(--border);
}

.order-id {
  font-size: 14px;
  color: var(--text-secondary);
}

.order-id strong {
  color: var(--primary);
  font-weight: 600;
}

/* Status Banner */
.status-banner {
  background: var(--bg-card);
  border-radius: var(--radius);
  padding: 16px;
  margin-bottom: 12px;
  box-shadow: var(--shadow-sm);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}

.status-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.status-icon {
  width: 48px;
  height: 48px;
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.status-icon.success { background: #E8F5E9; }
.status-icon.success svg { stroke: var(--success); }

.status-icon.info { background: #E3F2FD; }
.status-icon.info svg { stroke: var(--info); }

.status-icon.warning { background: #FFF3E0; }
.status-icon.warning svg { stroke: var(--warning); }

.status-icon.danger { background: #FFEBEE; }
.status-icon.danger svg { stroke: var(--danger); }

.status-text h3 {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 4px;
}

.status-text p {
  font-size: 13px;
  color: var(--text-secondary);
}

/* Badge */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border-radius: 100px;
  font-size: 13px;
  font-weight: 600;
}

.badge-success {
  background: #E8F5E9;
  color: var(--success);
}

.badge-info {
  background: #E3F2FD;
  color: var(--info);
}

.badge-warn {
  background: #FFF3E0;
  color: var(--warning);
}

.badge-primary {
  background: #E0F2FE;
  color: var(--primary);
}

.badge-cancel {
  background: #FFEBEE;
  color: var(--danger);
}

/* Grid Layout */
.content-grid {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 12px;
  align-items: start;
}

/* Card */
.card {
  background: var(--bg-card);
  border-radius: var(--radius);
  box-shadow: var(--shadow-sm);
  margin-bottom: 12px;
}

.card-header {
  padding: 16px;
  border-bottom: 1px solid var(--border-light);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-title {
  font-size: 15px;
  font-weight: 600;
  color: var(--text-primary);
}

.card-subtitle {
  font-size: 13px;
  color: var(--text-secondary);
}

.card-body {
  padding: 16px;
}

/* Shipping Info */
.shipping-section {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding-bottom: 16px;
  border-bottom: 1px solid var(--border-light);
  margin-bottom: 16px;
}

.shipping-icon {
  width: 40px;
  height: 40px;
  background: #E0F2FE;
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.shipping-icon svg {
  stroke: var(--primary);
}

.shipping-details {
  flex: 1;
}

.shipping-label {
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 4px;
}

.shipping-value {
  font-size: 14px;
  font-weight: 500;
  color: var(--text-primary);
}

.tracking-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
}

.tracking-number {
  font-family: 'Courier New', monospace;
  font-size: 13px;
  color: var(--text-primary);
  font-weight: 600;
  padding: 6px 10px;
  background: var(--bg-page);
  border-radius: var(--radius-sm);
  flex: 1;
}

.copy-btn {
  padding: 6px 12px;
  background: var(--bg-page);
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  font-size: 13px;
  color: var(--text-secondary);
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.copy-btn:hover {
  background: var(--bg-card);
  border-color: var(--primary);
  color: var(--primary);
}

/* Address Card */
.address-card {
  display: flex;
  gap: 12px;
}

.address-icon {
  width: 40px;
  height: 40px;
  background: #E0F2FE;
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.address-icon svg {
  stroke: var(--primary);
}

.address-info {
  flex: 1;
}

.address-name {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 4px;
}

.address-label-tag {
  display: inline-block;
  padding: 2px 8px;
  background: var(--bg-page);
  border-radius: var(--radius-sm);
  font-size: 11px;
  color: var(--text-secondary);
  margin-left: 8px;
}

.address-phone {
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 8px;
}

.address-full {
  font-size: 13px;
  color: var(--text-secondary);
  line-height: 1.6;
}

/* Product List */
.product-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.product-item {
  display: flex;
  gap: 12px;
  padding: 12px;
  border: 1px solid var(--border-light);
  border-radius: var(--radius);
  transition: all 0.2s;
}

.product-item:hover {
  border-color: var(--border);
  box-shadow: var(--shadow-sm);
}

.product-image {
  width: 80px;
  height: 80px;
  border-radius: var(--radius);
  overflow: hidden;
  background: var(--bg-page);
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid var(--border-light);
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.product-name {
  font-size: 14px;
  font-weight: 500;
  color: var(--text-primary);
  line-height: 1.4;
}

.product-variant {
  font-size: 12px;
  color: var(--text-secondary);
}

.product-price-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: auto;
}

.product-price {
  font-size: 13px;
  color: var(--text-secondary);
}

.product-qty {
  font-size: 12px;
  color: var(--text-secondary);
  padding: 2px 8px;
  background: var(--bg-page);
  border-radius: var(--radius-sm);
}

.product-subtotal {
  text-align: right;
  font-size: 14px;
  font-weight: 600;
  color: var(--text-primary);
}

/* History Section */
.history-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  padding: 16px;
  border-bottom: 1px solid var(--border-light);
}

.history-toggle {
  display: flex;
  align-items: center;
  gap: 8px;
}

.toggle-icon {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.3s;
}

.toggle-icon.collapsed {
  transform: rotate(-90deg);
}

.history-title-group h4 {
  font-size: 15px;
  font-weight: 600;
  margin-bottom: 2px;
}

.history-title-group p {
  font-size: 12px;
  color: var(--text-secondary);
}

.history-list {
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.history-item {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  position: relative;
  padding-left: 24px;
}

.history-item::before {
  content: '';
  position: absolute;
  left: 7px;
  top: 24px;
  bottom: -12px;
  width: 2px;
  background: var(--border-light);
}

.history-item:last-child::before {
  display: none;
}

.history-dot {
  position: absolute;
  left: 0;
  top: 4px;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background: var(--primary);
  border: 3px solid var(--bg-card);
  box-shadow: 0 0 0 2px var(--border-light);
}

.history-content {
  flex: 1;
}

.history-label {
  font-size: 14px;
  font-weight: 500;
  color: var(--text-primary);
  margin-bottom: 4px;
}

.history-time {
  font-size: 12px;
  color: var(--text-secondary);
}

/* Notes */
.notes-section {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-light);
}

.notes-title {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 8px;
}

.notes-content {
  font-size: 13px;
  color: var(--text-secondary);
  line-height: 1.6;
  padding: 12px;
  background: var(--bg-page);
  border-radius: var(--radius);
}

/* Summary Card */
.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  font-size: 14px;
}

.summary-row.total {
  padding-top: 12px;
  margin-top: 12px;
  border-top: 1px solid var(--border-light);
  font-size: 16px;
  font-weight: 600;
}

.summary-total {
  font-size: 18px;
  font-weight: 700;
  color: var(--primary);
}

.summary-label {
  color: var(--text-secondary);
}

.summary-value {
  color: var(--text-primary);
  font-weight: 500;
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 20px;
  border: none;
  border-radius: var(--radius);
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  width: 100%;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-primary {
  background: var(--primary);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: var(--primary-dark);
}

.btn-secondary {
  background: var(--secondary);
  color: white;
}

.btn-secondary:hover:not(:disabled) {
  background: #e65100;
}

.btn-success {
  background: var(--success);
  color: white;
}

.btn-success:hover:not(:disabled) {
  background: #388E3C;
}

.btn-danger {
  background: var(--danger);
  color: white;
}

.btn-danger:hover:not(:disabled) {
  background: #D32F2F;
}

.btn-outline {
  background: white;
  color: var(--text-primary);
  border: 1px solid var(--border);
}

.btn-outline:hover:not(:disabled) {
  background: var(--bg-page);
  border-color: var(--text-secondary);
}

.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 16px;
}

.button-group {
  display: flex;
  gap: 8px;
}

.button-group .btn {
  flex: 1;
}

/* Helper Text */
.help-text {
  font-size: 12px;
  color: var(--text-secondary);
  text-align: center;
  margin-top: 12px;
  line-height: 1.5;
}

/* Loader */
.loader {
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 16px;
}

.modal {
  background: white;
  border-radius: var(--radius);
  max-width: 500px;
  width: 100%;
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}

.modal-header {
  padding: 16px;
  border-bottom: 1px solid var(--border-light);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title {
  font-size: 16px;
  font-weight: 600;
}

.modal-close {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: none;
  border: none;
  cursor: pointer;
  border-radius: var(--radius-sm);
  transition: background 0.2s;
}

.modal-close:hover {
  background: var(--bg-page);
}

.modal-body {
  padding: 16px;
}

.modal-footer {
  padding: 16px;
  border-top: 1px solid var(--border-light);
  display: flex;
  gap: 8px;
  justify-content: flex-end;
}

/* Proof Modal */
.proof-modal {
  max-width: 800px;
}

.proof-image-container {
  max-height: 70vh;
  overflow: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-page);
}

.proof-image-container img {
  max-width: 100%;
  display: block;
}

.proof-image-container iframe {
  width: 100%;
  height: 600px;
  border: none;
}

/* Form */
.form-group {
  margin-bottom: 16px;
}

.form-label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 8px;
}

.form-input,
.form-select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  font-size: 14px;
  transition: border-color 0.2s;
}

.form-input:focus,
.form-select:focus {
  outline: none;
  border-color: var(--primary);
}

.form-hint {
  font-size: 12px;
  color: var(--text-secondary);
  margin-top: 4px;
}

/* Responsive */
@media (max-width: 768px) {
  .order-page {
    padding: 12px;
  }
  
  .content-grid {
    grid-template-columns: 1fr;
  }
  
  .status-banner {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .product-item {
    flex-direction: column;
  }
  
  .product-image {
    width: 100%;
    height: 200px;
  }
  
  .product-subtotal {
    text-align: left;
  }
  
  .button-group {
    flex-direction: column;
  }
}

/* Utility */
.hidden { display: none !important; }
.text-center { text-align: center; }
.mb-12 { margin-bottom: 12px; }
</style>

<!-- Top Navigation -->
<div class="top-nav">
  <a href="{{ $backRoute }}" class="back-link">
    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali
  </a>
  <div class="divider-vertical"></div>
  <div class="order-id">
    Order ID: <strong>#{{ $order->order_number }}</strong>
  </div>
</div>

<!-- Status Banner -->
<div class="status-banner">
  <div class="status-info">
    <div class="status-icon {{ in_array($orderStatus, $receivedStatuses) ? 'success' : (in_array($orderStatus, $shippedStatuses) ? 'info' : (in_array($orderStatus, ['cancelled','canceled','cancelled_by_user']) ? 'danger' : 'warning')) }}">
      {!! $badgeIcon !!}
    </div>
    <div class="status-text">
      <h3>{{ $displayLabel }}</h3>
      <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>
  </div>
  <span class="badge {{ $badgeClass }}">
    {!! $badgeIcon !!}
    {{ $displayLabel }}
  </span>
</div>

<!-- Content Grid -->
<div class="content-grid">
  <!-- Left Column -->
  <div class="left-column">
    
    <!-- Shipping Info Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Info Pengiriman</div>
      </div>
      <div class="card-body">
        <div class="shipping-section">
          <div class="shipping-icon">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="1" y="3" width="15" height="13"/>
              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
          </div>
          <div class="shipping-details">
            <div class="shipping-label">Kurir</div>
            <div class="shipping-value">{{ $shippingCarrier ?: '—' }}</div>
          </div>
          <div class="shipping-details" style="text-align: right;">
            <div class="shipping-label">Status Pengiriman</div>
            <div class="shipping-value">
              {{ in_array($orderStatus, $shippedStatuses) ? 'Dalam Pengiriman' : (in_array($orderStatus, $receivedStatuses) ? 'Diterima' : 'Menunggu') }}
            </div>
          </div>
        </div>
        
        @if($trackingNumber)
        <div>
          <div class="shipping-label">Nomor Resi</div>
          <div class="tracking-row">
            <div class="tracking-number">{{ $trackingNumber }}</div>
            <button class="copy-btn" type="button" data-copy="{{ $trackingNumber }}">
              <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="9" y="9" width="13" height="13" rx="2"/>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
              </svg>
              Salin
            </button>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Address Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Alamat Pengiriman</div>
      </div>
      <div class="card-body">
        <div class="address-card">
          <div class="address-icon">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
          </div>
          <div class="address-info">
            @php $addr = $order->address; @endphp
            @if($addr)
              <div class="address-name">
                {{ $addr->recipient_name ?? auth()->user()->name ?? 'Nama Penerima' }}
                @if($addr->label)
                  <span class="address-label-tag">{{ $addr->label }}</span>
                @endif
              </div>
              <div class="address-phone">{{ trim(($addr->phone_country ?? '') . ' ' . ($addr->phone ?? '')) }}</div>
              <div class="address-full">
                {!! e($addr->address_full) !!}{{ $addr->village ? ', '.$addr->village : '' }}{{ $addr->subdistrict ? ', '.$addr->subdistrict : '' }}{{ $addr->city ? ', '.$addr->city : '' }}{{ $addr->province ? ', '.$addr->province : '' }}{{ $addr->postal_code ? ' - ' . $addr->postal_code : '' }}
              </div>
            @else
              <div class="address-full">Tidak ada alamat pengiriman</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Products Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Produk Dipesan ({{ count($order->items) }})</div>
      </div>
      <div class="card-body">
        <div class="product-list">
          @foreach($order->items as $it)
            <div class="product-item">
              <div class="product-image">
                @if(!empty($it->meta['image']))
                  <img src="{{ asset('storage/'.ltrim($it->meta['image'],'/')) }}" alt="{{ $it->product_name }}">
                @else
                  <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="9" cy="9" r="2"/>
                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                  </svg>
                @endif
              </div>
              <div class="product-details">
                <div class="product-name">{{ $it->product_name }}</div>
                @if(!empty($it->meta['variant']))
                  <div class="product-variant">
                    Varian: 
                    @if(is_array($it->meta['variant']))
                      {{ implode(', ', $it->meta['variant']) }}
                    @else
                      {{ $it->meta['variant'] }}
                    @endif
                  </div>
                @endif
                <div class="product-price-row">
                  <span class="product-price">Rp {{ number_format($it->price,0,',','.') }}</span>
                  <span class="product-qty">x{{ $it->qty }}</span>
                </div>
              </div>
              <div class="product-subtotal">
                Rp {{ number_format($it->subtotal,0,',','.') }}
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- History Card -->
    <div class="card">
      <div class="history-header" id="historyHeader">
        <div class="history-toggle">
          <div class="toggle-icon" id="toggleIcon">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </div>
          <div class="history-title-group">
            <h4>Riwayat Pesanan</h4>
            <p>Lacak perjalanan pesanan Anda</p>
          </div>
        </div>
      </div>
      <div class="history-list" id="historyList">
        @php
          $history = [];
          if ($order->created_at) {
              $history[] = ['label' => 'Pesanan Dibuat', 'at' => $order->created_at];
          }
          if ($payment && $payment->created_at) {
              $history[] = ['label' => 'Bukti Pembayaran Diunggah', 'at' => $payment->created_at];
          }
          if ($payment && in_array($payment->status, ['confirmed','paid']) && $payment->updated_at) {
              $history[] = ['label' => 'Pembayaran Dikonfirmasi', 'at' => $payment->updated_at];
          }
          if ($order->updated_at && $order->updated_at->ne($order->created_at)) {
              $already = false;
              foreach ($history as $h) {
                  if ($h['at'] && $order->updated_at && $h['at']->eq($order->updated_at)) { $already = true; break; }
              }
              if (!$already) {
                  $label = 'Status diubah: ' . ($order->status ? ucfirst(str_replace('_',' ',$order->status)) : 'Updated');
                  $history[] = ['label' => $label, 'at' => $order->updated_at];
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
          <div class="history-item">
            <div class="history-dot"></div>
            <div class="history-content">
              <div class="history-label">{{ $h['label'] }}</div>
              <div class="history-time">
                @if(!empty($h['at']))
                  {{ $h['at']->format('d M Y, H:i') }}
                @else
                  —
                @endif
              </div>
            </div>
          </div>
        @empty
          <div style="text-align: center; color: var(--text-secondary);">Tidak ada riwayat</div>
        @endforelse
        
        <div class="notes-section">
          <div class="notes-title">Catatan</div>
          <div class="notes-content">
            @php
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

  <!-- Right Column -->
  <aside class="right-column">
    
    <!-- Summary Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Ringkasan Belanja</div>
      </div>
      <div class="card-body">
        <div class="summary-row">
          <span class="summary-label">Subtotal</span>
          <span class="summary-value">Rp {{ number_format($order->subtotal,0,',','.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Ongkos Kirim</span>
          <span class="summary-value">Rp {{ number_format($order->shipping_cost,0,',','.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Diskon</span>
          <span class="summary-value">- Rp {{ number_format($order->discount ?? 0,0,',','.') }}</span>
        </div>
        <div class="summary-row total">
          <span>Total</span>
          <span class="summary-total">Rp {{ number_format($order->total,0,',','.') }}</span>
        </div>
        
        <div class="action-buttons">
          {{-- Primary Action --}}
          @if($noProofAndWaitingPayment)
            @if($paymentsCreateRoute)
              <a href="{{ route($paymentsCreateRoute, $order->id) }}" class="btn btn-primary">
                <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="1" y="4" width="22" height="16" rx="2"/>
                  <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Bayar Sekarang
              </a>
            @endif
          @elseif($waitingConfirmation || $approved || $shipped || $received)
            @if($hasPaymentProof)
              <button type="button" class="btn btn-outline open-proof-btn" data-proof-url="{{ $proofUrl }}" data-proof-ext="{{ $proofExt }}">
                <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                Lihat Bukti Bayar
              </button>
            @endif
          @elseif($rejected)
            @if($paymentsCreateRoute)
              <a href="{{ route($paymentsCreateRoute, $order->id) }}" class="btn btn-primary">
                <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                  <polyline points="17 8 12 3 7 8"/>
                  <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Upload Ulang Bukti
              </a>
            @endif
          @endif
          
          {{-- Secondary Actions --}}
          <div class="button-group">
            @if($showReceive && $ordersReceiveRoute)
              <button type="button" class="btn btn-success open-receive-modal" data-order-id="{{ $order->id }}">
                <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
                Pesanan Diterima
              </button>
              <form id="receiveForm" action="{{ route($ordersReceiveRoute, $order->id) }}" method="POST" style="display:none;">@csrf</form>
            @endif
            
            @if($showCancel && $ordersCancelRoute)
              <form action="{{ route($ordersCancelRoute, $order->id) }}" method="POST" style="flex: 1;" onsubmit="return confirmCancel(this);">
                @csrf
                <button type="submit" class="btn btn-outline">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                  </svg>
                  Batalkan
                </button>
              </form>
            @endif
          </div>
        </div>
        
        <p class="help-text">
          Butuh bantuan? Hubungi penjual untuk informasi lebih lanjut
        </p>
      </div>
    </div>

  </aside>
</div>

<!-- Proof Modal -->
<div id="proofModalOverlay" class="modal-overlay">
  <div class="modal proof-modal">
    <div class="modal-header">
      <h3 class="modal-title">Bukti Pembayaran</h3>
      <button id="proofModalClose" class="modal-close">
        <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="modal-body proof-image-container" id="proofModalBody">
      <img id="proofImg" style="display: none;">
      <iframe id="proofIframe" style="display: none;"></iframe>
    </div>
  </div>
</div>

<!-- Receive Confirmation Modal -->
<div id="receiveModalOverlay" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title">Konfirmasi Penerimaan Pesanan</h3>
      <button id="receiveModalClose" class="modal-close">
        <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="modal-body">
      <p style="color: var(--text-secondary); line-height: 1.6;">
        Pastikan Anda telah menerima pesanan ini dengan kondisi baik. Setelah dikonfirmasi, status pesanan akan berubah menjadi <strong>Pesanan Diterima</strong> dan tidak dapat dibatalkan.
      </p>
    </div>
    <div class="modal-footer">
      <button id="receiveCancelBtn" class="btn btn-outline" style="width: auto;">Belum</button>
      <button id="receiveConfirmBtn" class="btn btn-success" style="width: auto;">
        <span id="receiveConfirmLabel">Ya, Sudah Diterima</span>
      </button>
    </div>
  </div>
</div>

<script>
(function(){
  'use strict';
  
  // History Toggle
  const historyHeader = document.getElementById('historyHeader');
  const historyList = document.getElementById('historyList');
  const toggleIcon = document.getElementById('toggleIcon');
  
  if (historyHeader && historyList && toggleIcon) {
    let isOpen = true;
    
    historyHeader.addEventListener('click', function() {
      isOpen = !isOpen;
      if (isOpen) {
        historyList.style.display = 'flex';
        toggleIcon.classList.remove('collapsed');
      } else {
        historyList.style.display = 'none';
        toggleIcon.classList.add('collapsed');
      }
    });
  }
  
  // Copy Button
  document.querySelectorAll('.copy-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const text = btn.getAttribute('data-copy');
      if (!text) return;
      
      if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
          const original = btn.innerHTML;
          btn.innerHTML = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Tersalin';
          setTimeout(() => btn.innerHTML = original, 2000);
        });
      }
    });
  });
  
  // Cancel Confirmation
  window.confirmCancel = function(form) {
    if (!confirm('Yakin ingin membatalkan pesanan ini?')) return false;
    const btn = form.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<span class="loader"></span> Membatalkan...';
    }
    return true;
  };
  
  // Proof Modal
  const proofOverlay = document.getElementById('proofModalOverlay');
  const proofClose = document.getElementById('proofModalClose');
  const proofImg = document.getElementById('proofImg');
  const proofIframe = document.getElementById('proofIframe');
  
  document.querySelectorAll('.open-proof-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const url = btn.getAttribute('data-proof-url');
      const ext = btn.getAttribute('data-proof-ext');
      if (!url) return alert('Bukti tidak tersedia');
      
      proofImg.style.display = 'none';
      proofIframe.style.display = 'none';
      
      if (ext === 'pdf') {
        proofIframe.src = url;
        proofIframe.style.display = 'block';
      } else {
        proofImg.src = url;
        proofImg.style.display = 'block';
      }
      
      proofOverlay.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    });
  });
  
  function closeProofModal() {
    proofOverlay.style.display = 'none';
    proofImg.src = '';
    proofIframe.src = '';
    document.body.style.overflow = '';
  }
  
  if (proofClose) proofClose.addEventListener('click', closeProofModal);
  if (proofOverlay) proofOverlay.addEventListener('click', e => {
    if (e.target === proofOverlay) closeProofModal();
  });
  
  // Receive Modal
  const receiveOverlay = document.getElementById('receiveModalOverlay');
  const receiveClose = document.getElementById('receiveModalClose');
  const receiveCancel = document.getElementById('receiveCancelBtn');
  const receiveConfirm = document.getElementById('receiveConfirmBtn');
  const receiveForm = document.getElementById('receiveForm');
  let receiveSubmitting = false;
  
  document.querySelectorAll('.open-receive-modal').forEach(btn => {
    btn.addEventListener('click', function() {
      receiveOverlay.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    });
  });
  
  function closeReceiveModal() {
    if (receiveSubmitting) return;
    receiveOverlay.style.display = 'none';
    document.body.style.overflow = '';
  }
  
  if (receiveClose) receiveClose.addEventListener('click', closeReceiveModal);
  if (receiveCancel) receiveCancel.addEventListener('click', closeReceiveModal);
  if (receiveOverlay) receiveOverlay.addEventListener('click', e => {
    if (e.target === receiveOverlay) closeReceiveModal();
  });
  
  if (receiveConfirm && receiveForm) {
    receiveConfirm.addEventListener('click', function() {
      if (receiveSubmitting) return;
      receiveSubmitting = true;
      receiveConfirm.disabled = true;
      receiveCancel.disabled = true;
      receiveConfirm.innerHTML = '<span class="loader"></span> Memproses...';
      receiveForm.submit();
    });
  }
  
  // ESC to close
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      if (proofOverlay.style.display === 'flex') closeProofModal();
      if (receiveOverlay.style.display === 'flex') closeReceiveModal();
    }
  });
})();
</script>

</div>
@endsection