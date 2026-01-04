@extends('layouts.nav_masterdashboard')

@section('title', 'Pengelola Pesanan')
@section('page-title', 'Pengelola Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<style>
:root {
  --primary: #7c3aed;
  --primary-light: #f3f0ff;
  --primary-dark: #5b21b6;
  --secondary: #8b5cf6;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --border: #e2e8f0;
  --card-bg: #ffffff;
  --hover-bg: #f8fafc;
}

/* Dashboard Header */
.dashboard-header {
  background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
  border-radius: 20px;
  padding: 28px 32px;
  margin-bottom: 24px;
  color: white;
  position: relative;
  overflow: hidden;
}

.dashboard-header::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
}

.dashboard-header h1 {
  font-size: 28px;
  font-weight: 800;
  margin-bottom: 6px;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  letter-spacing: -0.02em;
  position: relative;
  z-index: 1;
}

.dashboard-header p {
  font-size: 14px;
  opacity: 0.9;
  font-weight: 500;
  position: relative;
  z-index: 1;
}

/* Stat Cards */
.stat-cards-container {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
  margin-bottom: 28px;
}

.stat-card {
  background: linear-gradient(135deg, var(--card-bg) 0%, #fdfcff 100%);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 20px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--primary) 0%, transparent 100%);
  opacity: 0;
  transition: opacity 0.3s;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 24px rgba(124, 58, 237, 0.12);
  border-color: rgba(124, 58, 237, 0.2);
}

.stat-card:hover::before {
  opacity: 1;
}

.stat-content {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
}

.stat-left {
  flex: 1;
}

.stat-value {
  font-size: 28px;
  font-weight: 800;
  line-height: 1;
  color: #0f172a;
  margin-bottom: 4px;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.stat-label {
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  display: flex;
  align-items: center;
  gap: 6px;
}

.stat-label svg {
  width: 14px;
  height: 14px;
}

.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}

/* Status Badges */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: 16px;
  font-weight: 600;
  font-size: 12px;
  line-height: 1;
  white-space: nowrap;
  transition: all 0.3s;
  border: 1px solid transparent;
}

.status-badge span {
  display: flex;
  align-items: center;
  gap: 4px;
}

.status-badge svg {
  width: 12px;
  height: 12px;
}

.badge-pending { 
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  color: #92400e;
  border-color: rgba(146, 64, 14, 0.15);
}

.badge-waiting { 
  background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
  color: #9a3412;
  border-color: rgba(154, 52, 18, 0.15);
}

.badge-processing { 
  background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
  color: #3730a3;
  border-color: rgba(55, 48, 163, 0.15);
}

.badge-shipped { 
  background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
  color: #155e75;
  border-color: rgba(21, 94, 117, 0.15);
}

.badge-completed { 
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  color: #065f46;
  border-color: rgba(6, 95, 70, 0.15);
}

.badge-cancelled { 
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  color: #991b1b;
  border-color: rgba(153, 27, 27, 0.15);
}

/* Table Styling */
.dashboard-card {
  background: linear-gradient(135deg, var(--card-bg) 0%, #fdfcff 100%);
  border: 1px solid var(--border);
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
  transition: all 0.4s;
  overflow: hidden;
}

.dashboard-card:hover {
  box-shadow: 0 12px 32px rgba(124, 58, 237, 0.12);
}

.table-container {
  border-radius: 20px;
  overflow: hidden;
}

.order-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: transparent;
}

.order-table thead {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-bottom: 2px solid var(--border);
}

.order-table th {
  padding: 18px 24px;
  text-align: left;
  font-size: 12px;
  font-weight: 700;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  white-space: nowrap;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  border-bottom: none;
}

.order-table th:first-child {
  padding-left: 28px;
}

.order-table th:last-child {
  padding-right: 28px;
}

.order-table td {
  padding: 22px 24px;
  border-bottom: 1px solid rgba(226, 232, 240, 0.6);
  vertical-align: middle;
  transition: all 0.3s;
}

