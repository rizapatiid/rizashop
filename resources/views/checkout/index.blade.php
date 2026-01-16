@extends('layouts.app')
@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
<style>
:root {
  --primary-blue: #0095DA;
  --primary-blue-dark: #0077B5;
  --primary-blue-light: #E6F5FC;
  --bg-light: #F5F5F5;
  --bg-white: #FFFFFF;
  --border: #E5E5E5;
  --border-light: #F0F0F0;
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

.checkout-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px 16px;
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

.breadcrumb svg {
  width: 16px;
  height: 16px;
  stroke: currentColor;
}

/* Page Header */
.page-header {
  background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
  color: white;
  padding: 24px 28px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: var(--shadow-md);
  position: relative;
  overflow: hidden;
}

.page-header::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 300px;
  height: 300px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
}

.page-header-content {
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
  z-index: 1;
}

.page-header-icon {
  width: 48px;
  height: 48px;
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.page-header-icon svg {
  width: 24px;
  height: 24px;
  stroke: white;
}

.page-header-text h1 {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 4px;
}

.page-header-text p {
  font-size: 14px;
  opacity: 0.9;
}

/* Alert Messages */
.alert {
  padding: 16px 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-size: 14px;
  box-shadow: var(--shadow);
}

.alert svg {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
  margin-top: 2px;
}

.alert-error {
  background: var(--danger-light);
  border: 1px solid #FFCDD2;
  color: #C62828;
}

.alert-success {
  background: var(--success-light);
  border: 1px solid #C8E6C9;
  color: #2E7D32;
}

.alert ul {
  margin-top: 8px;
  padding-left: 20px;
}

/* Grid Layout */
.checkout-grid {
  display: grid;
  gap: 20px;
  grid-template-columns: 1fr;
}

@media (min-width: 1024px) {
  .checkout-grid {
    grid-template-columns: 1fr 420px;
  }
}

/* Card */
.card {
  background: var(--bg-white);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--border);
  margin-bottom: 20px;
}

.card:last-child {
  margin-bottom: 0;
}

.card-header {
  padding: 16px 20px;
  background: #FAFAFA;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 12px;
}

