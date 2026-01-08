@extends('layouts.app')
@section('title', 'Bukti Payment')
@section('page-title', 'Bukti Payment')

@section('content')

<style>
/* =====================================================
   PAYMENT PROOF CHECKOUT
   TOTAL UI + ICON REDESIGN (2026 READY)
   ===================================================== */

:root{
  --bg:#f6f8fc;
  --surface:#ffffff;
  --border:#e4e9f2;
  --text:#0b1220;
  --muted:#6b7280;

  --blue:#2563eb;
  --green:#16a34a;
  --orange:#f59e0b;
  --red:#dc2626;

  --radius-xl:34px;
  --radius-lg:22px;
  --radius-md:14px;

  --shadow-main:0 40px 90px rgba(15,23,42,.12);
  --shadow-soft:0 18px 45px rgba(15,23,42,.08);
}

*{ box-sizing:border-box; }

body{ background:var(--bg); }

.viewport{
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:32px 16px;
}

/* ================= CONTAINER ================= */

.checkout{
  width:100%;
  max-width:1080px;
  background:var(--surface);
  border-radius:var(--radius-xl);
  border:1px solid var(--border);
  box-shadow:var(--shadow-main);
  display:grid;
  grid-template-columns:1.15fr .85fr;
  overflow:hidden;
}

/* ================= LEFT ================= */

.left{
  padding:54px 52px;
}

.status-head{
  display:flex;
  gap:22px;
  align-items:center;
}

/* ICON PILL */
.icon-pill{
  width:92px;
  height:92px;
  border-radius:30px;
  display:flex;
  align-items:center;
  justify-content:center;
}

.icon-pill svg{
  width:42px;
  height:42px;
  stroke:white;
}

