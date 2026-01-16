@extends('layouts.app')
@section('title', 'Status Pembayaran')
@section('page-title', 'Status Pembayaran')

@section('content')

<style>
:root {
  --primary-blue: #0095DA;
  --primary-blue-dark: #0077B5;
  --primary-blue-light: #E6F5FC;
  --bg-light: #F5F5F5;
  --bg-white: #FFFFFF;
  --border: #E5E5E5;
  --text-dark: #212121;
  --text-gray: #6D6D6D;
  --text-light: #9E9E9E;
  --success: #00C853;
  --success-light: #E8F5E9;
  --warning: #FF8A00;
  --warning-light: #FFF3E0;
  --danger: #EF4444;
  --danger-light: #FFEBEE;
  --shadow: 0 1px 6px rgba(0,0,0,.1);
  --shadow-md: 0 2px 8px rgba(0,0,0,.12);
  --shadow-lg: 0 4px 16px rgba(0,0,0,.15);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Open Sans', sans-serif;
  background: var(--bg-light);
  color: var(--text-dark);
  line-height: 1.5;
}

.payment-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 24px 16px;
}

/* Breadcrumb */
.breadcrumb {
  background: var(--bg-white);
  padding: 12px 20px;
  margin-bottom: 16px;
  border-radius: 8px;
  font-size: 13px;
  color: var(--text-gray);
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: var(--shadow);
}

.breadcrumb a {
  color: var(--primary-blue);
  text-decoration: none;
}

.breadcrumb a:hover {
  text-decoration: underline;
}

/* Status Card */
.status-card {
  background: var(--bg-white);
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  overflow: hidden;
  margin-bottom: 16px;
}

.status-header {
  padding: 32px 28px;
  background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
  color: white;
  position: relative;
  overflow: hidden;
}

.status-header::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 300px;
  height: 300px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
}

.status-content {
  display: flex;
  align-items: center;
  gap: 20px;
  position: relative;
  z-index: 1;
}

.status-icon {
  width: 80px;
  height: 80px;
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.status-icon svg {
  width: 40px;
  height: 40px;
  stroke: white;
}

/* Success Header */
.status-header.success {
  background: linear-gradient(135deg, var(--success) 0%, #00A84A 100%);
}

/* Warning Header */
.status-header.warning {
  background: linear-gradient(135deg, var(--warning) 0%, #F97316 100%);
}

/* Danger Header */
.status-header.danger {
  background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%);
}

.status-info {
  flex: 1;
}

.status-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 8px;
  text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.status-subtitle {
  font-size: 14px;
  opacity: 0.95;
  display: flex;
  align-items: center;
  gap: 8px;
}

.status-subtitle svg {
  width: 16px;
  height: 16px;
}

/* Status Body */
.status-body {
  padding: 28px;
}

.info-box {
  background: var(--primary-blue-light);
  border-left: 4px solid var(--primary-blue);
  padding: 16px 20px;
  border-radius: 8px;
  margin-bottom: 24px;
  display: flex;
  gap: 16px;
}

.info-box.success {
  background: var(--success-light);
  border-left-color: var(--success);
}

.info-box.warning {
  background: var(--warning-light);
  border-left-color: var(--warning);
}

.info-box.danger {
  background: var(--danger-light);
  border-left-color: var(--danger);
}

.info-box-icon {
  flex-shrink: 0;
}

.info-box-icon svg {
  width: 24px;
  height: 24px;
}

.info-box.success .info-box-icon svg {
  stroke: var(--success);
}

.info-box.warning .info-box-icon svg {
  stroke: var(--warning);
}

.info-box.danger .info-box-icon svg {
  stroke: var(--danger);
}

.info-box-text {
  font-size: 14px;
  line-height: 1.7;
  color: var(--text-dark);
}

/* Payment Details */
.payment-details {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.detail-item {
  background: #FAFAFA;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 16px;
}

.detail-label {
  font-size: 12px;
  color: var(--text-gray);
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 600;
}

.detail-value {
  font-size: 16px;
  font-weight: 600;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 8px;
}

.detail-value svg {
  width: 20px;
  height: 20px;
  stroke: var(--primary-blue);
}

.method-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--primary-blue-light);
  color: var(--primary-blue-dark);
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
}

.method-badge svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
}

