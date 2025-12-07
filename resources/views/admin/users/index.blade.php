@extends('layouts.app')

@section('content')
<style>
/* ===== Responsive Users Index (self-contained) ===== */
:root{
  --bg: #f6f8fb;
  --card: #ffffff;
  --muted: #6b7280;
  --accent: #2563eb;
  --accent-600: #1e40af;
  --danger: #ef4444;
  --pill-bg: #f1f5f9;
  --radius: 12px;
  --shadow: 0 18px 48px rgba(2,6,23,0.06);
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  color-scheme: light;
}

/* Page */
.container-page {
  max-width:1150px;
  margin:32px auto;
  padding:22px;
  background:var(--bg);
  border-radius:14px;
  color:#071033;
}

/* Header (desktop) */
.header {
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:20px;
  margin-bottom:18px;
}
.header-left { display:flex; flex-direction:column; gap:6px; }
.h1 { font-size:22px; font-weight:900; margin:0; }
.h1-sub { font-size:13px; color:var(--muted); margin:0; }

/* Controls (search + add) */
.controls { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
.controls-left { display:flex; align-items:center; gap:12px; }

/* search */
.search { position:relative; width:420px; max-width:100%; }
.search input {
  width:100%;
  padding:12px 16px 12px 44px;
  border-radius:12px;
  border:1px solid rgba(14,30,60,0.06);
  background:var(--card);
  font-size:14px;
  outline:none;
  box-shadow: 0 6px 18px rgba(2,6,23,0.04);
}
.search input:focus {
  box-shadow: 0 12px 30px rgba(37,99,235,0.06);
  border-color: rgba(37,99,235,0.18);
}
.search .icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); opacity:0.7; }

/* add button */
.btn-add {
  display:inline-flex; align-items:center; gap:10px; padding:10px 16px; border-radius:12px;
  background:linear-gradient(180deg,var(--accent),var(--accent-600)); color:white; font-weight:800;
  box-shadow: 0 12px 30px rgba(37,99,235,0.12); text-decoration:none; white-space:nowrap;
}

