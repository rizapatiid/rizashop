@extends('layouts.app')
@section('title', 'Riwayat Pemesanan')
@section('page-title', 'Riwayat Pemesanan')

@section('content')

@php
use Illuminate\Support\Facades\Route;
@endphp

<style>
:root{
  --bg:#e8f4f8;
  --border:#d4e8f0;
  --border-light:#e8f4f8;
  --muted:#6b7280;
  --accent:#ee4d2d;
  --accent-hover:#d73211;
  --text:#1e293b;
  --text-secondary:#475569;
  --card:#ffffff;
  --success:#00aa5b;
  --warning:#ffa500;
  --info:#03a9f4;
  --danger:#ee4d2d;
  --primary-gradient: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
  --header-bg: linear-gradient(135deg, #0ea5e9 0%, #f59e0b 100%);
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

* { 
  box-sizing: border-box; 
  margin: 0;
  padding: 0;
}

body {
  background: linear-gradient(135deg, #38bdf8 0%, #fbbf24 100%);
  color: var(--text);
  min-height: 100vh;
}

.container{ 
  max-width: 1200px; 
  margin: 0 auto; 
  padding: 24px 16px;
}

/* Header */
.page-header {
  background: var(--card);
  padding: 20px 24px;
  margin-bottom: 16px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
}

.page-title {
  font-size: 20px;
  font-weight: 600;
  color: var(--text);
  margin-bottom: 4px;
}

.page-subtitle {
  font-size: 13px;
  color: var(--muted);
}

/* Filter Tabs */
.filter-nav {
  background: var(--card);
  border-bottom: 2px solid var(--border);
  margin-bottom: 16px;
  overflow-x: auto;
  scrollbar-width: thin;
  box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
  border-radius: 8px;
}

.filter-nav::-webkit-scrollbar {
  height: 4px;
}

.filter-nav::-webkit-scrollbar-thumb {
  background: var(--border);
  border-radius: 2px;
}

.filter-tabs {
  display: flex;
  gap: 0;
  min-width: max-content;
}

.filter-tab {
  padding: 16px 24px;
  font-size: 14px;
  font-weight: 400;
  color: var(--text-secondary);
  text-decoration: none;
  border-bottom: 3px solid transparent;
  transition: all 0.2s;
  white-space: nowrap;
  position: relative;
}

.filter-tab:hover {
  color: #0ea5e9;
  background: rgba(14, 165, 233, 0.05);
}

.filter-tab.active {
  color: #0ea5e9;
  border-bottom-color: #0ea5e9;
  font-weight: 600;
  background: rgba(14, 165, 233, 0.05);
}

/* Order Card */
.order-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 8px;
  margin-bottom: 10px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
  transition: all 0.2s ease;
  cursor: pointer;
  position: relative;
}

.order-card:hover {
  box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
  border-color: #0ea5e9;
  transform: translateY(-2px);
}

.order-card-link {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1;
}

/* Card Header */
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  border-bottom: 1px solid var(--border-light);
  background: #f8fafc;
}

.order-meta {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 12px;
}

.order-number {
  color: var(--text);
  font-weight: 500;
  font-size: 13px;
}

.meta-divider {
  width: 1px;
  height: 10px;
  background: var(--border);
}

.order-date {
  color: var(--muted);
  font-size: 12px;
}

/* Status Badge */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 12px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.3px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.status-badge svg {
  width: 13px;
  height: 13px;
}

.status-waiting {
  background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
  color: #fff;
}

.status-processing {
  background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
  color: #fff;
}

.status-shipped {
  background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  color: #fff;
}

.status-completed {
  background: linear-gradient(135deg, #16a34a 0%, #10b981 100%);
  color: #fff;
}

.status-cancelled {
  background: linear-gradient(135deg, #ef4444 0%, #fb7185 100%);
  color: #fff;
}

/* Card Body */
.card-body {
  padding: 0;
}

/* Product List */
.product-list {
  padding: 12px 16px;
}

.product-item {
  display: flex;
  gap: 10px;
  padding: 10px 0;
  border-bottom: 1px solid var(--border-light);
}

.product-item:first-child {
  padding-top: 0;
}

.product-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.product-image {
  width: 60px;
  height: 60px;
  flex-shrink: 0;
  border: 1px solid var(--border-light);
  border-radius: 4px;
  overflow: hidden;
  background: #f8fafc;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--muted);
}

.product-placeholder svg {
  width: 24px;
  height: 24px;
  opacity: 0.3;
}

.product-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.product-name {
  font-size: 13px;
  color: var(--text);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-qty {
  font-size: 12px;
  color: var(--muted);
}

.more-products {
  text-align: center;
  padding: 10px 0 0;
  font-size: 12px;
  color: var(--muted);
}

/* Shipping Info */
.shipping-info {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 10px 16px;
  background: #f8fafc;
  border-top: 1px solid var(--border-light);
  border-bottom: 1px solid var(--border-light);
  font-size: 12px;
}

.shipping-info svg {
  width: 14px;
  height: 14px;
  color: var(--muted);
  flex-shrink: 0;
}

.shipping-text {
  color: var(--text-secondary);
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 12px;
}

.tracking-number {
  color: var(--text);
  font-weight: 500;
}

.copy-btn {
  background: none;
  border: none;
  padding: 3px;
  cursor: pointer;
  color: var(--muted);
  display: inline-flex;
  align-items: center;
  border-radius: 2px;
  transition: all 0.2s;
  position: relative;
  z-index: 2;
}

.copy-btn:hover {
  background: rgba(0,0,0,0.05);
  color: var(--accent);
}

.copy-btn svg {
  width: 13px;
  height: 13px;
}

/* Card Footer */
.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  border-top: 1px solid var(--border-light);
}

.total-section {
  display: flex;
  align-items: center;
  gap: 6px;
}

.total-label {
  font-size: 12px;
  color: var(--muted);
}

.total-amount {
  font-size: 16px;
  font-weight: 600;
  color: var(--accent);
}

/* Actions */
.card-actions {
  display: flex;
  gap: 6px;
  align-items: center;
  position: relative;
  z-index: 2;
}

.btn {
  padding: 8px 18px;
  min-height: 36px;
  border: none;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  white-space: nowrap;
  position: relative;
  z-index: 2;
  min-width: 120px;
}

.btn svg {
  width: 16px;
  height: 16px;
}

.btn-primary {
  background: var(--accent);
  color: white;
  box-shadow: 0 2px 6px rgba(238, 77, 45, 0.25);
}

.btn-primary:hover {
  background: var(--accent-hover);
  transform: translateY(-1px);
  box-shadow: 0 4px 10px rgba(238, 77, 45, 0.3);
}

.btn-secondary {
  background: white;
  color: var(--text-secondary);
  border: 1px solid var(--border);
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.btn-secondary:hover {
  background: #fafafa;
  border-color: var(--text-secondary);
  transform: translateY(-1px);
}

.btn-outline {
  background: white;
  color: var(--text-secondary);
  border: 1px solid var(--border);
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.btn-outline:hover {
  border-color: var(--accent);
  color: var(--accent);
  transform: translateY(-1px);
}

.btn-success {
  background: var(--success);
  color: white;
  box-shadow: 0 2px 6px rgba(0, 170, 91, 0.25);
}

.btn-success:hover {
  background: #008c4c;
  transform: translateY(-1px);
  box-shadow: 0 4px 10px rgba(0, 170, 91, 0.3);
}

.btn-link {
  background: transparent;
  color: var(--accent);
  padding: 8px 12px;
}

.btn-link:hover {
  background: rgba(238, 77, 45, 0.04);
}

/* Empty State */
.empty-state {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 60px 20px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
}

.empty-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 20px;
  color: var(--muted);
  opacity: 0.3;
}

.empty-title {
  font-size: 16px;
  color: var(--text);
  margin-bottom: 8px;
  font-weight: 500;
}

.empty-text {
  font-size: 14px;
  color: var(--muted);
}

/* Responsive */
@media (max-width: 1024px) {
  .container {
    padding: 16px 12px;
  }
}

@media (max-width: 768px) {
  .container {
    padding: 12px 8px;
  }

  .page-header {
    padding: 16px;
    margin-bottom: 12px;
  }

  .page-title {
    font-size: 18px;
  }

  .page-subtitle {
    font-size: 12px;
  }

  .filter-tab {
    padding: 14px 16px;
    font-size: 13px;
  }

  .card-header {
    flex-direction: row;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    padding: 12px;
  }

  .order-meta {
    flex-direction: column;
    gap: 6px;
    font-size: 11px;
    align-items: flex-start;
  }

  .meta-divider {
    display: none;
  }

  .order-number {
    font-size: 12px;
  }

  .order-date {
    font-size: 11px;
  }

  .status-badge {
    align-self: flex-start;
    font-size: 10px;
    padding: 4px 10px;
  }

  .status-badge svg {
    width: 12px;
    height: 12px;
  }

  .product-list {
    padding: 10px 12px;
  }

  .product-item {
    gap: 8px;
    padding: 8px 0;
  }

  .product-image {
    width: 50px;
    height: 50px;
  }

  .product-placeholder svg {
    width: 20px;
    height: 20px;
  }

  .product-name {
    font-size: 12px;
  }

  .product-qty {
    font-size: 11px;
  }

  .more-products {
    font-size: 11px;
    padding: 8px 0 0;
  }

  .shipping-info {
    padding: 8px 12px;
    font-size: 11px;
    flex-wrap: wrap;
  }

  .shipping-info svg {
    width: 13px;
    height: 13px;
  }

  .shipping-text {
    font-size: 11px;
  }

  .copy-btn svg {
    width: 12px;
    height: 12px;
  }

  .card-footer {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px;
  }

  .total-section {
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
  }

  .total-label {
    font-size: 11px;
  }

  .total-amount {
    font-size: 15px;
  }

  .card-actions {
    flex-direction: row;
    gap: 6px;
    width: auto;
  }

  .btn {
    width: auto;
    justify-content: center;
    min-width: auto;
    padding: 8px 14px;
    min-height: 36px;
    font-size: 12px;
  }

  .btn svg {
    width: 15px;
    height: 15px;
  }

  .empty-state {
    padding: 40px 16px;
  }

  .empty-icon {
    width: 60px;
    height: 60px;
  }

  .empty-title {
    font-size: 15px;
  }

  .empty-text {
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .container {
    padding: 8px 6px;
  }

  .page-header {
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 6px;
  }

  .page-title {
    font-size: 16px;
  }

  .page-subtitle {
    font-size: 11px;
  }

  .filter-nav {
    border-radius: 6px;
    margin-bottom: 10px;
  }

  .filter-tab {
    padding: 12px 14px;
    font-size: 12px;
    border-bottom-width: 2px;
  }

  .order-card {
    border-radius: 6px;
    margin-bottom: 8px;
  }

  .card-header {
    padding: 10px;
    gap: 6px;
  }

  .order-meta {
    gap: 4px;
  }

  .order-number {
    font-size: 11px;
  }

  .order-date {
    font-size: 10px;
  }

  .status-badge {
    font-size: 9px;
    padding: 3px 8px;
  }

  .status-badge svg {
    width: 11px;
    height: 11px;
  }

  .product-list {
    padding: 8px 10px;
  }

  .product-item {
    gap: 6px;
    padding: 6px 0;
  }

  .product-image {
    width: 45px;
    height: 45px;
    border-radius: 3px;
  }

  .product-placeholder svg {
    width: 18px;
    height: 18px;
  }

  .product-name {
    font-size: 11px;
    line-height: 1.3;
  }

  .product-qty {
    font-size: 10px;
  }

  .more-products {
    font-size: 10px;
  }

  .shipping-info {
    padding: 6px 10px;
    font-size: 10px;
  }

  .shipping-info svg {
    width: 12px;
    height: 12px;
  }

  .shipping-text {
    font-size: 10px;
  }

  .tracking-number {
    font-size: 10px;
  }

  .card-footer {
    padding: 10px;
    gap: 8px;
  }

  .total-section {
    gap: 2px;
  }

  .total-label {
    font-size: 10px;
  }

  .total-amount {
    font-size: 14px;
  }

  .card-actions {
    gap: 5px;
  }

  .btn {
    padding: 7px 12px;
    min-height: 34px;
    font-size: 11px;
    border-radius: 5px;
  }

  .btn svg {
    width: 14px;
    height: 14px;
  }

  .empty-state {
    padding: 30px 12px;
    border-radius: 6px;
  }

  .empty-icon {
    width: 50px;
    height: 50px;
    margin-bottom: 12px;
  }

  .empty-title {
    font-size: 14px;
  }

  .empty-text {
    font-size: 12px;
  }
}

/* Landscape Mobile */
@media (max-width: 768px) and (orientation: landscape) {
  .card-header {
    flex-direction: row;
    align-items: center;
  }

  .order-meta {
    flex-direction: row;
    align-items: center;
    gap: 10px;
  }

  .meta-divider {
    display: block;
  }

  .card-footer {
    flex-direction: row;
    align-items: center;
  }

  .total-section {
    flex-direction: row;
    align-items: center;
    gap: 6px;
  }

  .card-actions {
    flex-direction: row;
    width: auto;
  }

  .btn {
    width: auto;
    min-width: 100px;
  }
}

/* Tablet */
@media (min-width: 768px) and (max-width: 1024px) {
  .container {
    max-width: 100%;
    padding: 20px 16px;
  }

  .page-header {
    padding: 18px 20px;
  }

  .filter-tab {
    padding: 15px 20px;
  }

  .card-header {
    padding: 13px 18px;
  }

  .product-list {
    padding: 14px 18px;
  }

  .product-image {
    width: 70px;
    height: 70px;
  }

  .shipping-info {
    padding: 11px 18px;
  }

  .card-footer {
    padding: 14px 18px;
  }

  .btn {
    min-width: 130px;
    padding: 9px 20px;
  }
}

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  gap: 8px;
  padding: 20px 0;
}

@media (max-width: 768px) {
  .pagination {
    padding: 15px 0;
    gap: 6px;
  }
}

@media (max-width: 480px) {
  .pagination {
    padding: 10px 0;
    gap: 4px;
  }
}
</style>

<div class="container">

  <div class="page-header">
    <h1 class="page-title">Pesanan Saya</h1>
    <p class="page-subtitle">Cek pesanan anda yang sedang diproses dan dikirim</p>
  </div>

  <div class="filter-nav">
    <div class="filter-tabs">
      <a href="{{ route('orders.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
        Semua
      </a>
      <a href="{{ route('orders.index', ['status' => 'belum_bayar']) }}" class="filter-tab {{ request('status') == 'belum_bayar' ? 'active' : '' }}">
        Belum Bayar
      </a>
      <a href="{{ route('orders.index', ['status' => 'dikemas']) }}" class="filter-tab {{ request('status') == 'dikemas' ? 'active' : '' }}">
        Dikemas
      </a>
      <a href="{{ route('orders.index', ['status' => 'dikirim']) }}" class="filter-tab {{ request('status') == 'dikirim' ? 'active' : '' }}">
        Dikirim
      </a>
      <a href="{{ route('orders.index', ['status' => 'selesai']) }}" class="filter-tab {{ request('status') == 'selesai' ? 'active' : '' }}">
        Selesai
      </a>
      <a href="{{ route('orders.index', ['status' => 'dibatalkan']) }}" class="filter-tab {{ request('status') == 'dibatalkan' ? 'active' : '' }}">
        Dibatalkan
      </a>
    </div>
  </div>

  @forelse($orders as $order)
    @php
    $payment = $order->payment ?? null;
    $hasProof = $payment && !empty($payment->proof_path);
    $paymentStatus = $payment->status ?? null;
    $orderStatus = $order->status ?? null;

    // Status Logic
    $isWaitingPayment = !$hasProof && in_array($orderStatus, ['pending', 'waiting_payment']);
    $isWaitingConfirmation = $hasProof && in_array($paymentStatus, ['waiting_confirm', 'waiting']);
    $isApproved = $hasProof && in_array($paymentStatus, ['confirmed', 'paid']);
    $isRejected = ($hasProof && in_array($paymentStatus, ['rejected', 'declined', 'failed'])) || $orderStatus === 'need_confirmation';
    $isShipped = in_array($orderStatus, ['terkirim', 'shipped', 'delivered']);
    $isReceived = in_array($orderStatus, ['completed', 'received', 'diterima']);
    $isCancelled = $orderStatus === 'cancelled';

    // Status Display
    if ($isCancelled) {
      $statusLabel = 'Dibatalkan';
      $statusClass = 'status-cancelled';
      $statusIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    } elseif ($isReceived) {
      $statusLabel = 'Selesai';
      $statusClass = 'status-completed';
      $statusIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
    } elseif ($isShipped) {
      $statusLabel = 'Dikirim';
      $statusClass = 'status-shipped';
      $statusIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h13l4 4v6"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="18.5" cy="17.5" r="1.5"/></svg>';
    } elseif ($isApproved) {
      $statusLabel = 'Diproses';
      $statusClass = 'status-processing';
      $statusIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10h-7l-4-4H3v13h18V10z"/></svg>';
    } elseif ($isRejected || $isWaitingConfirmation) {
      $statusLabel = $isRejected ? 'Perlu Konfirmasi' : 'Menunggu Konfirmasi';
      $statusClass = 'status-waiting';
      $statusIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>';
    } else {
      $statusLabel = 'Menunggu Pembayaran';
      $statusClass = 'status-waiting';
      $statusIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>';
    }

    $carrier = $order->shipping_courier ?? 'Kurir';
    $resi = $order->tracking_number ?? '-';
    @endphp

    <div class="order-card">
      
      <a href="{{ route('orders.show', $order->id) }}" class="order-card-link"></a>
      
      <div class="card-header">
        <div class="order-meta">
          <span class="order-number">#{{ $order->order_number }}</span>
          <span class="meta-divider"></span>
          <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
        </div>
        <div class="status-badge {{ $statusClass }}">
          {!! $statusIcon !!}
          {{ $statusLabel }}
        </div>
      </div>

      <div class="card-body">
        
        <div class="product-list">
          @php
          $firstItem = $order->items->first();
          $totalItems = $order->items->count();
          $additionalItems = $totalItems - 1;
          @endphp
          
          @if($firstItem)
            <div class="product-item">
              <div class="product-image">
                @php
                $itemMeta = is_string($firstItem->meta) ? json_decode($firstItem->meta, true) : $firstItem->meta;
                $itemImage = isset($itemMeta['image']) ? $itemMeta['image'] : null;
                @endphp
                
                @if($itemImage)
                  <img src="{{ asset('storage/' . $itemImage) }}" alt="{{ $firstItem->product_name ?? 'Product' }}">
                @else
                  <div class="product-placeholder">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                      <circle cx="8.5" cy="8.5" r="1.5"/>
                      <polyline points="21 15 16 10 5 21"/>
                    </svg>
                  </div>
                @endif
              </div>
              <div class="product-details">
                <div class="product-name">{{ $firstItem->product_name ?? 'Produk' }}</div>
                <div class="product-qty">{{ $firstItem->qty }} barang</div>
              </div>
            </div>
            @if($additionalItems > 0)
              <div class="more-products">+{{ $additionalItems }} produk lainnya</div>
            @endif
          @endif
        </div>

        <div class="shipping-info">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
          </svg>
          <div class="shipping-text">
            <strong>{{ $carrier }}</strong>
            @if($resi !== '-')
              <span>•</span>
              <span class="tracking-number" id="resi-{{ $order->id }}">{{ $resi }}</span>
              <button class="copy-btn" onclick="copyResi('{{ $order->id }}', '{{ $resi }}')" title="Salin nomor resi">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                  <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                </svg>
              </button>
            @endif
          </div>
        </div>

      </div>

      <div class="card-footer">
        <div class="total-section">
          <span class="total-label">Total Pesanan:</span>
          <span class="total-amount">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>

        <div class="card-actions">
          @if($isCancelled)
            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-outline">Bukti Bayar</a>

          @elseif($isReceived)
            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-outline">Bukti Bayar</a>

          @elseif($isShipped)
            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-outline">Bukti Bayar</a>
            <form action="{{ route('orders.receive', $order->id) }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-success">Terima Pesanan</button>
            </form>

          @elseif($isWaitingPayment)
            <a href="{{ route('payments.create', $order->id) }}" class="btn btn-primary">Bayar Sekarang</a>
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-outline">Batalkan</button>
            </form>

          @elseif($isWaitingConfirmation)
            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-outline">Bukti Bayar</a>
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-outline">Batalkan</button>
            </form>

          @elseif($isApproved)
            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-outline">Bukti Bayar</a>

          @elseif($isRejected)
            <a href="{{ route('payments.create', $order->id) }}" class="btn btn-primary">Upload Ulang</a>
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-outline">Batalkan</button>
            </form>
          @endif
        </div>
      </div>

    </div>

  @empty
    <div class="empty-state">
      <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <circle cx="9" cy="21" r="1"/>
        <circle cx="20" cy="21" r="1"/>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
      </svg>
      <div class="empty-title">Belum ada pesanan</div>
      <div class="empty-text">Yuk, mulai belanja sekarang!</div>
    </div>
  @endforelse

  {{ $orders->links() }}

</div>

<script>
function copyResi(orderId, resi) {
  navigator.clipboard.writeText(resi).then(function() {
    const btn = event.currentTarget;
    const originalHTML = btn.innerHTML;
    
    btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
    btn.style.color = 'var(--success)';
    
    setTimeout(function() {
      btn.innerHTML = originalHTML;
      btn.style.color = '';
    }, 1500);
  }).catch(function(err) {
    console.error('Gagal menyalin:', err);
  });
}
</script>

@endsection