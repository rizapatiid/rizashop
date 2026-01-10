@extends('layouts.nav_masterdashboard')

@section('title', 'Pengelola Pesanan')
@section('page-title', 'Pengelola Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

<style>
/* ================= SIMPLE ORDER UI ================= */
.order-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    overflow:hidden;
}

/* ===== TOP BAR ===== */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:16px;
    flex-wrap:wrap;
}

.search-input{
    padding:10px 14px;
    border:1px solid #e5e7eb;
    border-radius:8px;
    font-size:14px;
    width:260px;
}

.filter-group{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.filter-btn{
    display:flex;
    align-items:center;
    gap:6px;
    padding:8px 12px;
    font-size:12px;
    border-radius:999px;
    border:1px solid #e5e7eb;
    background:#fff;
    cursor:pointer;
    font-weight:600;
    color:#374151;
}

.filter-btn svg{ width:14px;height:14px; }

.filter-btn.active,
.filter-btn:hover{
    background:#eef2ff;
    border-color:#6366f1;
    color:#4f46e5;
}

/* ===== TABLE ===== */
.table-wrap{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

.order-table{
    width:100%;
    min-width:1000px;
    border-collapse:collapse;
}

.order-table th{
    background:#f9fafb;
    padding:14px 16px;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#6b7280;
    text-align:left;
    border-bottom:1px solid #e5e7eb;
    white-space:nowrap;
}

.order-table td{
    padding:14px 16px;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
    white-space:nowrap;
}

.order-table tbody tr:hover{
    background:#f8fafc;
}

.order-number{ font-weight:600;color:#111827; }
.order-id{ font-size:12px;color:#9ca3af; }

.customer-name{ font-weight:600;font-size:14px; }
.customer-email{ font-size:12px;color:#6b7280; }

.order-amount{ font-weight:700;color:#111827; }
.order-date{ font-size:13px;color:#374151; }

/* ===== STATUS BADGE ===== */
.status-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.status-badge svg{ width:14px;height:14px; }

.badge-pending{ background:#fef3c7;color:#92400e; }
.badge-waiting{ background:#ffedd5;color:#9a3412; }
.badge-processing{ background:#e0e7ff;color:#3730a3; }
.badge-shipped{ background:#cffafe;color:#155e75; }
.badge-completed{ background:#d1fae5;color:#065f46; }
.badge-cancelled{ background:#fee2e2;color:#991b1b; }

/* ===== ACTION ===== */
.action-btn{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 12px;
    background:#6366f1;
    color:#fff;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
}

.action-btn svg{ width:14px;height:14px; }

.action-btn:hover{ background:#4f46e5; }

/* ===== EMPTY ===== */
.empty{
    padding:60px;
    text-align:center;
    color:#6b7280;
    font-weight:600;
}

/* ===== MOBILE ===== */
@media(max-width:768px){
    .order-card::after{
        content:"Geser ke samping →";
        display:block;
        text-align:right;
        font-size:12px;
        color:#6b7280;
        padding:6px 12px;
        background:#f9fafb;
    }
}
/* ===== ACTION (SAMA DENGAN EDIT PRODUK) ===== */
.action-manage{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:#eef2ff;
    color:#6366f1;
    border:1px solid #c7d2fe;
    text-decoration:none;
    transition:.2s;
}

.action-manage svg{
    width:14px;
    height:14px;
}

.action-manage:hover{
    background:#6366f1;
    color:#fff;
}

</style>

{{-- ================= TOP BAR ================= --}}
<div class="top-bar">
    <input type="text" id="searchInput" class="search-input"
           placeholder="Cari pesanan / pelanggan…">

    <div class="filter-group">
        <button class="filter-btn active" data-filter="all">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M3 4h18M3 12h18M3 20h18"/></svg>
            Semua
        </button>
        <button class="filter-btn" data-filter="pending" data-filter="waiting_confirm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M12 8v4l3 3"/></svg>
            Menunggu
        </button>
        <button class="filter-btn" data-filter="processing">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M19 11H5"/></svg>
            Diproses
        </button>
        <button class="filter-btn" data-filter="shipped">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M3 13l4 4L21 7"/></svg>
            Dikirim
        </button>
        <button class="filter-btn" data-filter="completed">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M9 12l2 2 4-4"/></svg>
            Selesai
        </button>
        <button class="filter-btn" data-filter="cancelled">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Batal
        </button>
    </div>
</div>

<div class="order-card">
<div class="table-wrap">
<table class="order-table" id="orderTable">
<thead>
<tr>
    <th>Pesanan</th>
    <th>Pelanggan</th>
    <th>Item</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tanggal</th>
    <th class="text-right">Aksi</th>
</tr>
</thead>
<tbody>
@forelse($orders as $order)
@php
/* ===== LOGIC STATUS ASLI (AMAN) ===== */
$payment = $order->payment ?? null;
$hasPaymentProof = ($payment && !empty($payment->proof_path));
$paymentStatus = $payment->status ?? null;
$orderStatus = $order->status ?? 'pending';

$labelMap = [
 'pending'=>'Pesanan Masuk','waiting_payment'=>'Menunggu Pembayaran',
 'waiting_confirm'=>'Konfirmasi Pembayaran','processing'=>'Diproses',
 'shipped'=>'Dikirimkan','completed'=>'Diterima','cancelled'=>'Dibatalkan'
];
$badgeMap = [
 'pending'=>'badge-pending','waiting_payment'=>'badge-waiting',
 'waiting_confirm'=>'badge-waiting','processing'=>'badge-processing',
 'shipped'=>'badge-shipped','completed'=>'badge-completed',
 'cancelled'=>'badge-cancelled'
];

if($orderStatus==='cancelled'){
 $displayLabel=$labelMap['cancelled'];$badgeClass=$badgeMap['cancelled'];
}elseif(in_array($orderStatus,['shipped','delivered'])){
 $displayLabel=$labelMap['shipped'];$badgeClass=$badgeMap['shipped'];
}elseif($orderStatus==='completed'){
 $displayLabel=$labelMap['completed'];$badgeClass=$badgeMap['completed'];
}else{
 if(!$hasPaymentProof){
  $displayLabel=$labelMap['waiting_payment'];$badgeClass=$badgeMap['waiting_payment'];
 }else{
  if(in_array($paymentStatus,['waiting_confirm','waiting'])){
   $displayLabel=$labelMap['waiting_confirm'];$badgeClass=$badgeMap['waiting_confirm'];
  }elseif(in_array($paymentStatus,['confirmed','paid'])){
   $displayLabel=$labelMap['processing'];$badgeClass=$badgeMap['processing'];
  }else{
   $displayLabel=$labelMap[$orderStatus];$badgeClass=$badgeMap[$orderStatus];
  }
 }
}
@endphp

<tr data-status="{{ $orderStatus }}">
<td>
 <div class="order-number">{{ $order->order_number ?: '#'.$order->id }}</div>
 <div class="order-id">ID: {{ $order->id }}</div>
</td>

<td>
@if($order->user)
 <div class="customer-name">{{ $order->user->name }}</div>
 <div class="customer-email">{{ $order->user->email }}</div>
@else
 <span class="text-gray-400 italic">Guest</span>
@endif
</td>

<td>{{ $order->items_count ?? $order->items->count() }}</td>
<td class="order-amount">Rp {{ number_format($order->total,0,',','.') }}</td>

<td>
 <span class="status-badge {{ $badgeClass }}">
   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
     <path stroke-width="2" d="M9 12l2 2 4-4"/>
   </svg>
   {{ $displayLabel }}
 </span>
</td>

<td>
 <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
 <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
</td>

<td class="text-right">
<a href="{{ route('admin.orders.show',$order->id) }}#actions"
   class="action-manage">

   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
     <path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M16 3l5 5"/>
   </svg>
   Kelola
 </a>
</td>
</tr>
@empty
<tr><td colspan="7"><div class="empty">Belum ada pesanan</div></td></tr>
@endforelse
</tbody>
</table>
</div>

@if($orders->hasPages())
<div class="border-t px-4 py-3 bg-gray-50">
 {{ $orders->links() }}
</div>
@endif
</div>

</div>

{{-- ================= JS SEARCH & FILTER ================= --}}
<script>
const searchInput = document.getElementById('searchInput');
const filterButtons = document.querySelectorAll('.filter-btn');
const rows = document.querySelectorAll('#orderTable tbody tr');

function filterTable(){
    const keyword = searchInput.value.toLowerCase();
    const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

    rows.forEach(row=>{
        const text = row.innerText.toLowerCase();
        const status = row.dataset.status;
        row.style.display =
            (text.includes(keyword) && (activeFilter === 'all' || status === activeFilter))
            ? '' : 'none';
    });
}

searchInput.addEventListener('input', filterTable);
filterButtons.forEach(btn=>{
    btn.addEventListener('click', ()=>{
        filterButtons.forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        filterTable();
    });
});
</script>
@endsection
