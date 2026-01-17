@extends('layouts.nav_masterdashboard')
@section('title', 'Lihat Pesanan')
@section('page-title', 'Lihat Pesanan')

@section('content')
<div class="admin-order-show">
@php
  // determine label + state for dynamic button
  $st = $order->status;
  $btn = ['label'=>'','class'=>'btn','disabled'=>false,'action'=>null];
  if (in_array($st, ['pending','waiting_payment'])) {
    $btn['label'] = 'Konfirmasi Pembayaran';
    $btn['class'] = 'btn btn-ghost';
    $btn['disabled'] = true;
  } elseif ($st === 'waiting_confirm') {
    $btn['label'] = 'Konfirmasi Pembayaran';
    $btn['class'] = 'btn';
    $btn['disabled'] = false;
    $btn['action'] = 'openProofModal';
  } elseif (in_array($st, ['processing'])) {
    $btn['label'] = 'Kirimkan Pesanan';
    $btn['class'] = 'btn';
    $btn['disabled'] = false;
    $btn['action'] = 'openTrackingModal';
  } elseif (in_array($st, ['shipped'])) {
    $btn['label'] = 'Kirimkan Catatan';
    $btn['class'] = 'btn btn-ghost';
    $btn['disabled'] = false;
    $btn['action'] = 'openNoteModal';
  } elseif ($st === 'completed') {
    $btn['label'] = 'Pesanan Selesai';
    $btn['class'] = 'btn btn-success';
    $btn['disabled'] = true;
  } elseif ($st === 'cancelled') {
    $btn['label'] = 'Pesanan Dibatalkan';
    $btn['class'] = 'btn btn-danger';
    $btn['disabled'] = true;
  } else {
    $btn['label'] = 'Aksi';
    $btn['class'] = 'btn';
    $btn['disabled'] = true;
  }

  // Label & badge mapping
  $labelMap = [
    'pending'=>'Pesanan Masuk',
    'waiting_payment'=>'Menunggu Pembayaran',
    'waiting_confirm'=>'Konfirmasi Pembayaran',
    'processing'=>'Pesanan Diproses',
    'shipped'=>'Pesanan Dikirimkan',
    'completed'=>'Pesanan Diterima',
    'cancelled'=>'Pesanan Dibatalkan'
  ];
  $badgeMap = [
    'pending'=>'badge-warn','waiting_payment'=>'badge-warn','waiting_confirm'=>'badge-warn','processing'=>'badge-primary',
    'shipped'=>'badge-info','completed'=>'badge-success','cancelled'=>'badge-cancel'
  ];

  $iconMap = [
    'pending' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
    'waiting_payment' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
    'waiting_confirm' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h11"/><path d="M17 2v4"/></svg>',
    'processing' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10v6a2 2 0 0 1-2 2H8"/><path d="M3 6h18"/><path d="M16 3v6"/></svg>',
    'shipped' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h13l4 4v6a1 1 0 0 1-1 1h-1"/><path d="M16 3v4"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="18.5" cy="17.5" r="1.5"/></svg>',
    'completed' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
    'cancelled' => '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
  ];
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
}

body {
  background: var(--bg-page);
  color: var(--text-primary);
  line-height: 1.6;
}

.admin-order-show {
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
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
}

