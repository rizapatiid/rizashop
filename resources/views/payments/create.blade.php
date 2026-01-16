@extends('layouts.app')
@section('title', 'Payment')
@section('page-title', 'Payment')

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
  --warning: #FF8A00;
  --info: #0095DA;
  --shadow: 0 1px 6px rgba(0,0,0,.1);
  --shadow-md: 0 2px 8px rgba(0,0,0,.12);
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
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px 16px;
}

/* BREADCRUMB */
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
}

.breadcrumb a {
  color: var(--primary-blue);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 4px;
}

.breadcrumb a:hover {
  text-decoration: underline;
}

.breadcrumb svg {
  width: 14px;
  height: 14px;
}

/* MAIN GRID */
.payment-grid {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 16px;
  align-items: flex-start;
}

/* LEFT COLUMN */
.payment-main {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

/* CARD */
.card {
  background: var(--bg-white);
  border-radius: 8px;
  box-shadow: var(--shadow);
  overflow: hidden;
}

.card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 12px;
}

.card-icon {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.card-icon svg {
  width: 20px;
  height: 20px;
  fill: var(--primary-blue);
}

.card-title {
  font-size: 16px;
  font-weight: 700;
  color: var(--text-dark);
}

.card-body {
  padding: 20px;
}

/* ORDER INFO */
.order-info {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 16px;
}

.order-number {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: var(--text-gray);
}

.order-number strong {
  color: var(--text-dark);
  font-weight: 600;
}

.order-status {
  background: #FFF3E0;
  color: var(--warning);
  padding: 4px 12px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
}

/* PAYMENT METHODS */
.method-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.method-item {
  border: 2px solid var(--border);
  border-radius: 8px;
  padding: 16px;
  cursor: pointer;
  transition: all .2s;
  position: relative;
}

.method-item:hover {
  border-color: var(--primary-blue);
  background: var(--primary-blue-light);
}

.method-item.active {
  border-color: var(--primary-blue);
  background: var(--primary-blue-light);
}

.method-item input[type="radio"] {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

.method-header {
  display: flex;
  align-items: center;
  gap: 12px;
}

.method-radio {
  width: 20px;
  height: 20px;
  border: 2px solid #BDBDBD;
  border-radius: 50%;
  position: relative;
  flex-shrink: 0;
  transition: all .2s;
}

.method-item.active .method-radio {
  border-color: var(--primary-blue);
}

.method-item.active .method-radio::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 10px;
  height: 10px;
  background: var(--primary-blue);
  border-radius: 50%;
}

.method-logo {
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #F5F5F5;
  border-radius: 8px;
  flex-shrink: 0;
}

.method-logo svg {
  width: 28px;
  height: 28px;
}

.method-info {
  flex: 1;
}

.method-name {
  font-size: 15px;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 2px;
}

.method-desc {
  font-size: 13px;
  color: var(--text-gray);
}

.method-badge {
  background: var(--success);
  color: white;
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 600;
  margin-left: auto;
}

.method-badge.instant {
  background: var(--primary-blue);
}

/* METHOD DETAILS */
.method-details {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px dashed var(--border);
  display: none;
}

.method-item.active .method-details {
  display: block;
  animation: slideDown .3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bank-selector {
  margin-bottom: 12px;
}

.bank-selector label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 8px;
}

.bank-select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid var(--border);
  border-radius: 6px;
  font-size: 14px;
  background: white;
  cursor: pointer;
  transition: border .2s;
}

.bank-select:hover {
  border-color: var(--primary-blue);
}

.bank-select:focus {
  outline: none;
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 3px var(--primary-blue-light);
}

.bank-detail {
  margin-top: 12px;
  background: #FAFAFA;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 14px;
}

.bank-detail-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.bank-detail-row:last-child {
  margin-bottom: 0;
}

.bank-label {
  font-size: 12px;
  color: var(--text-gray);
}

.bank-value {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-dark);
}

.bank-number-row {
  display: flex;
  align-items: center;
  gap: 12px;
  background: white;
  padding: 12px;
  border-radius: 6px;
  border: 1px dashed var(--border);
}

.bank-number {
  flex: 1;
  font-size: 18px;
  font-weight: 700;
  color: var(--primary-blue);
  font-family: 'Courier New', monospace;
  letter-spacing: 1px;
}

.copy-btn {
  padding: 6px 16px;
  background: white;
  border: 1px solid var(--primary-blue);
  color: var(--primary-blue);
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all .2s;
  display: flex;
  align-items: center;
  gap: 6px;
}