/* Card + table (desktop) */
.card { background:var(--card); border-radius:14px; box-shadow:var(--shadow); border:1px solid rgba(14,30,60,0.04); overflow:hidden; }
.table-wrap { overflow:auto; }
.table { width:100%; border-collapse:collapse; table-layout:fixed; min-width:880px; font-size:14px; }
.table thead th { padding:16px 20px; text-align:left; font-weight:700; color:#0f1724; background: linear-gradient(180deg,#fbfdff,#f7fbff); font-size:13px; border-bottom:1px solid rgba(14,30,60,0.04); }
.table tbody td { padding:14px 20px; vertical-align:middle; color:#071033; border-bottom:1px solid rgba(14,30,60,0.04); }

/* column widths */
.table th:nth-child(1), .table td:nth-child(1) { width:38%; }
.table th:nth-child(2), .table td:nth-child(2) { width:24%; }
.table th:nth-child(3), .table td:nth-child(3) { width:10%; }
.table th:nth-child(4), .table td:nth-child(4) { width:10%; }
.table th:nth-child(5), .table td:nth-child(5) { width:10%; }
.table th:nth-child(6), .table td:nth-child(6) { width:8%; }

/* rows */
.tr-hover { transition: background .12s ease; }
.tr-hover:hover { background: #fbfcff; }

/* name cell */
.name-cell { display:flex; align-items:center; gap:14px; }
.avatar { width:44px; height:44px; border-radius:999px; display:flex; align-items:center; justify-content:center; font-weight:800; color:white; background: linear-gradient(135deg,#7c83ff,#4f46e5); box-shadow: 0 6px 18px rgba(79,70,229,0.12); flex:0 0 44px; }
.name-text { font-weight:800; font-size:15px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.email-text { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#0f1724; }

/* pill */
.pill { display:inline-flex; align-items:center; justify-content:center; padding:6px 10px; border-radius:999px; font-weight:700; font-size:13px; background:var(--pill-bg); color:#0b1220; }
.pill.active { background:#ecfdf5; color:#065f46; }
.pill.inactive { background:#fff1f2; color:#991b1b; }

/* created/date */
.created { color:var(--muted); font-size:13px; }

/* actions */
.actions { display:flex; gap:8px; justify-content:flex-end; align-items:center; }
.icon-btn { width:40px; height:40px; border-radius:10px; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; background: #f4f7fb; transition:transform .08s ease, background .12s; }
.icon-btn:hover { transform: translateY(-2px); background:#eef3ff; }
.icon-edit svg { stroke: var(--accent); }
.icon-delete svg { stroke: var(--danger); }
.icon-delete:hover { background:#fff5f5; }

/* empty */
.empty { padding:56px; text-align:center; color:var(--muted); font-weight:700; }

/* cards list (mobile) */
.cards-list { display:none; gap:12px; padding:12px; }
.card-item { background: #fff; border-radius:12px; padding:12px; box-shadow: 0 8px 28px rgba(2,6,23,0.04); border:1px solid rgba(14,30,60,0.04); display:flex; gap:12px; align-items:center; justify-content:space-between; }
.card-item .left { display:flex; gap:12px; align-items:center; min-width:0; flex:1; }
.card-item .meta { display:flex; flex-direction:column; gap:6px; min-width:0; }
.card-item .meta .title { font-weight:800; font-size:15px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.card-item .meta .sub { font-size:13px; color:var(--muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.card-item .right { display:flex; gap:8px; align-items:center; }

/* modal */
.modal-backdrop { position:fixed; inset:0; display:none; align-items:center; justify-content:center; background:rgba(3,7,18,0.54); z-index:99999; }
.modal { width:92%; max-width:480px; border-radius:12px; background:#fff; box-shadow:0 28px 80px rgba(2,6,23,0.36); overflow:hidden; }
.modal .modal-header, .modal .modal-footer { padding:16px; border-bottom:1px solid rgba(14,30,60,0.04); }
.modal .modal-footer { border-top:1px solid rgba(14,30,60,0.04); display:flex; gap:12px; justify-content:flex-end; align-items:center; }
.modal .modal-body { padding:18px; }

/* footer/pagination */
.card-footer { padding:12px 18px; display:flex; justify-content:flex-end; background: linear-gradient(180deg,#ffffff,#fbfcff); }

/* ---------- RESPONSIVE LAYOUT ADJUSTMENTS ---------- */
/* On small screens we want:
   1) Header title & subtitle at top
   2) Below them, the "search + add button" bar stacked
   3) Table hidden; card-list visible
*/
@media (max-width:720px){
  .header { flex-direction:column; align-items:stretch; gap:12px; }
  .controls { display:flex; flex-direction:row; gap:10px; align-items:center; justify-content:space-between; width:100%; }
  .controls-left { flex:1; }
  .search { width:100%; max-width:100%; }
  .table-wrap, .table { display:none; }
  .cards-list { display:flex; flex-direction:column; }
  .container-page { padding:16px; }
  .btn-add { padding:8px 12px; font-size:14px; }
  .card { box-shadow:none; border:1px solid rgba(14,30,60,0.03); }
}
</style>

<div class="container-page" id="users-page">
  <!-- HEADER: title/subtitle always on top -->
  <div class="header" role="region" aria-label="Header pengguna">
    <div class="header-left">
      <h1 class="h1">Manajemen Pengguna</h1>
      <p class="h1-sub">Kelola akun, role, dan status pengguna — sederhana & rapi.</p>
    </div>

    <!-- CONTROLS: on desktop shown to the right; on mobile moved below title (CSS handles layout) -->
    <div class="controls" role="region" aria-label="Kontrol pengguna">
      <div class="controls-left">
        <div class="search" title="Cari nama atau email">
          <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M21 21l-4.35-4.35" stroke="#6b7280" stroke-width="2" stroke-linecap="round"/><path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" stroke="#6b7280" stroke-width="2" stroke-linecap="round"/></svg>
          <input id="q" type="search" placeholder="Cari nama atau email..." value="{{ request('q','') }}" aria-label="Cari pengguna">
        </div>
      </div>

      <a href="{{ route('admin.users.create') }}" class="btn-add" title="Tambah user">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 5v14" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M5 12h14" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
        Tambah User
      </a>
    </div>
  </div>

  @if(session('success'))
    <div style="margin-bottom:12px;"><div style="display:inline-block; background:#ecfdf6; color:#065f46; border-radius:10px; padding:10px 12px; font-weight:700;">{{ session('success') }}</div></div>
  @endif
  @if(session('error'))
    <div style="margin-bottom:12px;"><div style="display:inline-block; background:#fff1f2; color:#991b1b; border-radius:10px; padding:10px 12px; font-weight:700;">{{ session('error') }}</div></div>
  @endif

  <div class="card" role="region" aria-labelledby="table-heading">
    <!-- TABLE (desktop / tablet) -->
    <div class="table-wrap" tabindex="0" aria-describedby="table-desc">
      <table class="table" aria-describedby="table-desc">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @forelse($users as $u)
          <tr class="tr-hover" role="row">
            <td>
              <div class="name-cell">
                <div class="avatar" aria-hidden="true">{{ strtoupper(substr($u->name,0,1)) }}</div>
                <div class="name-text" title="{{ $u->name }}">{{ $u->name }}</div>
              </div>
            </td>

            <td><div class="email-text" title="{{ $u->email }}">{{ $u->email }}</div></td>

            <td><span class="pill role">{{ ucfirst($u->role) }}</span></td>

            <td>
              @php $active = isset($u->is_active) ? $u->is_active : true; @endphp
              @if($active)
                <span class="pill active">Active</span>
              @else
                <span class="pill inactive">Inactive</span>
              @endif
            </td>

            <td><div class="created">{{ $u->created_at->format('d M Y') }}</div></td>

            <td>
              <div class="actions" role="group" aria-label="Aksi pengguna {{ $u->name }}">
                <a href="{{ route('admin.users.edit', $u->id) }}" class="icon-btn icon-edit" title="Edit {{ $u->name }}" aria-label="Edit">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 20h9" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/><path d="M16.5 3.5l4 4L10 18l-4 1 1-4L16.5 3.5z" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>

                @if(auth()->id() !== $u->id)
                <button class="icon-btn icon-delete del" data-id="{{ $u->id }}" data-name="{{ e($u->name) }}" data-action="{{ url('/masterdashboard/users/'.$u->id) }}" title="Hapus {{ $u->name }}" aria-label="Hapus">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 6h18" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/><path d="M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6" stroke="#ef4444" stroke-width="2"/><path d="M10 11v6M14 11v6" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6">
              <div class="empty">Belum ada pengguna.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- CARDS (mobile) -->
    <div class="cards-list" aria-hidden="true">
      @forelse($users as $u)
      <div class="card-item" role="listitem" aria-label="Pengguna {{ $u->name }}">
        <div class="left">
          <div class="avatar" aria-hidden="true">{{ strtoupper(substr($u->name,0,1)) }}</div>
          <div class="meta">
            <div class="title" title="{{ $u->name }}">{{ $u->name }}</div>
            <div class="sub" title="{{ $u->email }}">{{ $u->email }}</div>
            <div style="display:flex; gap:8px; margin-top:6px; align-items:center;">
              <span class="pill role">{{ ucfirst($u->role) }}</span>
              @if(isset($u->is_active) ? $u->is_active : true)
                <span class="pill active">Active</span>
              @else
                <span class="pill inactive">Inactive</span>
              @endif
            </div>
          </div>
        </div>

        <div class="right">
          <a href="{{ route('admin.users.edit', $u->id) }}" class="icon-btn icon-edit" title="Edit {{ $u->name }}" aria-label="Edit">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 20h9" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/><path d="M16.5 3.5l4 4L10 18l-4 1 1-4L16.5 3.5z" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>

          @if(auth()->id() !== $u->id)
          <button class="icon-btn icon-delete del" data-id="{{ $u->id }}" data-name="{{ e($u->name) }}" data-action="{{ url('/masterdashboard/users/'.$u->id) }}" title="Hapus {{ $u->name }}" aria-label="Hapus">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 6h18" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/><path d="M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6" stroke="#ef4444" stroke-width="2"/><path d="M10 11v6M14 11v6" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/></svg>
          </button>
          @endif
        </div>
      </div>
      @empty
      @endforelse
    </div>

    <div class="card-footer" aria-label="Pagination">
      {{ $users->appends(request()->query())->links() }}
    </div>
  </div>
</div>

<!-- Modal (fixed & outside flows) -->
<div id="modalBackdrop" class="modal-backdrop" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal" role="document">
    <div class="modal-header">
      <h3 id="modalTitle" style="margin:0; font-weight:900; font-size:16px;">Hapus Pengguna</h3>
    </div>
    <div class="modal-body">
      <p>Apakah Anda yakin ingin menghapus <strong id="modalUserName"></strong>? Tindakan ini tidak dapat dikembalikan.</p>
    </div>
    <div class="modal-footer">
      <button id="modalCancel" type="button" style="padding:8px 12px; border-radius:10px; border:1px solid rgba(14,30,60,0.04); background:white; cursor:pointer;">Batal</button>
      <form id="deleteForm" method="POST" style="margin:0;">
        @csrf
        @method('DELETE')
        <button id="modalDeleteBtn" type="submit" style="padding:9px 14px; border-radius:10px; background:var(--danger); color:white; border:none; font-weight:800;">Hapus</button>
      </form>
    </div>
  </div>
</div>

<script>
(() => {
  // Debounce helper
  const debounce = (fn, delay) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), delay); }; };

  // SEARCH handling (debounced + Enter)
  const qInput = document.getElementById('q');
  function applySearch(){
    const v = qInput.value.trim();
    const params = new URLSearchParams(window.location.search);
    if(v) params.set('q', v); else params.delete('q');
    params.set('page','1');
    const url = window.location.pathname + (params.toString() ? ('?' + params.toString()) : '');
    window.location.href = url;
  }
  if(qInput){
    qInput.addEventListener('input', debounce(applySearch, 300));
    qInput.addEventListener('keydown', (e) => { if(e.key === 'Enter'){ e.preventDefault(); applySearch(); } });
  }

  // Modal logic (fixed)
  const modalBackdrop = document.getElementById('modalBackdrop');
  const modalUserName = document.getElementById('modalUserName');
  const deleteForm = document.getElementById('deleteForm');
  const modalCancel = document.getElementById('modalCancel');
  const modalDeleteBtn = document.getElementById('modalDeleteBtn');

  function lockBody(lock){
    if(lock) document.body.style.overflow = 'hidden';
    else document.body.style.overflow = '';
  }

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.del');
    if(!btn) return;
    e.preventDefault();

    const name = btn.getAttribute('data-name') || 'pengguna ini';
    const action = btn.getAttribute('data-action');
    if(!action){
      console.error('Missing delete action URL on button', btn);
      return;
    }

    modalUserName.textContent = name;
    deleteForm.setAttribute('action', action);
    modalBackdrop.style.display = 'flex';
    modalBackdrop.setAttribute('aria-hidden','false');
    lockBody(true);
    modalCancel.focus();
  });

  function closeModal(){
    modalBackdrop.style.display = 'none';
    modalBackdrop.setAttribute('aria-hidden','true');
    lockBody(false);
  }

  modalCancel.addEventListener('click', (e) => { e.preventDefault(); closeModal(); });
  modalBackdrop.addEventListener('click', (e) => { if(e.target === modalBackdrop) closeModal(); });
  document.addEventListener('keydown', (e) => { if(e.key === 'Escape' && modalBackdrop.style.display === 'flex') closeModal(); });

  // disable delete button on submit
  deleteForm && deleteForm.addEventListener('submit', (e) => {
    const act = deleteForm.getAttribute('action');
    if(!act){ e.preventDefault(); console.error('Delete form submitted without action.'); closeModal(); return; }
    modalDeleteBtn.disabled = true;
    modalDeleteBtn.textContent = 'Menghapus...';
  });

  // Keep cards/table visibility in sync (for initial load & resize)
  function syncCardVisibility(){
    const cards = document.querySelector('.cards-list');
    const tableWrap = document.querySelector('.table-wrap');
    if(window.innerWidth <= 720){
      if(cards) cards.setAttribute('aria-hidden','false');
      if(tableWrap) tableWrap.setAttribute('aria-hidden','true');
    } else {
      if(cards) cards.setAttribute('aria-hidden','true');
      if(tableWrap) tableWrap.setAttribute('aria-hidden','false');
    }
  }
  window.addEventListener('resize', syncCardVisibility);
  document.addEventListener('DOMContentLoaded', syncCardVisibility);
})();
</script>
@endsection