.nav-left {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-title {
  font-size: 20px;
  font-weight: 800;
  color: var(--text-primary);
}

.nav-subtitle {
  font-size: 13px;
  color: var(--text-secondary);
}

.order-id-text {
  font-weight: 600;
  color: var(--primary);
}

.nav-actions {
  display: flex;
  gap: 8px;
  align-items: center;
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
  border: 1px solid var(--border-light);
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

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px 16px;
  border: none;
  border-radius: var(--radius);
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  background: var(--primary);
  color: white;
}

.btn svg {
  flex-shrink: 0;
}

.btn:hover:not(:disabled) {
  background: var(--primary-dark);
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-ghost {
  background: white;
  color: var(--text-primary);
  border: 1px solid var(--border);
  padding: 8px 14px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
}

.btn-ghost svg {
  flex-shrink: 0;
}

.btn-ghost:hover:not(:disabled) {
  background: var(--bg-page);
  border-color: var(--text-secondary);
}

.btn-success {
  background: var(--success);
  color: white;
}

.btn-success:hover:not(:disabled) {
  background: #059669;
}

.btn-danger {
  background: var(--danger);
  color: white;
}

.btn-danger:hover:not(:disabled) {
  background: #DC2626;
}

/* Info Section */
.info-section {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
}

.info-left {
  flex: 1;
}

.info-title {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 8px;
}

.info-text {
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 4px;
}

.info-right {
  text-align: right;
}

/* Address */
.address-box {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-light);
}

.address-title {
  font-weight: 700;
  margin-bottom: 8px;
}

.address-content {
  font-size: 13px;
  color: var(--text-secondary);
  line-height: 1.6;
}

/* Items List */
.items-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.item-box {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  border: 1px solid var(--border-light);
  border-radius: var(--radius);
  background: white;
  transition: all 0.2s;
  gap: 12px;
}

.item-box:hover {
  border-color: var(--border);
  box-shadow: var(--shadow-sm);
}

.item-image {
  width: 60px;
  height: 60px;
  border-radius: var(--radius-sm);
  overflow: hidden;
  background: var(--bg-page);
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid var(--border-light);
}

.item-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.item-left {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 0;
}

.item-info {
  flex: 1;
  min-width: 0;
}

.item-name {
  font-weight: 700;
  font-size: 14px;
  margin-bottom: 4px;
}

.item-meta {
  font-size: 13px;
  color: var(--text-secondary);
}

.item-right {
  text-align: right;
}

.item-price {
  font-weight: 800;
  font-size: 14px;
}

.item-label {
  font-size: 12px;
  color: var(--text-secondary);
}

/* Payment Section */
.payment-card-modern {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* Status Banner - Redesigned */
.payment-status-banner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  border-radius: var(--radius);
  border: 2px solid;
  gap: 12px;
}

.payment-status-confirmed,
.payment-status-paid {
  background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
  border-color: #10B981;
}

.payment-status-waiting_confirm,
.payment-status-waiting_confirmation,
.payment-status-waiting,
.payment-status-pending_cod {
  background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
  border-color: #F59E0B;
}

.payment-status-rejected,
.payment-status-declined {
  background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%);
  border-color: #EF4444;
}

.payment-status-content {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
}

.payment-status-icon-wrapper {
  width: 48px;
  height: 48px;
  background: white;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.payment-status-confirmed .payment-status-icon-wrapper svg,
.payment-status-paid .payment-status-icon-wrapper svg {
  stroke: #10B981;
}

.payment-status-waiting_confirm .payment-status-icon-wrapper svg,
.payment-status-waiting_confirmation .payment-status-icon-wrapper svg,
.payment-status-waiting .payment-status-icon-wrapper svg,
.payment-status-pending_cod .payment-status-icon-wrapper svg {
  stroke: #F59E0B;
}

.payment-status-rejected .payment-status-icon-wrapper svg,
.payment-status-declined .payment-status-icon-wrapper svg {
  stroke: #EF4444;
}

.payment-status-label-small {
  font-size: 11px;
  color: var(--text-secondary);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 2px;
}

.payment-status-value {
  font-size: 16px;
  font-weight: 800;
  color: var(--text-primary);
}

.cod-badge {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  background: white;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 700;
  color: var(--primary);
  border: 2px solid var(--primary);
  flex-shrink: 0;
}

.cod-badge svg {
  stroke: var(--primary);
}

/* Payment Details Grid */
.payment-details-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

.payment-info-box {
  padding: 16px;
  background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
  border: 1px solid var(--border-light);
  border-radius: var(--radius);
  transition: all 0.2s;
}

.payment-info-box:hover {
  border-color: var(--primary);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(14, 165, 233, 0.1);
}

.payment-info-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 10px;
}

.payment-info-icon {
  width: 32px;
  height: 32px;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.payment-info-icon svg {
  stroke: white;
}

.payment-info-label {
  font-size: 11px;
  color: var(--text-secondary);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.payment-info-value {
  font-size: 15px;
  color: var(--text-primary);
  font-weight: 700;
  word-break: break-word;
}

/* COD Waiting Section */
.payment-proof-section-cod {
  padding: 16px;
  background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
  border-radius: var(--radius);
  border: 2px dashed #F59E0B;
}

.cod-waiting-box {
  display: flex;
  gap: 14px;
  align-items: center;
}

.cod-waiting-icon {
  width: 52px;
  height: 52px;
  background: white;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
}

.cod-waiting-icon svg {
  stroke: #F59E0B;
}

.cod-waiting-content {
  flex: 1;
}

.cod-waiting-title {
  font-size: 14px;
  font-weight: 700;
  color: #92400E;
  margin-bottom: 4px;
}

.cod-waiting-text {
  font-size: 12px;
  color: #78350F;
  line-height: 1.5;
}

/* Proof Section */
.payment-proof-section {
  padding-top: 12px;
  border-top: 2px dashed var(--border);
}

.btn-view-proof {
  width: 100%;
  padding: 14px 18px;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: white;
  border: none;
  border-radius: var(--radius);
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: all 0.3s;
  box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
}

.btn-view-proof:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
}

.btn-view-proof svg {
  stroke: white;
}

.no-proof-box {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 16px;
  background: #FEF3C7;
  border-radius: var(--radius);
  color: #92400E;
  font-size: 13px;
  font-weight: 600;
  border: 1px dashed #F59E0B;
}

.no-proof-box svg {
  stroke: #F59E0B;
  flex-shrink: 0;
}

.no-payment-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  text-align: center;
  color: var(--text-secondary);
}

