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
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    * {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    :root{ 
      --accent:#0ea5e9; 
      --accent-600:#0284c7; 
      --accent-700:#0369a1;
      --header-btn-w:56px; 
    }

    body {
      background: #f5f5f5;
    }

    /* ===== CARD STYLES ===== */
    .card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
      transition: all 0.2s ease;
    }

    .card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    /* ===== HEADER ===== */
    .site-header { 
      height: 64px; 
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    
    .site-header .container { 
      max-width: 1200px; 
      margin: 0 auto; 
      height: 100%; 
      padding: 0 24px; 
      display: flex; 
      align-items: center; 
      justify-content: space-between; 
      position: relative; 
    }
    
    .back-btn { 
      display: inline-flex; 
      align-items: center; 
      gap: 8px; 
      padding: 8px 12px; 
      border-radius: 8px; 
      background: transparent; 
      border: none;
      cursor: pointer; 
      transition: all 0.2s ease;
      color: #374151;
      font-size: 14px;
      font-weight: 500;
    }
    
    .back-btn:hover { 
      background: #f3f4f6; 
    }
    
    .header-right-spacer { 
      width: var(--header-btn-w); 
      height: 40px; 
      visibility: hidden; 
    }

    .logo-center { 
      position: absolute; 
      left: 50%; 
      top: 50%; 
      transform: translate(-50%,-50%); 
      display: flex; 
      align-items: center; 
      justify-content: center; 
    }
    
    .logo-center img { 
      height: 36px; 
      object-fit: contain; 
    }

    /* ===== SIDEBAR ===== */
    .sidebar-item {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: 8px;
      background: transparent;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
      color: #6b7280;
      font-size: 14px;
      font-weight: 500;
      text-align: left;
    }

    .sidebar-item:hover {
      background: #f9fafb;
      color: #111827;
    }

    .sidebar-item.sidebar-active {
      background: #eff6ff;
      color: #0ea5e9;
      font-weight: 600;
    }

    .sidebar-item svg {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
    }

    /* ===== PROFILE CARD ===== */
    .profile-card {
      display: flex;
      gap: 24px;
      align-items: flex-start;
      padding: 0;
    }

    .profile-left {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
      width: 180px;
      flex-shrink: 0;
    }

    .avatar-wrap {
      position: relative;
    }

    .avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .avatar-edit-btn {
      position: absolute;
      right: 0;
      bottom: 0;
      background: #fff;
      border-radius: 50%;
      padding: 8px;
      border: 2px solid #e5e7eb;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .avatar-edit-btn:hover {
      background: #f9fafb;
      transform: scale(1.05);
    }

    .profile-name {
      font-weight: 700;
      font-size: 16px;
      color: #111827;
      text-align: center;
      margin-top: 4px;
    }

    .profile-joined {
      font-size: 12px;
      color: #9ca3af;
      text-align: center;
    }

    .profile-right {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .details-box {
      padding: 24px;
      border-radius: 12px;
      border: 1px solid #e5e7eb;
      background: #fafafa;
    }

    .details-row {
      display: grid;
      gap: 20px;
    }

    .detail-item {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .details-label {
      font-size: 12px;
      color: #6b7280;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .details-value {
      font-size: 15px;
      color: #111827;
      font-weight: 500;
    }

    /* ===== BUTTONS ===== */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.2s ease;
      cursor: pointer;
      border: none;
      outline: none;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn-primary {
      background: #0ea5e9;
      color: #fff;
    }

    .btn-primary:hover {
      background: #0284c7;
    }

    .btn-secondary {
      background: #fff;
      color: #374151;
      border: 1px solid #e5e7eb;
    }

    .btn-secondary:hover {
      background: #f9fafb;
      border-color: #d1d5db;
    }

    .btn-danger {
      background: #ef4444;
      color: #fff;
    }

    .btn-danger:hover {
      background: #dc2626;
    }

    .btn-ghost {
      background: transparent;
      color: #6b7280;
      border: 1px solid #e5e7eb;
    }

    .btn-ghost:hover {
      background: #f9fafb;
      color: #111827;
    }

    /* ===== ADDRESS CARD ===== */
    .address-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 20px;
      transition: all 0.2s ease;
      position: relative;
    }

    .address-card:hover {
      border-color: #0ea5e9;
      box-shadow: 0 4px 12px rgba(14,165,233,0.1);
    }

    .address-primary-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 4px 12px;
      border-radius: 6px;
      background: #dcfce7;
      color: #16a34a;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .address-label {
      font-size: 16px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 8px;
    }

    .address-detail {
      font-size: 14px;
      color: #6b7280;
      line-height: 1.6;
    }

    /* ===== MODALS ===== */
    .modal-wrapper {
      position: fixed;
      inset: 0;
      z-index: 9999;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 16px;
    }

    .modal-wrapper.active {
      display: flex;
    }

    .modal-backdrop {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.5);
      backdrop-filter: blur(4px);
      animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-content {
      position: relative;
      width: 100%;
      max-width: 720px;
      max-height: calc(100vh - 80px);
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      box-shadow: 0 20px 60px rgba(0,0,0,0.2);
      animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      z-index: 10;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .modal-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 24px;
      border-bottom: 1px solid #e5e7eb;
      background: #fafafa;
      flex-shrink: 0;
    }

    .modal-title-wrap {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .modal-title {
      font-size: 18px;
      font-weight: 700;
      color: #111827;
    }

    .modal-subtitle {
      font-size: 13px;
      color: #6b7280;
      margin-top: 2px;
    }

    .modal-close {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      background: transparent;
      border: none;
      cursor: pointer;
      color: #6b7280;
      transition: all 0.2s ease;
      font-size: 20px;
      line-height: 1;
    }

    .modal-close:hover {
      background: #f3f4f6;
      color: #111827;
    }

    .modal-body {
      padding: 24px;
      overflow-y: auto;
      overflow-x: hidden;
      flex: 1 1 auto;
      min-height: 0;
      max-height: calc(100vh - 240px);
    }

    .modal-body::-webkit-scrollbar {
      width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
      background: #f3f4f6;
      border-radius: 4px;
    }

    .modal-body::-webkit-scrollbar-thumb {
      background: #d1d5db;
      border-radius: 4px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
      background: #9ca3af;
    }

    .modal-actions {
      padding: 16px 24px;
      border-top: 1px solid #e5e7eb;
      background: #fafafa;
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      flex-shrink: 0;
      position: sticky;
      bottom: 0;
      z-index: 10;
    }

    /* ===== FORM INPUTS ===== */
    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #374151;
      margin-bottom: 8px;
    }

    .form-input {
      width: 100%;
      padding: 12px 16px;
      border-radius: 8px;
      border: 1px solid #d1d5db;
      background: #fff;
      font-size: 14px;
      color: #111827;
      transition: all 0.2s ease;
    }

    .form-input:focus {
      outline: none;
      border-color: #0ea5e9;
      box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
    }

    .form-input::placeholder {
      color: #9ca3af;
    }

    .form-input:disabled,
    .form-input:read-only {
      background: #f3f4f6;
      color: #9ca3af;
      cursor: not-allowed;
    }

    textarea.form-input {
      min-height: 100px;
      resize: vertical;
    }

    .form-helper {
      font-size: 12px;
      color: #6b7280;
      margin-top: 6px;
    }

    .input-with-icon {
      position: relative;
    }

    .input-icon-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      padding: 4px;
      cursor: pointer;
      color: #9ca3af;
      transition: color 0.2s ease;
    }

    .input-icon-btn:hover {
      color: #6b7280;
    }

    /* ===== TOAST ===== */
    .toast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #111827;
      color: #fff;
      padding: 14px 20px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      z-index: 11000;
      display: none;
      max-width: 400px;
      font-size: 14px;
      animation: toastIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .toast.show {
      display: block;
    }

    @keyframes toastIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ===== UTILITIES ===== */
    .panel-hidden {
      display: none;
    }

    .cs-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border-radius: 8px;
      background: #eff6ff;
      color: #0284c7;
      border: 1px solid #bfdbfe;
      font-weight: 600;
      font-size: 12px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .site-header .container {
        padding: 0 16px;
      }

      .logo-center img {
        height: 32px;
      }

      .profile-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .profile-left {
        width: 100%;
        align-items: center;
      }

      .profile-right {
        width: 100%;
      }

      .details-box {
        padding: 20px;
      }

      .modal-content {
        max-width: calc(100% - 32px);
        max-height: calc(100vh - 40px);
        border-radius: 12px;
      }

      .modal-head,
      .modal-actions {
        padding: 16px;
      }

      .modal-body {
        padding: 16px;
        min-height: 0;
        max-height: calc(100vh - 200px);
      }

      .btn {
        width: 100%;
      }
    }

    /* ===== GRID UTILITIES ===== */
    .grid-2 {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }

    @media (max-width: 640px) {
      .grid-2 {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body class="antialiased">
  <div id="toast" class="toast" role="status" aria-live="polite"></div>

  {{-- HEADER --}}
  <header class="site-header">
    <div class="container">
      <button type="button" class="back-btn" aria-label="Kembali" onclick="window.history.back();">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
      </button>

      <div class="logo-center">
        <a href="{{ url('/') }}">
          <img src="{{ asset('images/logo/logo_tokoriza.png') }}" alt="Tokoriza">
        </a>
      </div>

      <div class="header-right-spacer"></div>
    </div>
  </header>

  {{-- HERO --}}
  <section style="max-width: 1200px; margin: 0 auto; padding: 24px;">
    <div class="card" style="padding: 24px;">
      <h1 style="font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 6px;">Akun Saya</h1>
      <p style="font-size: 14px; color: #6b7280;">Kelola informasi akun, foto profil, dan alamat pengiriman Anda</p>
    </div>
  </section>

  {{-- MAIN --}}
  <main style="max-width: 1200px; margin: 0 auto; padding: 0 24px 80px;">
    <div class="grid grid-cols-12 gap-6 items-start">

      {{-- SIDEBAR --}}
      <aside class="col-span-12 lg:col-span-3">
        <div class="card" style="padding: 16px; position: sticky; top: 88px;">
          <nav style="display: flex; flex-direction: column; gap: 4px;">
            <button class="sidebar-item sidebar-active" data-panel="panel-detail">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              <span>Profil Saya</span>
            </button>

            <button class="sidebar-item" data-panel="panel-address">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <span>Alamat Saya</span>
            </button>

            <button class="sidebar-item" data-panel="panel-help">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span>Bantuan</span>
            </button>

            <button class="sidebar-item" data-panel="panel-cs">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
              </svg>
              <span>Hubungi CS</span>
            </button>
          </nav>

          <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="font-size: 12px; color: #6b7280; line-height: 1.5;">
              Butuh bantuan? Klik <span class="cs-badge">Hubungi CS</span> untuk menghubungi tim support kami.
            </p>
          </div>
        </div>
      </aside>

      {{-- CONTENT --}}
      <section class="col-span-12 lg:col-span-9 space-y-6">

        {{-- PANEL: PROFILE --}}
        <div id="panel-detail" class="panel card" style="padding: 32px;">
          <div class="profile-card">
            {{-- Left: Avatar --}}
            <div class="profile-left">
              <div class="avatar-wrap">
                <img id="header-avatar" 
                     src="{{ $user->profile_photo ? asset('storage/profile/'.$user->profile_photo) : asset('images/default-avatar.png') }}" 
                     class="avatar"
                     alt="Profile photo">
                <button type="button" 
                        onclick="openModal('modal-photo')" 
                        class="avatar-edit-btn"
                        aria-label="Ubah foto profil">
                  <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </button>
              </div>
              <div class="profile-name">{{ $user->name }}</div>
              <div class="profile-joined">Bergabung {{ $user->created_at->format('d M Y') }}</div>
            </div>

            {{-- Right: Details --}}
            <div class="profile-right">
              <div class="details-box">
                <div class="details-row">
                  <div class="detail-item">
                    <div class="details-label">Nama Lengkap</div>
                    <div class="details-value">{{ $user->name }}</div>
                  </div>

                  <div class="detail-item">
                    <div class="details-label">Nomor Handphone</div>
                    <div class="details-value">{{ ($user->phone_country ?? '') . ' ' . ($user->phone ?? '-') }}</div>
                  </div>

                  <div class="detail-item">
                    <div class="details-label">Alamat Email</div>
                    <div class="details-value">{{ $user->email }}</div>
                  </div>
                </div>
              </div>

              {{-- Action Buttons --}}
              <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px;">
                <button type="button" onclick="openModal('modal-personal')" class="btn btn-primary">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                  Edit Profil
                </button>

                <button type="button" onclick="openModal('modal-password')" class="btn btn-secondary">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                  </svg>
                  Ubah Password
                </button>

                <button type="button" onclick="openModal('modal-delete')" class="btn" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                  Hapus Akun
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- PANEL: ADDRESS --}}
        <div id="panel-address" class="panel panel-hidden card" style="padding: 32px;">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <div>
              <h3 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 4px;">Alamat Saya</h3>
              <p style="font-size: 13px; color: #6b7280;">Kelola alamat pengiriman untuk pesanan Anda</p>
            </div>
            <button type="button" onclick="openModal('modal-add-address')" class="btn btn-primary">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Tambah Alamat
            </button>
          </div>

          <div style="display: flex; flex-direction: column; gap: 16px;">
            @if($user->addresses->count() === 0)
              <div style="text-align: center; padding: 48px 24px; background: #fafafa; border-radius: 12px; border: 1px dashed #d1d5db;">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <p style="font-size: 14px; color: #6b7280; margin-bottom: 16px;">Belum ada alamat tersimpan</p>
                <button type="button" onclick="openModal('modal-add-address')" class="btn btn-primary">
                  Tambah Alamat Pertama
                </button>
              </div>
            @endif

            @foreach($user->addresses as $address)
              @include('profile.partials.address-item', ['address' => $address])
            @endforeach
          </div>
        </div>

        {{-- PANEL: HELP --}}
        <div id="panel-help" class="panel panel-hidden card" style="padding: 32px;">
          <h3 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Bantuan & FAQ</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="card" style="padding: 20px; background: #fafafa;">
              <div style="display: flex; align-items: start; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                  <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <div>
                  <p style="font-weight: 600; color: #111827; margin-bottom: 6px;">Bagaimana cara cek status pesanan?</p>
                  <p style="font-size: 13px; color: #6b7280; line-height: 1.5;">Buka menu "Pesanan Saya" lalu pilih pesanan yang ingin Anda lihat detailnya.</p>
                </div>
              </div>
            </div>

            <div class="card" style="padding: 20px; background: #fafafa;">
              <div style="display: flex; align-items: start; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                  <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  </svg>
                </div>
                <div>
                  <p style="font-weight: 600; color: #111827; margin-bottom: 6px;">Cara mengganti alamat pengiriman?</p>
                  <p style="font-size: 13px; color: #6b7280; line-height: 1.5;">Klik menu "Alamat Saya" lalu pilih "Edit" atau "Tambah Alamat Baru".</p>
                </div>
              </div>
            </div>

            <div class="card" style="padding: 20px; background: #fafafa;">
              <div style="display: flex; align-items: start; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                  <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                  </svg>
                </div>
                <div>
                  <p style="font-weight: 600; color: #111827; margin-bottom: 6px;">Metode pembayaran apa saja yang tersedia?</p>
                  <p style="font-size: 13px; color: #6b7280; line-height: 1.5;">Kami menerima transfer bank, e-wallet, dan kartu kredit/debit.</p>
                </div>
              </div>
            </div>

            <div class="card" style="padding: 20px; background: #fafafa;">
              <div style="display: flex; align-items: start; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                  <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                  </svg>
                </div>
                <div>
                  <p style="font-weight: 600; color: #111827; margin-bottom: 6px;">Bagaimana cara melakukan retur produk?</p>
                  <p style="font-size: 13px; color: #6b7280; line-height: 1.5;">Hubungi CS kami melalui menu "Hubungi CS" untuk mengajukan retur.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- PANEL: CS --}}
        <div id="panel-cs" class="panel panel-hidden card" style="padding: 32px;">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <div>
              <h3 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 4px;">Hubungi Customer Service</h3>
              <p style="font-size: 13px; color: #6b7280;">Tim kami siap membantu Anda</p>
            </div>
            <button type="button" onclick="openModal('modal-cs')" class="btn btn-primary">
              Chat Sekarang
            </button>
          </div>

          <div style="display: grid; gap: 16px;">
            <div class="card" style="padding: 24px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
              <div style="display: flex; align-items: start; gap: 16px;">
                <div style="width: 48px; height: 48px; background: #0ea5e9; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                  </svg>
                </div>
                <div style="flex: 1;">
                  <p style="font-weight: 700; color: #111827; margin-bottom: 8px; font-size: 16px;">Live Chat</p>
                  <p style="font-size: 14px; color: #374151; line-height: 1.6; margin-bottom: 12px;">
                    Klik tombol "Chat Sekarang" untuk memulai percakapan langsung dengan tim support kami. Kami akan merespons dengan cepat!
                  </p>
                  <button type="button" onclick="openModal('modal-cs')" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">
                    Mulai Chat
                  </button>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="card" style="padding: 20px; background: #fafafa;">
                <div style="display: flex; align-items: start; gap: 12px;">
                  <div style="width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #e5e7eb;">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                  </div>
                  <div>
                    <p style="font-weight: 600; color: #111827; margin-bottom: 6px;">Telepon</p>
                    <p style="font-size: 14px; color: #0ea5e9; font-weight: 600; margin-bottom: 4px;">0812-3456-7890</p>
                    <p style="font-size: 12px; color: #6b7280;">Senin–Jumat, 09:00–17:00 WIB</p>
                  </div>
                </div>
              </div>

              <div class="card" style="padding: 20px; background: #fafafa;">
                <div style="display: flex; align-items: start; gap: 12px;">
                  <div style="width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #e5e7eb;">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <div>
                    <p style="font-weight: 600; color: #111827; margin-bottom: 6px;">Email</p>
                    <p style="font-size: 14px; color: #0ea5e9; font-weight: 600; margin-bottom: 4px;">support@tokoriza.id</p>
                    <p style="font-size: 12px; color: #6b7280;">Respons dalam 1x24 jam</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>
    </div>
  </main>

  {{-- MODALS --}}
  
  {{-- Modal: Change Photo --}}
  <div id="modal-photo" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-photo')"></div>
    <div class="modal-content" style="max-width: 480px;">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          <div>
            <div class="modal-title">Ubah Foto Profil</div>
            <div class="modal-subtitle">Pilih foto baru untuk profil Anda</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-photo')">×</button>
      </div>

      <form id="form-photo" method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
            <img id="photo-preview" 
                 src="{{ $user->profile_photo ? asset('storage/profile/'.$user->profile_photo) : asset('images/default-avatar.png') }}" 
                 style="width: 160px; height: 160px; border-radius: 50%; object-fit: cover; border: 4px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            
            <div style="width: 100%;">
              <label class="form-label">Pilih Foto</label>
              <input id="photo-input" 
                     type="file" 
                     name="profile_photo" 
                     accept="image/*" 
                     class="form-input"
                     onchange="previewImage(event,'photo-preview','header-avatar')">
              <p class="form-helper">Format: JPG, PNG, WebP • Maksimal 2MB</p>
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-photo')">Batal</button>
          <button id="photo-save" type="button" class="btn btn-primary">Simpan Foto</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Edit Profile --}}
  <div id="modal-personal" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-personal')"></div>
    <div class="modal-content">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
          <div>
            <div class="modal-title">Edit Profil</div>
            <div class="modal-subtitle">Perbarui informasi profil Anda</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-personal')">×</button>
      </div>

      <form id="form-personal" method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        
        <div class="modal-body">
          <div class="grid-2">
            <div class="form-group">
              <label class="form-label">Nama Lengkap</label>
              <input name="name" value="{{ old('name', $user->name) }}" class="form-input" placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
              <label class="form-label">Kode Negara</label>
              <input value="{{ $user->phone_country }}" class="form-input" readonly>
            </div>

            <div class="form-group">
              <label class="form-label">Nomor Telepon</label>
              <input name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="08123456789">
            </div>

            <div class="form-group">
              <label class="form-label">Alamat Email</label>
              <input name="email" type="email" value="{{ old('email', $user->email) }}" class="form-input" placeholder="email@example.com">
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-personal')">Batal</button>
          <button id="personal-save" type="button" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Change Password --}}
  <div id="modal-password" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-password')"></div>
    <div class="modal-content" style="max-width: 540px;">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          <div>
            <div class="modal-title">Ubah Password</div>
            <div class="modal-subtitle">Perbarui password akun Anda</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-password')">×</button>
      </div>

      <form id="form-password" method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Password Saat Ini</label>
            <div class="input-with-icon">
              <input id="current_password" type="password" name="current_password" class="form-input" placeholder="Masukkan password saat ini">
              <button type="button" id="toggle-current" class="input-icon-btn" aria-label="Toggle password visibility">
                <svg id="icon-current" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <div class="input-with-icon">
              <input id="password" type="password" name="password" class="form-input" placeholder="Masukkan password baru">
              <button type="button" id="toggle-password" class="input-icon-btn" aria-label="Toggle password visibility">
                <svg id="icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </button>
            </div>
            <p class="form-helper">Minimal 8 karakter</p>
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-with-icon">
              <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
              <button type="button" id="toggle-password-confirm" class="input-icon-btn" aria-label="Toggle password visibility">
                <svg id="icon-password-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-password')">Batal</button>
          <button id="password-save" type="button" class="btn btn-primary">Simpan Password</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Delete Account --}}
  <div id="modal-delete" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-delete')"></div>
    <div class="modal-content" style="max-width: 480px;">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          <div>
            <div class="modal-title" style="color: #dc2626;">Hapus Akun</div>
            <div class="modal-subtitle">Tindakan ini tidak dapat dibatalkan</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-delete')">×</button>
      </div>

      <form id="form-delete" method="POST" action="{{ route('profile.destroy') }}" onsubmit="return false;">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
          <div style="padding: 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 20px;">
            <p style="font-size: 13px; color: #991b1b; line-height: 1.6;">
              <strong>Peringatan:</strong> Akun Anda akan dihapus secara permanen dari sistem kami. Semua data termasuk riwayat pesanan akan hilang dan tidak dapat dipulihkan.
            </p>
          </div>

          <div class="form-group">
            <label class="form-label">Masukkan Password untuk Konfirmasi</label>
            <input id="delete-password" type="password" name="password" class="form-input" placeholder="Password Anda" required>
            <p id="delete-error" class="form-helper" style="color: #dc2626; display: none;"></p>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-delete')">Batal</button>
          <button id="delete-confirm" type="button" class="btn btn-danger">Hapus Akun Saya</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Add Address --}}
  <div id="modal-add-address" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-add-address')"></div>
    <div class="modal-content">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          <div>
            <div class="modal-title">Tambah Alamat Baru</div>
            <div class="modal-subtitle">Isikan detail alamat pengiriman</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-add-address')">×</button>
      </div>

      <form method="POST" action="{{ route('addresses.store') }}">
        @csrf
        
        <div class="modal-body">
          <div class="grid-2">
            <div class="form-group">
              <label class="form-label">Label Alamat *</label>
              <input name="label" class="form-input" placeholder="Rumah / Kantor" required>
            </div>

            <div class="form-group">
              <label class="form-label">Nama Penerima *</label>
              <input name="recipient_name" class="form-input" placeholder="Nama penerima" required>
            </div>

            <div class="form-group">
              <label class="form-label">Kode Negara</label>
              <input name="phone_country" class="form-input" value="{{ $user->phone_country }}" readonly>
            </div>

            <div class="form-group">
              <label class="form-label">Nomor Telepon *</label>
              <input name="phone" class="form-input" placeholder="08123456789" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Alamat Lengkap *</label>
            <textarea name="address_full" class="form-input" rows="3" placeholder="Jalan, RT/RW, Blok, No. Rumah" required></textarea>
            <p class="form-helper">Isi detail alamat agar kurir mudah menemukan lokasi</p>
          </div>

          <div class="grid-2">
            <div class="form-group">
              <label class="form-label">Desa / Kelurahan</label>
              <input name="village" class="form-input" placeholder="Contoh: Sukamaju">
            </div>

            <div class="form-group">
              <label class="form-label">Kecamatan</label>
              <input name="subdistrict" class="form-input" placeholder="Contoh: Kebayoran">
            </div>

            <div class="form-group">
              <label class="form-label">Kota / Kabupaten</label>
              <input name="city" class="form-input" placeholder="Contoh: Jakarta Selatan">
            </div>

            <div class="form-group">
              <label class="form-label">Provinsi</label>
              <input name="province" class="form-input" placeholder="Contoh: DKI Jakarta">
            </div>

            <div class="form-group">
              <label class="form-label">Kode Pos</label>
              <input name="postal_code" class="form-input" placeholder="12345">
            </div>

            <div class="form-group">
              <label class="form-label">Negara</label>
              <input name="country" class="form-input" value="Indonesia">
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-add-address')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Alamat</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Edit Address --}}
  <div id="modal-edit-address" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-edit-address')"></div>
    <div class="modal-content">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
          <div>
            <div class="modal-title">Edit Alamat</div>
            <div class="modal-subtitle">Perbarui detail alamat pengiriman</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-edit-address')">×</button>
      </div>

      <form id="form-edit-address" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="address_id" id="edit_address_id">
        
        <div class="modal-body">
          <div class="grid-2">
            <div class="form-group">
              <label class="form-label">Label Alamat</label>
              <input name="label" id="edit_label" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Nama Penerima</label>
              <input name="recipient_name" id="edit_recipient" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Kode Negara</label>
              <input name="phone_country" id="edit_phone_country" class="form-input" readonly>
            </div>

            <div class="form-group">
              <label class="form-label">Nomor Telepon</label>
              <input name="phone" id="edit_phone" class="form-input">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="address_full" id="edit_address_full" class="form-input" rows="3"></textarea>
          </div>

          <div class="grid-2">
            <div class="form-group">
              <label class="form-label">Desa / Kelurahan</label>
              <input name="village" id="edit_village" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Kecamatan</label>
              <input name="subdistrict" id="edit_subdistrict" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Kota / Kabupaten</label>
              <input name="city" id="edit_city" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Provinsi</label>
              <input name="province" id="edit_province" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Kode Pos</label>
              <input name="postal_code" id="edit_postal" class="form-input">
            </div>

            <div class="form-group">
              <label class="form-label">Negara</label>
              <input name="country" id="edit_country" class="form-input">
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-edit-address')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: Delete Address --}}
  <div id="modal-delete-address" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-delete-address')"></div>
    <div class="modal-content" style="max-width: 480px;">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          <div>
            <div class="modal-title" style="color: #dc2626;">Hapus Alamat</div>
            <div class="modal-subtitle">Konfirmasi penghapusan alamat</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-delete-address')">×</button>
      </div>

      <form id="form-delete-address" method="POST" onsubmit="return false;">
        @csrf
        @method('DELETE')
        
        <div class="modal-body">
          <p style="font-size: 14px; color: #374151; line-height: 1.6;">
            Apakah Anda yakin ingin menghapus alamat ini? Tindakan ini tidak dapat dibatalkan.
          </p>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-ghost" onclick="closeModal('modal-delete-address')">Batal</button>
          <button id="delete-address-confirm" type="button" class="btn btn-danger">Hapus Alamat</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal: CS Chat --}}
  <div id="modal-cs" class="modal-wrapper" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeModal('modal-cs')"></div>
    <div class="modal-content" style="max-width: 540px;">
      <div class="modal-head">
        <div class="modal-title-wrap">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
          </svg>
          <div>
            <div class="modal-title">Chat Customer Service</div>
            <div class="modal-subtitle">Kami siap membantu Anda</div>
          </div>
        </div>
        <button type="button" class="modal-close" onclick="closeModal('modal-cs')">×</button>
      </div>

      <div class="modal-body">
        <form id="form-cs" onsubmit="return false;">
          <div class="form-group">
            <label class="form-label">Pesan Anda</label>
            <textarea id="cs-message" class="form-input" rows="5" placeholder="Tulis pesan atau pertanyaan Anda di sini..."></textarea>
            <p class="form-helper">Tim kami akan merespons secepat mungkin</p>
          </div>
        </form>
      </div>

      <div class="modal-actions">
        <button type="button" class="btn btn-ghost" onclick="closeModal('modal-cs')">Batal</button>
        <button type="button" class="btn btn-primary" onclick="sendCsMessage()">Kirim Pesan</button>
      </div>
    </div>
  </div>

  {{-- SCRIPTS --}}
  <script>
    // Toast notification
    function showToast(msg, ms = 3500) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), ms);
    }

    // Panel navigation
    const sidebarItems = document.querySelectorAll('.sidebar-item');
    const panels = document.querySelectorAll('.panel');
    
    function activatePanel(id, updateHash = true) {
      panels.forEach(p => p.classList.add('panel-hidden'));
      const el = document.getElementById(id);
      if (el) el.classList.remove('panel-hidden');
      sidebarItems.forEach(btn => btn.classList.toggle('sidebar-active', btn.dataset.panel === id));
      if (updateHash) history.replaceState(null, '', '#' + id.replace('panel-', ''));
    }
    
    sidebarItems.forEach(btn => btn.addEventListener('click', () => activatePanel(btn.dataset.panel)));
    
    // Initialize on load
    window.addEventListener('DOMContentLoaded', () => {
      const hash = location.hash.replace('#', '');
      activatePanel(hash ? 'panel-' + hash : 'panel-detail', false);

      @if(session()->has('status'))
        const status = {!! json_encode(session('status')) !!};
        if (status === 'profile-updated') {
          showToast('✓ Profil berhasil diperbarui');
        } else if (status === 'password-updated') {
          showToast('✓ Password berhasil diubah');
        } else {
          showToast(String(status));
        }
      @endif

      @if(session()->has('message'))
        const message = {!! json_encode(session('message')) !!};
        showToast(String(message));
      @endif
    });

    // Modal functions
    function openModal(id) {
      const m = document.getElementById(id);
      if (!m) return;
      m.classList.add('active');
      m.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      setTimeout(() => {
        const first = m.querySelector('input:not([readonly]), textarea, button');
        if (first) first.focus();
      }, 120);
    }

    function closeModal(id) {
      const m = document.getElementById(id);
      if (!m) return;
      m.classList.remove('active');
      m.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    // Close modal on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal-wrapper.active').forEach(m => {
          m.classList.remove('active');
          m.setAttribute('aria-hidden', 'true');
        });
        document.body.style.overflow = '';
      }
    });

    // Image preview
    function previewImage(e, previewId, headerId = null) {
      const file = e.target.files ? e.target.files[0] : null;
      if (!file) return;
      if (file.size > 2 * 1024 * 1024) {
        showToast('⚠ Ukuran file maksimal 2MB');
        e.target.value = '';
        return;
      }
      const reader = new FileReader();
      reader.onload = function(ev) {
        const img = document.getElementById(previewId);
        if (img) img.src = ev.target.result;
        if (headerId) {
          const h = document.getElementById(headerId);
          if (h) h.src = ev.target.result;
        }
      };
      reader.readAsDataURL(file);
    }

    // Toggle password visibility
    function toggleInputVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      if (!input) return;
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
    }

    // Setup password toggles
    (function setupPasswordToggles() {
      const map = [
        { btn: 'toggle-current', input: 'current_password', icon: 'icon-current' },
        { btn: 'toggle-password', input: 'password', icon: 'icon-password' },
        { btn: 'toggle-password-confirm', input: 'password_confirmation', icon: 'icon-password-confirm' },
      ];
      map.forEach(m => {
        const b = document.getElementById(m.btn);
        if (!b) return;
        b.addEventListener('click', () => toggleInputVisibility(m.input, m.icon));
      });
    })();

    // Photo upload handler
    (function() {
      const formPhoto = document.getElementById('form-photo');
      if (!formPhoto) return;
      const actionUrl = formPhoto.getAttribute('action');
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const photoSaveBtn = document.getElementById('photo-save');

      if (photoSaveBtn) {
        photoSaveBtn.addEventListener('click', function() {
          formPhoto.dispatchEvent(new Event('submit', { cancelable: true }));
        });
      }

      formPhoto.addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('photo-input');
        if (!input || !input.files || !input.files[0]) {
          showToast('⚠ Pilih file foto terlebih dahulu');
          return;
        }
        const file = input.files[0];
        if (file.size > 2 * 1024 * 1024) {
          showToast('⚠ Ukuran file maksimal 2MB');
          return;
        }

        const fd = new FormData();
        fd.append('profile_photo', file);

        const saveBtn = photoSaveBtn || document.getElementById('photo-save');
        if (saveBtn) {
          saveBtn.disabled = true;
          saveBtn.textContent = 'Menyimpan...';
        }

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

          const data = await res.json().catch(() => null);

          if (!res.ok) {
            if (res.status === 422 && data && data.errors) {
              const errs = Object.values(data.errors).flat().join(' ');
              showToast('⚠ ' + errs);
            } else if (data && data.message) {
              showToast('⚠ ' + data.message);
            } else {
              showToast('⚠ Gagal mengunggah foto');
            }
            if (saveBtn) {
              saveBtn.disabled = false;
              saveBtn.textContent = 'Simpan Foto';
            }
            return;
          }

          if (data && data.success && data.url) {
            const header = document.getElementById('header-avatar');
            const preview = document.getElementById('photo-preview');
            if (header) header.src = data.url;
            if (preview) preview.src = data.url;
            showToast('✓ Foto profil berhasil diperbarui');
            closeModal('modal-photo');
          } else {
            showToast('✓ Foto profil berhasil diperbarui');
            closeModal('modal-photo');
            setTimeout(() => location.reload(), 800);
          }
        } catch (err) {
          console.error(err);
          showToast('⚠ Terjadi kesalahan saat mengunggah');
        } finally {
          if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Simpan Foto';
          }
          const inputEl = document.getElementById('photo-input');
          if (inputEl) inputEl.value = '';
        }
      });
    })();

    // Personal info update
    (function() {
      const formPersonal = document.getElementById('form-personal');
      const personalBtn = document.getElementById('personal-save');
      if (!formPersonal || !personalBtn) return;
      personalBtn.addEventListener('click', function() {
        formPersonal.submit();
      });
    })();

    // Password update
    (function() {
      const formPassword = document.getElementById('form-password');
      const passwordBtn = document.getElementById('password-save');
      if (!formPassword || !passwordBtn) return;
      passwordBtn.addEventListener('click', function() {
        formPassword.submit();
      });
    })();

    // Account deletion
    (function() {
      const deleteForm = document.getElementById('form-delete');
      if (!deleteForm) return;

      const deleteActionUrl = deleteForm.getAttribute('action');
      const deleteBtn = document.getElementById('delete-confirm');
      const deletePassword = document.getElementById('delete-password');
      const deleteError = document.getElementById('delete-error');
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      deleteBtn.addEventListener('click', async function() {
        deleteError.style.display = 'none';
        const pw = deletePassword.value.trim();
        if (!pw) {
          deleteError.textContent = 'Password wajib diisi';
          deleteError.style.display = 'block';
          return;
        }

        deleteBtn.disabled = true;
        deleteBtn.textContent = 'Menghapus...';

        try {
          const fd = new FormData();
          fd.append('password', pw);
          fd.append('_method', 'DELETE');

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
            const j = await res.json().catch(() => null);
            if (j && j.errors && j.errors.password) {
              deleteError.textContent = j.errors.password.join(' ');
              deleteError.style.display = 'block';
            } else if (j && j.message) {
              deleteError.textContent = j.message;
              deleteError.style.display = 'block';
            } else {
              deleteError.textContent = 'Password salah atau tidak valid';
              deleteError.style.display = 'block';
            }
            deleteBtn.disabled = false;
            deleteBtn.textContent = 'Hapus Akun Saya';
            return;
          }

          let msg = 'Gagal menghapus akun';
          try {
            const j = await res.json();
            if (j.message) msg = j.message;
          } catch (e) {}
          showToast('⚠ ' + msg);
          deleteBtn.disabled = false;
          deleteBtn.textContent = 'Hapus Akun Saya';
        } catch (err) {
          console.error(err);
          showToast('⚠ Terjadi kesalahan saat menghapus akun');
          deleteBtn.disabled = false;
          deleteBtn.textContent = 'Hapus Akun Saya';
        }
      });
    })();

    // CS message
    function sendCsMessage() {
      const txt = document.getElementById('cs-message');
      if (!txt || !txt.value.trim()) {
        showToast('⚠ Tuliskan pesan sebelum mengirim');
        return;
      }
      showToast('✓ Pesan terkirim. Tim CS akan membalas segera');
      txt.value = '';
      closeModal('modal-cs');
    }

    // Address functions
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

        openModal('modal-edit-address');
      })
      .catch(err => {
        console.error('openAddressEdit error', err);
        showToast('⚠ Gagal memuat data alamat');
      });
    };

    window.openAddressDelete = function(id) {
      const form = document.getElementById('form-delete-address');
      if (form) form.action = '/addresses/' + id;
      openModal('modal-delete-address');
    };

    // Address delete handler
    document.addEventListener('DOMContentLoaded', function() {
      const deleteBtn = document.getElementById('delete-address-confirm');
      const deleteForm = document.getElementById('form-delete-address');
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');

      if (!deleteBtn || !deleteForm || !tokenMeta) return;

      deleteBtn.addEventListener('click', async function() {
        deleteBtn.disabled = true;
        const originalText = deleteBtn.textContent;
        deleteBtn.textContent = 'Menghapus...';

        const actionUrl = deleteForm.getAttribute('action');
        if (!actionUrl) {
          showToast('⚠ URL aksi tidak ditemukan');
          deleteBtn.disabled = false;
          deleteBtn.textContent = originalText;
          return;
        }

        const fd = new FormData();
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
            showToast('✓ Alamat berhasil dihapus');
            setTimeout(() => location.reload(), 700);
            return;
          }

          let msg = 'Gagal menghapus alamat';
          try {
            const j = await res.json();
            if (j) {
              if (j.message) msg = j.message;
              else if (j.errors) msg = Object.values(j.errors).flat().join(' ');
            }
          } catch (e) {}

          showToast('⚠ ' + msg);
        } catch (err) {
          console.error('delete address error', err);
          showToast('⚠ Terjadi kesalahan saat menghapus alamat');
        } finally {
          deleteBtn.disabled = false;
          deleteBtn.textContent = originalText;
        }
      });
    });
  </script>
</body>
</html>