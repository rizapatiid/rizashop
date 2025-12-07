@extends('layouts.app')

@section('content')
<style>
:root{
  --bg:#f8fafc;
  --card:#ffffff;
  --muted:#64748b;
  --accent:#2563eb;
  --accent-600:#1e40af;
  --danger:#ef4444;
  --radius:14px;
  --shadow-sm:0 8px 28px rgba(2,6,23,0.06);
  --shadow-md:0 18px 48px rgba(2,6,23,0.08);
  font-family:Inter,ui-sans-serif,system-ui;
}

/* ========== PAGE WRAPPER ========== */
.page-wrap{
  max-width:900px;
  margin:36px auto;
  padding:26px;
  background:var(--bg);
  border-radius:16px;
  box-shadow:var(--shadow-sm);
  color:#071030;
}

/* ========== HEADER ========== */
.header{
  display:flex;
  align-items:center;
  justify-content:space-between;
  margin-bottom:14px;
}
.header h1{
  margin:0;
  font-size:22px;
  font-weight:900;
}
.header small{
  color:var(--muted);
  font-size:13px;
}

/* ========== CARD ========== */
.card{
  background:var(--card);
  border-radius:var(--radius);
  padding:24px;
  box-shadow:var(--shadow-md);
  border:1px solid rgba(14,30,60,0.04);
}

/* ========== FORM ========== */
.field-label{
  font-size:13px;
  color:#334155;
  font-weight:700;
  margin-bottom:6px;
  display:block;
}
.input,.select{
  width:100%;
  padding:12px 14px;
  border-radius:10px;
  border:1px solid #e6eef8;
  background:#fbfdff;
  font-size:14px;
  outline:none;
}
.input:disabled{
  background:#f1f5f9;
  color:#94a3b8;
}
.select{
  appearance:none;
  background-position:right 14px center;
  background-repeat:no-repeat;
}

/* checkbox */
.checkbox-wrap{
  display:flex;
  align-items:center;
  gap:10px;
  cursor:pointer;
  user-select:none;
}
.checkbox-box{
  width:20px;
  height:20px;
  border-radius:6px;
  border:1px solid #d5dbe6;
  background:white;
  display:flex;
  align-items:center;
  justify-content:center;
}
.checkbox-box svg{
  opacity:0;
}
.checkbox-box.active{
  background:var(--accent);
  border-color:var(--accent);
}
.checkbox-box.active svg{
  opacity:1;
}

/* ERRORS */
.error-box{
  background:#fff1f2;
  color:#991b1b;
  padding:10px 14px;
  border-radius:10px;
  border:1px solid #fee2e2;
  margin-bottom:16px;
  font-size:14px;
}

/* BUTTONS */
.btn{
  padding:10px 14px;
  border-radius:10px;
  font-weight:800;
  cursor:pointer;
  border:none;
  font-size:14px;
  text-decoration:none;
}
.btn-primary{
  background:linear-gradient(180deg,var(--accent),var(--accent-600));
  color:white;
}
.btn-ghost{
  border:1px solid rgba(14,30,60,0.08);
  background:white;
}
.btn-danger{
  background:var(--danger);
  color:white;
}

/* ACTION GROUP */
.actions{
  display:flex;
  justify-content:flex-end;
  gap:12px;
  margin-top:18px;
}

/* ========== MODAL ========== */
.modal-backdrop{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.55);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index:9999;
}
.modal{
  width:90%;
  max-width:420px;
  background:white;
  border-radius:14px;
  overflow:hidden;
  box-shadow:0 28px 70px rgba(0,0,0,0.35);
}
.modal-header,.modal-footer{
  padding:14px 18px;
  border-bottom:1px solid rgba(14,30,60,0.06);
}
.modal-footer{
  border-top:1px solid rgba(14,30,60,0.06);
  display:flex;
  gap:12px;
  justify-content:flex-end;
}
.modal-body{
  padding:18px;
  font-size:15px;
  color:#071030;
}

/* Responsive */
@media(max-width:720px){
  .actions{ flex-direction:column-reverse; }
  .btn{ width:100%; text-align:center; }
}
</style>