.no-payment-card svg {
  stroke: var(--text-disabled);
}

/* Responsive */
@media (max-width: 640px) {
  .payment-details-grid {
    grid-template-columns: 1fr;
  }
  
  .payment-status-banner {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .cod-badge {
    align-self: flex-start;
  }
}

/* Summary */
.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 0;
  font-size: 14px;
}

.summary-label {
  color: var(--text-secondary);
  font-size: 13px;
}

.summary-value {
  font-weight: 700;
  color: var(--text-primary);
}

.summary-total {
  padding-top: 12px;
  margin-top: 12px;
  border-top: 1px solid var(--border-light);
  font-size: 16px;
  font-weight: 800;
}

.summary-total-label {
  color: var(--text-secondary);
  font-size: 13px;
}

.summary-total-value {
  font-size: 18px;
  font-weight: 900;
  color: var(--primary);
}

/* Quick Actions */
.quick-actions {
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid var(--border-light);
}

.quick-actions-title {
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 10px;
}

.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.action-buttons .btn,
.action-buttons .btn-ghost,
.action-buttons .btn-success,
.action-buttons .btn-danger {
  width: 100%;
}

.tracking-info {
  margin-top: 12px;
  padding: 12px;
  background: var(--bg-page);
  border-radius: var(--radius);
}

.tracking-row {
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 6px;
}

.tracking-row:last-child {
  margin-bottom: 0;
}

/* Flash Messages */
.flash-message {
  margin-top: 12px;
  padding: 16px;
  border-radius: var(--radius);
  font-weight: 600;
}

.flash-success {
  background: #ECFDF5;
  color: #065F46;
  border: 1px solid #A7F3D0;
}

.flash-error {
  background: #FEF2F2;
  color: #991B1B;
  border: 1px solid #FECACA;
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 16px;
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.modal {
  background: white;
  border-radius: 12px;
  max-width: 600px;
  width: 100%;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  max-height: 85vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  animation: slideUp 0.3s ease-out;
}

.modal-large {
  max-width: 900px;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-header {
  padding: 20px 24px;
  border-bottom: 1px solid var(--border-light);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-shrink: 0;
  background: linear-gradient(to bottom, #ffffff, #fafbfc);
}

.modal-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--text-primary);
  display: flex;
  align-items: center;
  gap: 10px;
}

.modal-title::before {
  content: '';
  width: 4px;
  height: 24px;
  background: linear-gradient(to bottom, var(--primary), var(--secondary));
  border-radius: 2px;
}

.modal-close {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-page);
  border: none;
  cursor: pointer;
  border-radius: 8px;
  transition: all 0.2s;
  font-weight: 700;
  color: var(--text-secondary);
  font-size: 18px;
}

.modal-close:hover {
  background: #fee2e2;
  color: var(--danger);
  transform: rotate(90deg);
}

.modal-body {
  padding: 24px;
  overflow: auto;
  flex: 1;
}