.copy-btn svg {
  width: 14px;
  height: 14px;
  fill: currentColor;
}

.copy-btn:hover {
  background: var(--primary-blue);
  color: white;
}

.copy-btn:active {
  transform: scale(.95);
}

/* QRIS */
.qris-box {
  text-align: center;
  padding: 20px;
}

.qris-image {
  width: 240px;
  height: 240px;
  margin: 0 auto;
  border: 2px solid var(--border);
  border-radius: 8px;
  background: white;
  padding: 12px;
}

.qris-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.qris-info {
  margin-top: 12px;
  font-size: 13px;
  color: var(--text-gray);
}

/* COD */
.cod-box {
  background: #E8F5E9;
  border: 1px solid #81C784;
  border-radius: 8px;
  padding: 16px;
  display: flex;
  gap: 12px;
}

.cod-icon {
  flex-shrink: 0;
}

.cod-icon svg {
  width: 24px;
  height: 24px;
  fill: var(--success);
}

.cod-content .cod-title {
  font-size: 14px;
  font-weight: 600;
  color: var(--success);
  margin-bottom: 8px;
}

.cod-content .cod-text {
  font-size: 13px;
  color: #2E7D32;
  line-height: 1.6;
}

/* UPLOAD SECTION */
.upload-box {
  border: 2px dashed var(--border);
  border-radius: 8px;
  padding: 24px;
  text-align: center;
  cursor: pointer;
  transition: all .2s;
}

.upload-box:hover {
  border-color: var(--primary-blue);
  background: var(--primary-blue-light);
}

.upload-icon {
  margin-bottom: 12px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.upload-icon svg {
  width: 48px;
  height: 48px;
  fill: var(--primary-blue);
}

.upload-title {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 4px;
}

.upload-subtitle {
  font-size: 12px;
  color: var(--text-gray);
}

.preview-box {
  margin-top: 16px;
  position: relative;
}

.preview-box img {
  max-width: 100%;
  max-height: 300px;
  border-radius: 8px;
  border: 1px solid var(--border);
}

.remove-preview {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 32px;
  height: 32px;
  background: rgba(255,255,255,.95);
  border: none;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--shadow-md);
}

.remove-preview svg {
  width: 16px;
  height: 16px;
  fill: #666;
}

.remove-preview:hover {
  background: #FF5252;
}

.remove-preview:hover svg {
  fill: white;
}

/* RIGHT SIDEBAR */
.payment-sidebar {
  position: sticky;
  top: 20px;
}

.summary-card {
  background: var(--bg-white);
  border-radius: 8px;
  box-shadow: var(--shadow);
  overflow: hidden;
}

.summary-header {
  padding: 16px 20px;
  background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
  color: white;
}

.summary-title {
  font-size: 16px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 10px;
}

.summary-title svg {
  width: 20px;
  height: 20px;
  fill: white;
}

.summary-body {
  padding: 20px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
  font-size: 14px;
}

.summary-row:last-child {
  border-bottom: none;
}

.summary-label {
  color: var(--text-gray);
}

.summary-value {
  font-weight: 600;
  color: var(--text-dark);
}

.summary-total {
  background: #FAFAFA;
  padding: 16px 20px;
  margin: -20px -20px 20px;
  border-bottom: 1px solid var(--border);
}

.total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.total-label {
  font-size: 15px;
  font-weight: 600;
  color: var(--text-dark);
}

.total-amount {
  font-size: 24px;
  font-weight: 700;
  color: var(--success);
}

