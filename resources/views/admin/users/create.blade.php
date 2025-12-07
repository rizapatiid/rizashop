@extends('layouts.app')

@section('content')
<style>
/* Modern, clean, single-column form — self-contained */
:root{
  --bg:#f6f8fb;
  --card:#ffffff;
  --muted:#64748b;
  --accent:#2563eb;
  --accent-700:#1e40af;
  --success:#10b981;
  --danger:#ef4444;
  --radius:12px;
  --shadow: 0 12px 40px rgba(2,6,23,0.06);
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  color-scheme: light;
}

/* Page layout */
.wrapper {
  max-width: 760px;
  margin: 36px auto;
  padding: 26px;
  background: var(--bg);
  border-radius: 14px;
}

/* Card */
.card {
  background: var(--card);
  border-radius: 14px;
  padding: 26px;
  box-shadow: var(--shadow);
  border: 1px solid rgba(14,30,60,0.04);
}

/* Header */
.header {
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:12px;
  margin-bottom:18px;
}
.title { margin:0; font-size:20px; font-weight:900; color:#071033; }
.subtitle { margin-top:6px; color:var(--muted); font-size:13px; }

/* Form */
.form { display:flex; flex-direction:column; gap:14px; margin-top:6px; }

/* Field */
.label { display:block; font-size:13px; font-weight:700; color:#334155; margin-bottom:8px; }
.input {
  width:100%;
  padding:12px 14px;
  border-radius:10px;
  border:1px solid #e6eef8;
  background:#fbfdff;
  font-size:14px;
  outline:none;
  transition: box-shadow .15s, border-color .15s, transform .06s;
  box-shadow: 0 4px 18px rgba(11,17,32,0.02) inset;
}
.input:focus { border-color: rgba(37,99,235,0.28); box-shadow: 0 12px 32px rgba(37,99,235,0.06); transform:translateY(-1px); }
.input[aria-invalid="true"] { border-color: var(--danger); box-shadow: 0 6px 18px rgba(239,68,68,0.06); }

/* password wrapper with icon */
.pw-wrap { position:relative; display:flex; align-items:center; }
.pw-toggle {
  position:absolute;
  right:10px;
  top:50%;
  transform:translateY(-50%);
  height:28px;
  width:28px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  border-radius:6px;
  background:transparent;
  border: none;
  color:var(--muted);
}

/* small helper text */
.helper { font-size:13px; color:var(--muted); margin-top:6px; }
.hint { font-size:12px; color:#94a3b8; margin-top:4px; }

/* match indicator */
.match {
  font-size:13px;
  margin-top:8px;
  font-weight:700;
}
.match.ok { color: var(--success); }
.match.bad { color: var(--danger); }

/* actions */
.actions { display:flex; gap:12px; justify-content:flex-end; margin-top:18px; flex-wrap:wrap; }
.btn { padding:10px 14px; border-radius:10px; font-weight:800; border:none; cursor:pointer; font-size:14px; text-decoration:none; }
.btn-ghost { background:transparent; border:1px solid rgba(14,30,60,0.06); color:#071033; }
.btn-primary { background: linear-gradient(180deg,var(--accent),var(--accent-700)); color:white; box-shadow:0 12px 30px rgba(37,99,235,0.12); }

/* responsive */
@media (max-width:640px){
  .wrapper { padding:18px; }
  .actions { flex-direction:column-reverse; }
  .btn { width:100%; }
}
</style>

<div class="wrapper">
  <div class="card" role="main" aria-labelledby="title-create-user">
    <div class="header">
      <div>
        <h1 id="title-create-user" class="title">Tambah Pengguna</h1>
        <div class="subtitle">Buat akun baru — kosongkan password agar dibuat otomatis.</div>
      </div>
    </div>

    @if($errors->any())
      <div class="errors" role="alert" style="margin-bottom:12px; background:#fff1f2; color:#991b1b; border:1px solid #fee2e2; padding:12px; border-radius:10px;">
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin-top:8px; padding-left:18px;">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="createForm" action="{{ route('admin.users.store') }}" method="POST" novalidate class="form">
      @csrf

      <!-- Name -->
      <div>
        <label class="label" for="name">Nama lengkap</label>
        <input id="name" name="name" class="input" type="text" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required aria-required="true" />
        <div class="helper">Nama lengkap sesuai identitas (untuk profil).</div>
      </div>

      <!-- Email -->
      <div>
        <label class="label" for="email">Email</label>
        <input id="email" name="email" class="input" type="email" value="{{ old('email') }}" placeholder="nama@domain.com" required aria-required="true" />
        <div id="emailHint" class="hint">Email harus unik dan valid — akan digunakan untuk login.</div>
      </div>

      <!-- Role -->
      <div>
        <label class="label" for="role">Role</label>
        <select id="role" name="role" class="input" style="appearance:auto; padding-right:40px;">
          <option value="user" {{ old('role')=='user' ? 'selected' : '' }}>User</option>
          <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
        </select>
      </div>

      <!-- Status (checkbox simple) -->
      <div>
        <label class="label">Status akun</label>
        <label style="display:inline-flex; align-items:center; gap:12px; cursor:pointer; user-select:none;">
          <input id="is_active_checkbox" name="is_active" type="checkbox" value="1" style="display:none;" {{ old('is_active', true) ? 'checked' : '' }}>
          <div id="fakeSwitch" style="width:46px; height:26px; background:#eef2f7; border-radius:999px; position:relative; border:1px solid rgba(14,30,60,0.03);">
            <div id="fakeThumb" style="width:20px; height:20px; background:white; border-radius:999px; position:absolute; left:4px; top:50%; transform:translateY(-50%); box-shadow:0 6px 18px rgba(2,6,23,0.06); transition:left .18s;"></div>
          </div>
          <div id="statusLabel" style="font-weight:800; color:#071033;">{{ old('is_active', true) ? 'Active' : 'Inactive' }}</div>
        </label>
        <div class="helper">Centang untuk aktifkan akun.</div>
      </div>

      <!-- Password -->
      <div>
        <label class="label" for="password">Password (opsional)</label>
        <div class="pw-wrap">
          <input id="password" name="password" class="input" type="password" autocomplete="new-password" placeholder="Kosong = password dibuat otomatis">
          <button type="button" id="pwToggle" class="pw-toggle" aria-label="Tampilkan password" title="Tampilkan/ Sembunyikan password">
            <!-- eye icon (closed by default) -->
            <svg id="pwEyeOpen" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            <svg id="pwEyeClosed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.94 17.94A10.06 10.06 0 0 1 12 19c-7 0-11-7-11-7a18.38 18.38 0 0 1 5-5.11"/>
              <path d="M1 1l22 22"/>
              <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12"/>
            </svg>
          </button>
        </div>
        <div class="helper">Kosongkan agar password dibuat acak. Jika diisi, minimal 6 karakter.</div>
      </div>

      <!-- Konfirmasi Password (mirip dengan password) -->
      <div>
        <label class="label" for="password_confirmation">Konfirmasi Password</label>
        <div class="pw-wrap">
          <input id="password_confirmation" name="password_confirmation" class="input" type="password" autocomplete="new-password" placeholder="Ulangi password jika diisi">
          <button type="button" id="pwToggleConfirm" class="pw-toggle" aria-label="Tampilkan konfirmasi password" title="Tampilkan/ Sembunyikan konfirmasi password">
            <!-- eye icons -->
            <svg id="pwCeyeOpen" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            <svg id="pwCeyeClosed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.94 17.94A10.06 10.06 0 0 1 12 19c-7 0-11-7-11-7a18.38 18.38 0 0 1 5-5.11"/>
              <path d="M1 1l22 22"/>
              <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12"/>
            </svg>
          </button>
        </div>

        <div id="matchMessage" class="match" aria-live="polite" style="display:none;"></div>
        <div class="helper">Harap ketik ulang password jika Anda mengisinya di atas.</div>
      </div>

      <!-- Actions -->
      <div class="actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" id="saveBtn" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
(function(){
  // Elements
  const pw = document.getElementById('password');
  const pwConfirm = document.getElementById('password_confirmation');
  const pwToggle = document.getElementById('pwToggle');
  const pwEyeOpen = document.getElementById('pwEyeOpen');
  const pwEyeClosed = document.getElementById('pwEyeClosed');

  const pwCtoggle = document.getElementById('pwToggleConfirm');
  const pwCeyeOpen = document.getElementById('pwCeyeOpen');
  const pwCeyeClosed = document.getElementById('pwCeyeClosed');

  const matchMessage = document.getElementById('matchMessage');
  const saveBtn = document.getElementById('saveBtn');
  const form = document.getElementById('createForm');

  // Switch visual (status)
  const checkbox = document.getElementById('is_active_checkbox');
  const fakeSwitch = document.getElementById('fakeSwitch');
  const fakeThumb = document.getElementById('fakeThumb');
  const statusLabel = document.getElementById('statusLabel');

  function setSwitchVisual(checked){
    if(checked){
      fakeSwitch.style.background = 'linear-gradient(90deg, var(--accent), var(--accent-700))';
      fakeThumb.style.left = 'calc(100% - 4px - 20px)';
      statusLabel.textContent = 'Active';
    } else {
      fakeSwitch.style.background = '#eef2f7';
      fakeThumb.style.left = '4px';
      statusLabel.textContent = 'Inactive';
    }
  }
  setSwitchVisual(checkbox.checked);
  fakeSwitch.parentElement.addEventListener('click', function(){
    checkbox.checked = !checkbox.checked;
    setSwitchVisual(checkbox.checked);
  });

  // toggle show/hide password for password field
  function togglePassword(inputEl, eyeOpenEl, eyeClosedEl){
    if(inputEl.type === 'password'){
      inputEl.type = 'text';
      eyeOpenEl.style.display = 'inline';
      eyeClosedEl.style.display = 'none';
    } else {
      inputEl.type = 'password';
      eyeOpenEl.style.display = 'none';
      eyeClosedEl.style.display = 'inline';
    }
  }

  pwToggle.addEventListener('click', function(){ togglePassword(pw, pwEyeOpen, pwEyeClosed); });
  pwCtoggle.addEventListener('click', function(){ togglePassword(pwConfirm, pwCeyeOpen, pwCeyeClosed); });

  // initialize eye icons: closed shown, open hidden
  pwEyeOpen.style.display = 'none';
  pwEyeClosed.style.display = 'inline';
  pwCeyeOpen.style.display = 'none';
  pwCeyeClosed.style.display = 'inline';

  // match checking (live)
  function checkMatch(){
    const a = pw.value;
    const b = pwConfirm.value;

    // if both empty -> hide message
    if(!a && !b){
      matchMessage.style.display = 'none';
      matchMessage.textContent = '';
      pw.setAttribute('aria-invalid', 'false');
      pwConfirm.setAttribute('aria-invalid', 'false');
      return true;
    }

    // if password empty but confirm has value -> not match
    if(!a && b){
      matchMessage.style.display = 'block';
      matchMessage.className = 'match bad';
      matchMessage.textContent = 'Tidak cocok — password kosong.';
      pw.setAttribute('aria-invalid', 'true');
      pwConfirm.setAttribute('aria-invalid', 'true');
      return false;
    }

    // if a exists and b empty -> hide message (user still typing)
    if(a && !b){
      matchMessage.style.display = 'none';
      matchMessage.textContent = '';
      pw.setAttribute('aria-invalid', 'false');
      pwConfirm.setAttribute('aria-invalid', 'false');
      return false;
    }

    // both exist -> compare
    if(a === b){
      matchMessage.style.display = 'block';
      matchMessage.className = 'match ok';
      matchMessage.textContent = 'Cocok';
      pw.setAttribute('aria-invalid', 'false');
      pwConfirm.setAttribute('aria-invalid', 'false');
      return true;
    } else {
      matchMessage.style.display = 'block';
      matchMessage.className = 'match bad';
      matchMessage.textContent = 'Tidak cocok';
      pw.setAttribute('aria-invalid', 'true');
      pwConfirm.setAttribute('aria-invalid', 'true');
      return false;
    }
  }

  pw.addEventListener('input', checkMatch);
  pwConfirm.addEventListener('input', checkMatch);

  // prevent submit if password mismatch
  form.addEventListener('submit', function(e){
    // if user supplied password, enforce minimum length
    if(pw.value && pw.value.length < 6){
      e.preventDefault();
      pw.setAttribute('aria-invalid','true');
      alert('Password minimal 6 karakter jika diisi.');
      pw.focus();
      return;
    }

    // if either password or confirm provided, require match
    if(pw.value || pwConfirm.value){
      const ok = checkMatch();
      if(!ok){
        e.preventDefault();
        alert('Password dan konfirmasi tidak cocok.');
        pwConfirm.focus();
        return;
      }
    }

    // disable button to prevent double submit
    if(saveBtn){
      saveBtn.disabled = true;
      saveBtn.textContent = 'Menyimpan...';
      saveBtn.style.opacity = '0.85';
    }
  });
})();
</script>
@endsection
