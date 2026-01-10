@extends('layouts.nav_masterdashboard')

@section('title','Manajemen Pengguna')
@section('page-title','Manajemen Pengguna')

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
    margin-bottom:16px;
    flex-wrap:wrap;
}

.search-wrap{
    position:relative;
}
.search-wrap svg{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    width:16px;
    color:var(--muted);
}
.search-input{
    padding:10px 14px 10px 38px;
    border:1px solid var(--border);
    border-radius:8px;
    font-size:14px;
    width:260px;
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
tbody tr:hover{
    background:#f8fafc;
}

/* ===== USER CELL ===== */
.user-info{
    display:flex;
    align-items:center;
    gap:12px;
}
.avatar{
    width:40px;
    height:40px;
    border-radius:999px;
    background:#eef2ff;
    color:var(--primary);
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
}
.user-name{
    font-weight:600;
    font-size:14px;
}
.user-email{
    font-size:12px;
    color:var(--muted);
}

/* ===== ROLE & STATUS ===== */
.pill{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}
.pill-role{
    background:#eef2ff;
    color:#4338ca;
}
.pill-active{
    background:#dcfce7;
    color:#166534;
}
.pill-inactive{
    background:#fee2e2;
    color:#991b1b;
}

/* ===== ACTION ===== */
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
}
.modal-title{
    font-size:18px;
    font-weight:700;
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
    font-weight:600;
    cursor:pointer;
    border:1px solid var(--border);
}
.btn-cancel{background:#f9fafb}
.btn-delete{background:var(--danger);color:#fff;border:none}
</style>

{{-- ================= TOP BAR ================= --}}
<div class="top-bar">
    <div class="search-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input id="searchInput" class="search-input" placeholder="Cari nama atau email…">
    </div>
</div>

<div class="table-card">
<div class="table-wrap">
<table id="userTable">
<thead>
<tr>
    <th>Pengguna</th>
    <th>Role</th>
    <th>Status</th>
    <th>Dibuat</th>
    <th class="text-right">Aksi</th>
</tr>
</thead>
<tbody>

@foreach($users as $u)
<tr data-text="{{ strtolower($u->name.$u->email) }}">

<td>
<div class="user-info">
    <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
    <div>
        <div class="user-name">{{ $u->name }}</div>
        <div class="user-email">{{ $u->email }}</div>
    </div>
</div>
</td>

<td>
<span class="pill pill-role">{{ ucfirst($u->role) }}</span>
</td>

<td>
@if($u->is_active ?? true)
<span class="pill pill-active">Aktif</span>
@else
<span class="pill pill-inactive">Nonaktif</span>
@endif
</td>

<td>{{ $u->created_at->format('d M Y') }}</td>

<td>
<div class="actions">
    <a href="{{ route('admin.users.edit',$u->id) }}" class="action-btn action-edit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4Z"/>
        </svg>
        Edit
    </a>

    @if(auth()->id() !== $u->id)
    <button class="action-btn action-delete"
            data-action="{{ route('admin.users.destroy',$u->id) }}"
            data-name="{{ $u->name }}"
            onclick="openDeleteModal(this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
        </svg>
        Hapus
    </button>
    @endif
</div>
</td>

</tr>
@endforeach

</tbody>
</table>
</div>

<div class="table-footer">
    <div>Menampilkan {{ $users->count() }} pengguna</div>
    <div>{{ $users->links() }}</div>
</div>
</div>

{{-- ================= DELETE MODAL ================= --}}
<div id="deleteModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-title">Hapus Pengguna?</div>
        <div class="modal-text">
            Pengguna <strong id="deleteName"></strong> akan dihapus permanen.
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
const searchInput=document.getElementById('searchInput');
const rows=document.querySelectorAll('#userTable tbody tr');

searchInput.addEventListener('input',()=>{
    const q=searchInput.value.toLowerCase();
    rows.forEach(r=>{
        r.style.display=r.dataset.text.includes(q)?'':'none';
    });
});

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

@endsection