/* COD Info Box */
.cod-info {
  background: var(--success-light);
  border: 2px solid var(--success);
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  margin-bottom: 24px;
}

.cod-info-icon {
  width: 60px;
  height: 60px;
  background: var(--success);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}

.cod-info-icon svg {
  width: 32px;
  height: 32px;
  stroke: white;
}

.cod-info-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--success);
  margin-bottom: 8px;
}

.cod-info-text {
  font-size: 14px;
  color: #2E7D32;
  line-height: 1.6;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.btn {
  flex: 1;
  min-width: 200px;
  padding: 14px 24px;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  text-decoration: none;
  transition: all 0.2s;
}

.btn svg {
  width: 18px;
  height: 18px;
}

.btn-primary {
  background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(0, 149, 218, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 149, 218, 0.4);
}

.btn-outline {
  background: white;
  color: var(--primary-blue);
  border: 2px solid var(--primary-blue);
}

.btn-outline:hover {
  background: var(--primary-blue-light);
}

.btn-secondary {
  background: #F5F5F5;
  color: var(--text-dark);
  border: 1px solid var(--border);
}

.btn-secondary:hover {
  background: #EEEEEE;
}

.btn:active {
  transform: translateY(0);
}

/* Help Text */
.help-text {
  margin-top: 16px;
  padding: 12px 16px;
  background: #F9FAFB;
  border-radius: 6px;
  font-size: 13px;
  color: var(--text-gray);
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.help-text svg {
  width: 16px;
  height: 16px;
  stroke: var(--text-gray);
  flex-shrink: 0;
}

/* Modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.75);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
  backdrop-filter: blur(4px);
}

.modal-overlay.show {
  display: flex;
}

.modal {
  max-width: 900px;
  width: 100%;
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: var(--shadow-lg);
  animation: modalSlide 0.3s ease;
}

@keyframes modalSlide {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1px solid var(--border);
  background: #FAFAFA;
}

.modal-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--text-dark);
}

.modal-close {
  width: 36px;
  height: 36px;
  background: white;
  border: 1px solid var(--border);
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.modal-close:hover {
  background: var(--danger);
  border-color: var(--danger);
  color: white;
}

.modal-close svg {
  width: 20px;
  height: 20px;
}

.modal-body {
  padding: 24px;
  text-align: center;
  max-height: 70vh;
  overflow: auto;
}

.modal-body img {
  max-width: 100%;
  height: auto;
  border-radius: 12px;
  border: 1px solid var(--border);
  box-shadow: var(--shadow-md);
}

/* Responsive */
@media (max-width: 768px) {
  .payment-container {
    padding: 16px 12px;
  }

  .breadcrumb {
    padding: 10px 16px;
    font-size: 12px;
  }

  .status-header {
    padding: 24px 20px;
  }

  .status-content {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }

  .status-icon {
    width: 64px;
    height: 64px;
  }

  .status-icon svg {
    width: 32px;
    height: 32px;
  }

  .status-title {
    font-size: 22px;
  }

  .status-subtitle {
    font-size: 13px;
  }

  .status-body {
    padding: 20px 16px;
  }

  .payment-details {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .action-buttons {
    flex-direction: column;
  }

  .btn {
    min-width: auto;
    width: 100%;
  }

  .modal {
    margin: 16px;
  }

  .modal-header {
    padding: 16px 20px;
  }

  .modal-body {
    padding: 20px 16px;
  }
}

@media (max-width: 480px) {
  .payment-container {
    padding: 12px 8px;
  }

  .status-header {
    padding: 20px 16px;
  }

  .status-title {
    font-size: 20px;
  }

  .status-body {
    padding: 16px;
  }

  .info-box {
    padding: 12px 16px;
    flex-direction: column;
    gap: 12px;
  }

  .detail-item {
    padding: 12px;
  }

  .btn {
    padding: 12px 20px;
    font-size: 14px;
  }
}
</style>

@php
$payment = $order->payment ?? null;
$hasProof = $payment && !empty($payment->proof_path);
$paymentStatus = $payment->status ?? null;
$paymentMethod = $payment->method ?? null;
$orderStatus = $order->status ?? null;

// Check if COD
$isCOD = $paymentMethod === 'cod';

// Get payment method label and icon
$methodLabel = 'Tidak Diketahui';
$methodIcon = '<circle cx="12" cy="12" r="10"/>';

if ($isCOD) {
  $methodLabel = 'Cash on Delivery (COD)';
  $methodIcon = '<path d="M18 18.5a1.5 1.5 0 0 1-1.5-1.5 1.5 1.5 0 0 1 1.5-1.5 1.5 1.5 0 0 1 1.5 1.5 1.5 1.5 0 0 1-1.5 1.5m1.5-9l1.96 2.5H17V9.5m-11 9A1.5 1.5 0 0 1 4.5 17 1.5 1.5 0 0 1 6 15.5 1.5 1.5 0 0 1 7.5 17 1.5 1.5 0 0 1 6 18.5M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 0 0 3 3 3 3 0 0 0 3-3h6a3 3 0 0 0 3 3 3 3 0 0 0 3-3h2v-5l-3-4z"/>';
} elseif ($paymentMethod === 'va') {
  $methodLabel = 'Virtual Account';
  $methodIcon = '<path d="M11.5 1L2 6v2h19V6m-5 4v7h3v-7M2 22h19v-3H2m8-9v7h3v-7m-9 0v7h3v-7H1z"/>';
} elseif ($paymentMethod === 'manual') {
  $methodLabel = 'Transfer Bank';
  $methodIcon = '<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>';
} elseif ($paymentMethod === 'qris') {
  $methodLabel = 'QRIS';
  $methodIcon = '<path d="M16 1H8C6.34 1 5 2.34 5 4v16c0 1.66 1.34 3 3 3h8c1.66 0 3-1.34 3-3V4c0-1.66-1.34-3-3-3zm-2 20h-4v-1h4v1zm3.25-3H6.75V4h10.5v14z"/>';
}

// Status Logic
if ($isCOD && $paymentStatus === 'confirmed' && $orderStatus === 'processing') {
  $title = 'Pembayaran COD Dikonfirmasi';
  $desc  = 'Pesanan Anda sedang dikemas dan akan segera dikirim. Siapkan pembayaran tunai sejumlah Rp ' . number_format($order->total, 0, ',', '.') . ' saat pesanan tiba di lokasi Anda.';
  $headerClass = 'success';
  $infoClass = 'success';
  $icon  = '<polyline points="20 6 9 17 4 12"/>';
  $showCODInfo = true;
}
elseif (!$hasProof && !$isCOD) {
  $title = 'Menunggu Pembayaran';
  $desc  = 'Silakan lakukan pembayaran dan upload bukti pembayaran untuk melanjutkan proses pesanan Anda.';
  $headerClass = 'warning';
  $infoClass = 'warning';
  $icon  = '<circle cx="12" cy="12" r="9"/><path d="M12 6v6l4 2"/>';
  $showCODInfo = false;
}
elseif (in_array($paymentStatus, ['waiting', 'waiting_confirm', 'waiting_confirmation'])) {
  $title = 'Menunggu Konfirmasi Admin';
  $desc  = 'Bukti pembayaran Anda sudah diterima dan sedang dalam proses verifikasi oleh admin. Mohon tunggu beberapa saat.';
  $headerClass = 'warning';
  $infoClass = 'warning';
  $icon  = '<circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><circle cx="12" cy="16" r="1"/>';
  $showCODInfo = false;
}
elseif (in_array($paymentStatus, ['confirmed', 'paid']) && !$isCOD) {
  $title = 'Pembayaran Berhasil';
  $desc  = 'Pembayaran Anda telah dikonfirmasi dan pesanan sedang diproses. Terima kasih atas pembayaran Anda.';
  $headerClass = 'success';
  $infoClass = 'success';
  $icon  = '<polyline points="20 6 9 17 4 12"/>';
  $showCODInfo = false;
}
elseif (in_array($paymentStatus, ['rejected', 'declined', 'failed'])) {
  $title = 'Pembayaran Ditolak';
  $desc  = 'Bukti pembayaran yang Anda upload tidak valid atau tidak sesuai. Silakan upload ulang bukti pembayaran yang benar.';
  $headerClass = 'danger';
  $infoClass = 'danger';
  $icon  = '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>';
  $showCODInfo = false;
}
else {
  $title = 'Menunggu Pembayaran';
  $desc  = 'Status pembayaran sedang diproses. Silakan tunggu atau hubungi admin jika ada kendala.';
  $headerClass = 'warning';
  $infoClass = 'warning';
  $icon  = '<circle cx="12" cy="12" r="9"/><path d="M12 6v6"/>';
  $showCODInfo = false;
}
@endphp

<div class="payment-container">
  
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a> › 
    <a href="{{ route('orders.index') }}">Pesanan Saya</a> › 
    <span>Status Pembayaran</span>
  </div>

  <!-- Status Card -->
  <div class="status-card">
    
    <!-- Status Header -->
    <div class="status-header {{ $headerClass }}">
      <div class="status-content">
        <div class="status-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            {!! $icon !!}
          </svg>
        </div>
        <div class="status-info">
          <div class="status-title">{{ $title }}</div>
          <div class="status-subtitle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <span>Order #{{ $order->order_number }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Status Body -->
    <div class="status-body">
      
      <!-- Info Box -->
      <div class="info-box {{ $infoClass }}">
        <div class="info-box-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4"/>
            <circle cx="12" cy="8" r="0.5" fill="currentColor"/>
          </svg>
        </div>
        <div class="info-box-text">
          {{ $desc }}
        </div>
      </div>

      <!-- Payment Details -->
      <div class="payment-details">
        <div class="detail-item">
          <div class="detail-label">Total Pembayaran</div>
          <div class="detail-value" style="color: var(--success); font-size: 20px;">
            Rp {{ number_format($order->total, 0, ',', '.') }}
          </div>
        </div>

        @if($payment)
        <div class="detail-item">
          <div class="detail-label">Metode Pembayaran</div>
          <div class="detail-value">
            <div class="method-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                {!! $methodIcon !!}
              </svg>
              {{ $methodLabel }}
            </div>
          </div>
        </div>
        @endif

        <div class="detail-item">
          <div class="detail-label">Tanggal Order</div>
          <div class="detail-value">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            {{ $order->created_at->format('d M Y, H:i') }}
          </div>
        </div>
      </div>

      @if($showCODInfo)
      <!-- COD Info -->
      <div class="cod-info">
        <div class="cod-info-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
        </div>
        <div class="cod-info-title">✓ Pesanan COD Telah Dikonfirmasi</div>
        <div class="cod-info-text">
          Tidak ada tindakan yang diperlukan. Pesanan Anda sedang dikemas dan akan segera dikirim ke alamat tujuan.
        </div>
      </div>
      @endif

      <!-- Action Buttons -->
      <div class="action-buttons">
        @if($isCOD && $paymentStatus === 'confirmed')
          <!-- COD sudah dikonfirmasi -->
          <a href="{{ route('orders.index') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
              <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Lihat Semua Pesanan
          </a>

        @elseif(!$hasProof || in_array($paymentStatus, ['rejected', 'declined', 'failed']))
          <!-- Perlu upload bukti -->
          <a href="{{ route('payments.create', $order->id) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="17 8 12 3 7 8"/>
              <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            Upload Bukti Pembayaran
          </a>
          <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
          </a>

        @else
          <!-- Sudah upload bukti -->
          <button class="btn btn-outline" onclick="openProofModal()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            Lihat Bukti Pembayaran
          </button>
          <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
          </a>
        @endif
      </div>

      <!-- Help Text -->
      <div class="help-text">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
          <line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <span>Jika terjadi kendala atau pertanyaan, silakan hubungi admin untuk bantuan.</span>
      </div>

    </div>

  </div>

</div>

<!-- Modal Proof -->
@if($hasProof)
<div id="proofModal" class="modal-overlay" onclick="closeProofModal(event)">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Bukti Pembayaran</div>
      <button class="modal-close" onclick="closeProofModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="modal-body">
      <img src="{{ asset(ltrim($payment->proof_path, '/')) }}" alt="Bukti Pembayaran">
    </div>
  </div>
</div>
@endif

<script>
function openProofModal() {
  const modal = document.getElementById('proofModal');
  modal.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeProofModal(event) {
  if (!event || event.target.id === 'proofModal' || event.target.classList.contains('modal-close')) {
    const modal = document.getElementById('proofModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
  }
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeProofModal();
  }
});
</script>

@endsection