@extends('layouts.nav_masterdashboard')

@section('promosi', 'Edit Promosi')
@section('promosi-title', 'Edit Promosi')

@section('content')
<div class="form-container">
    
    <div class="form-header">
        <a href="{{ route('admin.banners.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="form-title">{{ isset($banner) ? 'Edit Banner' : 'Tambah Banner Baru' }}</h1>
    </div>

    <form action="{{ isset($banner) ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="banner-form">
        @csrf
        @if(isset($banner))
            @method('PUT')
        @endif

        <div class="form-card">
            
            {{-- Title --}}
            <div class="form-group">
                <label class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    Judul Banner <span class="required">*</span>
                </label>
                <input type="text" name="title" class="form-input @error('title') error @enderror" 
                       value="{{ old('title', $banner->title ?? '') }}" 
                       placeholder="Contoh: Mega Deals Dijamin Ori!" required>
                @error('title')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            {{-- Subtitle --}}
            <div class="form-group">
                <label class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    Subtitle (Opsional)
                </label>
                <input type="text" name="subtitle" class="form-input @error('subtitle') error @enderror" 
                       value="{{ old('subtitle', $banner->subtitle ?? '') }}" 
                       placeholder="Contoh: Voucher Diskon Total s.d. Rp10 Miliar*">
                @error('subtitle')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

{{-- Pilih Produk --}}
<div class="form-group">
    <label class="form-label">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2">
            <path d="M20 7h-9"></path>
            <path d="M14 17H5"></path>
            <circle cx="17" cy="17" r="3"></circle>
            <circle cx="7" cy="7" r="3"></circle>
        </svg>
        Pilih Produk (Opsional)
    </label>

    <select name="product_id"
            class="form-input @error('product_id') error @enderror">
        <option value="">— Tidak ditautkan ke produk —</option>

        @foreach($products as $p)
            <option value="{{ $p->id }}"
                {{ old('product_id', $banner->product_id ?? null) == $p->id ? 'selected' : '' }}>
                {{ $p->name }} — Rp {{ number_format($p->price,0,',','.') }}
            </option>
        @endforeach
    </select>

    <small class="form-hint">
        Banner akan mengarah ke halaman detail produk
    </small>

    @error('product_id')
    <span class="error-message">{{ $message }}</span>
    @enderror
</div>


            {{-- Sort Order --}}
            <div class="form-group">
                <label class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                    Urutan Tampil <span class="required">*</span>
                </label>
                <input type="number" name="sort_order" class="form-input @error('sort_order') error @enderror" 
                       value="{{ old('sort_order', $banner->sort_order ?? 0) }}" 
                       min="0" required>
                <small class="form-hint">Semakin kecil angka, semakin awal tampil</small>
                @error('sort_order')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            {{-- Image Upload --}}
            <div class="form-group">
                <label class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    Gambar Banner <span class="required">{{ isset($banner) ? '' : '*' }}</span>
                </label>
                
                @if(isset($banner) && $banner->image_path)
                <div class="current-image">
                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="Current banner">
                    <small>Gambar saat ini</small>
                </div>
                @endif

                <div class="file-upload-wrapper">
                    <input type="file" name="image" id="imageInput" class="file-input @error('image') error @enderror" 
                           accept="image/*" {{ isset($banner) ? '' : 'required' }}>
                    <label for="imageInput" class="file-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <span>Pilih Gambar</span>
                    </label>
                    <div id="fileName" class="file-name">Belum ada file dipilih</div>
                </div>

                <small class="form-hint">Format: JPG, PNG, WEBP. Max: 2MB. Rekomendasi: 1400x400px</small>
                @error('image')
                <span class="error-message">{{ $message }}</span>
                @enderror

                <div id="imagePreview" class="image-preview"></div>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-checkbox">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
                    <span class="checkbox-label">Aktifkan banner ini</span>
                </label>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('admin.banners.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                {{ isset($banner) ? 'Update Banner' : 'Simpan Banner' }}
            </button>
        </div>

    </form>

</div>

<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 24px;
}

.form-header {
    margin-bottom: 32px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #f3f4f6;
    color: #374151;
    font-weight: 600;
    font-size: 14px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
    margin-bottom: 16px;
}

.btn-back:hover {
    background: #e5e7eb;
}

.form-title {
    font-size: 28px;
    font-weight: 900;
    color: #111827;
    margin: 0;
}

.banner-form {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
}

.form-card {
    padding: 32px;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    font-size: 14px;
    color: #374151;
    margin-bottom: 8px;
}

.required {
    color: #ef4444;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    font-family: inherit;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-input.error {
    border-color: #ef4444;
}

.form-hint {
    display: block;
    font-size: 12px;
    color: #6b7280;
    margin-top: 6px;
}

.error-message {
    display: block;
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    margin-top: 6px;
}

.current-image {
    margin-bottom: 16px;
    text-align: center;
}

.current-image img {
    width: 100%;
    max-height: 200px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 8px;
}

.current-image small {
    font-size: 12px;
    color: #6b7280;
}

.file-upload-wrapper {
    position: relative;
}

.file-input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
}

.file-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 24px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.file-label:hover {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-color: #3b82f6;
}

.file-label span {
    font-weight: 700;
    color: #374151;
}

.file-name {
    margin-top: 10px;
    font-size: 13px;
    color: #6b7280;
    text-align: center;
}

.image-preview {
    margin-top: 16px;
}

.image-preview img {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
    border-radius: 12px;
}

.form-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.form-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #3b82f6;
    cursor: pointer;
}

.checkbox-label {
    font-weight: 600;
    color: #374151;
}

.form-actions {
    display: flex;
    gap: 12px;
    padding: 20px 32px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    justify-content: flex-end;
}

.btn-cancel {
    padding: 12px 24px;
    background: #fff;
    color: #374151;
    font-weight: 700;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
    border: 2px solid #e5e7eb;
}

.btn-cancel:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    font-weight: 700;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.btn-submit:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
}
</style>

<script>
const imageInput = document.getElementById('imageInput');
const fileName = document.getElementById('fileName');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if(file) {
        fileName.textContent = file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        reader.readAsDataURL(file);
    } else {
        fileName.textContent = 'Belum ada file dipilih';
        imagePreview.innerHTML = '';
    }
});
</script>
@endsection