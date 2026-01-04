@extends('layouts.app')

@section('content')
<style>
:root{
  --bg:#f1f5fb;
  --card:#ffffff;
  --border:#e5eaf2;
  --text:#0f172a;
  --muted:#64748b;

  --primary:#2563eb;
  --primary-soft:#eff6ff;
  --success:#16a34a;

  --radius-xl:28px;
  --radius-lg:18px;
  --radius-md:12px;

  --shadow:0 30px 80px rgba(2,6,23,.15);
}

*{ box-sizing:border-box; }

.page{
  min-height:100vh;
  background:var(--bg);
  padding:32px 16px;
  display:flex;
  justify-content:center;
}

.checkout{
  width:100%;
  max-width:920px;
  background:var(--card);
  border-radius:var(--radius-xl);
  border:1px solid var(--border);
  box-shadow:var(--shadow);
  padding:36px;
}

/* HEADER */
.header{
  display:flex;
  flex-direction:column;
  gap:6px;
  padding-bottom:20px;
  border-bottom:1px solid var(--border);
}
.header h1{
  font-size:26px;
  font-weight:900;
}
.header p{
  color:var(--muted);
  font-size:14px;
}

/* SECTION */
.section{
  margin-top:28px;
}
.section-title{
  font-size:16px;
  font-weight:900;
  margin-bottom:14px;
}

/* TOTAL */
.total-box{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:16px 18px;
  background:#f8fafc;
  border:1px solid var(--border);
  border-radius:var(--radius-md);
}
.total-box .amount{
  font-size:20px;
  font-weight:900;
}

/* STEP GRID */
.method-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:14px;
}

/* METHOD CARD */
.method{
  border:2px solid var(--border);
  border-radius:var(--radius-lg);
  padding:18px;
  cursor:pointer;
  transition:.2s;
  background:#fff;
}
.method:hover{ border-color:var(--primary); }
.method.active{
  border-color:var(--primary);
  background:var(--primary-soft);
}
.method input{ display:none; }

.method-head{
  display:flex;
  align-items:center;
  gap:12px;
}
.method-icon{
  width:44px;
  height:44px;
  border-radius:12px;
  background:#f1f5f9;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:20px;
}
.method-title{
  font-weight:900;
}
.method-desc{
  font-size:13px;
  color:var(--muted);
  margin-top:6px;
}

/* SUB SECTION */
.sub-box{
  margin-top:18px;
  padding:20px;
  border-radius:var(--radius-lg);
  border:1px solid var(--border);
  background:#f9fbff;
  display:none;
}

/* DROPDOWN */
.select{
  width:100%;
  padding:14px;
  border-radius:var(--radius-md);
  border:1px solid var(--border);
  font-weight:700;
  margin-top:10px;
}

/* BANK DETAIL */
.bank-card{
  margin-top:14px;
  padding:14px 16px;
  border-radius:var(--radius-md);
  border:1px dashed var(--border);
  display:flex;
  justify-content:space-between;
  align-items:center;
}
.bank-info{
  display:flex;
  flex-direction:column;
  gap:4px;
}
.bank-name{
  font-weight:900;
}
.bank-number{
  font-weight:900;
  letter-spacing:1px;
}

/* COPY */
.copy-btn{
  border:0;
  background:var(--primary-soft);
  color:var(--primary);
  font-weight:800;
  padding:8px 14px;
  border-radius:10px;
  cursor:pointer;
}

/* QRIS */
.qris{
  text-align:center;
}
.qris img{
  max-width:240px;
  border-radius:14px;
  border:1px solid var(--border);
  background:#fff;
}
.qris p{
  margin-top:10px;
  font-size:13px;
  color:var(--muted);
}

/* UPLOAD */
.upload{
  border:2px dashed var(--border);
  border-radius:var(--radius-lg);
  padding:28px;
  text-align:center;
  cursor:pointer;
}
.upload:hover{
  background:#f8fafc;
  border-color:var(--primary);
}
.preview img{
  margin-top:16px;
  max-width:100%;
  border-radius:var(--radius-md);
  border:1px solid var(--border);
}

