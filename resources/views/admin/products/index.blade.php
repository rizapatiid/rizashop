@extends('layouts.nav_masterdashboard')

@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

<style>
:root{
    --primary:#6366f1;
    --danger:#ef4444;
    --border:#e5e7eb;
    --muted:#6b7280;
    --bg:#f9fafb;
}

/* ===== TOP BAR (SAMA DENGAN ORDERS) ===== */
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
    border:1px solid var(--border);
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
    border:1px solid var(--border);
    background:#fff;
    cursor:pointer;
    font-weight:600;
    color:#374151;
}
.filter-btn svg{width:14px;height:14px}
.filter-btn.active,
.filter-btn:hover{
    background:#eef2ff;
    border-color:var(--primary);
    color:var(--primary);
}

/* ===== TABLE ===== */
.table-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:12px;
    overflow:hidden;
}
.table-wrap{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
table{
    width:100%;
    min-width:900px;
    border-collapse:collapse;
}
thead th{
    background:var(--bg);
    padding:14px 16px;
    font-size:12px;
    text-transform:uppercase;
    color:var(--muted);
    text-align:left;
    border-bottom:1px solid var(--border);
}
tbody td{
    padding:14px 16px;
    border-bottom:1px solid #f1f5f9;
}
tbody tr:hover{background:#f8fafc}

/* ===== PRODUCT ===== */
.product-info{display:flex;gap:12px;align-items:center}
.product-img{
    width:44px;height:44px;
    border-radius:10px;
    object-fit:cover;
    border:1px solid var(--border);
}
.product-name{font-weight:600;font-size:14px}
.product-sku{font-size:12px;color:var(--muted)}

/* ===== STOCK ===== */
.stock-pill{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}
.stock-ok{background:#dcfce7;color:#166534}
.stock-low{background:#fef3c7;color:#92400e}
.stock-empty{background:#fee2e2;color:#991b1b}

.actions{
    display:flex;
    gap:8px;
    justify-content:flex-end;
    flex-wrap:wrap;
}

.action-btn{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    border:1px solid transparent;
    cursor:pointer;
    transition:.2s;
    white-space:nowrap;
}

.action-btn svg{
    width:14px;
    height:14px;
}

/* EDIT */
.action-edit{
    background:#eef2ff;
    color:var(--primary);
    border-color:#c7d2fe;
}
.action-edit:hover{
    background:var(--primary);
    color:#fff;
}

/* DELETE */
.action-delete{
    background:#fee2e2;
    color:var(--danger);
    border-color:#fecaca;
}
.action-delete:hover{
    background:var(--danger);
    color:#fff;
}


/* ===== FOOTER ===== */
.table-footer{
    padding:12px 16px;
    background:var(--bg);
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:13px;
    color:var(--muted);
}

/* ===== MOBILE ===== */
@media(max-width:768px){
    .table-card::after{
        content:"Geser ke samping →";
        display:block;
        text-align:right;
        font-size:12px;
        color:#6b7280;
        padding:6px 12px;
        background:#f9fafb;
    }
}
/* ===== DELETE MODAL ===== */
.modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.55);
    backdrop-filter:blur(4px);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
}

.modal{
    background:#fff;
    width:100%;
    max-width:420px;
    border-radius:16px;
    padding:28px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
    animation:modalPop .25s ease;
}

@keyframes modalPop{
    from{transform:scale(.92);opacity:0}
    to{transform:scale(1);opacity:1}
}

.modal-icon{
    width:56px;
    height:56px;
    border-radius:14px;
    background:#fee2e2;
    color:#dc2626;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:14px;
}

.modal-icon svg{
    width:28px;
    height:28px;
}

.modal-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:6px;
    color:#111827;
}

.modal-text{
    font-size:14px;
    color:#6b7280;
    margin-bottom:22px;
}

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.modal-btn{
    padding:10px 16px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    border:1px solid #e5e7eb;
}

.btn-cancel{
    background:#f9fafb;
}

.btn-cancel:hover{
    background:#f1f5f9;
}

.btn-delete{
    background:#ef4444;
    color:#fff;
    border:none;
}

.btn-delete:hover{
    background:#dc2626;
}

</style>

{{-- ================= TOP BAR ================= --}}
<div class="top-bar">
    <input id="searchInput" class="search-input" placeholder="Cari nama atau SKU…">

    <div class="filter-group">
        <button class="filter-btn active" data-filter="all">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M3 12h18"/></svg>
            Semua
        </button>
        <button class="filter-btn" data-filter="available">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Tersedia
        </button>
        <button class="filter-btn" data-filter="low">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M12 9v4"/><circle cx="12" cy="17" r="1"/></svg>
            Menipis
        </button>
        <button class="filter-btn" data-filter="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" d="M6 6l12 12M18 6l-12 12"/></svg>
            Habis
        </button>
    </div>
</div>

@if($products->count())
<div class="table-card">
<div class="table-wrap">
<table id="productTable">
<thead>
<tr>
    <th>#</th>
    <th>Produk</th>
    <th>Harga</th>
    <th>Terjual</th>
    <th>Stok</th>
    <th class="text-right">Aksi</th>
</tr>
</thead>
<tbody>

@foreach($products as $product)
@php
$terjual=\App\Models\OrderItem::where('product_id',$product->id)
    ->whereHas('order',fn($q)=>$q->whereIn('status',['paid','confirmed','shipped','completed','received','diterima']))
    ->sum('qty');
$stockStatus=$product->stock<=0?'empty':($product->stock<=10?'low':'available');
@endphp

<tr data-name="{{ strtolower($product->name) }}"
    data-sku="{{ strtolower($product->sku ?? '') }}"
    data-stock="{{ $stockStatus }}">

<td>{{ $loop->iteration }}</td>

<td>
<div class="product-info">
@if($product->image_path)
<img src="{{ asset('storage/'.$product->image_path) }}" class="product-img">
@else
<div class="product-img flex items-center justify-center text-gray-400">📦</div>
@endif
<div>
<div class="product-name">{{ $product->name }}</div>
@if($product->sku)<div class="product-sku">SKU: {{ $product->sku }}</div>@endif
</div>
</div>
</td>

<td>Rp {{ number_format($product->price,0,',','.') }}</td>
<td>{{ $terjual }}</td>

<td>
@if($stockStatus==='available')
<span class="stock-pill stock-ok">Aman ({{ $product->stock }})</span>
@elseif($stockStatus==='low')
<span class="stock-pill stock-low">Menipis ({{ $product->stock }})</span>
@else
<span class="stock-pill stock-empty">Habis</span>
@endif
</td>

<td>
<div class="actions">

    {{-- EDIT --}}
    <a href="{{ route('admin.products.edit',$product->id) }}"
       class="action-btn action-edit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4Z"/>
        </svg>
        Edit
    </a>

    {{-- DELETE --}}
    <button class="action-btn action-delete"
            data-action="{{ route('admin.products.destroy',$product->id) }}"
            data-name="{{ $product->name }}"
            onclick="openDeleteModal(this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
        </svg>
        Hapus
    </button>

</div>
</td>

</tr>
@endforeach

</tbody>
</table>
</div>

<div class="table-footer">
    <div>Menampilkan {{ $products->count() }} produk</div>
    <div>{{ $products->links() }}</div>
</div>
</div>
@endif
</div>

{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal" class="modal-overlay" style="display:none">
    <div class="modal">
        <div class="modal-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <circle cx="12" cy="16" r="1"/>
            </svg>
        </div>

        <div class="modal-title">Hapus Produk?</div>
        <div class="modal-text">
            Produk <strong id="deleteName"></strong> akan dihapus permanen.
        </div>

        <div class="modal-actions">
            <button class="modal-btn btn-cancel" onclick="closeDeleteModal()">Batal</button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn btn-delete">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>


{{-- ================= JS SEARCH & FILTER ================= --}}
<script>
const searchInput=document.getElementById('searchInput');
const filterBtns=document.querySelectorAll('.filter-btn');
const rows=document.querySelectorAll('#productTable tbody tr');
let active='all';

function applyFilter(){
    const q=searchInput.value.toLowerCase();
    rows.forEach(r=>{
        const text=r.dataset.name+r.dataset.sku;
        const okText=text.includes(q);
        const okStock=active==='all'||r.dataset.stock===active;
        r.style.display=(okText&&okStock)?'':'none';
    });
}
searchInput.addEventListener('input',applyFilter);
filterBtns.forEach(btn=>{
    btn.onclick=()=>{
        filterBtns.forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        active=btn.dataset.filter;
        applyFilter();
    };
});
</script>
<script>
function openDeleteModal(btn){
    document.getElementById('deleteForm').action = btn.dataset.action;
    document.getElementById('deleteName').textContent = btn.dataset.name;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal(){
    document.getElementById('deleteModal').style.display = 'none';
}

/* klik luar modal */
document.getElementById('deleteModal').addEventListener('click', function(e){
    if(e.target === this){
        closeDeleteModal();
    }
});

/* ESC */
document.addEventListener('keydown', function(e){
    if(e.key === 'Escape'){
        closeDeleteModal();
    }
});
</script>

@endsection