.modal-body-centered {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.modal-body::-webkit-scrollbar {
  width: 8px;
}

.modal-body::-webkit-scrollbar-track {
  background: var(--bg-page);
  border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb {
  background: var(--border);
  border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
  background: var(--text-secondary);
}

.modal-actions {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--border-light);
}

.modal-actions .btn,
.modal-actions .btn-ghost {
  min-width: 120px;
}

.modal-footer-actions {
  display: flex;
  gap: 10px;
  width: 100%;
  padding-top: 20px;
  border-top: 1px solid var(--border-light);
}

.modal-footer-actions .btn,
.modal-footer-actions .btn-ghost {
  flex: 1;
}

/* Proof Image */
.img-proof {
  width: 100%;
  max-height: 400px;
  object-fit: contain;
  border: 2px solid var(--border-light);
  border-radius: var(--radius);
  background: var(--bg-page);
  padding: 8px;
}

.proof-image-container {
  width: 100%;
  max-height: 500px;
  border-radius: var(--radius);
  overflow: hidden;
  background: var(--bg-page);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
}

.img-proof-large {
  max-width: 100%;
  max-height: 500px;
  object-fit: contain;
  border-radius: var(--radius);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.proof-info {
  margin-top: 16px;
  padding: 16px;
  background: linear-gradient(135deg, #E0F2FE 0%, #E0E7FF 100%);
  border-radius: var(--radius);
  border-left: 4px solid var(--primary);
}

.proof-info-text {
  font-size: 14px;
  color: var(--text-primary);
  font-weight: 600;
}

.proof-info-card {
  width: 100%;
  padding: 20px;
  background: linear-gradient(135deg, #F0F9FF 0%, #EFF6FF 100%);
  border-radius: var(--radius);
  border: 2px solid var(--primary);
}

.proof-info-row {
  display: flex;
  align-items: center;
  gap: 12px;
}

.proof-info-icon {
  font-size: 28px;
}

.proof-info-icon-svg {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, rgba(14, 165, 233, 0.15), rgba(6, 182, 212, 0.15));
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.proof-info-icon-svg svg {
  stroke: var(--primary);
}

.proof-info-label {
  font-size: 12px;
  color: var(--text-secondary);
  font-weight: 500;
  margin-bottom: 4px;
}

.proof-info-value {
  font-size: 16px;
  color: var(--text-primary);
  font-weight: 700;
}

.proof-info-divider {
  height: 1px;
  background: linear-gradient(to right, transparent, var(--border), transparent);
  margin: 16px 0;
}

/* Form in Modal */
.modal-body .form-group {
  margin-bottom: 20px;
}

.modal-body label {
  display: flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
  font-size: 14px;
  margin-bottom: 8px;
  color: var(--text-primary);
}

.modal-body label::before {
  content: '';
  width: 3px;
  height: 16px;
  background: var(--primary);
  border-radius: 2px;
}

.modal-body input[type="text"],
.modal-body textarea {
  width: 100%;
  padding: 12px 14px;
  border: 2px solid var(--border-light);
  border-radius: var(--radius);
  font-size: 14px;
  transition: all 0.2s;
  font-family: inherit;
}

.modal-body input[type="text"]:focus,
.modal-body textarea:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

.modal-body textarea {
  resize: vertical;
  min-height: 100px;
}

.modal-body input::placeholder,
.modal-body textarea::placeholder {
  color: var(--text-disabled);
}

/* Action Buttons Styling */
.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.action-buttons form {
  width: 100%;
}

.action-buttons .btn,
.action-buttons .btn-success,
.action-buttons .btn-danger {
  width: 100%;
  justify-content: center;
  font-size: 15px;
  padding: 12px 20px;
  position: relative;
  overflow: hidden;
}

.action-buttons .btn::before,
.action-buttons .btn-success::before,
.action-buttons .btn-danger::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%);
  transition: width 0.4s, height 0.4s;
}

.action-buttons .btn:hover::before,
.action-buttons .btn-success:hover::before,
.action-buttons .btn-danger:hover::before {
  width: 300px;
  height: 300px;
}

/* Success/Danger button icons */
.action-buttons .btn-success {
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.action-buttons .btn-danger {
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Modal Sections */
.modal-section {
  padding: 16px;
  background: var(--bg-page);
  border-radius: var(--radius);
  margin-bottom: 16px;
  border: 1px solid var(--border-light);
}

.modal-section-title {
  font-size: 14px;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.modal-section-title svg {
  stroke: var(--primary);
}

/* Form Elements */
label {
  display: block;
  font-weight: 600;
  font-size: 13px;
  margin-bottom: 6px;
  color: var(--text-primary);
}

input[type="text"],
textarea,
select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  font-size: 14px;
  transition: border-color 0.2s;
  font-family: inherit;
}

input[type="text"]:focus,
textarea:focus,
select:focus {
  outline: none;
  border-color: var(--primary);
}

textarea {
  resize: vertical;
  min-height: 80px;
}

.form-group {
  margin-bottom: 16px;
}

/* Divider */
.divider {
  height: 1px;
  background: var(--border-light);
  margin: 16px 0;
}

/* Utility */
.hidden { display: none !important; }
.text-center { text-align: center; }
.mb-2 { margin-bottom: 8px; }
.mt-2 { margin-top: 8px; }

/* Responsive */
@media (max-width: 768px) {
  .admin-order-show {
    padding: 12px;
  }
  
  .content-grid {
    grid-template-columns: 1fr;
  }
  
  .top-nav {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .nav-actions {
    width: 100%;
    flex-direction: column;
  }
  
  .nav-actions .btn,
  .nav-actions .btn-ghost {
    width: 100%;
  }
  
  .info-section {
    flex-direction: column;
  }
  
  .info-right {
    text-align: left;
    width: 100%;
  }
}
</style>

<!-- Top Navigation -->
<div class="top-nav">
  <div class="nav-left">
    <h2 class="nav-title">Detail Pesanan</h2>
    <div class="nav-subtitle">
      Order: <span class="order-id-text">{{ $order->order_number ?: '#'.$order->id }}</span>
    </div>
    <div class="nav-subtitle">
      Dibuat: {{ $order->created_at->format('d M Y, H:i') }}
    </div>
  </div>
  
  <div class="nav-actions">
    <a href="{{ route('admin.orders.index') }}" class="btn-ghost">
      <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
      Kembali
    </a>
    
    <button id="dynamicActionBtn"
      class="{{ $btn['class'] }}"
      @if($btn['disabled']) disabled aria-disabled="true" title="Tombol tidak aktif pada status ini" @endif
      data-action="{{ $btn['action'] ?? '' }}">
      {{ $btn['label'] }}
    </button>
  </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
  <!-- Left Column -->
  <div class="left-column">
    
    <!-- Buyer Info Card -->
    <div class="card">
      <div class="card-body">
        <div class="info-section">
          <div class="info-left">
            <div class="info-title">Informasi Pembeli</div>
            <div class="info-text">{{ $order->user?->name ?? '—' }} · {{ $order->user?->email ?? '—' }}</div>
            <div class="info-text">No. Pesanan: <strong>{{ $order->order_number ?: '#'.$order->id }}</strong></div>
          </div>
          
          <div class="info-right">
            <div class="badge {{ $badgeMap[$order->status] ?? 'badge-warn' }}">
              {!! $iconMap[$order->status] ?? $iconMap['pending'] !!}
              <span>{{ $labelMap[$order->status] ?? ucfirst($order->status) }}</span>
            </div>
            <div class="info-text mt-2">
              Terakhir: {{ $order->updated_at ? $order->updated_at->format('d M Y, H:i') : '-' }}
            </div>
          </div>
        </div>
        
        <div class="address-box">
          <div class="address-title">Alamat Pengiriman</div>
          <div class="address-content">
            @if($order->address)
              {!! e($order->address->address_full) !!}{{ $order->address->village ? ', '.$order->address->village : '' }}{{ $order->address->city ? ', '.$order->address->city : '' }}
              <div style="margin-top: 8px;">
                <strong>Penerima:</strong> {{ $order->address->recipient_name }} · {{ trim(($order->address->phone_country??'').' '.($order->address->phone??'')) }}
              </div>
            @else
              <div class="info-text">Tidak ada alamat pada pesanan ini.</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Items Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Items ({{ count($order->items) }})</div>
        <div class="card-subtitle">Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}</div>
      </div>
      <div class="card-body">
        <div class="items-list">
          @foreach($order->items as $it)
            <div class="item-box">
              <div class="item-left">
                <div class="item-image">
                  @if(!empty($it->meta['image']))
                    <img src="{{ asset('storage/'.ltrim($it->meta['image'],'/')) }}" alt="{{ $it->product_name }}">
                  @else
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="3" width="18" height="18" rx="2"/>
                      <circle cx="9" cy="9" r="2"/>
                      <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                    </svg>
                  @endif
                </div>
                <div class="item-info">
                  <div class="item-name">{{ $it->product_name }}</div>
                  <div class="item-meta">
                    Qty: {{ $it->qty }} · Rp {{ number_format($it->price,0,',','.') }} /pcs
                    @if(!empty($it->meta['variant']))
                      · Varian: 
                      @if(is_array($it->meta['variant']))
                        {{ implode(', ', $it->meta['variant']) }}
                      @else
                        {{ $it->meta['variant'] }}
                      @endif
                    @endif
                  </div>
                </div>
              </div>
              <div class="item-right">
                <div class="item-price">Rp {{ number_format($it->subtotal,0,',','.') }}</div>
                <div class="item-label">Subtotal</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Payment Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
            <line x1="1" y1="10" x2="23" y2="10"/>
          </svg>
          Informasi Pembayaran
        </div>
      </div>
      <div class="card-body">
        @if($order->payment)
          @php
            $isCOD = $order->payment->method === 'cod';
            $hasProof = !empty($order->payment->proof_path);
            
            // Tentukan status untuk COD
            if ($isCOD && !$hasProof) {
              $displayStatus = 'pending_cod';
              $statusLabel = 'Menunggu Bukti';
              $statusIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
            } else {
              $displayStatus = $order->payment->status;
              if ($order->payment->status === 'confirmed' || $order->payment->status === 'paid') {
                $statusLabel = 'Dikonfirmasi';
                $statusIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
              } elseif ($order->payment->status === 'waiting_confirm' || $order->payment->status === 'waiting_confirmation') {
                $statusLabel = 'Menunggu Konfirmasi';
                $statusIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
              } elseif ($order->payment->status === 'rejected' || $order->payment->status === 'declined') {
                $statusLabel = 'Ditolak';
                $statusIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
              } else {
                $statusLabel = ucfirst($order->payment->status);
                $statusIcon = '<svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
              }
            }
          @endphp
          
          <div class="payment-card-modern">
            <!-- Status Banner -->
            <div class="payment-status-banner payment-status-{{ $displayStatus }}">
              <div class="payment-status-content">
                <div class="payment-status-icon-wrapper">
                  {!! $statusIcon !!}
                </div>
                <div>
                  <div class="payment-status-label-small">Status Pembayaran</div>
                  <div class="payment-status-value">{{ $statusLabel }}</div>
                </div>
              </div>
              
              @if($isCOD)
                <div class="cod-badge">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                  </svg>
                  COD
                </div>
              @endif
            </div>

            <!-- Payment Details Grid -->
            <div class="payment-details-grid">
              <div class="payment-info-box">
                <div class="payment-info-header">
                  <div class="payment-info-icon">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                      <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                  </div>
                  <div class="payment-info-label">Metode</div>
                </div>
                <div class="payment-info-value">
                  @if($order->payment->method === 'bank_transfer')
                    Transfer Bank
                  @elseif($order->payment->method === 'cod')
                    Cash on Delivery
                  @elseif($order->payment->method === 'manual_transfer')
                    Transfer Manual
                  @else
                    {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}
                  @endif
                </div>
              </div>

              <div class="payment-info-box">
                <div class="payment-info-header">
                  <div class="payment-info-icon">
                    <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="12" y1="1" x2="12" y2="23"/>
                      <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                  </div>
                  <div class="payment-info-label">Jumlah</div>
                </div>
                <div class="payment-info-value">Rp {{ number_format($order->payment->amount ?? 0,0,',','.') }}</div>
              </div>
            </div>

            <!-- Proof Section -->
            @if($isCOD && !$hasProof)
              <div class="payment-proof-section-cod">
                <div class="cod-waiting-box">
                  <div class="cod-waiting-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"/>
                      <polyline points="12 6 12 12 16 14"/>
                    </svg>
                  </div>
                  <div class="cod-waiting-content">
                    <div class="cod-waiting-title">Menunggu Bukti Pembayaran COD</div>
                    <div class="cod-waiting-text">Pembeli akan mengunggah bukti pembayaran setelah barang diterima</div>
                  </div>
                </div>
              </div>
            @elseif($hasProof)
              <div class="payment-proof-section">
                <button type="button" class="btn-view-proof" id="viewProofBtn">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                  Lihat Bukti Pembayaran
                </button>
              </div>
            @else
              <div class="payment-proof-section">
                <div class="no-proof-box">
                  <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                  </svg>
                  Belum ada bukti pembayaran
                </div>
              </div>
            @endif
          </div>
        @else
          <div class="no-payment-card">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div style="margin-top: 8px;">Belum ada informasi pembayaran</div>
          </div>
        @endif
      </div>
    </div>

  </div>

  <!-- Right Column -->
  <aside class="right-column">
    
    <!-- Summary Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Ringkasan Pembayaran</div>
        <div class="card-subtitle">Order ID: {{ $order->id }}</div>
      </div>
      <div class="card-body">
        <div class="summary-row">
          <span class="summary-label">Subtotal</span>
          <span class="summary-value">Rp {{ number_format($order->subtotal,0,',','.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Ongkir</span>
          <span class="summary-value">Rp {{ number_format($order->shipping_cost,0,',','.') }}</span>
        </div>
        <div class="summary-row summary-total">
          <span class="summary-total-label">Total</span>
          <span class="summary-total-value">Rp {{ number_format($order->total,0,',','.') }}</span>
        </div>
        
        <div class="quick-actions">
          <div class="quick-actions-title">Tindakan Cepat</div>
          
          @if($order->status === 'waiting_confirm')
            <div class="action-buttons">
              <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                @csrf
                <input type="hidden" name="action" value="approve_payment">
                <button class="btn btn-success" type="submit">Setujui Pembayaran</button>
              </form>

              <button class="btn btn-danger" id="quickRejectBtn">Tolak Pembayaran</button>
            </div>
          @endif

          @if($order->status === 'processing')
            <div class="action-buttons">
              <button class="btn" id="quickTrackingBtn">Isi No. Resi & Kirim</button>
            </div>
          @endif

          @if($order->status === 'shipped' || $order->tracking_number)
            <div class="tracking-info">
              <div class="tracking-row">
                <strong>Kurir:</strong> {{ $order->shipping_courier ?? $order->courier ?? '-' }}
              </div>
              <div class="tracking-row">
                <strong>Resi:</strong> {{ $order->tracking_number ?? '-' }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>

  </aside>
</div>

<!-- Flash Messages -->
@if(session('success'))
  <div class="flash-message flash-success">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="flash-message flash-error">
    {{ session('error') }}
  </div>
@endif

<!-- MODALS -->

<!-- View Proof Modal (Separate from Confirmation) -->
<div id="viewProofModal" class="hidden" aria-hidden="true">
  <div class="modal-overlay" role="dialog" aria-modal="true">
    <div class="modal modal-large" role="document">
      <div class="modal-header">
        <div class="modal-title">
          <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="12" cy="12" r="3"/>
            <path d="M16 8l3-3"/>
          </svg>
          Bukti Pembayaran
        </div>
        <button class="modal-close" onclick="closeModal('viewProofModal')" aria-label="Tutup">✕</button>
      </div>
      <div class="modal-body modal-body-centered">
        @if($order->payment && $order->payment->proof_path)
          <div class="proof-image-container">
            <img src="{{ asset(ltrim($order->payment->proof_path,'/')) }}" alt="Bukti Pembayaran" class="img-proof-large" />
          </div>
          
          <div class="proof-info-card">
            <div class="proof-info-row">
              <div class="proof-info-icon-svg">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="1" x2="12" y2="23"/>
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
              </div>
              <div>
                <div class="proof-info-label">Jumlah Transfer</div>
                <div class="proof-info-value">Rp {{ number_format($order->payment->amount ?? 0,0,',','.') }}</div>
              </div>
            </div>
            <div class="proof-info-divider"></div>
            <div class="proof-info-row">
              <div class="proof-info-icon-svg">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                  <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
              </div>
              <div>
                <div class="proof-info-label">Metode Pembayaran</div>
                <div class="proof-info-value">
                  @if($order->payment->method === 'bank_transfer')
                    Transfer Bank
                  @elseif($order->payment->method === 'cod')
                    Cash on Delivery (COD)
                  @else
                    {{ ucfirst($order->payment->method) }}
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer-actions">
            <a href="{{ asset(ltrim($order->payment->proof_path,'/')) }}" target="_blank" class="btn-ghost">
              <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
              </svg>
              Download Bukti
            </a>
            <button class="btn" onclick="closeModal('viewProofModal')">Tutup</button>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Proof Modal -->
<div id="proofModal" class="hidden" aria-hidden="true">
  <div class="modal-overlay" role="dialog" aria-modal="true">
    <div class="modal" role="document">
      <div class="modal-header">
        <div class="modal-title">
          <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="12" cy="12" r="3"/>
            <path d="M16 8l3-3"/>
          </svg>
          Konfirmasi Pembayaran
        </div>
        <button class="modal-close" onclick="closeModal('proofModal')" aria-label="Tutup">✕</button>
      </div>
      <div class="modal-body">
        @if($order->payment && $order->payment->proof_path)
          <div class="modal-section">
            <img src="{{ asset(ltrim($order->payment->proof_path,'/')) }}" alt="Bukti Pembayaran" class="img-proof" />
          </div>
          
          <div class="proof-info">
            <div class="proof-info-text">
              💰 Jumlah: <strong>Rp {{ number_format($order->payment->amount ?? 0,0,',','.') }}</strong>
            </div>
            <div class="proof-info-text" style="margin-top: 6px;">
              💳 Metode: <strong>{{ $order->payment->method ?? '-' }}</strong>
            </div>
          </div>
        @else
          <div class="info-text">Tidak ada bukti pembayaran.</div>
        @endif

        <div class="divider"></div>

        <div class="action-buttons">
          <form id="approveForm" method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
            @csrf
            <input type="hidden" name="action" value="approve_payment">
            <button class="btn btn-success" type="submit">
              <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              Setujui Pembayaran
            </button>
          </form>

          <form id="rejectForm" method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
            @csrf
            <input type="hidden" name="action" value="reject_payment">
            <div class="form-group">
              <label for="reject_note">
                Catatan Penolakan
              </label>
              <textarea name="note" id="reject_note" rows="3" placeholder="Contoh: Bukti tidak jelas atau nominal tidak sesuai"></textarea>
            </div>
            <div class="modal-actions">
              <button class="btn-ghost" type="button" onclick="closeModal('proofModal')">Batal</button>
              <button class="btn btn-danger" type="submit" onclick="return confirm('Tolak bukti pembayaran?')">
                <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="18" y1="6" x2="6" y2="18"/>
                  <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
                Tolak Pembayaran
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tracking Modal -->
<div id="trackingModal" class="hidden" aria-hidden="true">
  <div class="modal-overlay" role="dialog" aria-modal="true">
    <div class="modal" role="document">
      <div class="modal-header">
        <div class="modal-title">
          <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="1" y="3" width="15" height="13"/>
            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
            <circle cx="5.5" cy="18.5" r="2.5"/>
            <circle cx="18.5" cy="18.5" r="2.5"/>
          </svg>
          Kirimkan Pesanan
        </div>
        <button class="modal-close" onclick="closeModal('trackingModal')" aria-label="Tutup">✕</button>
      </div>
      <div class="modal-body">
        <form id="trackingForm" method="POST" action="{{ route('admin.orders.setTracking', $order->id) }}">
          @csrf
          <div class="form-group">
            <label for="modal_courier">
              Nama Kurir Pengiriman
            </label>
            <input type="text" name="courier" id="modal_courier" value="{{ $order->shipping_courier ?? $order->courier ?? 'Belum ada kurir' }}" readonly style="background: var(--bg-page); cursor: not-allowed;">
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 6px; display: flex; align-items: center; gap: 6px;">
              <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 16v-4"/>
                <path d="M12 8h.01"/>
              </svg>
              Kurir ditentukan oleh pembeli saat checkout
            </div>
          </div>

          <div class="form-group">
            <label for="modal_tracking">
              Nomor Resi / Tracking Number
            </label>
            <input type="text" name="tracking_number" id="modal_tracking" value="{{ $order->tracking_number ?? '' }}" placeholder="Masukkan nomor resi pengiriman">
          </div>

          <div class="modal-actions">
            <button class="btn-ghost" type="button" onclick="closeModal('trackingModal')">Batal</button>
            <button class="btn" type="submit">
              <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
              </svg>
              Simpan & Kirim
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Note Modal -->
<div id="noteModal" class="hidden" aria-hidden="true">
  <div class="modal-overlay" role="dialog" aria-modal="true">
    <div class="modal" role="document">
      <div class="modal-header">
        <div class="modal-title">
          <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
          </svg>
          Kirimkan Catatan
        </div>
        <button class="modal-close" onclick="closeModal('noteModal')" aria-label="Tutup">✕</button>
      </div>
      <div class="modal-body">
        <form id="noteForm" method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
          @csrf
          <input type="hidden" name="status" value="{{ $order->status }}">
          <div class="form-group">
            <label for="admin_note">
              Catatan untuk Pembeli
            </label>
            <textarea name="note" id="admin_note" rows="5" placeholder="Tulis catatan atau informasi tambahan untuk pembeli...&#10;&#10;Contoh: Pesanan akan segera sampai, terima kasih sudah berbelanja!"></textarea>
          </div>

          <div class="modal-actions">
            <button class="btn-ghost" type="button" onclick="closeModal('noteModal')">Batal</button>
            <button class="btn" type="submit">
              <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
              </svg>
              Kirim Catatan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div>

<script>
(function(){
  'use strict';
  
  // Helpers
  function $(s) { return document.querySelector(s); }
  function $all(s) { return Array.from(document.querySelectorAll(s)); }
  
  function openModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('hidden');
    el.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
  
  function closeModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.add('hidden');
    el.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
  
  window.closeModal = closeModal;

  // Dynamic Action Button
  const dynBtn = $('#dynamicActionBtn');
  if (dynBtn) {
    dynBtn.addEventListener('click', function(e) {
      const action = dynBtn.dataset.action || '';
      if (!action) return;
      if (action === 'openProofModal') openModal('proofModal');
      if (action === 'openTrackingModal') openModal('trackingModal');
      if (action === 'openNoteModal') openModal('noteModal');
    });
  }

  // View Proof Button
  const viewProofBtn = $('#viewProofBtn');
  if (viewProofBtn) {
    viewProofBtn.addEventListener('click', function() {
      openModal('viewProofModal');
    });
  }

  // Quick Reject Button
  const quickReject = $('#quickRejectBtn');
  if (quickReject) {
    quickReject.addEventListener('click', function() {
      openModal('proofModal');
      setTimeout(() => {
        const t = $('#reject_note');
        if (t) t.focus();
      }, 200);
    });
  }

  // Quick Tracking Button
  const quickTracking = $('#quickTrackingBtn');
  if (quickTracking) {
    quickTracking.addEventListener('click', function() {
      openModal('trackingModal');
      setTimeout(() => {
        const t = $('#modal_tracking');
        if (t) t.focus();
      }, 200);
    });
  }

  // Close modal on ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      ['proofModal', 'trackingModal', 'noteModal', 'viewProofModal'].forEach(id => {
        const el = document.getElementById(id);
        if (el && !el.classList.contains('hidden')) closeModal(id);
      });
    }
  });
  
  // Close modal on backdrop click
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) {
        const modal = overlay.closest('[id$="Modal"]');
        if (modal) closeModal(modal.id);
      }
    });
  });
})();
</script>

@endsection