{{-- resources/views/profile/edit.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Akun Saya — Tokoriza</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    :root{ --accent:#0ea5e9; --accent-600:#0284c7; --header-btn-w:56px; }
    .card{ border-radius:14px; background:#fff; border:1px solid rgba(15,23,42,0.04); }
    .floating{ transition: transform .18s ease, box-shadow .18s ease; }
    .panel-hidden{ display:none; }
    .sidebar-active{ background: rgba(14,165,233,0.08); color:#0369a1; font-weight:600; }
    .modal-wrapper{ position:fixed; inset:0; z-index:9999; display:none; align-items:center; justify-content:center; }
    .modal-wrapper.active{ display:flex; }
    .modal-backdrop{ position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter: blur(3px); }
    .modal-content{ position:relative; width:100%; max-width:720px; background:#fff; border-radius:12px; overflow:visible; padding:0; animation:zoom .22s ease; box-shadow:0 10px 30px rgba(2,6,23,0.08); z-index:10; }
    @keyframes zoom{ 0%{ transform: scale(.96); opacity:0 } 100%{ transform: scale(1); opacity:1 } }
    .muted{ color:#64748b; }
    .form-input{ width:100%; border-radius:.75rem; border:1px solid rgba(148,163,184,0.2); background:#fff; padding:.625rem .75rem; font-size:.875rem; color:#0f172a; }
    .input-with-icon{ position:relative; }
    .input-icon-btn{ position:absolute; right:0.5rem; top:50%; transform:translateY(-50%); background:transparent; border:none; padding:.25rem; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
    .toast{ position:fixed; right:18px; bottom:18px; background:#111827; color:#fff; padding:10px 14px; border-radius:10px; box-shadow:0 6px 18px rgba(2,6,23,0.12); z-index:11000; display:none; max-width:320px; }
    .toast.show{ display:block; animation:slideUp .28s ease; }
    @keyframes slideUp{ from{ transform:translateY(8px); opacity:0 } to{ transform:translateY(0); opacity:1 } }

    /* header tweaks for perfectly centered logo */
    .site-header { height:64px; display:block; position:relative; }
    .site-header .container { max-width:1120px; margin:0 auto; height:100%; padding:0 1.5rem; display:flex; align-items:center; justify-content:space-between; position:relative; }
    .back-btn { display:inline-flex; align-items:center; gap:.5rem; padding:.4rem .6rem; border-radius:8px; background:transparent; border:1px solid transparent; cursor:pointer; width:var(--header-btn-w); height:40px; justify-content:flex-start; }
    .back-btn:hover{ background: rgba(2,6,23,0.03); }
    .header-right-spacer { width:var(--header-btn-w); height:40px; visibility:hidden; }

    /* centered logo */
    .logo-center { position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); display:flex; align-items:center; justify-content:center; pointer-events:auto; }
    .logo-center img { height:40px; object-fit:contain; display:block; }

    /* CS badge (used in sidebar card) */
    .cs-badge { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .6rem; border-radius:8px; background:rgba(14,165,233,0.06); color:#0369a1; border:1px solid rgba(2,6,23,0.04); font-weight:600; }

    /* profile card styling - photo left with name & join date below photo, details box on right, action buttons under details box */
    .profile-card { display:flex; gap:1.25rem; align-items:flex-start; padding:1.25rem; border-radius:12px; }
    .profile-card, .profile-card * { transition: none !important; }
    .profile-card:hover { transform: none !important; box-shadow: none !important; }

    .profile-left { display:flex; flex-direction:column; align-items:flex-start; gap:0.35rem; width:170px; }
    .avatar-wrap { position:relative; }
    .avatar { width:165px; height:165px; border-radius:9999px; object-fit:cover; border:3px solid #fff; box-shadow:0 10px 34px rgba(2,6,23,0.12); }
    .profile-name { font-weight:700; font-size:1rem; color:#0f172a; margin-top:0.35rem; }
    .profile-joined { font-size:0.72rem; color:#64748b; margin-top:0.02rem; }

    .profile-right { flex:1; display:flex; flex-direction:column; gap:0.75rem; }
    .details-box { padding:1rem; border-radius:10px; border:1px solid rgba(15,23,42,0.04); background:#fff; }
    .details-row { display:flex; flex-direction:column; gap:0.5rem; }
    .details-label { font-size:0.75rem; color:#64748b; }
    .details-value { font-size:0.95rem; color:#0f172a; }

    .card-actions { display:flex; gap:0.5rem; margin-top:0.5rem; width:100%; justify-content:flex-start; flex-wrap:wrap; }
    .card-actions .btn { min-width:140px; }

    @media (max-width: 768px) {
      .site-header .container { padding:0 1rem; }
      .logo-center img { height:36px; }
      .profile-card { flex-direction:column; align-items:center; text-align:center; }
      .profile-left { align-items:center; width:100%; }
      .profile-right { width:100%; }
      .card-actions { justify-content:center; }
      :root { --header-btn-w:48px; }
      .back-btn { width:var(--header-btn-w); }
      .header-right-spacer { width:var(--header-btn-w); }
    }

<style>
/* ===== Modal tidy polish (compatible with existing style) ===== */
.modal-content {
  width: 100%;
  max-width: 720px;
  max-height: calc(100vh - 84px);
  overflow: hidden;
  border-radius: 12px;
  background: #ffffff;
  display: flex;
  flex-direction: column;
  box-shadow: 0 18px 36px rgba(2,6,23,0.10);
}

/* header */
.modal-head {
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  padding:16px 18px;
  border-bottom:1px solid rgba(15,23,42,0.04);
}
.modal-head .title { display:flex; gap:12px; align-items:center; font-weight:700; color:#0f172a; }

/* body scroll */
.modal-body {
  padding:16px 18px;
  overflow-y:auto;
  -webkit-overflow-scrolling: touch;
}

/* actions */
.modal-actions {
  padding:12px 18px;
  border-top:1px solid rgba(0, 76, 255, 0.04);
  display:flex;
  justify-content:flex-end;
  gap:.75rem;
  background: linear-gradient(180deg, rgba(255,255,255,0.7), rgba(255,255,255,1));
}
@media(min-width:1024px){
  .modal-actions { position: sticky; bottom: 0; }
}

/* responsive grid: vertical mobile, two columns desktop */
.modal-grid { display:block; gap:12px; }
@media(min-width:1024px){
  .modal-grid { display:flex; gap:18px; align-items:flex-start; }
  .modal-grid .col { width:50%; }
}

/* compact internal grids */
.row-2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
@media(max-width:640px){ .row-2 { grid-template-columns:1fr; } }

/* keep existing form-input but tighten */
.form-input {
  width:100%;
  padding:.625rem .75rem;
  border-radius:10px;
  border:1px solid rgba(26, 92, 245, 0.06);
  background:#fff;
  font-size:.95rem;
  color:#0f172a;
}
.form-input::placeholder { color:#9aa4b2; }

/* helper / muted */
.helper { font-size:0.85rem; color:#64748b; margin-top:6px; }

/* small icon left inside input */
.input-with-icon { position:relative; }
.input-with-icon svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8; width:16px;height:16px; }
.input-with-icon .form-input { padding-left:36px; }

/* textarea niceness */
.form-input[rows] { min-height:110px; resize:vertical; }

/* button tokens to match your theme */
.btn-ghost { padding:.55rem .9rem; border-radius:8px; border:1px solid rgba(15,23,42,0.06); background:#fff; color:#0f172a; }
.btn-primary { padding:.55rem 1rem; border-radius:8px; background:#0ea5e9; color:#fff; font-weight:600; border:none; }
.btn-danger  { padding:.55rem 1rem; border-radius:8px; background:#ef4444; color:#fff; font-weight:600; border:none; }

/* limit modal body height a bit on small screens */
@media(max-width:640px){
  .modal-content { max-width:96%; max-height: calc(100vh - 48px); border-radius:10px; }
  .modal-head, .modal-actions, .modal-body { padding-left:14px; padding-right:14px; }
}
</style>

    
  </style>
</head>

<body class="min-h-screen bg-gray-50 text-slate-800 antialiased">
  <div id="toast" class="toast" role="status" aria-live="polite"></div>

  {{-- HEADER: centered logo, back icon on left --}}
  <header class="bg-white border-b sticky top-0 z-50 site-header">
    <div class="container">
      <button type="button" class="back-btn" aria-label="Kembali" onclick="window.history.back();">
        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.8" d="M15 19l-7-7 7-7"/></svg>
        <span class="sr-only">Kembali</span>
      </button>

      <div class="logo-center" aria-hidden="false">
        <a href="{{ url('/') }}" class="flex items-center">
          <img src="{{ asset('images/logo/logo_tokoriza.png') }}" alt="Tokoriza">
        </a>
      </div>

      <div class="header-right-spacer" aria-hidden="true"></div>
    </div>
  </header>

  {{-- HERO --}}
  <section class="max-w-7xl mx-auto px-6 lg:px-8 mt-8">
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <h1 class="text-2xl font-bold text-slate-800">Akun Saya</h1>
      <p class="text-sm muted mt-1">Kelola informasi akun, foto profil, dan alamat Anda.</p>
    </div>
  </section>

  {{-- MAIN --}}
  <main class="max-w-7xl mx-auto px-6 lg:px-8 mt-6 mb-20">
   <div class="grid grid-cols-12 gap-8 items-start">

      <aside class="col-span-12 lg:col-span-3">
        <div class="card p-6 sticky top-24 shadow-sm">

          <nav class="space-y-3">
            <button class="w-full flex items-center gap-3 p-3 rounded-lg sidebar-item hover:bg-slate-50 transition sidebar-active" data-panel="panel-detail">
              <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.6" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/></svg>
              <span class="text-sm">Detail Profil</span>
            </button>

            <button class="w-full flex items-center gap-3 p-3 rounded-lg sidebar-item hover:bg-slate-50 transition" data-panel="panel-address">
              <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.6" d="M12 2c3.866 0 7 3.134 7 7 0 5.25-7 13-7 13S5 14.25 5 9c0-3.866 3.134-7 7-7z"/><circle cx="12" cy="9" r="2.4" stroke-width="1.6"/></svg>
              <span class="text-sm">Alamat</span>
            </button>

            <button class="w-full flex items-center gap-3 p-3 rounded-lg sidebar-item hover:bg-slate-50 transition" data-panel="panel-help">
              <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="1.6"/><path stroke-linecap="round" stroke-width="1.6" d="M12 17h.01"/><path stroke-linecap="round" stroke-width="1.6" d="M12 13a3 3 0 10-3-3"/></svg>
              <span class="text-sm">Bantuan</span>
            </button>

            <button class="w-full flex items-center gap-3 p-3 rounded-lg sidebar-item hover:bg-slate-50 transition" data-panel="panel-cs">
              <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.6" d="M21 15a2 2 0 01-2 2h-3l-4 4v-4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v8z"/><circle cx="9" cy="12" r="1.2"/><circle cx="12" cy="12" r="1.2"/><circle cx="15" cy="12" r="1.2"/></svg>
              <span class="text-sm">Hubungi CS</span>
            </button>
          </nav>

          <div class="mt-6 pt-4 border-t">
            <div class="text-sm text-slate-600 mt-2">Butuh bantuan? Klik <span class="cs-badge">Hubungi CS</span> di menu.</div>
          </div>
        </div>
      </aside>

      <section class="col-span-12 lg:col-span-9 space-y-0">

        {{-- Redesigned PROFILE CARD --}}
        <div id="panel-detail" class="panel card p-6 shadow floating">
          <div class="profile-card">
            <div class="profile-left">
              <div class="avatar-wrap" style="position:relative;">
                <img id="header-avatar" src="{{ $user->profile_photo ? asset('storage/profile/'.$user->profile_photo) : asset('images/default-avatar.png') }}" class="avatar">

                <button type="button" onclick="openModal('modal-photo')" aria-label="Ubah foto profil" title="Ubah foto profil" style="position:absolute; right:4px; bottom:4px; background:#fff; border-radius:9999px; padding:8px; border:1px solid rgba(15,23,42,0.06); box-shadow:0 6px 14px rgba(2,6,23,0.08); display:flex; align-items:center; justify-content:center;">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 7h4l2-3h6l2 3h4v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
              </div>

              <div class="profile-name">{{ $user->name }}</div>
              <div class="profile-joined mt-0.5">Bergabung sejak {{ $user->created_at->format('d M Y') }}</div>
            </div>

            <div class="profile-right">
              <div class="details-box">
                <div class="details-row">
                  <div>
                    <div class="details-label">Nama Lengkap</div>
                    <div class="details-value">{{ $user->name }}</div>
                  </div>

                  <div class="mt-3">
                    <div class="details-label">Nomor Handphone</div>
                    <div class="details-value">{{ ($user->phone_country ?? '') . ' ' . ($user->phone ?? '-') }}</div>
                  </div>

                  <div class="mt-3">
                    <div class="details-label">Alamat Email</div>
                    <div class="details-value">{{ $user->email }}</div>
                  </div>
                </div>
              </div>

              <div class="card-actions">
                <div class="card-actions">

                    <!-- EDIT PROFIL -->
                    <button type="button"
                        onclick="openModal('modal-personal')"
                        class="btn px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-medium transition flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>

                        Edit Profil
                    </button>


                    <!-- UBAH PASSWORD -->
                    <button type="button"
                        onclick="openModal('modal-password')"
                        class="btn px-4 py-2 rounded-lg bg-white border hover:shadow transition text-sm flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-600"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 8V7a5 5 0 10-10 0v1M5 8h14v10a2 2 0 01-2 2H7a2 2 0 01-2-2V8z"/>
                        </svg>

                        Ubah Password
                    </button>


                    <!-- HAPUS AKUN -->
                    <button type="button"
                        onclick="openModal('modal-delete')"
                        class="btn px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-sm flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2m2 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h12z" />
                        </svg>

                        Hapus Akun
                    </button>

                </div>

              </div>
            </div>
          </div>
        </div>

        {{-- ALAMAT: menggunakan struktur terperinci (address_full, village, subdistrict, city, province, country, postal_code) --}}


       
        {{-- PANEL ADDRESS  --}}
    
        <div id="panel-address" class="panel card  p-6 shadow floating">

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Alamat Saya</h3>
                <button type="button"
                    onclick="openModal('modal-add-address')"
                    class="px-3 py-1.5 rounded-lg bg-sky-600 text-white hover:bg-sky-700 text-sm flex items-center gap-2">

                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                    </svg>

                    Tambah Alamat
                </button>
            </div>

            <div class="mt-6 space-y-4">

                @if($user->addresses->count() === 0)
                    <p class="text-sm text-slate-600">Belum ada alamat. Tambahkan alamat baru.</p>
                @endif

                {{-- LOOP SEMUA ALAMAT --}}
                @foreach($user->addresses as $address)
                    @include('profile.partials.address-item', ['address' => $address])
                @endforeach

            </div>
          
        </div>




        <div id="panel-help" class="panel card p-6 shadow floating panel-hidden">
          <h3 class="text-lg font-semibold">Bantuan & FAQ</h3>
          <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-600">
            <div class="p-4 border rounded-lg">
              <p class="font-medium">Bagaimana cara cek status pesanan?</p>
              <p class="mt-1">Buka menu Pesanan lalu pilih pesanan terkait.</p>
            </div>
            <div class="p-4 border rounded-lg">
              <p class="font-medium">Cara ganti alamat?</p>
              <p class="mt-1">Klik Alamat → Tambah / Edit.</p>
            </div>
          </div>
        </div>

        <div id="panel-cs" class="panel card p-6 shadow floating panel-hidden">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold">Hubungi Customer Service</h3>
            <button type="button" class="text-sm px-3 py-1 rounded-lg border" onclick="openModal('modal-cs')">Chat CS</button>
          </div>

          <div class="mt-6 text-sm text-slate-700 space-y-3">
            <div class="p-4 border rounded-lg">
              <p class="font-medium">Live Chat</p>
              <p class="mt-1">Klik tombol "Chat CS" di kanan atas untuk memulai chat langsung dengan tim support kami.</p>
            </div>

            <div class="p-4 border rounded-lg">
              <p class="font-medium">Telepon</p>
              <p class="mt-1">0812-3456-7890 (Senin–Jumat 09:00–17:00)</p>
            </div>

            <div class="p-4 border rounded-lg">
              <p class="font-medium">Email</p>
              <p class="mt-1">support@tokoriza.id</p>
            </div>
          </div>
        </div>

      </section>
    </div>
  </main>

  {{-- MODALS (same as before, except modal-address-edit is updated) --}}
  <div id="modal-photo" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-photo')"></div>
    <div class="modal-content max-w-md">
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold">Ubah Foto Profil</h3>
        <button type="button" class="text-slate-500" onclick="closeModal('modal-photo')">✕</button>
      </div>

      <form id="form-photo" method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="px-6 py-6 space-y-4">
        @csrf

        <div class="flex flex-col items-center gap-4">
          <img id="photo-preview" src="{{ $user->profile_photo ? asset('storage/profile/'.$user->profile_photo) : asset('images/default-avatar.png') }}" class="w-32 h-32 rounded-full object-cover border shadow">
          <input id="photo-input" type="file" name="profile_photo" accept="image/*" class="form-input" onchange="previewImage(event,'photo-preview','header-avatar')">
          <p class="text-xs muted">Format JPG/PNG/WebP — maksimal 2MB.</p>
        </div>

        <div class="flex justify-end gap-3">
          <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal('modal-photo')">Batal</button>
          <button id="photo-save" type="button" class="px-4 py-2 bg-sky-600 text-white rounded-lg">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <div id="modal-personal" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-personal')"></div>
    <div class="modal-content max-w-2xl">
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold">Edit Profil</h3>
        <button type="button" class="text-slate-500" onclick="closeModal('modal-personal')">✕</button>
      </div>

      <form id="form-personal" method="POST" action="{{ route('profile.update') }}" class="px-6 py-6 space-y-4">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-slate-600 mb-1">Nama lengkap</label>
            <input name="name" value="{{ old('name', $user->name) }}" class="form-input">
          </div>

          <div>
            <label class="block text-sm text-slate-600 mb-1">Kode Negara</label>
            <input name="phone_country" value="{{ old('phone_country', $user->phone_country) }}" class="form-input bg-gray-100 cursor-not-allowed" readonly aria-readonly="true">
          </div>

          <div>
            <label class="block text-sm text-slate-600 mb-1">No Telepon</label>
            <input name="phone" value="{{ old('phone', $user->phone) }}" class="form-input">
          </div>

          <div>
            <label class="block text-sm text-slate-600 mb-1">Email</label>
            <input name="email" type="email" value="{{ old('email', $user->email) }}" class="form-input">
          </div>
        </div>

        <div class="flex justify-end gap-3">
          <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal('modal-personal')">Batal</button>
          <button id="personal-save" type="button" class="px-4 py-2 bg-sky-600 text-white rounded-lg">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

            <!-- MODAL: Tambah Alamat (tertata, responsive) -->
<div id="modal-add-address" class="modal-wrapper" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="modal-backdrop" onclick="closeModal('modal-add-address')"></div>

  <div class="modal-content" role="document" aria-labelledby="add-address-title">
    <div class="modal-head">
      <div class="title">
        <svg class="w-5 h-5 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 4v16m8-8H4"/>
        </svg>
        <div>
          <div id="add-address-title">Tambah Alamat Baru</div>
          <div class="helper" style="margin-top:3px;">Isikan data alamat untuk pengiriman.</div>
        </div>
      </div>
      <button type="button" class="text-slate-500" onclick="closeModal('modal-add-address')" aria-label="Tutup">✕</button>
    </div>

    <div class="modal-body">
      <form method="POST" action="{{ route('addresses.store') }}" novalidate>
        @csrf

        <div class="modal-grid">
          <div class="col">
            <div class="space-y-4">
              <div>
                <label class="helper">Label Alamat *</label>
                <input name="label" class="form-input" placeholder="Rumah / Kantor / Orang Tua" required>
              </div>

              <div>
                <label class="helper">Nama Penerima *</label>
                <input name="recipient_name" class="form-input" placeholder="Nama penerima" required>
              </div>

              <div class="row-2">
                <div>
                  <label class="helper">Kode Negara</label>
                  <input name="phone_country" class="form-input bg-gray-100 cursor-not-allowed" value="{{ $user->phone_country }}" readonly>
                </div>
                <div class="input-with-icon">
                  <label class="helper">Nomor Telepon *</label>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M21 15.46..."/></svg>
                  <input name="phone" class="form-input" placeholder="0812xxxxxxx" required>
                </div>
              </div>

              <div>
                <label class="helper">Alamat Lengkap *</label>
                <input name="address_full" class="form-input" placeholder="Jalan, RT/RW, Blok, No" required>

                <div class="helper">Isi detail alamat sehingga kurir mudah menemukan tujuan.</div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="space-y-4">
              <div class="row-2">
                <div>
                  <label class="helper">Desa / Kelurahan</label>
                  <input name="village" class="form-input" placeholder="Contoh: Sukamaju">
                </div>
                <div>
                  <label class="helper">Kecamatan</label>
                  <input name="subdistrict" class="form-input" placeholder="Contoh: Kebayoran">
                </div>
              </div>

              <div class="row-2">
                <div>
                  <label class="helper">Kota / Kabupaten</label>
                  <input name="city" class="form-input" placeholder="Contoh: Jakarta Selatan">
                </div>
                <div>
                  <label class="helper">Provinsi</label>
                  <input name="province" class="form-input" placeholder="Contoh: DKI Jakarta">
                </div>
              </div>

              <div class="row-2">
                <div class="input-with-icon">
                  <label class="helper">Kode Pos</label>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5..."/></svg>
                  <input name="postal_code" class="form-input" placeholder="12345">
                </div>
                <div>
                  <label class="helper">Negara</label>
                  <input name="country" class="form-input" value="Indonesia">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" onclick="closeModal('modal-add-address')" class="btn-ghost">Batal</button>
          <button type="submit" class="btn-primary">Simpan Alamat</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: Edit Alamat (tertata) -->
<div id="modal-edit-address" class="modal-wrapper" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="modal-backdrop" onclick="closeModal('modal-edit-address')"></div>

  <div class="modal-content" role="document" aria-labelledby="edit-address-title">
    <div class="modal-head">
      <div class="title">
        <svg class="w-5 h-5 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15.232 5.232l3.536 3.536M4 20h4.768L19.768 9.232"/>
        </svg>
        <div>
          <div id="edit-address-title">Edit Alamat</div>
          <div class="helper" style="margin-top:3px;">Perbarui detail alamat pengiriman.</div>
        </div>
      </div>
      <button type="button" class="text-slate-500" onclick="closeModal('modal-edit-address')" aria-label="Tutup">✕</button>
    </div>

    <div class="modal-body">
      <form id="form-edit-address" method="POST" novalidate>
        @csrf @method('PUT')
        <input type="hidden" name="address_id" id="edit_address_id">

        <div class="modal-grid">
          <div class="col">
            <div class="space-y-4">
              <div>
                <label class="helper">Label Alamat</label>
                <input name="label" id="edit_label" class="form-input" placeholder="Rumah / Kantor">
              </div>

              <div>
                <label class="helper">Nama Penerima</label>
                <input name="recipient_name" id="edit_recipient" class="form-input" placeholder="Nama penerima">
              </div>

              <div class="row-2">
                <div>
                  <label class="helper">Kode Negara</label>
                  <input name="phone_country" id="edit_phone_country" class="form-input bg-gray-100 cursor-not-allowed" readonly>
                </div>
                <div>
                  <label class="helper">Nomor Telepon</label>
                  <input name="phone" id="edit_phone" class="form-input" placeholder="0812xxxxxxx">
                </div>
              </div>

              <div>
                <label class="helper">Alamat Lengkap</label>
                <textarea name="address_full" id="edit_address_full" class="form-input" rows="4" placeholder="Jalan, RT/RW, Blok, No"></textarea>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="space-y-4">
              <div class="row-2">
                <div><label class="helper">Desa / Kelurahan</label><input id="edit_village" name="village" class="form-input"></div>
                <div><label class="helper">Kecamatan</label><input id="edit_subdistrict" name="subdistrict" class="form-input"></div>
              </div>

              <div class="row-2">
                <div><label class="helper">Kota / Kabupaten</label><input id="edit_city" name="city" class="form-input"></div>
                <div><label class="helper">Provinsi</label><input id="edit_province" name="province" class="form-input"></div>
              </div>

              <div class="row-2">
                <div><label class="helper">Kode Pos</label><input id="edit_postal" name="postal_code" class="form-input"></div>
                <div><label class="helper">Negara</label><input id="edit_country" name="country" class="form-input"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" onclick="closeModal('modal-edit-address')" class="btn-ghost">Batal</button>
          <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>



                        <!-- MODAL: Delete Address -->
            <div id="modal-delete-address" class="modal-wrapper" aria-hidden="true">
            <div class="modal-backdrop" onclick="closeModal('modal-delete-address')"></div>
            <div class="modal-content max-w-md">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-red-600">Hapus Alamat</h3>
                <button type="button" class="text-slate-500" onclick="closeModal('modal-delete-address')">✕</button>
                </div>

                <form id="form-delete-address" method="POST" class="px-6 py-6 space-y-4" onsubmit="return false;">
                @csrf
                @method('DELETE')

                <p class="text-sm muted">Apakah Anda yakin ingin menghapus alamat ini? Aksi ini tidak dapat dibatalkan.</p>

                <div class="flex justify-end gap-3">
                    <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal('modal-delete-address')">Batal</button>
                    <button id="delete-address-confirm" type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus Alamat</button>
                </div>
                </form>
            </div>
            </div>



  <div id="modal-password" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-password')"></div>
    <div class="modal-content max-w-md">
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold">Ubah Password</h3>
        <button type="button" class="text-slate-500" onclick="closeModal('modal-password')">✕</button>
      </div>

      <form id="form-password" method="POST" action="{{ route('password.update') }}" class="px-6 py-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm mb-1">Password Saat Ini</label>
          <div class="input-with-icon">
            <input id="current_password" type="password" name="current_password" class="form-input pr-10">
            <button type="button" id="toggle-current" class="input-icon-btn" aria-label="Tampilkan password saat ini">
              <svg id="icon-current" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="1.6" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-width="1.6" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1">Password Baru</label>
          <div class="input-with-icon">
            <input id="password" type="password" name="password" class="form-input pr-10">
            <button type="button" id="toggle-password" class="input-icon-btn" aria-label="Tampilkan password baru">
              <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="1.6" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-width="1.6" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1">Konfirmasi Password</label>
          <div class="input-with-icon">
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-input pr-10">
            <button type="button" id="toggle-password-confirm" class="input-icon-btn" aria-label="Tampilkan konfirmasi password">
              <svg id="icon-password-confirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="1.6" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-width="1.6" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
          </div>
        </div>

        <div class="flex justify-end gap-3">
          <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal('modal-password')">Batal</button>
          <button id="password-save" type="button" class="px-4 py-2 bg-sky-600 text-white rounded-lg">Simpan Password</button>
        </div>
      </form>
    </div>
  </div>

  <div id="modal-delete" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-delete')"></div>
    <div class="modal-content max-w-md">
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
        <button type="button" class="text-slate-500" onclick="closeModal('modal-delete')">✕</button>
      </div>

      <form id="form-delete" method="POST" action="{{ route('profile.destroy') }}" class="px-6 py-6 space-y-4" onsubmit="return false;">
        @csrf
        @method('DELETE')

        <div>
          <label class="text-sm mb-1 block">Password</label>
          <input id="delete-password" type="password" name="password" required class="form-input">
          <p id="delete-error" class="text-xs text-red-600 mt-1 hidden"></p>
        </div>

        <p class="text-sm muted">Akun Anda akan dihapus permanen dari sistem.</p>

        <div class="flex justify-end gap-3">
          <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeModal('modal-delete')">Batal</button>
          <button id="delete-confirm" type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus Akun</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal CS -->
  <div id="modal-cs" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-cs')"></div>
    <div class="modal-content max-w-md">
      <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold">Chat Customer Service</h3>
        <button type="button" class="text-slate-500" onclick="closeModal('modal-cs')">✕</button>
      </div>

      <div class="px-6 py-6 space-y-4">
        <p class="text-sm">Halo! Silakan tulis pesan Anda. Tim CS kami akan membalas secepatnya.</p>
        <form id="form-cs" onsubmit="return false;">
          <textarea id="cs-message" class="form-input" rows="4" placeholder="Tulis pesan..."></textarea>
          <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-cs')" class="px-4 py-2 border rounded-lg">Batal</button>
            <button type="button" onclick="sendCsMessage()" class="px-4 py-2 bg-sky-600 text-white rounded-lg">Kirim</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- SCRIPTS (unchanged logic) --}}
  <script>
    function showToast(msg, ms = 3500) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(()=> t.classList.remove('show'), ms);
    }

    const sidebarItems = document.querySelectorAll('.sidebar-item');
    const panels = document.querySelectorAll('.panel');
    function activatePanel(id, updateHash = true) {
      panels.forEach(p => p.classList.add('panel-hidden'));
      const el = document.getElementById(id);
      if (el) el.classList.remove('panel-hidden');
      sidebarItems.forEach(btn => btn.classList.toggle('sidebar-active', btn.dataset.panel === id));
      if (updateHash) history.replaceState(null,'','#' + id.replace('panel-',''));
    }
    sidebarItems.forEach(btn => btn.addEventListener('click', () => activatePanel(btn.dataset.panel)));
    window.addEventListener('DOMContentLoaded', () => {
      const hash = location.hash.replace('#','');
      activatePanel(hash ? 'panel-' + hash : 'panel-detail', false);

      @if(session()->has('status'))
        (function(){
          const s = {!! json_encode(session('status')) !!};
          if (s === 'profile-updated') {
            showToast('Profil berhasil diperbarui.');
          } else if (s === 'password-updated') {
            showToast('Password berhasil diubah.');
          } else {
            showToast(String(s));
          }
        })();
      @endif

      @if(session()->has('message'))
        (function(){
          const m = {!! json_encode(session('message')) !!};
          showToast(String(m));
        })();
      @endif
    });

    function openModal(id){
      const m = document.getElementById(id);
      if(!m) return;
      m.classList.add('active');
      m.setAttribute('aria-hidden','false');
      document.body.style.overflow = 'hidden';
      setTimeout(()=> {
        const first = m.querySelector('input, textarea, button');
        if(first) first.focus();
      }, 120);
    }
    function closeModal(id){
      const m = document.getElementById(id);
      if(!m) return;
      m.classList.remove('active');
      m.setAttribute('aria-hidden','true');
      document.body.style.overflow = '';
    }
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal-wrapper.active').forEach(m => {
          m.classList.remove('active'); m.setAttribute('aria-hidden','true');
        });
        document.body.style.overflow = '';
      }
    });

    function previewImage(e, previewId, headerId = null){
      const file = e.target.files ? e.target.files[0] : null;
      if(!file) return;
      if (file.size > 2 * 1024 * 1024) { alert('Ukuran file maksimal 2MB'); e.target.value = ''; return; }
      const reader = new FileReader();
      reader.onload = function(ev){
        const img = document.getElementById(previewId);
        if(img) img.src = ev.target.result;
        if(headerId){
          const h = document.getElementById(headerId);
          if(h) h.src = ev.target.result;
        }
      };
      reader.readAsDataURL(file);
    }

    function toggleInputVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (!input) return;
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      if (icon) { icon.style.opacity = isPassword ? '0.9' : '0.6'; }
    }

    (function setupPasswordToggles(){
      const map = [
        {btn: 'toggle-current', input: 'current_password', icon: 'icon-current'},
        {btn: 'toggle-password', input: 'password', icon: 'icon-password'},
        {btn: 'toggle-password-confirm', input: 'password_confirmation', icon: 'icon-password-confirm'},
      ];
      map.forEach(m => {
        const b = document.getElementById(m.btn);
        if (!b) return;
        b.addEventListener('click', ()=> toggleInputVisibility(m.input, m.icon));
      });
    })();

    (function(){
      const formPhoto = document.getElementById('form-photo');
      if(!formPhoto) return;
      const actionUrl = formPhoto.getAttribute('action');
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const photoSaveBtn = document.getElementById('photo-save');

      if (photoSaveBtn) {
        photoSaveBtn.addEventListener('click', function(){
          formPhoto.dispatchEvent(new Event('submit', {cancelable: true}));
        });
      }

      formPhoto.addEventListener('submit', async function(e){
        e.preventDefault();
        const input = document.getElementById('photo-input');
        if(!input || !input.files || !input.files[0]) {
          showToast('Pilih file foto terlebih dahulu');
          return;
        }
        const file = input.files[0];
        if (file.size > 2 * 1024 * 1024) { showToast('Ukuran file maksimal 10MB'); return; }

        const fd = new FormData();
        fd.append('profile_photo', file);

        const saveBtn = photoSaveBtn || document.getElementById('photo-save');
        if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Menyimpan...'; }

        try {
          const res = await fetch(actionUrl, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: fd,
            credentials: 'same-origin'
          });

          const data = await res.json().catch(()=>null);

          if (!res.ok) {
            if (res.status === 422 && data && data.errors) {
              const errs = Object.values(data.errors).flat().join(' ');
              showToast(errs);
            } else if (data && data.message) {
              showToast(data.message);
            } else {
              showToast('Gagal mengunggah foto');
            }
            if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Simpan'; }
            return;
          }

          if (data && data.success && data.url) {
            const header = document.getElementById('header-avatar');
            const preview = document.getElementById('photo-preview');
            if (header) header.src = data.url;
            if (preview) preview.src = data.url;
            showToast('Foto profil berhasil diperbarui');
            closeModal('modal-photo');
          } else {
            showToast('Foto profil berhasil diperbarui');
            closeModal('modal-photo');
            setTimeout(()=> location.reload(), 800);
          }
        } catch (err) {
          console.error(err);
          showToast('Terjadi kesalahan saat mengunggah');
        } finally {
          if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = 'Simpan'; }
          const inputEl = document.getElementById('photo-input');
          if(inputEl) inputEl.value = '';
        }
      });
    })();

    (function(){
      const formPersonal = document.getElementById('form-personal');
      const personalBtn = document.getElementById('personal-save');
      if(!formPersonal || !personalBtn) return;
      personalBtn.addEventListener('click', function(){
        formPersonal.submit();
      });
    })();

    (function(){
      const formPassword = document.getElementById('form-password');
      const passwordBtn = document.getElementById('password-save');
      if(!formPassword || !passwordBtn) return;
      passwordBtn.addEventListener('click', function(){
        formPassword.submit();
      });
    })();

    (function(){
      const deleteForm = document.getElementById('form-delete');
      if(!deleteForm) return;

      const deleteActionUrl = deleteForm.getAttribute('action');
      const deleteBtn = document.getElementById('delete-confirm');
      const deletePassword = document.getElementById('delete-password');
      const deleteError = document.getElementById('delete-error');
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      deleteBtn.addEventListener('click', async function(){
        deleteError.classList.add('hidden');
        const pw = deletePassword.value.trim();
        if (!pw) { deleteError.textContent = 'Password wajib diisi.'; deleteError.classList.remove('hidden'); return; }

        deleteBtn.disabled = true; deleteBtn.textContent = 'Menghapus...';

        try {
          const fd = new FormData();
          fd.append('password', pw);
          fd.append('_method','DELETE');

          const res = await fetch(deleteActionUrl, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: fd,
            credentials: 'same-origin',
            redirect: 'follow'
          });

          if (res.ok) {
            if (res.redirected && res.url) {
              location.href = res.url;
            } else {
              location.href = '/';
            }
            return;
          }

          if (res.status === 422 || res.status === 403) {
            const j = await res.json().catch(()=>null);
            if (j && j.errors && j.errors.password) {
              deleteError.textContent = j.errors.password.join(' ');
              deleteError.classList.remove('hidden');
            } else if (j && j.message) {
              deleteError.textContent = j.message;
              deleteError.classList.remove('hidden');
            } else {
              deleteError.textContent = 'Password salah atau tidak valid.';
              deleteError.classList.remove('hidden');
            }
            deleteBtn.disabled = false; deleteBtn.textContent = 'Hapus Akun';
            return;
          }

          let msg = 'Gagal menghapus akun';
          try { const j = await res.json(); if (j.message) msg = j.message; } catch(e){}
          showToast(msg);
          deleteBtn.disabled = false; deleteBtn.textContent = 'Hapus Akun';
        } catch (err) {
          console.error(err);
          showToast('Terjadi kesalahan saat menghapus akun');
          deleteBtn.disabled = false; deleteBtn.textContent = 'Hapus Akun';
        }
      });
    })();

    function sendCsMessage(){
      const txt = document.getElementById('cs-message');
      if(!txt || !txt.value.trim()){ showToast('Tuliskan pesan sebelum mengirim'); return; }
      showToast('Pesan terkirim. Tim CS akan membalas segera.');
      txt.value = '';
      closeModal('modal-cs');
    }


  </script>
<script>
  // gabungan: openAddressEdit + openAddressDelete + handler delete confirm
  (function () {
    // --- openAddressEdit (memfetch data edit dan buka modal) ---
    window.openAddressEdit = function(id) {
      fetch('/addresses/' + id + '/edit', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        const a = data.address || {};

        const form = document.getElementById('form-edit-address');
        if (form) form.action = '/addresses/' + id;
        const hid = document.getElementById('edit_address_id');
        if (hid) hid.value = id;

        // safe setters (cek elemen dulu)
        const setIf = (idName, value) => {
          const el = document.getElementById(idName);
          if (el) el.value = value ?? '';
        };

        setIf('edit_label', a.label ?? '');
        setIf('edit_recipient', a.recipient_name ?? '');
        setIf('edit_phone_country', a.phone_country ?? '');
        setIf('edit_phone', a.phone ?? '');

        setIf('edit_address_full', a.address_full ?? '');
        setIf('edit_village', a.village ?? '');
        setIf('edit_subdistrict', a.subdistrict ?? '');
        setIf('edit_city', a.city ?? '');
        setIf('edit_province', a.province ?? '');
        setIf('edit_postal', a.postal_code ?? '');
        setIf('edit_country', a.country ?? '');

        const primaryChk = document.getElementById('edit_is_primary');
        if (primaryChk) primaryChk.checked = a.is_primary == true;

        openModal('modal-edit-address');
      })
      .catch(err => {
        console.error('openAddressEdit error', err);
        showToast('Gagal memuat data alamat.');
      });
    };


    // --- openAddressDelete (set action form & buka modal) ---
    window.openAddressDelete = function(id) {
      const form = document.getElementById('form-delete-address');
      if (form) form.action = '/addresses/' + id;
      openModal('modal-delete-address');
    };


    // --- setup delete confirm handler (saat DOM siap) ---
    document.addEventListener('DOMContentLoaded', function () {
      const deleteBtn = document.getElementById('delete-address-confirm');
      const deleteForm = document.getElementById('form-delete-address');
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');

      if (!deleteBtn || !deleteForm || !tokenMeta) {
        // jika salah satu elemen belum ada, tidak perlu error — cukup keluar
        return;
      }

      deleteBtn.addEventListener('click', async function () {
        deleteBtn.disabled = true;
        const originalText = deleteBtn.textContent;
        deleteBtn.textContent = 'Menghapus...';

        const actionUrl = deleteForm.getAttribute('action');
        if (!actionUrl) {
          showToast('URL aksi tidak ditemukan.');
          deleteBtn.disabled = false;
          deleteBtn.textContent = originalText;
          return;
        }

        const fd = new FormData();
        // Laravel method override
        fd.append('_method', 'DELETE');

        try {
          const res = await fetch(actionUrl, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': tokenMeta.getAttribute('content'),
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: fd,
            credentials: 'same-origin'
          });

          if (res.ok) {
            closeModal('modal-delete-address');
            showToast('Alamat berhasil dihapus');
            // beri waktu toast muncul lalu reload
            setTimeout(() => location.reload(), 700);
            return;
          }

          // coba ambil pesan error dari response JSON
          let msg = 'Gagal menghapus alamat';
          try {
            const j = await res.json();
            if (j) {
              if (j.message) msg = j.message;
              else if (j.errors) msg = Object.values(j.errors).flat().join(' ');
            }
          } catch (e) { /* non-json */ }

          showToast(msg);
        } catch (err) {
          console.error('delete address error', err);
          showToast('Terjadi kesalahan saat menghapus alamat');
        } finally {
          deleteBtn.disabled = false;
          deleteBtn.textContent = originalText;
        }
      });
    });

  })();
</script>

</body>
</html>
