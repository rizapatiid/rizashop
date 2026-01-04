@extends('layouts.nav_masterdashboard')


@section('content')
<style>
/* ===== Responsive Users Index (self-contained) ===== */
:root{
  --bg:#f6f8fb;--card:#fff;--muted:#6b7280;
  --accent:#2563eb;--accent-600:#1e40af;
  --danger:#ef4444;--pill-bg:#f1f5f9;
  --radius:12px;--shadow:0 18px 48px rgba(2,6,23,.06);
  font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,Arial;
}
.container-page{max-width:1150px;margin:32px auto;padding:22px;background:var(--bg);border-radius:14px}
.header{display:flex;justify-content:space-between;gap:16px;margin-bottom:18px}
.h1{font-size:22px;font-weight:900;margin:0}
.h1-sub{font-size:13px;color:var(--muted)}
.controls{display:flex;gap:12px;align-items:center}
.search{position:relative;width:380px}
.search input{width:100%;padding:12px 16px 12px 42px;border-radius:12px;border:1px solid #e5e7eb}
.search svg{position:absolute;left:12px;top:50%;transform:translateY(-50%)}
.btn-add{display:inline-flex;gap:8px;align-items:center;padding:10px 16px;border-radius:12px;
background:linear-gradient(180deg,var(--accent),var(--accent-600));
color:#fff;font-weight:800;text-decoration:none}

.card{background:#fff;border-radius:14px;box-shadow:var(--shadow);overflow:hidden}
.table{width:100%;border-collapse:collapse;min-width:880px}
.table th,.table td{padding:14px 18px;border-bottom:1px solid #e5e7eb;text-align:left}
.avatar{width:42px;height:42px;border-radius:999px;display:flex;align-items:center;
justify-content:center;font-weight:900;color:#fff;background:#4f46e5}
.name-cell{display:flex;gap:12px;align-items:center}
.pill{padding:6px 10px;border-radius:999px;font-weight:700;font-size:13px}
.pill.active{background:#ecfdf5;color:#065f46}
.pill.inactive{background:#fff1f2;color:#991b1b}

.actions{display:flex;gap:8px;justify-content:flex-end}
.icon-btn{width:40px;height:40px;border-radius:10px;border:none;
display:flex;align-items:center;justify-content:center;cursor:pointer;background:#f3f4f6}
.icon-delete:hover{background:#fff1f2}

.modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.55);
display:none;align-items:center;justify-content:center;z-index:9999}
.modal{background:#fff;border-radius:12px;width:92%;max-width:460px;overflow:hidden}
.modal-header,.modal-footer{padding:16px;border-bottom:1px solid #e5e7eb}
.modal-footer{border-top:1px solid #e5e7eb;display:flex;gap:12px;justify-content:flex-end}
.modal-body{padding:18px}
</style>

<div class="container-page">
  <div class="header">
    <div>
      <h1 class="h1">Manajemen Pengguna</h1>
      <p class="h1-sub">Kelola akun, role, dan status pengguna</p>
    </div>

    <div class="controls">
      <div class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M21 21l-4.35-4.35" stroke="#6b7280" stroke-width="2"/>
          <circle cx="10.5" cy="10.5" r="7.5" stroke="#6b7280" stroke-width="2"/>
        </svg>
        <input type="search" id="q" placeholder="Cari nama / email..." value="{{ request('q') }}">
      </div>

      <a href="{{ route('admin.users.create') }}" class="btn-add">
        + Tambah User
      </a>
    </div>
  </div>

  @if(session('success'))
    <div style="margin-bottom:12px;color:#065f46;font-weight:700">
      {{ session('success') }}
    </div>
  @endif

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Dibuat</th>
          <th style="text-align:right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td>
            <div class="name-cell">
              <!-- <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div> -->
              <strong>{{ $u->name }}</strong>
            </div>
          </td>
          <td>{{ $u->email }}</td>
          <td>{{ ucfirst($u->role) }}</td>
          <td>
            @if($u->is_active ?? true)
              <span class="pill active">Active</span>
            @else
              <span class="pill inactive">Inactive</span>
            @endif
          </td>
          <td>{{ $u->created_at->format('d M Y') }}</td>
          <td>
            <div class="actions">
              <a href="{{ route('admin.users.edit',$u->id) }}" class="icon-btn">
                ✏️
              </a>

              @if(auth()->id() !== $u->id)
              <button
                class="icon-btn icon-delete del"
                data-name="{{ e($u->name) }}"
                data-action="{{ route('admin.users.destroy',$u->id) }}">
                🗑️
              </button>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:32px">Belum ada pengguna</td></tr>
        @endforelse
      </tbody>
    </table>

    <div style="padding:14px">
      {{ $users->links() }}
    </div>
  </div>
</div>

{{-- MODAL DELETE --}}
<div id="modalBackdrop" class="modal-backdrop">
  <div class="modal">
    <div class="modal-header">
      <strong>Hapus Pengguna</strong>
    </div>
    <div class="modal-body">
      Yakin ingin menghapus <strong id="modalUser"></strong>?
    </div>
    <div class="modal-footer">
      <button id="cancelBtn">Batal</button>
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <button style="background:#ef4444;color:#fff;border:none;padding:8px 14px;border-radius:8px">
          Hapus
        </button>
      </form>
    </div>
  </div>
</div>

<script>
(() => {
  const modal = document.getElementById('modalBackdrop');
  const nameEl = document.getElementById('modalUser');
  const form = document.getElementById('deleteForm');

  document.addEventListener('click', e => {
    const btn = e.target.closest('.del');
    if(!btn) return;
    e.preventDefault();
    nameEl.textContent = btn.dataset.name;
    form.action = btn.dataset.action;
    modal.style.display = 'flex';
  });

  document.getElementById('cancelBtn').onclick = () => modal.style.display = 'none';
})();
</script>
@endsection
