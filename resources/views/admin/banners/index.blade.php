@extends('layouts.nav_masterdashboard')

@section('title','Promosi')
@section('page-title','Promosi')

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

/* ===== TOP BAR ===== */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:18px;
    flex-wrap:wrap;
}
.page-title{
    font-size:20px;
    font-weight:800;
}
.page-subtitle{
    font-size:13px;
    color:var(--muted);
}
.btn-primary{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:10px 16px;
    border-radius:999px;
    background:#eef2ff;
    color:var(--primary);
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    border:1px solid #c7d2fe;
}
.btn-primary:hover{
    background:var(--primary);
    color:#fff;
}

/* ===== GRID ===== */
.banner-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:20px;
}

/* ===== CARD ===== */
.banner-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
}
.banner-image{
    position:relative;
    aspect-ratio:16/9;
    background:#f3f4f6;
}
.banner-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ===== STATUS ===== */
.banner-status{
    position:absolute;
    top:12px;
    right:12px;
    padding:6px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}
.banner-status.active{
    background:#dcfce7;
    color:#166534;
}
.banner-status.inactive{
    background:#fee2e2;
    color:#991b1b;
}

/* ===== CONTENT ===== */
.banner-content{
    padding:16px;
    flex:1;
}
.banner-order{
    display:inline-block;
    padding:4px 10px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
    background:#f1f5f9;
    color:#475569;
    margin-bottom:8px;
}
.banner-title{
    font-size:15px;
    font-weight:700;
    margin-bottom:4px;
}
.banner-subtitle{
    font-size:13px;
    color:var(--muted);
    margin-bottom:10px;
}
.banner-link{
    display:flex;
    align-items:center;
    gap:6px;
    font-size:12px;
    color:#2563eb;
    background:#eff6ff;
    padding:8px 10px;
    border-radius:10px;
    word-break:break-all;
}
.banner-link svg{width:14px;height:14px}

/* ===== ACTION ===== */
.banner-actions{
    display:flex;
    gap:8px;
    padding:12px 16px;
    border-top:1px solid var(--border);
    background:var(--bg);
}
.action-btn{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    cursor:pointer;
    border:1px solid transparent;
}
.action-btn svg{width:14px;height:14px}

.action-edit{
    background:#eef2ff;
    color:var(--primary);
    border-color:#c7d2fe;
}
.action-edit:hover{
    background:var(--primary);
    color:#fff;
}

.action-delete{
    background:#fee2e2;
    color:var(--danger);
    border-color:#fecaca;
}
.action-delete:hover{
    background:var(--danger);
    color:#fff;
}

/* ===== EMPTY ===== */
.empty{
    background:#fff;
    border:2px dashed var(--border);
    border-radius:16px;
    padding:60px 20px;
    text-align:center;
    color:var(--muted);
}

/* ===== MODAL ===== */
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
}
.modal-title{
    font-size:18px;
    font-weight:800;
    margin-bottom:8px;
}
.modal-text{
    font-size:14px;
    color:var(--muted);
    margin-bottom:20px;
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
    font-weight:700;
    border:1px solid var(--border);
    cursor:pointer;
}
.btn-cancel{background:#f9fafb}
.btn-delete{background:var(--danger);color:#fff;border:none}
</style>

{{-- TOP BAR --}}
<div class="top-bar">
    <div>
        <div class="page-title">Kelola Banner Promo</div>
        <div class="page-subtitle">Banner slider untuk homepage</div>
    </div>


</div>

@if($banners->count()===0)
<div class="empty">
    Belum ada banner promo
</div>
@else
<div class="banner-grid">
@foreach($banners as $banner)
<div class="banner-card">

    <div class="banner-image">
        <img src="{{ asset('storage/'.$banner->image_path) }}">
        <div class="banner-status {{ $banner->is_active?'active':'inactive' }}">
            {{ $banner->is_active?'Aktif':'Nonaktif' }}
        </div>
    </div>

    <div class="banner-content">
        <div class="banner-order">Urutan {{ $banner->sort_order }}</div>
        <div class="banner-title">{{ $banner->title }}</div>
        @if($banner->subtitle)
        <div class="banner-subtitle">{{ $banner->subtitle }}</div>
        @endif
        @if($banner->link_url)
        <div class="banner-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3"/>
            </svg>
            {{ Str::limit($banner->link_url,40) }}
        </div>
        @endif
    </div>

    <div class="banner-actions">
        <a href="{{ route('admin.banners.edit',$banner->id) }}" class="action-btn action-edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4Z"/>
            </svg>
            Edit
        </a>

        <button class="action-btn action-delete"
                data-name="{{ $banner->title }}"
                data-action="{{ route('admin.banners.destroy',$banner->id) }}"
                onclick="openDeleteModal(this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
            </svg>
            Hapus
        </button>
    </div>

</div>
@endforeach
</div>
@endif

{{-- DELETE MODAL --}}
<div id="deleteModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-title">Hapus Banner?</div>
        <div class="modal-text">
            Banner <strong id="deleteName"></strong> akan dihapus permanen.
        </div>
        <div class="modal-actions">
            <button class="modal-btn btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button class="modal-btn btn-delete">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(btn){
    deleteForm.action=btn.dataset.action;
    deleteName.textContent=btn.dataset.name;
    deleteModal.style.display='flex';
}
function closeDeleteModal(){
    deleteModal.style.display='none';
}
deleteModal.onclick=e=>{
    if(e.target===deleteModal) closeDeleteModal();
};
</script>

</div>
@endsection