/* ACTIONS */
.actions{
  margin-top:36px;
  display:flex;
  gap:14px;
  flex-wrap:wrap;
}
.btn{
  padding:14px 28px;
  border-radius:18px;
  font-weight:900;
  border:none;
  cursor:pointer;
}
.btn-primary{
  background:linear-gradient(90deg,#2563eb,#1d4ed8);
  color:white;
}
.btn-ghost{
  background:#f8fafc;
  border:1px solid var(--border);
}

/* MOBILE */
@media(max-width:640px){
  .checkout{ padding:26px 20px; }
  .header h1{ font-size:22px; }
}
</style>

@php
$storeRoute = \Illuminate\Support\Facades\Route::has('payments.store')
  ? 'payments.store'
  : (\Illuminate\Support\Facades\Route::has('addresses.payments.store')
      ? 'addresses.payments.store'
      : null);
@endphp

<div class="page">
<div class="checkout">

<div class="header">
  <h1>Checkout Pembayaran</h1>
  <p>Order #{{ $order->order_number }}</p>
</div>

@if($storeRoute)
<form action="{{ route($storeRoute, $order->id) }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="amount" value="{{ $order->total }}">

{{-- TOTAL --}}
<div class="section">
  <div class="section-title">Total Pembayaran</div>
  <div class="total-box">
    <div class="amount">Rp {{ number_format($order->total,0,',','.') }}</div>
    <div class="muted">Tidak dapat diubah</div>
  </div>
</div>

{{-- STEP 1 --}}
<div class="section">
  <div class="section-title">Pilih Metode Pembayaran</div>

  <div class="method-grid">
    <label class="method" data-method="va">
      <input type="radio" name="method" value="va">
      <div class="method-head">
        <div class="method-icon">🏦</div>
        <div>
          <div class="method-title">Virtual Account</div>
          <div class="method-desc">Transfer otomatis via bank</div>
        </div>
      </div>
    </label>

    <label class="method" data-method="manual">
      <input type="radio" name="method" value="manual">
      <div class="method-head">
        <div class="method-icon">💳</div>
        <div>
          <div class="method-title">Transfer Manual</div>
          <div class="method-desc">Transfer ke rekening</div>
        </div>
      </div>
    </label>

    <label class="method" data-method="qris">
      <input type="radio" name="method" value="qris">
      <div class="method-head">
        <div class="method-icon">📱</div>
        <div>
          <div class="method-title">QRIS</div>
          <div class="method-desc">Scan e-wallet / m-banking</div>
        </div>
      </div>
    </label>

    <label class="method" data-method="cod">
      <input type="radio" name="method" value="cod">
      <div class="method-head">
        <div class="method-icon">🚚</div>
        <div>
          <div class="method-title">COD</div>
          <div class="method-desc">Bayar saat diterima</div>
        </div>
      </div>
    </label>
  </div>

  <div id="subBox" class="sub-box"></div>
</div>

{{-- UPLOAD --}}
<div class="section">
  <div class="section-title">Bukti Pembayaran</div>
  <div class="upload" onclick="document.getElementById('proof').click()">
    Klik untuk unggah bukti pembayaran
  </div>
  <input type="file" name="proof" id="proof" accept="image/*" hidden required>
  <div class="preview" id="preview"></div>
</div>

<div class="actions">
  <button class="btn btn-primary">Kirim Bukti Pembayaran</button>
  <a href="{{ url()->previous() }}" class="btn btn-ghost">Kembali</a>
</div>

</form>
@endif

</div>
</div>

<script>
const methods = document.querySelectorAll('.method');
const subBox = document.getElementById('subBox');

methods.forEach(m=>{
  m.addEventListener('click',()=>{
    methods.forEach(x=>x.classList.remove('active'));
    m.classList.add('active');
    m.querySelector('input').checked = true;

    const t = m.dataset.method;
    let html = '';

    if(t === 'va'){
      html = `
        <strong>Pilih Bank Virtual Account</strong>
        <select class="select" onchange="showVA(this.value)">
          <option value="">-- Pilih Bank --</option>
          <option value="BCA">BCA</option>
          <option value="BNI">BNI</option>
          <option value="BRI">BRI</option>
          <option value="Mandiri">Mandiri</option>
        </select>
        <div id="bankDetail"></div>
      `;
    }
    else if(t === 'manual'){
      html = `
        <strong>Pilih Bank Transfer Manual</strong>
        <select class="select" onchange="showManual(this.value)">
          <option value="">-- Pilih Bank --</option>
          <option value="BCA">BCA</option>
          <option value="BRI">BRI</option>
          <option value="LAIN">Bank Lain</option>
        </select>
        <div id="bankDetail"></div>
      `;
    }
    else if(t === 'qris'){
      html = `
        <div class="qris">
          <img src="https://d2v6npc8wmnkqk.cloudfront.net/storage/26035/conversions/Tipe-QRIS-statis-small-large.jpg">
          <p>Scan QR menggunakan e-wallet atau mobile banking</p>
        </div>
      `;
    }
    else{
      html = `<strong>COD</strong><p class="muted">Bayar saat pesanan diterima.</p>`;
    }

    subBox.innerHTML = html;
    subBox.style.display = 'block';
  });
});

function showVA(bank){
  if(!bank) return document.getElementById('bankDetail').innerHTML='';
  const prefix = {BCA:'70001',BNI:'80001',BRI:'90001',Mandiri:'60001'}[bank];
  const va = prefix + '{{ $order->id }}';
  document.getElementById('bankDetail').innerHTML = `
    <div class="bank-card">
      <div class="bank-info">
        <div class="bank-name">${bank}</div>
        <div class="bank-number">${va}</div>
      </div>
      <button type="button" class="copy-btn" onclick="copyText('${va}')">Salin</button>
    </div>`;
}

function showManual(bank){
  const map = {BCA:'1234567890',BRI:'0987654321',LAIN:'1122334455'};
  if(!bank) return document.getElementById('bankDetail').innerHTML='';
  const no = map[bank];
  document.getElementById('bankDetail').innerHTML = `
    <div class="bank-card">
      <div class="bank-info">
        <div class="bank-name">${bank}</div>
        <div class="bank-number">${no}</div>
        <div class="muted">a.n RIZA BADRUZ ZAMAN</div>
      </div>
      <button type="button" class="copy-btn" onclick="copyText('${no}')">Salin</button>
    </div>`;
}

function copyText(t){
  navigator.clipboard.writeText(t);
  alert('Berhasil disalin');
}

const proof = document.getElementById('proof');
const preview = document.getElementById('preview');
proof.addEventListener('change',()=>{
  const f = proof.files[0];
  if(!f) return;
  const r = new FileReader();
  r.onload = e => preview.innerHTML = `<img src="${e.target.result}">`;
  r.readAsDataURL(f);
});
</script>
@endsection