.card-header-icon {
  width: 36px;
  height: 36px;
  background: var(--primary-blue-light);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.card-header-icon svg {
  width: 18px;
  height: 18px;
  stroke: var(--primary-blue);
}

.card-header h2 {
  font-size: 16px;
  font-weight: 700;
  color: var(--text-dark);
}

.card-body {
  padding: 20px;
}

/* Address Selection */
.address-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.address-item {
  display: flex;
  gap: 14px;
  padding: 16px;
  border: 2px solid var(--border);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s;
  background: var(--bg-white);
}

.address-item:hover {
  border-color: var(--primary-blue);
  background: var(--primary-blue-light);
  box-shadow: 0 4px 12px rgba(0, 149, 218, 0.15);
}

.address-item input[type="radio"] {
  width: 20px;
  height: 20px;
  accent-color: var(--primary-blue);
  cursor: pointer;
  margin-top: 2px;
  flex-shrink: 0;
}

.address-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.address-header {
  display: flex;
  align-items: center;
  gap: 8px;
}

.address-label {
  font-weight: 700;
  font-size: 14px;
  color: var(--text-dark);
}

.badge-primary {
  background: var(--primary-blue);
  color: white;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.address-recipient-name {
  font-weight: 600;
  font-size: 14px;
  color: var(--text-gray);
  display: flex;
  align-items: center;
  gap: 6px;
}

.address-recipient-name svg {
  width: 14px;
  height: 14px;
  stroke: var(--primary-blue);
  flex-shrink: 0;
}

.address-detail {
  color: var(--text-gray);
  font-size: 13px;
  line-height: 1.6;
}

.address-phone {
  display: flex;
  align-items: center;
  gap: 6px;
  color: var(--text-gray);
  font-size: 13px;
  font-weight: 600;
}

.address-phone svg {
  width: 14px;
  height: 14px;
  stroke: var(--primary-blue);
  flex-shrink: 0;
}

/* Shipping Method */
.shipping-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.shipping-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px;
  border: 2px solid var(--border);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s;
  background: var(--bg-white);
}

.shipping-item:hover {
  border-color: var(--primary-blue);
  background: var(--primary-blue-light);
  box-shadow: 0 4px 12px rgba(0, 149, 218, 0.15);
}

.shipping-item input[type="radio"] {
  width: 20px;
  height: 20px;
  accent-color: var(--primary-blue);
  cursor: pointer;
  flex-shrink: 0;
}

.shipping-icon {
  width: 44px;
  height: 44px;
  background: var(--primary-blue-light);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.shipping-icon svg {
  width: 22px;
  height: 22px;
  stroke: var(--primary-blue);
}

.shipping-content {
  flex: 1;
}

.shipping-name {
  font-weight: 700;
  font-size: 14px;
  color: var(--text-dark);
  margin-bottom: 4px;
}

.shipping-eta {
  color: var(--text-gray);
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 4px;
}

.shipping-eta svg {
  width: 14px;
  height: 14px;
}

.shipping-cost {
  font-weight: 700;
  font-size: 16px;
  color: var(--primary-blue);
}

/* Product Items */
.product-list {
  display: flex;
  flex-direction: column;
  gap: 0;
  border-radius: 8px;
  overflow: hidden;
  background: var(--bg-white);
}

.product-item {
  display: flex;
  gap: 14px;
  padding: 16px;
  background: var(--bg-white);
  border-bottom: 1px solid var(--border-light);
  transition: all 0.2s;
}

.product-item:last-child {
  border-bottom: none;
}

.product-item:hover {
  background: #FAFAFA;
}

.product-image {
  width: 70px;
  height: 70px;
  border-radius: 8px;
  overflow: hidden;
  background: #F8F8F8;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid var(--border);
  flex-shrink: 0;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 6px;
  min-width: 0;
}

.product-name {
  font-weight: 600;
  font-size: 14px;
  color: var(--text-dark);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-variant-row {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-top: 2px;
  margin-bottom: 4px;
}

.product-variant {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  background: var(--primary-blue-light);
  color: var(--primary-blue-dark);
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 600;
  white-space: nowrap;
}

.product-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
}

.product-qty {
  color: var(--text-light);
  font-size: 13px;
  font-weight: 500;
}

.product-price-section {
  text-align: right;
}

.product-unit-price {
  color: var(--text-light);
  font-size: 11px;
  text-decoration: line-through;
  margin-bottom: 2px;
}

.product-total-price {
  font-weight: 700;
  font-size: 15px;
  color: var(--text-dark);
}

/* Notes Section */
.notes-label {
  display: flex;
  align-items: center;
  gap: 6px;
  color: var(--text-gray);
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 10px;
}

.notes-label svg {
  width: 16px;
  height: 16px;
  stroke: var(--primary-blue);
}

.notes-textarea {
  width: 100%;
  border: 2px solid var(--border);
  border-radius: 8px;
  padding: 12px;
  font-size: 14px;
  resize: vertical;
  transition: all 0.2s;
  font-family: inherit;
  line-height: 1.6;
}

.notes-textarea:focus {
  outline: none;
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 4px var(--primary-blue-light);
  background: white;
}

/* Summary Section */
.summary-items-header {
  padding: 14px 16px;
  background: #FAFAFA;
  border-bottom: 1px solid var(--border-light);
  font-weight: 700;
  font-size: 14px;
  color: var(--text-dark);
  display: flex;
  align-items: center;
  gap: 8px;
}

.summary-items-header svg {
  width: 16px;
  height: 16px;
  stroke: var(--primary-blue);
}

.summary-calculation {
  padding: 20px;
  background: var(--bg-white);
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 0;
  font-size: 14px;
}

.summary-row:first-child {
  padding-top: 0;
}

.summary-label {
  color: var(--text-gray);
  font-weight: 500;
}

.summary-value {
  font-weight: 600;
  color: var(--text-dark);
}

.summary-divider {
  height: 1px;
  background: var(--border-light);
  margin: 12px 0;
}

.summary-total-row {
  padding: 20px;
  background: var(--primary-blue-light);
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 2px dashed var(--border);
}

.summary-total-label {
  font-size: 15px;
  font-weight: 700;
  color: var(--text-dark);
}

.summary-total-value {
  font-size: 22px;
  font-weight: 700;
  color: var(--primary-blue);
}

/* Buttons */
.btn {
  padding: 14px 24px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  text-decoration: none;
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

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 149, 218, 0.4);
}

.btn-primary:active:not(:disabled) {
  transform: translateY(0);
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-outline {
  background: white;
  border: 2px solid var(--border);
  color: var(--text-gray);
}

.btn-outline:hover {
  border-color: var(--primary-blue);
  color: var(--primary-blue);
  background: var(--primary-blue-light);
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 60px 20px;
}

.empty-state-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  background: #F5F5F5;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.empty-state-icon svg {
  width: 40px;
  height: 40px;
  stroke: var(--text-light);
}

.empty-state p {
  color: var(--text-gray);
  font-size: 15px;
  margin-bottom: 20px;
}

/* Info Box */
.info-box {
  background: var(--warning-light);
  border: 1px solid #FFE0B2;
  border-radius: 8px;
  padding: 14px;
  margin-top: 16px;
  font-size: 13px;
  color: #E65100;
  display: flex;
  gap: 10px;
  line-height: 1.6;
}

.info-box svg {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
  margin-top: 2px;
  stroke: var(--warning);
}

/* Responsive */
@media (max-width: 1024px) {
  .checkout-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .checkout-container {
    padding: 16px 12px;
  }
  
  .page-header {
    padding: 20px;
  }
  
  .page-header-text h1 {
    font-size: 20px;
  }
  
  .page-header-text p {
    font-size: 13px;
  }
  
  .card-body {
    padding: 16px;
  }
  
  .product-item {
    gap: 12px;
    padding: 14px;
  }
  
  .product-image {
    width: 60px;
    height: 60px;
  }
  
  .product-name {
    font-size: 13px;
  }
  
  .summary-total-value {
    font-size: 20px;
  }
  
  .address-item,
  .shipping-item {
    padding: 14px;
  }
}

/* Loading Animation */
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>

<div class="checkout-container">
  
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a> › 
    <span>Checkout</span>
  </div>

  <!-- Page Header -->
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-header-icon">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
      </div>
      <div class="page-header-text">
        <h1>Checkout Pesanan</h1>
        <p>Lengkapi data pengiriman dan pilih metode pembayaran</p>
      </div>
    </div>
  </div>

  <!-- Alert Messages -->
  @if($errors->any())
    <div class="alert alert-error">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
      </svg>
      <div>
        <strong>Terjadi kesalahan:</strong>
        <ul>
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-error">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
      </svg>
      <div>{{ session('error') }}</div>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"></circle>
        <polyline points="9 11 12 14 22 4"></polyline>
      </svg>
      <div>{{ session('success') }}</div>
    </div>
  @endif

  <!-- Form -->
  <form id="checkoutForm" action="{{ route('checkout.place') }}" method="POST" novalidate>
    @csrf

    <div class="checkout-grid">
      
      <!-- Left Column -->
      <div style="display:flex;flex-direction:column;">
        
        <!-- Address Card -->
        <div class="card">
          <div class="card-header">
            <div class="card-header-icon">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            <h2>Alamat Pengiriman</h2>
          </div>
          <div class="card-body">
            @if($addresses->isEmpty())
              <div class="empty-state">
                <div class="empty-state-icon">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  </svg>
                </div>
                <p>Belum ada alamat pengiriman yang tersimpan</p>
                <a href="{{ route('profile.edit') }}#address" class="btn btn-outline">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Tambah Alamat Baru
                </a>
              </div>
            @else
              <div class="address-list">
                @foreach($addresses as $addr)
                  <label class="address-item">
                    <input type="radio" name="address_id" value="{{ $addr->id }}" {{ $addr->is_primary ? 'checked' : '' }}>
                    <div class="address-content">
                      <div class="address-header">
                        <span class="address-label">{{ $addr->label ?? 'Alamat' }}</span>
                        @if($addr->is_primary)
                          <span class="badge-primary">UTAMA</span>
                        @endif
                      </div>
                      
                      <div class="address-recipient-name">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                          <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        {{ Auth::user()->name }}
                      </div>
                      
                      <div class="address-detail">
                        {{ $addr->address_full }}{{ $addr->village ? ', ' . $addr->village : '' }}{{ $addr->subdistrict ? ', ' . $addr->subdistrict : '' }}{{ $addr->city ? ', ' . $addr->city : '' }}{{ $addr->province ? ', ' . $addr->province : '' }}{{ $addr->postal_code ? ' - ' . $addr->postal_code : '' }}
                      </div>
                      
                      <div class="address-phone">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        {{ $addr->phone_country ?? '' }} {{ $addr->phone ?? '' }}
                      </div>
                    </div>
                  </label>
                @endforeach
              </div>
              
              <a href="{{ route('profile.edit') }}#address" class="btn btn-outline" style="width:100%;margin-top:16px;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M12 4v16m8-8H4"></path>
                </svg>
                Kelola Alamat
              </a>
            @endif
          </div>
        </div>

        <!-- Shipping Card -->
        <div class="card">
          <div class="card-header">
            <div class="card-header-icon">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="1" y="3" width="22" height="13" rx="2"></rect>
                <path d="M16 21h2a2 2 0 0 0 2-2v-3"></path>
                <path d="M8 21H6a2 2 0 0 1-2-2v-3"></path>
              </svg>
            </div>
            <h2>Metode Pengiriman</h2>
          </div>

          <div class="card-body">
            <div class="shipping-list">
              @forelse($shippingMethods as $method)
                @php
                  $price = $method->products->first()->pivot->price ?? 0;
                @endphp

                <label class="shipping-item">
                  <input
                    type="radio"
                    name="shipping_method"
                    value="{{ $method->code }}"
                    data-price="{{ $price }}"
                    data-courier="{{ $method->name }}"
                    class="shipping-radio"
                  >

                  <div class="shipping-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M3 7h13v10H3z"></path>
                      <path d="M16 10h4l1 2v5h-5z"></path>
                      <circle cx="7.5" cy="17.5" r="1.5"></circle>
                      <circle cx="17.5" cy="17.5" r="1.5"></circle>
                    </svg>
                  </div>

                  <div class="shipping-content">
                    <div class="shipping-name">{{ $method->name }}</div>
                    <div class="shipping-eta">
                      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 6v6l4 2"></path>
                      </svg>
                      {{ $method->description }}
                    </div>
                  </div>

                  <div class="shipping-cost">
                    Rp {{ number_format($price, 0, ',', '.') }}
                  </div>
                </label>

              @empty
                <div class="empty-state">
                  <div class="empty-state-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="8" y1="15" x2="16" y2="15"></line>
                    </svg>
                  </div>
                  <p>Tidak ada metode pengiriman tersedia</p>
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <input type="hidden" name="shipping_cost" id="shipping_cost">
        <input type="hidden" name="shipping_courier" id="shipping_courier">

        <!-- Notes Card -->
        <div class="card">
          <div class="card-header">
            <div class="card-header-icon">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
              </svg>
            </div>
            <h2>Catatan Pesanan</h2>
          </div>
          <div class="card-body">
            <div class="notes-label">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
              </svg>
              Tambahkan catatan untuk penjual (opsional)
            </div>
            <textarea name="notes" class="notes-textarea" rows="4" placeholder="Contoh: Tolong bungkus dengan rapih dan sertakan kartu ucapan. Terima kasih!"></textarea>
          </div>
        </div>

      </div>

      <!-- Right Column - Summary -->
      <div class="card">
        <div class="card-header">
          <div class="card-header-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
          </div>
          <h2>Ringkasan Pesanan</h2>
        </div>
        <div class="card-body" style="padding: 0;">
          
          <!-- Products List -->
          <div class="summary-items-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
              <path d="M3 9h18"></path>
              <path d="M9 21V9"></path>
            </svg>
            Produk Dipesan
          </div>
          
          <div class="product-list">
            @foreach($cart as $c)
              <div class="product-item">
                <div class="product-image">
                  @if(!empty($c['image']))
                    <img src="{{ asset('storage/' . ltrim($c['image'], '/')) }}" alt="{{ $c['name'] }}">
                  @else
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="32" height="32" style="color:#adb5bd;">
                      <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                      <circle cx="8.5" cy="8.5" r="1.5"></circle>
                      <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                  @endif
                </div>
                <div class="product-info">
                  <div class="product-name">{{ $c['name'] }}</div>
                  @if(!empty($c['variant']))
                    <div class="product-variant-row">
                      @if(is_array($c['variant']))
                        @foreach($c['variant'] as $v)
                          <span class="product-variant">{{ $v }}</span>
                        @endforeach
                      @else
                        <span class="product-variant">{{ $c['variant'] }}</span>
                      @endif
                    </div>
                  @endif

                  <div class="product-footer">
                    <div class="product-qty">× {{ $c['qty'] }}</div>
                    <div class="product-price-section">
                      @if($c['qty'] > 1)
                        <div class="product-unit-price">@ Rp {{ number_format($c['price'] ?? 0,0,',','.') }}</div>
                      @endif
                      <div class="product-total-price">Rp {{ number_format(($c['price'] ?? 0) * $c['qty'],0,',','.') }}</div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Summary Calculation -->
          <div class="summary-calculation">
            <div class="summary-row">
              <span class="summary-label">Subtotal Produk</span>
              <span class="summary-value" id="subtotal_display">Rp {{ number_format($subtotal,0,',','.') }}</span>
            </div>
            
            <div class="summary-row">
              <span class="summary-label">Ongkos Kirim</span>
              <span class="summary-value" id="shipping_display">Rp 0</span>
            </div>
          </div>
          
          <div class="summary-total-row">
            <span class="summary-total-label">Total Pembayaran</span>
            <span class="summary-total-value" id="total_display">Rp {{ number_format($subtotal,0,',','.') }}</span>
          </div>

          <!-- Submit Button -->
          <div style="padding: 20px;">
            <button id="placeOrderBtn" class="btn btn-primary" type="submit" style="width:100%;" disabled>
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="9 11 12 14 22 4"></polyline>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
              </svg>
              Proses Pembayaran
            </button>

            <!-- Info Box -->
            <div class="info-box">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
              </svg>
              <div>
                Pastikan data pengiriman sudah benar sebelum melanjutkan pembayaran.
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </form>
</div>

<script>
(function(){
  
  const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
  const shippingCostInput = document.getElementById('shipping_cost');
  const shippingCourierInput = document.getElementById('shipping_courier');
  const shippingDisplay = document.getElementById('shipping_display');
  const subtotal = Number(@json($subtotal)) || 0;
  const totalDisplay = document.getElementById('total_display');
  const placeBtn = document.getElementById('placeOrderBtn');
  const checkoutForm = document.getElementById('checkoutForm');

  function formatRupiah(n){
    return 'Rp ' + Number(n).toLocaleString('id-ID');
  }

  function updateShippingAndTotal(){
    let selected = document.querySelector('input[name="shipping_method"]:checked');
    let cost = 0;
    let courier = '';
    
    if (selected) {
      cost = Number(selected.dataset.price || 0);
      courier = selected.dataset.courier || '';
    }
    
    shippingCostInput.value = cost;
    shippingCourierInput.value = courier;
    shippingDisplay.textContent = formatRupiah(cost);
    totalDisplay.textContent = formatRupiah(subtotal + cost);
    
    const addressSelected = !!document.querySelector('input[name="address_id"]:checked');
    placeBtn.disabled = !(addressSelected && !!selected);
  }

  // Auto-check first address
  const addressRadios = document.querySelectorAll('input[name="address_id"]');
  if (addressRadios.length && !document.querySelector('input[name="address_id"]:checked')) {
    addressRadios[0].checked = true;
  }

  updateShippingAndTotal();

  shippingRadios.forEach(r => {
    r.addEventListener('change', updateShippingAndTotal);
  });

  addressRadios.forEach(a => {
    a.addEventListener('change', updateShippingAndTotal);
  });

  // Form submit handler
  let isSubmitting = false;
  
  checkoutForm.addEventListener('submit', function(e){
    const sc = shippingCostInput.value;
    const courier = shippingCourierInput.value;
    
    if (sc === '') {
      const sel = document.querySelector('input[name="shipping_method"]:checked');
      shippingCostInput.value = sel ? sel.dataset.price : 0;
      shippingCourierInput.value = sel ? sel.dataset.courier : '';
    }

    const addressSelected = !!document.querySelector('input[name="address_id"]:checked');
    if (!addressSelected) {
      e.preventDefault();
      alert('Silakan pilih alamat pengiriman terlebih dahulu.');
      return false;
    }

    if (!courier) {
      e.preventDefault();
      alert('Silakan pilih metode pengiriman terlebih dahulu.');
      return false;
    }

    // Mark as submitting to prevent cache clear
    isSubmitting = true;
    
    placeBtn.disabled = true;
    placeBtn.innerHTML = `
      <svg style="animation:spin 1s linear infinite;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20">
        <line x1="12" y1="2" x2="12" y2="6"></line>
        <line x1="12" y1="18" x2="12" y2="22"></line>
        <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
        <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
        <line x1="2" y1="12" x2="6" y2="12"></line>
        <line x1="18" y1="12" x2="22" y2="12"></line>
        <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
        <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
      </svg>
      Memproses Pesanan...
    `;
  });
  
  // ====== CLEAR CACHE ON PAGE LEAVE ======
  
  // Function to clear checkout cache (client-side)
  function clearClientCache() {
    try {
      // Clear localStorage items related to checkout
      const checkoutKeys = [
        'checkout_data',
        'checkout_address',
        'checkout_shipping',
        'checkout_notes',
        'cart_data',
        'selected_address',
        'selected_shipping'
      ];
      
      checkoutKeys.forEach(key => {
        localStorage.removeItem(key);
      });
      
      // Clear sessionStorage
      sessionStorage.removeItem('checkout_session');
      sessionStorage.removeItem('checkout_temp');
      
      console.log('✓ Client cache cleared');
    } catch (error) {
      console.error('Failed to clear client cache:', error);
    }
  }
  
  // Function to clear server-side cache/session
  function clearServerCache() {
    // Don't clear if form is being submitted
    if (isSubmitting) {
      return;
    }

    // Use Beacon API for reliable request even when page is closing
    if (navigator.sendBeacon) {
      const formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      const beaconSent = navigator.sendBeacon('{{ route("checkout.clear") }}', formData);
      console.log('✓ Server cache clear beacon sent:', beaconSent);
    } else {
      // Fallback for browsers that don't support Beacon
      fetch('{{ route("checkout.clear") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({}),
        keepalive: true // Keep request alive even after page unload
      })
      .then(response => response.json())
      .then(data => console.log('✓ Server cache cleared:', data))
      .catch(err => console.log('Server cache clear failed:', err));
    }
  }
  
  // Combined cache clearing function
  function clearAllCache() {
    if (!isSubmitting) {
      clearClientCache();
      clearServerCache();
    }
  }
  
  // Clear cache when page is being unloaded (close tab, navigate away)
  window.addEventListener('beforeunload', function(e) {
    clearAllCache();
  });

  // Clear cache when user navigates away using browser back/forward  
  window.addEventListener('pagehide', function(e) {
    clearAllCache();
  });

  // Clear cache when visibility changes (tab switch, minimize)
  document.addEventListener('visibilitychange', function() {
    if (document.hidden && !isSubmitting) {
      clearAllCache();
    }
  });

  // Clear cache on page load (in case user hit back button)
  window.addEventListener('load', function() {
    if (!isSubmitting) {
      clearClientCache(); // Only clear client cache on load
    }
  });

  // Also clear cache when navigating away using popstate
  window.addEventListener('popstate', function() {
    clearAllCache();
  });

  console.log('✓ Checkout cache clearing initialized');
  
})();
</script>
@endsection