.order-table tbody tr {
  transition: all 0.3s;
}

.order-table tbody tr:hover {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  transform: translateX(4px);
}

.order-table tbody tr:hover td {
  border-color: rgba(124, 58, 237, 0.2);
}

.order-number {
  font-weight: 700;
  color: #0f172a;
  font-size: 15px;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.order-id {
  font-size: 12px;
  color: #94a3b8;
  margin-top: 4px;
  display: flex;
  align-items: center;
  gap: 4px;
}

.order-id svg {
  width: 12px;
  height: 12px;
}

.customer-name {
  font-weight: 600;
  color: #0f172a;
  font-size: 14px;
  margin-bottom: 2px;
}

.customer-email {
  font-size: 12px;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 4px;
}

.customer-email svg {
  width: 12px;
  height: 12px;
}

.order-date {
  font-size: 13px;
  color: #475569;
  font-weight: 500;
}

.order-amount {
  font-weight: 700;
  color: #0f172a;
  font-size: 15px;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Action Button */
.action-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: white;
  text-decoration: none;
  font-weight: 600;
  font-size: 13px;
  border-radius: 14px;
  transition: all 0.3s;
  border: 1px solid transparent;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.15);
}

.action-btn:hover {
  transform: translateY(-2px) scale(1.02);
  box-shadow: 0 8px 20px rgba(124, 58, 237, 0.25);
  border-color: rgba(255, 255, 255, 0.2);
}

.action-btn svg {
  width: 14px;
  height: 14px;
  stroke: currentColor;
  transition: transform 0.3s;
}

.action-btn:hover svg {
  transform: translateX(2px);
}