<div class="page-wrap">

  <div class="header">
    <div>
      <h1>Edit Pengguna</h1>
      <small>Perbarui role dan status akun pengguna.</small>
    </div>
    <div style="text-align:right; font-size:13px; color:var(--muted);">
      Terakhir diubah <br>
      <strong style="color:#071030;">{{ $user->updated_at->format('d M Y H:i') }}</strong>
    </div>
  </div>

  <div class="card">

    @if ($errors->any())
      <div class="error-box">
        <strong>Terjadi kesalahan:</strong>
        <ul style="padding-left:18px; margin-top:6px;">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="editForm" action="{{ route('admin.users.update', $user->id) }}" method="POST">
      @csrf
      @method('PUT')

      {{-- Nama --}}
      <label class="field-label">Nama</label>
      <input class="input" value="{{ $user->name }}" disabled>

      {{-- Email --}}
      <label class="field-label" style="margin-top:14px;">Email</label>
      <input class="input" value="{{ $user->email }}" disabled>

      {{-- Role --}}
      <label class="field-label" style="margin-top:14px;">Role</label>
      <select name="role" class="select">
        <option value="user" {{ $user->role==='user'?'selected':'' }}>User</option>
        <option value="admin" {{ $user->role==='admin'?'selected':'' }}>Admin</option>
      </select>

      {{-- Status aktif --}}
      <label class="field-label" style="margin-top:14px;">Status</label>
      <label class="checkbox-wrap">
        <span id="activeBox" class="checkbox-box {{ $user->is_active ? 'active' : '' }}">
          <svg width="14" height="12" stroke="white" stroke-width="2" viewBox="0 0 14 12">
            <path d="M1 7L5 11L13 1"/>
          </svg>
        </span>
        <input id="activeInput" type="checkbox" name="is_active" value="1" style="display:none;" {{ $user->is_active ? 'checked':'' }}>
        <span id="activeText" style="font-weight:700;">
          {{ $user->is_active ? 'Active' : 'Inactive' }}
        </span>
      </label>

      {{-- ACTION BUTTONS --}}
      <div class="actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>

        @if(auth()->id() !== $user->id)
        <button id="deleteBtn" type="button" class="btn btn-danger">Hapus</button>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- ========== MODAL KONFIRMASI HAPUS ========== -->
<div id="modalBackdrop" class="modal-backdrop" style="display:none;">
  <div class="modal">
    <div class="modal-header">
      <strong>Konfirmasi Hapus</strong>
    </div>

    <div class="modal-body">
      Anda yakin ingin menghapus pengguna <strong>{{ $user->name }}</strong>?  
      Tindakan ini tidak dapat dibatalkan.
    </div>

    <div class="modal-footer">
      <button id="modalCancel" type="button" class="btn btn-ghost">Batal</button>
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>

<script>
/* ================== CHECKBOX ACTIVE ================== */
const activeBox = document.getElementById('activeBox');
const activeInput = document.getElementById('activeInput');
const activeText = document.getElementById('activeText');

activeBox.addEventListener('click', () => {
  activeInput.checked = !activeInput.checked;
  activeBox.classList.toggle('active');
  activeText.textContent = activeInput.checked ? "Active" : "Inactive";
});

/* ================== MODAL HAPUS ================== */
const deleteBtn = document.getElementById('deleteBtn');
const modalBackdrop = document.getElementById('modalBackdrop');
const modalCancel = document.getElementById('modalCancel');
const deleteForm = document.getElementById('deleteForm');

// OPEN MODAL
if(deleteBtn){
  deleteBtn.addEventListener('click', () => {
    deleteForm.setAttribute('action','{{ url("/masterdashboard/users/".$user->id) }}');
    modalBackdrop.style.display = 'flex';
  });
}

// CLOSE MODAL
modalCancel.addEventListener('click', () => {
  modalBackdrop.style.display = 'none';
});

// CLOSE by clicking backdrop
modalBackdrop.addEventListener('click', e => {
  if(e.target === modalBackdrop){
    modalBackdrop.style.display = 'none';
  }
});

// ESC key close
document.addEventListener('keydown', e => {
  if(e.key === 'Escape'){
    modalBackdrop.style.display = 'none';
  }
});
</script>

@endsection
