@extends('layouts.nav_masterdashboard')

@section('content')
<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Produk</h1>
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
            ← Kembali ke Daftar Produk
        </a>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-100 p-4 text-red-800 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Dasar</h2>

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                       value="{{ old('name', $product->name) }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- SKU & Kategori --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku"
                           value="{{ old('sku', $product->sku) }}"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Jenis Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Produk <span class="text-red-500">*</span>
                </label>
                <select name="product_type" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="physical" {{ old('product_type', $product->product_type) == 'physical' ? 'selected' : '' }}>Produk Fisik</option>
                    <option value="digital" {{ old('product_type', $product->product_type) == 'digital' ? 'selected' : '' }}>Produk Digital</option>
                    <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>Jasa / Layanan</option>
                </select>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        {{-- Harga & Stok --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Harga & Stok</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" name="price"
                           value="{{ old('price', $product->price) }}"
                           min="0" step="100"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                
            </div>
        </div>

        {{-- Gambar Produk --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Gambar Produk</h2>

            <p class="text-sm text-gray-600">
                Upload atau edit gambar produk (maksimal 5 gambar). 
                <span class="text-red-600 font-medium">Minimal 1 gambar harus ada.</span>
            </p>

            {{-- Grid Upload Individual --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @for($i = 1; $i <= 5; $i++)
                <div class="space-y-2">
                    @php
                        $existingImages = $product->images->sortBy('sort_order');
                        $currentImage = $existingImages->skip($i - 1)->first();
                    @endphp
                    
                    <label class="block text-xs font-medium text-gray-700">
                        Gambar {{ $i }} 
                        @if($i == 1 && !$existingImages->count())
                            <span class="text-red-500">*</span> (Utama)
                        @elseif($currentImage && $currentImage->is_primary)
                            <span class="text-green-600">(Utama)</span>
                        @endif
                    </label>
                    
                    <div class="relative border-2 border-dashed rounded-lg {{ $i == 1 && !$existingImages->count() ? 'border-red-300' : 'border-gray-300' }}">
                        {{-- Preview Gambar Existing atau Upload Baru --}}
                        <div class="w-full h-32">
                            @if($currentImage)
                                {{-- Gambar Existing --}}
                                <div class="relative w-full h-full group">
                                    <img src="{{ asset('storage/'.$currentImage->image_path) }}"
                                         id="existing-preview-{{ $i }}"
                                         class="w-full h-full object-cover rounded-lg"
                                         alt="Gambar {{ $i }}">
                                    
                                    {{-- Overlay Actions --}}
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center gap-2">
                                        <button type="button" 
                                                onclick="document.getElementById('new-image-{{ $i }}').click()"
                                                class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                            Ganti
                                        </button>
                                        <label class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 cursor-pointer">
                                            <input type="checkbox" 
                                                   name="delete_images[]" 
                                                   value="{{ $currentImage->id }}"
                                                   class="mr-1"
                                                   onchange="toggleDeleteImage({{ $i }}, this.checked)">
                                            Hapus
                                        </label>
                                    </div>
                                    
                                    {{-- Hidden: Image ID untuk tracking --}}
                                    <input type="hidden" name="existing_images[{{ $i }}]" value="{{ $currentImage->id }}">
                                </div>
                            @else
                                {{-- Upload Baru --}}
                                <label for="new-image-{{ $i }}" 
                                       class="w-full h-full flex items-center justify-center cursor-pointer hover:bg-gray-50 transition rounded-lg">
                                    <div id="upload-placeholder-{{ $i }}" class="text-center text-gray-400">
                                        <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <span class="text-xs">Upload</span>
                                    </div>
                                </label>
                            @endif
                            
                            {{-- Preview Gambar Baru (akan di-upload) --}}
                            <div id="new-preview-{{ $i }}" class="hidden absolute inset-0 bg-white rounded-lg">
                                <div class="relative w-full h-full">
                                    <img id="new-preview-img-{{ $i }}" 
                                         class="w-full h-full object-cover rounded-lg"
                                         alt="Preview baru {{ $i }}">
                                    <button type="button" 
                                            onclick="cancelNewImage({{ $i }})"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                                        ×
                                    </button>
                                    <div class="absolute bottom-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                        Baru
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Hidden File Input --}}
                        <input type="file" 
                               name="new_images[{{ $i }}]" 
                               id="new-image-{{ $i }}"
                               accept="image/*"
                               onchange="previewNewImage(event, {{ $i }})"
                               class="hidden">
                    </div>
                    <p class="text-xs text-gray-500">Max 2MB</p>
                </div>
                @endfor
            </div>

            {{-- Informasi --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                <p class="text-xs text-blue-800">
                    <strong>💡 Cara Edit Gambar:</strong><br>
                    • <strong>Ganti:</strong> Hover pada gambar → Klik "Ganti" → Pilih gambar baru<br>
                    • <strong>Hapus:</strong> Hover pada gambar → Centang "Hapus"<br>
                    • <strong>Tambah:</strong> Klik slot kosong → Upload gambar<br>
                    • Perubahan akan tersimpan setelah klik tombol "Update Produk"
                </p>
            </div>
        </div>

        {{-- VARIAN PRODUK --}}
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">
                Varian Produk
            </h2>

            <div class="text-xs text-gray-600 mb-2">
                <div class="grid grid-cols-5 gap-2 font-medium">
                    <div>Nama Varian</div>
                    <div class="col-span-2">Nilai (pisahkan dengan koma)</div>
                    <div>Modifier Harga</div>
                    <div>Aksi</div>
                </div>
            </div>

            <div id="variant-wrapper" class="space-y-3">
                @php 
                    $i = 0;
                    $groupedVariants = $product->variants->groupBy('variant_name');
                @endphp
                
                @forelse($groupedVariants as $name => $variants)
                    <div class="grid grid-cols-5 gap-2 items-center variant-row">
                        <input type="text"
                               name="variants[{{ $i }}][name]"
                               value="{{ old('variants.'.$i.'.name', $name) }}"
                               placeholder="Contoh: Ukuran"
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                        <input type="text"
                               name="variants[{{ $i }}][values]"
                               value="{{ old('variants.'.$i.'.values', $variants->pluck('variant_value')->implode(', ')) }}"
                               placeholder="Contoh: S, M, L, XL"
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 col-span-2">

                        <input type="number"
                               name="variants[{{ $i }}][price_modifier]"
                               value="{{ old('variants.'.$i.'.price_modifier', $variants->first()->price_modifier ?? 0) }}"
                               placeholder="0"
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                        <button type="button"
                                class="text-red-600 hover:text-red-800 text-sm font-medium"
                                onclick="hapusVarianIni(this)">
                            🗑️ Hapus
                        </button>
                    </div>
                    @php $i++; @endphp
                @empty
                    {{-- Tampilkan satu baris kosong jika belum ada varian --}}
                    <div id="empty-message" class="text-sm text-gray-500 italic">
                        Belum ada varian. Klik tombol "Tambah Varian" untuk menambahkan.
                    </div>
                @endforelse
            </div>

            <button type="button"
                    id="btn-tambah-varian"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition">
                ➕ Tambah Varian
            </button>
        </div>

        <script>
        let variantIndex = {{ $groupedVariants->count() ?? 0 }};

        document.getElementById('btn-tambah-varian').addEventListener('click', function() {
            const wrapper = document.getElementById('variant-wrapper');
            
            // Hapus pesan kosong jika ada
            const emptyMsg = document.getElementById('empty-message');
            if (emptyMsg) {
                emptyMsg.remove();
            }

            // Buat elemen div baru
            const newRow = document.createElement('div');
            newRow.className = 'grid grid-cols-5 gap-2 items-center variant-row';
            newRow.innerHTML = `
                <input type="text"
                       name="variants[${variantIndex}][name]"
                       placeholder="Contoh: Ukuran"
                       class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                <input type="text"
                       name="variants[${variantIndex}][values]"
                       placeholder="Contoh: S, M, L, XL"
                       class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 col-span-2">

                <input type="number"
                       name="variants[${variantIndex}][price_modifier]"
                       value="0"
                       placeholder="0"
                       class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                <button type="button"
                        onclick="hapusVarianIni(this)"
                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                    🗑️ Hapus
                </button>
            `;

            wrapper.appendChild(newRow);
            variantIndex++;
        });

        function hapusVarianIni(button) {
            const row = button.closest('.variant-row');
            row.remove();
            
            // Cek apakah masih ada variant-row
            const wrapper = document.getElementById('variant-wrapper');
            const remainingRows = wrapper.querySelectorAll('.variant-row');
            
            if (remainingRows.length === 0) {
                const emptyMsg = document.createElement('div');
                emptyMsg.id = 'empty-message';
                emptyMsg.className = 'text-sm text-gray-500 italic';
                emptyMsg.textContent = 'Belum ada varian. Klik tombol "Tambah Varian" untuk menambahkan.';
                wrapper.appendChild(emptyMsg);
            }
        }
        </script>

        {{-- Action --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.products.index') }}"
               class="px-5 py-2.5 border rounded-md text-sm text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                💾 Update Produk
            </button>
        </div>
    </form>
</div>

{{-- Scripts --}}
<script>
// Preview gambar baru yang akan di-upload
function previewNewImage(event, slotNumber) {
    const file = event.target.files[0];
    
    if (!file) return;
    
    // Validasi ukuran file (2MB)
    if (file.size > 2097152) {
        alert('Gambar terlalu besar! Maksimal 2MB.');
        event.target.value = '';
        return;
    }
    
    // Validasi tipe file
    if (!file.type.match('image.*')) {
        alert('File harus berupa gambar!');
        event.target.value = '';
        return;
    }
    
    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const newPreview = document.getElementById(`new-preview-${slotNumber}`);
        const newPreviewImg = document.getElementById(`new-preview-img-${slotNumber}`);
        const existingPreview = document.getElementById(`existing-preview-${slotNumber}`);
        const uploadPlaceholder = document.getElementById(`upload-placeholder-${slotNumber}`);
        
        newPreviewImg.src = e.target.result;
        newPreview.classList.remove('hidden');
        
        // Sembunyikan gambar existing atau placeholder
        if (existingPreview) {
            existingPreview.closest('.group').style.display = 'none';
        }
        if (uploadPlaceholder) {
            uploadPlaceholder.closest('label').style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
}

// Cancel upload gambar baru
function cancelNewImage(slotNumber) {
    const fileInput = document.getElementById(`new-image-${slotNumber}`);
    const newPreview = document.getElementById(`new-preview-${slotNumber}`);
    const existingPreview = document.getElementById(`existing-preview-${slotNumber}`);
    const uploadPlaceholder = document.getElementById(`upload-placeholder-${slotNumber}`);
    
    // Reset file input
    fileInput.value = '';
    
    // Sembunyikan preview baru
    newPreview.classList.add('hidden');
    
    // Tampilkan kembali gambar existing atau placeholder
    if (existingPreview) {
        existingPreview.closest('.group').style.display = 'block';
    }
    if (uploadPlaceholder) {
        uploadPlaceholder.closest('label').style.display = 'flex';
    }
}

// Toggle status delete image
function toggleDeleteImage(slotNumber, isChecked) {
    const existingPreview = document.getElementById(`existing-preview-${slotNumber}`);
    if (existingPreview) {
        if (isChecked) {
            existingPreview.style.opacity = '0.3';
            existingPreview.style.filter = 'grayscale(100%)';
        } else {
            existingPreview.style.opacity = '1';
            existingPreview.style.filter = 'none';
        }
    }
}
</script>

<style>
/* Custom scrollbar for better UX */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth transitions */
.group:hover .group-hover\:opacity-100 {
    transition: opacity 0.2s ease-in-out;
}
</style>

@endsection