.pill-wait{ background:linear-gradient(135deg,#f59e0b,#fb923c); }
.pill-ok{ background:linear-gradient(135deg,#16a34a,#22c55e); }
.pill-bad{ background:linear-gradient(135deg,#dc2626,#fb7185); }

.status-title{
  font-size:34px;
  font-weight:900;
  color:var(--text);
}

.status-sub{
  margin-top:8px;
  font-size:15px;
  color:var(--muted);
}

/* INFO BLOCK */
.info-block{
  margin-top:36px;
  background:#f9fbff;
  border:1px solid var(--border);
  border-radius:var(--radius-lg);
  padding:28px 30px;
  display:flex;
  gap:20px;
}

.info-icon{
  width:56px;
  height:56px;
  border-radius:16px;
  background:white;
  border:1px solid var(--border);
  display:flex;
  align-items:center;
  justify-content:center;
  flex-shrink:0;
}

.info-icon svg{
  width:26px;
  height:26px;
  stroke:var(--blue);
}

.info-text{
  font-size:15px;
  line-height:1.7;
  color:var(--muted);
}

/* ================= RIGHT ================= */

.right{
  padding:52px 44px;
  background:linear-gradient(180deg,#fbfdff,#f2f5ff);
  border-left:1px solid var(--border);
  display:flex;
  align-items:center;
}

.action-card{
  width:100%;
  background:white;
  border-radius:var(--radius-lg);
  border:1px solid var(--border);
  box-shadow:var(--shadow-soft);
  padding:34px;
}

.action-title{
  font-size:21px;
  font-weight:900;
  color:var(--text);
}

.action-sub{
  margin-top:6px;
  font-size:14px;
  color:var(--muted);
}

/* ================= BUTTON ================= */

.btn{
  width:100%;
  margin-top:20px;
  padding:18px;
  border-radius:20px;
  font-weight:900;
  font-size:15px;
  border:none;
  cursor:pointer;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:12px;
}

.btn svg{
  width:20px;
  height:20px;
}

.btn-primary{
  background:linear-gradient(90deg,#2563eb,#1d4ed8);
  color:white;
}

.btn-outline{
  background:white;
  border:1px solid var(--border);
  color:var(--text);
}

.btn-back{
  background:#f8fafc;
  border:1px solid var(--border);
  color:#0f172a;
}

.helper{
  margin-top:18px;
  font-size:13px;
  color:var(--muted);
  text-align:center;
}

/* ================= MODAL ================= */

.modal-overlay{
  position:fixed;
  inset:0;
  background:rgba(15,23,42,.85);
  display:none;
  align-items:center;
  justify-content:center;
  z-index:9999;
  padding:20px;
}

.modal{
  width:100%;
  max-width:920px;
  background:white;
  border-radius:32px;
  overflow:hidden;
}

.modal-head{
  padding:20px 26px;
  border-bottom:1px solid var(--border);
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.modal-body{
  padding:26px;
  background:#f8fafc;
  display:flex;
  justify-content:center;
}

.modal-body img{
  max-width:100%;
  max-height:75vh;
  border-radius:22px;
}

.modal-close{
  background:none;
  border:none;
  font-size:28px;
  cursor:pointer;
}

/* ================= RESPONSIVE ================= */

@media(max-width:960px){
  .checkout{
    grid-template-columns:1fr;
  }
  .right{
    border-left:none;
    border-top:1px solid var(--border);
  }
}

@media(max-width:520px){
  .left,.right{
    padding:28px 22px;
  }
  .status-title{
    font-size:24px;
  }
  .icon-pill{
    width:68px;
    height:68px;
  }
}
</style>

@php
$payment = $order->payment ?? null;
$hasProof = $payment && !empty($payment->proof_path);
$status = $payment->status ?? null;

/* STATUS LOGIC (SAMA SEPERTI SEBELUMNYA) */
if(!$hasProof){
  $title = 'Menunggu Pembayaran';
  $desc  = 'Silakan lakukan pembayaran dan unggah bukti pembayaran untuk melanjutkan proses.';
  $pill  = 'pill-wait';
  $icon  = '<circle cx="12" cy="12" r="9"/><path d="M12 6v6"/>';
}
elseif(in_array($status,['waiting','waiting_confirm','waiting_confirmation'])){
  $title = 'Menunggu Konfirmasi';
  $desc  = 'Bukti pembayaran sudah diterima dan sedang diverifikasi oleh sistem.';
  $pill  = 'pill-wait';
  $icon  = '<circle cx="12" cy="12" r="9"/><path d="M12 8v4"/>';
}
elseif(in_array($status,['confirmed','paid'])){
  $title = 'Pembayaran Berhasil';
  $desc  = 'Pembayaran telah dikonfirmasi dan checkout berhasil.';
  $pill  = 'pill-ok';
  $icon  = '<polyline points="20 6 9 17 4 12"/>';
}
else{
  $title = 'Pembayaran Ditolak';
  $desc  = 'Bukti pembayaran tidak valid. Silakan unggah ulang bukti pembayaran.';
  $pill  = 'pill-bad';
  $icon  = '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>';
}
@endphp

<div class="viewport">
  <div class="checkout">

    {{-- LEFT --}}
    <div class="left">
      <div class="status-head">
        <div class="icon-pill {{ $pill }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            {!! $icon !!}
          </svg>
        </div>
        <div>
          <div class="status-title">{{ $title }}</div>
          <div class="status-sub">Order #{{ $order->order_number }}</div>
        </div>
      </div>

      <div class="info-block">
        <div class="info-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4"/>
            <circle cx="12" cy="8" r="1"/>
          </svg>
        </div>
        <div class="info-text">
          {{ $desc }}
        </div>
      </div>
    </div>

    {{-- RIGHT --}}
    <div class="right">
      <div class="action-card">
        <div class="action-title">Aksi Checkout</div>
        <div class="action-sub">Kelola bukti pembayaran pesanan ini</div>

        @if(!$hasProof || in_array($status,['rejected','declined','failed']))
          <a href="{{ route('payments.create',$order->id) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 5v14"/><path d="M5 12h14"/>
            </svg>
            Upload Bukti Pembayaran
          </a>
        @else
          <button class="btn btn-outline" onclick="openProof()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M2 12s4-6 10-6 10 6 10 6"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            Lihat Bukti Pembayaran
          </button>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-back">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          Kembali
        </a>

        <div class="helper">
          Jika terjadi kendala, silakan hubungi admin.
        </div>
      </div>
    </div>

  </div>
</div>

@if($hasProof)
<div id="proofModal" class="modal-overlay" onclick="closeProof(event)">
  <div class="modal">
    <div class="modal-head">
      <strong>Bukti Pembayaran</strong>
      <button class="modal-close" onclick="closeProof()">×</button>
    </div>
    <div class="modal-body">
      <img src="{{ asset(ltrim($payment->proof_path,'/')) }}">
    </div>
  </div>
</div>
@endif

<script>
function openProof(){
  document.getElementById('proofModal').style.display='flex';
  document.body.style.overflow='hidden';
}
function closeProof(e){
  if(!e || e.target.id==='proofModal'){
    document.getElementById('proofModal').style.display='none';
    document.body.style.overflow='';
  }
}
document.addEventListener('keydown',e=>{
  if(e.key==='Escape') closeProof();
});
</script>

@endsection