/* Empty State */
.empty-state {
  padding: 80px 20px;
  text-align: center;
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.empty-icon {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.8;
}

.empty-text {
  color: #64748b;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 8px;
}

.empty-subtext {
  color: #94a3b8;
  font-size: 14px;
  max-width: 250px;
  margin: 0 auto;
}

/* Pagination */
.pagination-container {
  padding: 20px 24px;
  border-top: 1px solid var(--border);
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  display: flex;
  justify-content: center;
}

/* Footer Stats */
.stats-footer {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-radius: 16px;
  padding: 16px 20px;
  margin-top: 20px;
  border: 1px solid var(--border);
}

.stats-footer-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.stats-footer-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.stats-footer-icon {
  width: 36px;
  height: 36px;
  background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stats-footer-icon svg {
  width: 18px;
  height: 18px;
  color: white;
}

.stats-footer-text h4 {
  font-size: 14px;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 2px;
}

.stats-footer-text p {
  font-size: 12px;
  color: #64748b;
}

.stats-footer-right {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: #64748b;
}

/* Responsive */
@media (max-width: 1280px) {
  .stat-cards-container {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 768px) {
  .stat-cards-container {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .dashboard-header {
    padding: 20px 24px;
  }
  
  .dashboard-header h1 {
    font-size: 24px;
  }
  
  .order-table th,
  .order-table td {
    padding: 16px;
  }
  
  .stats-footer-content {
    flex-direction: column;
    gap: 12px;
    text-align: center;
  }
  
  .stats-footer-left {
    flex-direction: column;
    text-align: center;
  }
}

@media (max-width: 480px) {
  .stat-cards-container {
    grid-template-columns: 1fr;
  }
  
  .stat-card {
    padding: 16px;
  }
  
  .stat-value {
    font-size: 24px;
  }
}
</style>

@php
  $totalOrders = $orders->total() ?? 0;
  $countByStatus = $orders->getCollection()->groupBy('status')->map->count();
@endphp

<!-- Dashboard Header -->
<div class="dashboard-header">
  <h1>Dashboard Pesanan</h1>
  <p>Kelola semua transaksi pelanggan dengan mudah</p>
</div>

<!-- STATISTIK CARDS - Lebih Kecil dan Rapih -->
<div class="stat-cards-container">
  <!-- Pesanan -->
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-left">
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          <span>Pesanan</span>
        </div>
      </div>
      <div class="stat-icon" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #3b82f6;">
        📊
      </div>
    </div>
  </div>

  <!-- Menunggu -->
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-left">
        <div class="stat-value">{{ ($countByStatus['pending'] ?? 0) + ($countByStatus['waiting_payment'] ?? 0) }}</div>
        <div class="stat-label">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>Menunggu</span>
        </div>
      </div>
      <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #f59e0b;">
        ⏳
      </div>
    </div>
  </div>

  <!-- Diproses -->
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-left">
        <div class="stat-value">{{ $countByStatus['processing'] ?? 0 }}</div>
        <div class="stat-label">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
          </svg>
          <span>Diproses</span>
        </div>
      </div>
      <div class="stat-icon" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #6366f1;">
        ⚙
      </div>
    </div>
  </div>

  <!-- Dikirim -->
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-left">
        <div class="stat-value">{{ $countByStatus['shipped'] ?? 0 }}</div>
        <div class="stat-label">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>Dikirim</span>
        </div>
      </div>
      <div class="stat-icon" style="background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%); color: #06b6d4;">
        🚚
      </div>
    </div>
  </div>

  <!-- Selesai -->
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-left">
        <div class="stat-value">{{ $countByStatus['completed'] ?? 0 }}</div>
        <div class="stat-label">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>Selesai</span>
        </div>
      </div>
      <div class="stat-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #10b981;">
        ✅
      </div>
    </div>
  </div>
</div>

<!-- ORDERS TABLE -->
<div class="dashboard-card table-container">
  <div class="overflow-x-auto">
    <table class="order-table">
      <thead>
        <tr>
          <th class="pl-6">Pesanan</th>
          <th>Pelanggan</th>
          <th>Item</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th class="pr-6 text-right">Kelola</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          @php
            $payment = $order->payment ?? null;
            $hasPaymentProof = ($payment && !empty($payment->proof_path));
            $paymentStatus = $payment->status ?? null;
            $orderStatus = $order->status ?? 'pending';

            $labelMap = [
              'pending' => 'Pesanan Masuk',
              'waiting_payment' => 'Menunggu Pembayaran',
              'waiting_confirm' => 'Konfirmasi Pembayaran',
              'processing' => 'Diproses',
              'shipped' => 'Dikirimkan',
              'completed' => 'Diterima',
              'cancelled' => 'Dibatalkan'
            ];
            
            $badgeMap = [
              'pending' => 'badge-pending',
              'waiting_payment' => 'badge-waiting',
              'waiting_confirm' => 'badge-waiting',
              'processing' => 'badge-processing',
              'shipped' => 'badge-shipped',
              'completed' => 'badge-completed',
              'cancelled' => 'badge-cancelled'
            ];

            if ($orderStatus === 'cancelled') {
              $displayLabel = $labelMap['cancelled'];
              $badgeClass = $badgeMap['cancelled'];
            } elseif (in_array($orderStatus, ['shipped', 'delivered'])) {
              $displayLabel = $labelMap['shipped'];
              $badgeClass = $badgeMap['shipped'];
            } elseif ($orderStatus === 'completed') {
              $displayLabel = $labelMap['completed'];
              $badgeClass = $badgeMap['completed'];
            } else {
              if (!$hasPaymentProof) {
                $displayLabel = $labelMap['waiting_payment'];
                $badgeClass = $badgeMap['waiting_payment'];
              } else {
                if (in_array($paymentStatus, ['waiting_confirm', 'waiting_confirmation', 'waiting'])) {
                  $displayLabel = $labelMap['waiting_confirm'];
                  $badgeClass = $badgeMap['waiting_confirm'];
                } elseif (in_array($paymentStatus, ['confirmed', 'paid'])) {
                  $displayLabel = $labelMap['processing'];
                  $badgeClass = $badgeMap['processing'];
                } else {
                  $displayLabel = $labelMap[$orderStatus] ?? ucfirst(str_replace('_', ' ', $orderStatus));
                  $badgeClass = $badgeMap[$orderStatus] ?? 'badge-pending';
                }
              }
            }
          @endphp

          <tr>
            <td class="pl-6">
              <div class="order-number">
                {{ $order->order_number ?: '#' . $order->id }}
              </div>
              <div class="order-id">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span>ID: {{ $order->id }}</span>
              </div>
            </td>

            <td>
              @if($order->user)
                <div class="customer-name">{{ $order->user->name }}</div>
                <div class="customer-email">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                  {{ $order->user->email }}
                </div>
              @else
                <span class="text-slate-400 italic">Tidak terdaftar</span>
              @endif
            </td>

            <td>
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                  </svg>
                </div>
                <span class="font-bold text-slate-900">
                  {{ $order->items_count ?? $order->items->count() }}
                </span>
              </div>
            </td>

            <td>
              <div class="order-amount">
                Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
              </div>
            </td>

            <td>
              <span class="status-badge {{ $badgeClass }}">
                <span>
                  @if(str_contains($badgeClass, 'pending'))
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  @elseif(str_contains($badgeClass, 'processing'))
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                  @elseif(str_contains($badgeClass, 'shipped'))
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                  @elseif(str_contains($badgeClass, 'completed'))
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  @endif
                  {{ $displayLabel }}
                </span>
              </span>
            </td>

            <td>
              <div class="order-date">
                {{ optional($order->created_at)->format('d M Y') }}
              </div>
              <div class="text-xs text-slate-400">
                {{ optional($order->created_at)->format('H:i') }}
              </div>
            </td>

            <td class="pr-6">
              <div class="text-right">
                <a href="{{ route('admin.orders.show', $order->id) }}#actions" class="action-btn">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                  Kelola
                </a>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <div class="empty-icon">📦</div>
                <div class="empty-text">Belum ada pesanan</div>
                <div class="empty-subtext">Semua pesanan akan muncul di sini</div>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($orders->hasPages())
    <div class="pagination-container">
      {{ $orders->links() }}
    </div>
  @endif
</div>

<!-- Footer Stats -->
<div class="stats-footer">
  <div class="stats-footer-content">
    <div class="stats-footer-left">
      <div class="stats-footer-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
      </div>
      <div class="stats-footer-text">
        <h4>Statistik Pesanan</h4>
        <p>Menampilkan {{ $orders->count() }} dari {{ $totalOrders }} pesanan</p>
      </div>
    </div>
    <div class="stats-footer-right">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <span>Diperbarui: {{ now()->format('H:i') }}</span>
    </div>
  </div>
</div>

</div>

<!-- JavaScript untuk efek stat cards -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Efek hover pada stat cards
  const statCards = document.querySelectorAll('.stat-card');
  statCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      const icon = this.querySelector('.stat-icon');
      if (icon) {
        icon.style.transform = 'scale(1.1)';
      }
    });
    
    card.addEventListener('mouseleave', function() {
      const icon = this.querySelector('.stat-icon');
      if (icon) {
        icon.style.transform = 'scale(1)';
      }
    });
  });
  
  // Efek ripple pada action button
  const actionButtons = document.querySelectorAll('.action-btn');
  actionButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      const ripple = document.createElement('span');
      ripple.style.position = 'absolute';
      ripple.style.borderRadius = '50%';
      ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
      ripple.style.transform = 'translate(-50%, -50%)';
      ripple.style.animation = 'ripple 0.6s linear';
      ripple.style.width = ripple.style.height = '0';
      
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      
      this.appendChild(ripple);
      
      setTimeout(() => ripple.remove(), 600);
    });
  });
  
  // Tambah style untuk ripple effect
  const style = document.createElement('style');
  style.textContent = `
    @keyframes ripple {
      to {
        width: 150px;
        height: 150px;
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);
});
</script>
@endsection