/* BUTTONS */
.btn-submit {
  width: 100%;
  padding: 14px;
  background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: all .2s;
  box-shadow: 0 4px 12px rgba(0, 149, 218, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn-submit svg {
  width: 18px;
  height: 18px;
  fill: white;
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 149, 218, 0.4);
}

.btn-submit:active {
  transform: translateY(0);
}

.btn-submit:disabled {
  background: #BDBDBD;
  cursor: not-allowed;
  box-shadow: none;
}

.btn-back {
  width: 100%;
  padding: 12px;
  background: white;
  color: var(--text-dark);
  border: 1px solid var(--border);
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all .2s;
  margin-top: 12px;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn-back svg {
  width: 16px;
  height: 16px;
  fill: currentColor;
}

.btn-back:hover {
  background: var(--bg-light);
}

/* INFO BOX */
.info-box {
  background: var(--primary-blue-light);
  border-left: 4px solid var(--primary-blue);
  padding: 12px 16px;
  border-radius: 6px;
  margin-bottom: 16px;
  font-size: 13px;
  color: var(--primary-blue-dark);
  line-height: 1.6;
  display: flex;
  gap: 12px;
}

.info-box svg {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
  fill: var(--primary-blue);
}

.info-box strong {
  font-weight: 600;
}

/* TOAST */
.toast {
  position: fixed;
  top: 20px;
  right: 20px;
  background: white;
  padding: 16px 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,.15);
  display: none;
  align-items: center;
  gap: 12px;
  z-index: 9999;
  animation: slideInRight .3s ease;
  min-width: 300px;
}

@keyframes slideInRight {
  from {
    transform: translateX(400px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.toast.show {
  display: flex;
}

.toast.success {
  border-left: 4px solid var(--success);
}

.toast.error {
  border-left: 4px solid #FF5252;
}

.toast-icon svg {
  width: 24px;
  height: 24px;
}

.toast.success .toast-icon svg {
  fill: var(--success);
}

.toast.error .toast-icon svg {
  fill: #FF5252;
}

.toast-message {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-dark);
  flex: 1;
}

/* LOADING */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9998;
}

.loading-overlay.show {
  display: flex;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid rgba(255,255,255,.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* RESPONSIVE */
@media (max-width: 968px) {
  .payment-grid {
    grid-template-columns: 1fr;
  }

  .payment-sidebar {
    position: static;
    order: -1;
  }
}

@media (max-width: 640px) {
  .payment-container {
    padding: 12px 8px;
  }

  .breadcrumb {
    padding: 10px 12px;
    font-size: 12px;
  }

  .card-header {
    padding: 12px 16px;
  }

  .card-body {
    padding: 16px;
  }

  .method-item {
    padding: 12px;
  }

  .method-logo {
    width: 40px;
    height: 40px;
  }

  .method-logo svg {
    width: 24px;
    height: 24px;
  }

  .method-name {
    font-size: 14px;
  }

  .method-desc {
    font-size: 12px;
  }

  .bank-number {
    font-size: 16px;
  }

  .total-amount {
    font-size: 20px;
  }

  .summary-body {
    padding: 16px;
  }

  .toast {
    left: 12px;
    right: 12px;
    top: 12px;
    min-width: auto;
  }
}
</style>

@php
$storeRoute = \Illuminate\Support\Facades\Route::has('payments.store')
  ? 'payments.store'
  : (\Illuminate\Support\Facades\Route::has('addresses.payments.store')
      ? 'addresses.payments.store'
      : null);
@endphp

<div class="payment-container">
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{ url('/') }}">
      <svg viewBox="0 0 24 24">
        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
      </svg>
      Beranda
    </a>
    › 
    <a href="{{ url('/orders') }}">Pesanan Saya</a>
    › 
    <span>Pembayaran</span>
  </div>

  <div class="payment-grid">
    <!-- Main Content -->
    <div class="payment-main">
      <!-- Order Info Card -->
      <div class="card">
        <div class="card-header">
          <div class="card-icon">
            <svg viewBox="0 0 24 24">
              <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/>
            </svg>
          </div>
          <h2 class="card-title">Informasi Pesanan</h2>
        </div>
        <div class="card-body">
          <div class="order-info">
            <div class="order-number">
              <span>No. Pesanan:</span>
              <strong>#{{ $order->order_number }}</strong>
            </div>
            <div class="order-status">Menunggu Pembayaran</div>
          </div>
        </div>
      </div>

      @if($storeRoute)
      <form action="{{ route($storeRoute, $order->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
        @csrf
        <input type="hidden" name="amount" value="{{ $order->total }}">

        <!-- Payment Methods Card -->
        <div class="card">
          <div class="card-header">
            <div class="card-icon">
              <svg viewBox="0 0 24 24">
                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
              </svg>
            </div>
            <h2 class="card-title">Pilih Metode Pembayaran</h2>
          </div>
          <div class="card-body">
            <div class="method-list">
              
              <!-- Virtual Account -->
              <label class="method-item" data-method="va">
                <input type="radio" name="method" value="va">
                <div class="method-header">
                  <div class="method-radio"></div>
                  <div class="method-logo">
                    <svg viewBox="0 0 24 24" fill="#0095DA">
                      <path d="M11.5 1L2 6v2h19V6m-5 4v7h3v-7M2 22h19v-3H2m8-9v7h3v-7m-9 0v7h3v-7H1z"/>
                    </svg>
                  </div>
                  <div class="method-info">
                    <div class="method-name">Virtual Account</div>
                    <div class="method-desc">BCA, BNI, BRI, Mandiri</div>
                  </div>
                  <div class="method-badge">Populer</div>
                </div>
                <div class="method-details">
                  <div class="bank-selector">
                    <label>Pilih Bank</label>
                    <select class="bank-select" onchange="showVA(this.value)">
                      <option value="">-- Pilih Bank --</option>
                      <option value="BCA">BCA Virtual Account</option>
                      <option value="BNI">BNI Virtual Account</option>
                      <option value="BRI">BRI Virtual Account</option>
                      <option value="Mandiri">Mandiri Virtual Account</option>
                    </select>
                  </div>
                  <div id="vaDetail"></div>
                </div>
              </label>

              <!-- Transfer Manual -->
              <label class="method-item" data-method="manual">
                <input type="radio" name="method" value="manual">
                <div class="method-header">
                  <div class="method-radio"></div>
                  <div class="method-logo">
                    <svg viewBox="0 0 24 24" fill="#00C853">
                      <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                    </svg>
                  </div>
                  <div class="method-info">
                    <div class="method-name">Transfer Bank</div>
                    <div class="method-desc">Transfer manual ke rekening toko</div>
                  </div>
                </div>
                <div class="method-details">
                  <div class="bank-selector">
                    <label>Pilih Bank Tujuan</label>
                    <select class="bank-select" onchange="showManual(this.value)">
                      <option value="">-- Pilih Bank --</option>
                      <option value="BCA">BCA</option>
                      <option value="BRI">BRI</option>
                      <option value="MANDIRI">Mandiri</option>
                      <option value="LAIN">Bank Lainnya</option>
                    </select>
                  </div>
                  <div id="manualDetail"></div>
                </div>
              </label>

              <!-- QRIS -->
              <label class="method-item" data-method="qris">
                <input type="radio" name="method" value="qris">
                <div class="method-header">
                  <div class="method-radio"></div>
                  <div class="method-logo">
                    <svg viewBox="0 0 24 24" fill="#FF6B35">
                      <path d="M16 1H8C6.34 1 5 2.34 5 4v16c0 1.66 1.34 3 3 3h8c1.66 0 3-1.34 3-3V4c0-1.66-1.34-3-3-3zm-2 20h-4v-1h4v1zm3.25-3H6.75V4h10.5v14z"/>
                    </svg>
                  </div>
                  <div class="method-info">
                    <div class="method-name">QRIS</div>
                    <div class="method-desc">Bayar pakai DANA, OVO, GoPay, ShopeePay</div>
                  </div>
                  <div class="method-badge instant">Instan</div>
                </div>
                <div class="method-details">
                  <div class="qris-box">
                    <div class="qris-image">
                      <img src="{{ asset('images/qris/qris.jpeg') }}" alt="QRIS">
                    </div>
                    <div class="qris-info">
                      Scan kode QR dengan aplikasi e-wallet atau mobile banking Anda
                    </div>
                  </div>
                </div>
              </label>

              <!-- COD -->
              <label class="method-item" data-method="cod">
                <input type="radio" name="method" value="cod">
                <div class="method-header">
                  <div class="method-radio"></div>
                  <div class="method-logo">
                    <svg viewBox="0 0 24 24" fill="#FF8A00">
                      <path d="M18 18.5a1.5 1.5 0 0 1-1.5-1.5 1.5 1.5 0 0 1 1.5-1.5 1.5 1.5 0 0 1 1.5 1.5 1.5 1.5 0 0 1-1.5 1.5m1.5-9l1.96 2.5H17V9.5m-11 9A1.5 1.5 0 0 1 4.5 17 1.5 1.5 0 0 1 6 15.5 1.5 1.5 0 0 1 7.5 17 1.5 1.5 0 0 1 6 18.5M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 0 0 3 3 3 3 0 0 0 3-3h6a3 3 0 0 0 3 3 3 3 0 0 0 3-3h2v-5l-3-4z"/>
                    </svg>
                  </div>
                  <div class="method-info">
                    <div class="method-name">Bayar di Tempat (COD)</div>
                    <div class="method-desc">Bayar tunai saat barang tiba</div>
                  </div>
                </div>
                <div class="method-details">
                  <div class="cod-box">
                    <div class="cod-icon">
                      <svg viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                      </svg>
                    </div>
                    <div class="cod-content">
                      <div class="cod-title">Bayar di Tempat</div>
                      <div class="cod-text">
                        Siapkan uang tunai sejumlah <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> untuk dibayarkan kepada kurir saat pesanan tiba di lokasi Anda.
                      </div>
                    </div>
                  </div>
                </div>
              </label>

            </div>
          </div>
        </div>

        <!-- Upload Proof Card -->
        <div class="card" id="uploadCard">
          <div class="card-header">
            <div class="card-icon">
              <svg viewBox="0 0 24 24">
                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
              </svg>
            </div>
            <h2 class="card-title">Bukti Pembayaran</h2>
          </div>
          <div class="card-body">
            <div class="info-box">
              <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
              </svg>
              <div>
                <strong>Tips:</strong> Pastikan bukti transfer Anda jelas dan terbaca. Maksimal ukuran file 5MB dengan format JPG, PNG, atau JPEG.
              </div>
            </div>
            
            <div class="upload-box" onclick="document.getElementById('proof').click()">
              <div class="upload-icon">
                <svg viewBox="0 0 24 24">
                  <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                </svg>
              </div>
              <div class="upload-title">Klik atau drag file ke sini</div>
              <div class="upload-subtitle">untuk upload bukti pembayaran</div>
            </div>
            <input type="file" name="proof" id="proof" accept="image/*" hidden>
            
            <div class="preview-box" id="previewBox" style="display: none;">
              <img id="previewImage" src="" alt="Preview">
              <button type="button" class="remove-preview" onclick="removePreview()">
                <svg viewBox="0 0 24 24">
                  <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

      </form>
      @endif

    </div>

    <!-- Sidebar Summary -->
    <div class="payment-sidebar">
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-title">
            <svg viewBox="0 0 24 24">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
            </svg>
            <span>Ringkasan Pembayaran</span>
          </div>
        </div>
        <div class="summary-body">
          <div class="summary-total">
            <div class="total-row">
              <div class="total-label">Total Tagihan</div>
              <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
          </div>

          <div class="summary-row">
            <div class="summary-label">Subtotal Produk</div>
            <div class="summary-value">Rp {{ number_format($order->total * 0.95, 0, ',', '.') }}</div>
          </div>
          <div class="summary-row">
            <div class="summary-label">Ongkos Kirim</div>
            <div class="summary-value">Rp {{ number_format($order->total * 0.05, 0, ',', '.') }}</div>
          </div>

          <button type="button" class="btn-submit" onclick="submitPayment()">
            <svg viewBox="0 0 24 24">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
            <span>Konfirmasi Pembayaran</span>
          </button>

          <a href="{{ url()->previous() }}" class="btn-back">
            <svg viewBox="0 0 24 24">
              <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            <span>Kembali ke Pesanan</span>
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast">
  <div class="toast-icon" id="toastIcon">
    <svg viewBox="0 0 24 24">
      <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
    </svg>
  </div>
  <div class="toast-message" id="toastMessage"></div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="loading-spinner"></div>
</div>

<script>
// Method Selection
const methods = document.querySelectorAll('.method-item');
const uploadCard = document.getElementById('uploadCard');
const proofInput = document.getElementById('proof');

methods.forEach(method => {
  method.addEventListener('click', function(e) {
    if (e.target.classList.contains('bank-select') || 
        e.target.classList.contains('copy-btn')) {
      return;
    }

    methods.forEach(m => m.classList.remove('active'));
    this.classList.add('active');
    this.querySelector('input[type="radio"]').checked = true;

    const methodType = this.dataset.method;
    
    // Show/hide upload section based on method
    if (methodType === 'cod') {
      uploadCard.style.display = 'none';
      proofInput.removeAttribute('required');
    } else {
      uploadCard.style.display = 'block';
      proofInput.setAttribute('required', 'required');
    }
  });
});

// Show VA Details
function showVA(bank) {
  const detail = document.getElementById('vaDetail');
  if (!bank) {
    detail.innerHTML = '';
    return;
  }

  const prefix = {
    BCA: '70001',
    BNI: '80001',
    BRI: '90001',
    Mandiri: '60001'
  }[bank];

  const vaNumber = prefix + '{{ str_pad($order->id, 8, "0", STR_PAD_LEFT) }}';

  detail.innerHTML = `
    <div class="bank-detail">
      <div class="bank-detail-row">
        <div class="bank-label">Bank</div>
        <div class="bank-value">${bank}</div>
      </div>
      <div class="bank-number-row">
        <div class="bank-number">${vaNumber}</div>
        <button type="button" class="copy-btn" onclick="copyText('${vaNumber}')">
          <svg viewBox="0 0 24 24"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
          <span>Salin</span>
        </button>
      </div>
    </div>
  `;
}

// Show Manual Transfer Details
function showManual(bank) {
  const detail = document.getElementById('manualDetail');
  if (!bank) {
    detail.innerHTML = '';
    return;
  }

  const bankData = {
    BCA: { number: '1234567890', holder: 'RIZA BADRUZ ZAMAN' },
    BRI: { number: '0987654321', holder: 'RIZA BADRUZ ZAMAN' },
    MANDIRI: { number: '1357924680', holder: 'RIZA BADRUZ ZAMAN' },
    LAIN: { number: '1122334455', holder: 'RIZA BADRUZ ZAMAN' }
  };

  const data = bankData[bank];

  detail.innerHTML = `
    <div class="bank-detail">
      <div class="bank-detail-row">
        <div class="bank-label">Bank Tujuan</div>
        <div class="bank-value">${bank === 'LAIN' ? 'Bank Lainnya' : bank}</div>
      </div>
      <div class="bank-detail-row">
        <div class="bank-label">Atas Nama</div>
        <div class="bank-value">${data.holder}</div>
      </div>
      <div class="bank-number-row">
        <div class="bank-number">${data.number}</div>
        <button type="button" class="copy-btn" onclick="copyText('${data.number}')">
          <svg viewBox="0 0 24 24"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
          <span>Salin</span>
        </button>
      </div>
    </div>
  `;
}

// Copy Text Function
function copyText(text) {
  navigator.clipboard.writeText(text).then(() => {
    showToast('Nomor rekening berhasil disalin!', 'success');
  }).catch(() => {
    showToast('Gagal menyalin. Silakan salin manual.', 'error');
  });
}

// File Upload Preview
const previewBox = document.getElementById('previewBox');
const previewImage = document.getElementById('previewImage');

proofInput.addEventListener('change', function() {
  const file = this.files[0];
  if (!file) return;

  // Validate file size (5MB)
  if (file.size > 5 * 1024 * 1024) {
    showToast('Ukuran file terlalu besar! Maksimal 5MB', 'error');
    this.value = '';
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    previewImage.src = e.target.result;
    previewBox.style.display = 'block';
  };
  reader.readAsDataURL(file);
});

// Remove Preview
function removePreview() {
  proofInput.value = '';
  previewBox.style.display = 'none';
  previewImage.src = '';
}

// Drag and Drop
const uploadBox = document.querySelector('.upload-box');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  uploadBox.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
  uploadBox.addEventListener(eventName, () => {
    uploadBox.style.borderColor = 'var(--primary-blue)';
    uploadBox.style.background = 'var(--primary-blue-light)';
  });
});

['dragleave', 'drop'].forEach(eventName => {
  uploadBox.addEventListener(eventName, () => {
    uploadBox.style.borderColor = 'var(--border)';
    uploadBox.style.background = 'transparent';
  });
});

uploadBox.addEventListener('drop', function(e) {
  const files = e.dataTransfer.files;
  if (files.length > 0) {
    proofInput.files = files;
    proofInput.dispatchEvent(new Event('change'));
  }
});

// Submit Payment
function submitPayment() {
  const form = document.getElementById('paymentForm');
  const method = document.querySelector('input[name="method"]:checked');

  if (!method) {
    showToast('Silakan pilih metode pembayaran!', 'error');
    return;
  }

  // Only check for proof if NOT COD
  if (method.value !== 'cod') {
    const proof = document.getElementById('proof').files[0];
    if (!proof) {
      showToast('Silakan upload bukti pembayaran!', 'error');
      return;
    }
  }

  // Show loading
  document.getElementById('loadingOverlay').classList.add('show');

  // Submit form
  form.submit();
}

// Toast Notification
function showToast(message, type = 'success') {
  const toast = document.getElementById('toast');
  const icon = document.getElementById('toastIcon');
  const msg = document.getElementById('toastMessage');

  toast.className = 'toast show ' + type;
  
  if (type === 'success') {
    icon.innerHTML = '<svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>';
  } else {
    icon.innerHTML = '<svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
  }
  
  msg.textContent = message;

  setTimeout(() => {
    toast.classList.remove('show');
  }, 3000);
}
</script>

@endsection