@extends('layouts.nav_masterdashboard')

@section('promosi', 'Promosi')
@section('promosi-title', 'Promosi')

@section('content')
<div class="banner-admin-container">
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Banner Promo</h1>
            <p class="page-subtitle">Manage banner slider untuk homepage</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Banner
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($banners->count() === 0)
    <div class="empty-state">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <circle cx="8.5" cy="8.5" r="1.5"></circle>
            <polyline points="21 15 16 10 5 21"></polyline>
        </svg>
        <h3>Belum Ada Banner</h3>
        <p>Tambahkan banner promo untuk ditampilkan di homepage</p>
        <a href="{{ route('admin.banners.create') }}" class="btn-primary">Tambah Banner Pertama</a>
    </div>
    @else
    <div class="banner-grid">
        @foreach($banners as $banner)
        <div class="banner-card">
            <div class="banner-image">
                <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}">
                <div class="banner-status {{ $banner->is_active ? 'active' : 'inactive' }}">
                    {{ $banner->is_active ? 'AKTIF' : 'NONAKTIF' }}
                </div>
            </div>
            <div class="banner-content">
                <div class="banner-order">Urutan: {{ $banner->sort_order }}</div>
                <h3 class="banner-title">{{ $banner->title }}</h3>
                @if($banner->subtitle)
                <p class="banner-subtitle">{{ $banner->subtitle }}</p>
                @endif
                @if($banner->link_url)
                <div class="banner-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    <span>{{ Str::limit($banner->link_url, 40) }}</span>
                </div>
                @endif
            </div>
            <div class="banner-actions">
                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn-edit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Yakin hapus banner ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<style>
.banner-admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-size: 28px;
    font-weight: 900;
    color: #111827;
    margin: 0 0 4px 0;
}

.page-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
}

.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border: 2px solid #10b981;
    color: #065f46;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: #fff;
    border-radius: 16px;
    border: 2px dashed #e5e7eb;
}

.empty-state svg {
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 8px 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0 0 24px 0;
}

.banner-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
}

.banner-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    transition: all 0.3s;
}

.banner-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}

.banner-image {
    position: relative;
    aspect-ratio: 16/9;
    background: #f3f4f6;
}

.banner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-status {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.banner-status.active {
    background: #10b981;
    color: #fff;
}

.banner-status.inactive {
    background: #6b7280;
    color: #fff;
}

.banner-content {
    padding: 16px;
}

.banner-order {
    display: inline-block;
    padding: 4px 10px;
    background: #f3f4f6;
    color: #6b7280;
    font-size: 11px;
    font-weight: 700;
    border-radius: 6px;
    margin-bottom: 10px;
}

.banner-title {
    font-size: 16px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 6px 0;
}

.banner-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin: 0 0 10px 0;
}

.banner-link {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #3b82f6;
    padding: 8px 12px;
    background: #eff6ff;
    border-radius: 8px;
}

.banner-link svg {
    flex-shrink: 0;
}

.banner-actions {
    display: flex;
    gap: 8px;
    padding: 12px 16px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.banner-actions form {
    margin: 0;
}

.btn-edit, .btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #eff6ff;
    color: #1e40af;
}

.btn-edit:hover {
    background: #dbeafe;
}

.btn-delete {
    background: #fef2f2;
    color: #991b1b;
}

.btn-delete:hover {
    background: #fee2e2;
}

@media(max-width: 768px) {
    .banner-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
