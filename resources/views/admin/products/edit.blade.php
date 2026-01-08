@extends('layouts.nav_masterdashboard')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    * {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* TokoRiza Theme Colors */
    :root {
        --tokoriza-blue: #0EA5E9;
        --tokoriza-blue-dark: #0284C7;
        --tokoriza-blue-light: #E0F2FE;
        --tokoriza-yellow: #FDB813;
        --tokoriza-yellow-dark: #F59E0B;
        --tokoriza-yellow-light: #FEF3C7;
        --border-color: #E5E7EB;
        --text-primary: #333333;
        --text-secondary: #666666;
        --text-placeholder: #999999;
    }

    /* FORCE OVERRIDE PARENT LAYOUT - CRITICAL */
    .flex.pt-14.h-screen {
        height: auto !important;
        min-height: auto !important;
    }
    
    #main-content,
    main,
    #app, 
    .wrapper, 
    .main-content,
    .container-fluid,
    section,
    [class*="min-h"],
    [class*="h-screen"],
    [class*="min-height"],
    [class*="overflow-y-auto"] {
        min-height: auto !important;
        height: auto !important;
        overflow-y: visible !important;
        overflow: visible !important;
    }

    main#main-content {
        overflow: visible !important;
        overflow-y: visible !important;
        overflow-x: visible !important;
    }

    html {
        overflow-x: hidden;
        overflow-y: auto;
        height: auto;
        scroll-behavior: smooth;
    }

    body {
        background-color: #F5F5F5;
        overflow-x: hidden;
        height: auto !important;
        min-height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    #main-content {
        background-color: #F5F5F5 !important;
    }
    
    .product-add-container {
        background-color: #F5F5F5;
        min-height: calc(100vh - 80px); /* FIXED: 80px untuk navbar baru */
    }

    html, body {
        max-width: 100%;
        overscroll-behavior: none !important;
        overscroll-behavior-y: none !important;
        overscroll-behavior-x: none !important;
        -webkit-overflow-scrolling: touch;
    }

    body {
        position: relative;
    }
    
    #app, .min-h-screen {
        min-height: auto !important;
    }

    .input-primary:focus {
        border-color: var(--tokoriza-blue);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }

    .upload-area {
        position: relative;
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        border-color: var(--tokoriza-blue);
        background-color: var(--tokoriza-blue-light);
    }

    .upload-area:hover .upload-icon {
        color: var(--tokoriza-blue);
        transform: scale(1.1);
    }

    .upload-icon {
        transition: all 0.3s ease;
    }

    .variant-card {
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .radio-card {
        transition: all 0.2s ease;
    }

    .radio-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    input[type="radio"]:checked + .radio-card {
        border-color: var(--tokoriza-blue);
        background-color: var(--tokoriza-blue-light);
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .btn-primary {
        position: relative;
        overflow: hidden;
    }

    .btn-primary:active::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        animation: ripple 0.6s ease-out;
    }

    @keyframes ripple {
        to {
            width: 300px;
            height: 300px;
            opacity: 0;
        }
    }

    .badge-required {
        background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%);
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    .badge-optional {
        background: #F3F4F6;
        color: #6B7280;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    .image-preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .upload-area:hover .image-preview-overlay {
        opacity: 1;
    }

    /* ============================================
       FIXED HEADER - NAVBAR BARU (80px)
       ============================================ */
    .fixed-header-nav {
        position: fixed !important;
        top: 80px !important; /* FIXED: topbar (24px) + main nav (56px) = 80px */
        left: 0 !important;
        right: 0 !important;
        z-index: 40 !important;
        background: white !important;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-left: 0 !important;
        margin-top: 4px !important; /* Tambah sedikit space dari navbar */
        width: 100% !important;
        box-sizing: border-box !important;
    }
    
    @media (max-width: 640px) {
        body {
            font-size: 14px;
        }
        
        .fixed-header-nav {
            top: 80px !important; /* FIXED: navbar baru 80px di mobile */
        }
        
        .space-y-6 > * + *,
        .space-y-5 > * + *,
        .space-y-4 > * + * {
            margin-top: 0.75rem !important;
        }
        
        .bg-white.rounded-xl,
        .bg-white.rounded-lg {
            border-radius: 0.5rem !important;
            margin-bottom: 0.75rem;
        }
        
        .p-6 {
            padding: 0.875rem !important;
        }
        
        .px-6 {
            padding-left: 0.875rem !important;
            padding-right: 0.875rem !important;
        }
        
        .py-4 {
            padding-top: 0.625rem !important;
            padding-bottom: 0.625rem !important;
        }
        
        input:not([type="file"]):not([type="radio"]):not([type="checkbox"]),
        select,
        textarea {
            font-size: 14px !important;
            padding: 0.625rem 0.75rem !important;
            line-height: 1.25rem !important;
        }
        
        button {
            font-size: 13px !important;
        }
        
        .text-sm {
            font-size: 13px !important;
        }
        
        .text-xs {
            font-size: 11px !important;
        }
        
        .gap-6 {
            gap: 0.75rem !important;
        }
        
        .gap-4 {
            gap: 0.625rem !important;
        }
        
        .gap-3 {
            gap: 0.5rem !important;
        }
        
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
        
        .lg\\:col-span-8,
        .lg\\:col-span-4 {
            grid-column: span 1 !important;
        }
        
        .product-add-container {
            overflow-x: hidden !important;
        }
    }
    
    @media (min-width: 641px) and (max-width: 768px) {
        input:not([type="file"]):not([type="radio"]):not([type="checkbox"]),
        select,
        textarea {
            font-size: 14px !important;
        }
    }
    
    @media (min-width: 1024px) {
        .fixed-header-nav {
            left: 240px !important;
            width: calc(100% - 240px) !important;
        }
        
        body.sidebar-collapsed .fixed-header-nav,
        .sidebar-collapsed ~ * .fixed-header-nav {
            left: 72px !important;
            width: calc(100% - 72px) !important;
        }
    }
    
    @media (max-width: 1023px) {
        .fixed-header-nav {
            left: 0 !important;
            width: 100% !important;
        }
    }

    /* Form Padding - FIXED untuk navbar baru */
    .form-with-fixed-header {
        padding-top: 76px !important; /* FIXED: 80px navbar + 4px margin - 8px untuk lebih dekat */
    }
    
    @media (min-width: 640px) {
        .form-with-fixed-header {
            padding-top: 80px !important; /* FIXED: reduced gap */
        }
    }
    
    @media (min-width: 768px) {
        .form-with-fixed-header {
            padding-top: 84px !important; /* FIXED: reduced gap */
        }
    }

    @media (max-width: 640px) {
        .form-with-fixed-header {
            padding-top: 132px !important; /* FIXED: 80px navbar + 52px header (reduced) */
        }
    }

    .product-add-container {
        position: relative;
        overflow: visible !important;
    }
    
    @media (max-width: 640px) {
        .grid.grid-cols-5 {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem !important;
        }
        
        .grid.grid-cols-5 > div:nth-child(1) {
            grid-column: span 2 !important;
        }
        
        .grid.grid-cols-5 > div:nth-child(5) {
            display: none !important;
        }
    }
    
    @media (min-width: 641px) and (max-width: 1023px) {
        .grid.grid-cols-5 {
            grid-template-columns: repeat(3, 1fr) !important;
        }
        
        .grid.grid-cols-5 > div:nth-child(1) {
            grid-column: span 3 !important;
        }
    }
</style>

<div class="product-add-container">
    {{-- Top Navigation Bar --}}
    <div class="fixed-header-nav bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="h-12 sm:h-14 md:h-16 flex items-center justify-between px-3 sm:px-4 md:px-6 pr-4 sm:pr-6 md:pr-8">
            <div class="flex items-center gap-2 md:gap-4 min-w-0 flex-1">
                <a href="{{ route('admin.products.index') }}" 
                   class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-4 sm:h-4 md:w-5 md:h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div class="h-5 sm:h-6 md:h-8 w-px bg-gray-200 flex-shrink-0"></div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-sm sm:text-base md:text-xl font-bold text-gray-900 truncate">Edit Produk</h1>
                    <p class="text-xs text-gray-500 hidden md:block truncate">Update informasi produk Anda</p>
                </div>
            </div>
            
            <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3 flex-shrink-0">
                <a href="{{ route('admin.products.index') }}"
                   class="hidden sm:flex px-2 sm:px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <span class="flex items-center gap-1.5 md:gap-2">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="hidden md:inline">Batal</span>
                    </span>
                </a>
                <button type="submit" 
                        form="productForm"
                        class="btn-primary px-3 sm:px-4 md:px-6 py-1.5 md:py-2.5 text-xs md:text-sm font-semibold text-white rounded-lg transition-all whitespace-nowrap"
                        style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);">
                    <span class="flex items-center gap-1 md:gap-2">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Update</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- Error Alert --}}
    @if ($errors->any() || session('error'))
    <div class="max-w-[1400px] mx-auto px-6 mt-6">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-red-800">Ada beberapa kesalahan yang perlu diperbaiki:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @if($errors->any())
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            @endif
                            @if(session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Form --}}
    <form action="{{ route('admin.products.update', $product->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          id="productForm"
          class="form-with-fixed-header px-3 sm:px-4 md:px-6 pb-4 md:pb-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 sm:gap-4 md:gap-6">
            {{-- Left Content - 8 cols --}}
            <div class="col-span-1 lg:col-span-8 space-y-3 sm:space-y-4 md:space-y-5">

                {{-- Informasi Dasar --}}
                <div class="bg-white rounded-lg md:rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-4 md:px-6 py-3 md:py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm md:text-base font-bold text-gray-900">Informasi Dasar</h2>
                            <span class="badge-required text-[10px] md:text-xs">WAJIB</span>
                        </div>
                    </div>
                    
                    <div class="p-4 md:p-6 space-y-4 md:space-y-6">
                        {{-- Nama Produk --}}
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-900 mb-2">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Nama Produk
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   required
                                   maxlength="120"
                                   id="productName"
                                   class="input-primary w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all"
                                   placeholder="Contoh: Kaos Polos Premium Cotton Combed 30s - Nyaman & Adem">
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                                    </svg>
                                    Nama produk minimal 10 karakter, maksimal 120 karakter
                                </p>
                                <span class="text-xs font-medium text-gray-400"><span id="nameCount">{{ strlen($product->name) }}</span>/120</span>
                            </div>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-900 mb-2">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Kategori
                            </label>
                            <select name="category_id" 
                                    required
                                    class="input-primary w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                @forelse($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>Belum ada kategori tersedia</option>
                                @endforelse
                            </select>
                            @if(isset($categories) && $categories->isEmpty())
                                <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                                    </svg>
                                    Kategori belum tersedia. <a href="#" class="underline font-medium hover:text-red-700" onclick="alert('Jalankan: php artisan db:seed --class=CategorySeeder'); return false;">Jalankan Seeder</a>
                                </p>
                            @else
                                <p class="mt-2 text-xs text-gray-500">Pilih kategori yang sesuai dengan produk Anda</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Gambar Produk --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-bold text-gray-900">Gambar Produk</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Upload atau edit gambar produk (maksimal 5 gambar)</p>
                            </div>
                            <span class="badge-required">MIN. 1</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        {{-- Grid Upload Individual --}}
                        <div class="grid grid-cols-5 gap-4">
                            @for($i = 1; $i <= 5; $i++)
                            @php
                                $existingImages = $product->images->sortBy('sort_order');
                                $currentImage = $existingImages->skip($i - 1)->first();
                            @endphp
                            
                            <div class="{{ $i == 1 ? 'col-span-2' : '' }}">
                                <div class="relative border-2 border-dashed rounded-lg {{ $i == 1 && !$existingImages->count() ? 'border-red-300' : 'border-gray-300' }}">
                                    {{-- Preview Gambar Existing atau Upload Baru --}}
                                    <div class="w-full aspect-square">
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
                                                            class="bg-blue-500 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-blue-600 font-semibold">
                                                        Ganti
                                                    </button>
                                                    <label class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-red-600 cursor-pointer font-semibold">
                                                        <input type="checkbox" 
                                                               name="delete_images[]" 
                                                               value="{{ $currentImage->id }}"
                                                               class="mr-1"
                                                               onchange="toggleDeleteImage({{ $i }})">
                                                        Hapus
                                                    </label>
                                                </div>
                                                
                                                {{-- Hidden: Image ID untuk tracking --}}
                                                <input type="hidden" name="existing_images[{{ $i }}]" value="{{ $currentImage->id }}">
                                                
                                                {{-- Badge COVER untuk gambar pertama --}}
                                                @if($i == 1)
                                                <div class="absolute top-2 left-2 z-10">
                                                    <span class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">UTAMA</span>
                                                </div>
                                                @endif
                                            </div>
                                        @else
                                            {{-- Upload Baru --}}
                                            <label for="new-image-{{ $i }}" 
                                                   class="w-full h-full flex items-center justify-center cursor-pointer hover:bg-gray-50 transition rounded-lg">
                                                <div id="upload-placeholder-{{ $i }}" class="text-center text-gray-400 p-3">
                                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-2 mx-auto">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </div>
                                                    <span class="text-xs">{{ $i }}/5</span>
                                                </div>
                                            </label>
                                            
                                            @if($i == 1)
                                            <div class="absolute top-2 left-2 z-10">
                                                <span class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">UTAMA</span>
                                            </div>
                                            @endif
                                        @endif
                                        
                                        {{-- Preview Gambar Baru (akan di-upload) --}}
                                        <div id="new-preview-{{ $i }}" class="hidden absolute inset-0 bg-white rounded-lg">
                                            <div class="relative w-full h-full">
                                                <img id="new-preview-img-{{ $i }}" 
                                                     class="w-full h-full object-cover rounded-lg"
                                                     alt="Preview baru {{ $i }}">
                                                <button type="button" 
                                                        onclick="cancelNewImage({{ $i }})"
                                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center text-sm hover:bg-red-600 font-bold shadow-lg">
                                                    ×
                                                </button>
                                                <div class="absolute bottom-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded font-semibold">
                                                    Baru
                                                </div>
                                                @if($i == 1)
                                                <div class="absolute top-2 left-2 z-10">
                                                    <span class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">UTAMA</span>
                                                </div>
                                                @endif
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
                            </div>
                            @endfor
                        </div>

                        {{-- Informasi --}}
                        <div class="mt-5 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-blue-900 mb-2">💡 Cara Edit Gambar:</h4>
                                    <ul class="text-xs text-blue-800 space-y-1.5">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span><strong>Ganti:</strong> Hover pada gambar → Klik "Ganti" → Pilih gambar baru</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span><strong>Hapus:</strong> Hover pada gambar → Centang "Hapus"</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span><strong>Tambah:</strong> Klik slot kosong → Upload gambar</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span>Perubahan akan tersimpan setelah klik tombol "Update Produk"</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Produk --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-bold text-gray-900">Deskripsi Produk</h2>
                            <span class="badge-optional">Opsional</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <textarea name="description" 
                                  id="productDesc"
                                  rows="8" 
                                  maxlength="3000"
                                  class="input-primary w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all resize-none"
                                  placeholder="Jelaskan detail produk Anda. Contoh:&#10;&#10;✅ Bahan: Cotton Combed 30s&#10;✅ Ukuran: All Size (LD: 100cm, Panjang: 70cm)&#10;✅ Berat: ±200 gram&#10;✅ Warna: Hitam, Putih, Navy, Abu&#10;✅ Sablon: Rubber / Plastisol&#10;✅ Nyaman dipakai sehari-hari&#10;✅ Tidak mudah luntur&#10;&#10;Keunggulan:&#10;• Bahan lembut & adem&#10;• Jahitan rapi & kuat&#10;• Tersedia berbagai ukuran">{{ old('description', $product->description) }}</textarea>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-500">Deskripsi detail membantu pembeli memahami produk Anda</p>
                            <span class="text-xs font-medium text-gray-400"><span id="descCount">{{ strlen($product->description ?? '') }}</span>/3000</span>
                        </div>
                    </div>
                </div>

                {{-- Detail Lainnya --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">Detail Lainnya</h2>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        {{-- SKU --}}
                        <div>
                            <label class="text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                SKU Produk
                                <span class="badge-optional">Opsional</span>
                            </label>
                            <input type="text" 
                                   name="sku" 
                                   value="{{ old('sku', $product->sku) }}"
                                   class="input-primary w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all"
                                   placeholder="Contoh: KOS-BLK-001">
                            <p class="mt-2 text-xs text-gray-500">SKU (Stock Keeping Unit) untuk tracking internal</p>
                        </div>

                        {{-- Jenis Produk --}}
                        <div>
                            <label class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Jenis Produk
                            </label>
                            
                            <div class="grid grid-cols-3 gap-4">
                                @foreach([
                                    ['value' => 'physical', 'label' => 'Produk Fisik', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                                    ['value' => 'digital', 'label' => 'Produk Digital', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                    ['value' => 'service', 'label' => 'Jasa/Layanan', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z']
                                ] as $type)
                                <div>
                                    <input type="radio" 
                                           name="product_type" 
                                           value="{{ $type['value'] }}" 
                                           id="type-{{ $type['value'] }}"
                                           {{ old('product_type', $product->product_type) == $type['value'] ? 'checked' : '' }}
                                           required
                                           class="peer sr-only">
                                    <label for="type-{{ $type['value'] }}" class="radio-card block p-4 border-2 border-gray-200 rounded-lg cursor-pointer">
                                        <div class="flex flex-col items-center text-center gap-2">
                                            <div class="w-12 h-12 rounded-full bg-gray-100 peer-checked:bg-sky-100 flex items-center justify-center transition-colors">
                                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-700">{{ $type['label'] }}</span>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

              {{-- Varian Produk --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">Varian Produk</h2>
                <p class="text-xs text-gray-500 mt-0.5">Edit varian yang ada atau tambahkan baru</p>
            </div>
            <button type="button" 
                    id="btn-tambah-varian"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white rounded-lg transition-all"
                    style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Varian
            </button>
        </div>
    </div>
    
    <div class="p-6">
        <div id="variant-wrapper" class="space-y-4">
            @php 
                $i = 0;
                $groupedVariants = $product->variants->groupBy('variant_name');
            @endphp
            
            @forelse($groupedVariants as $name => $variants)
                <div class="variant-card bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-xl p-5 variant-row" id="variant-{{ $i + 1 }}">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-white text-sm"
                                 style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Varian {{ $i + 1 }}</h3>
                                <p class="text-xs text-gray-500">{{ $name }}</p>
                            </div>
                        </div>
                        <button type="button"
                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition-all"
                                onclick="hapusVarianIni(this, {{ $i + 1 }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-gray-900 mb-2 block">Nama Varian</label>
                            <input type="text"
                                   name="variants[{{ $i }}][name]"
                                   value="{{ old('variants.'.$i.'.name', $name) }}"
                                   placeholder="Contoh: Ukuran, Warna, Tipe"
                                   class="input-primary w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-900 mb-2 block">Opsi Varian (pisahkan dengan koma)</label>
                            <input type="text"
                                   name="variants[{{ $i }}][values]"
                                   value="{{ old('variants.'.$i.'.values', $variants->pluck('variant_value')->implode(', ')) }}"
                                   placeholder="Contoh: S, M, L, XL"
                                   class="input-primary w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
                            <p class="text-xs text-gray-500 mt-1.5">💡 Pisahkan setiap opsi dengan koma</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-900 mb-2 block">Tambahan Harga</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-xs font-semibold">Rp</span>
                                    <input type="number"
                                        name="variants[{{ $i }}][price_modifier]"
                                        value="{{ old('variants.'.$i.'.price_modifier', (int) ($variants->first()->price_modifier ?? 0)) }}"
                                        min="0"
                                        step="1"
                                        placeholder="0"
                                        class="input-primary w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-900 mb-2 block">Stok</label>
                                <input type="number"
                                       name="variants[{{ $i }}][stock]"
                                       value="{{ old('variants.'.$i.'.stock', $variants->first()->stock ?? 0) }}"
                                       min="0"
                                       placeholder="0"
                                       class="input-primary w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
                            </div>
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
            @empty
                {{-- Tampilkan pesan kosong jika belum ada varian --}}
                <div id="empty-message" class="text-center py-16 px-4">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Belum Ada Varian</h3>
                    <p class="text-xs text-gray-500 mb-4">Klik tombol "Tambah Varian" untuk menambahkan</p>
                    <button type="button"
                            onclick="tambahVarianBaru()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold border-2 border-sky-500 text-sky-600 rounded-lg hover:bg-sky-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Varian Sekarang
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</div>

            </div>
            {{-- End Left Content --}}

            {{-- Right Sidebar - 4 cols --}}
            <div class="col-span-1 lg:col-span-4 space-y-3 sm:space-y-4 md:space-y-5">
                
                {{-- Harga --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-orange-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-bold text-gray-900">Harga</h2>
                            <span class="badge-required">WAJIB</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-900 mb-3">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Harga Jual
                        </label>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-600 font-semibold text-lg">Rp</span>
                            </div>
                            <input type="number" 
                                name="price" 
                                value="{{ old('price', (int) $product->price) }}" 
                                min="0"
                                step="1"
                                required
                                id="priceInput"
                                class="input-primary w-full pl-14 pr-4 py-4 border border-gray-300 rounded-lg text-2xl font-bold"
                                placeholder="0">
                        </div>
                        
                        <p class="mt-3 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                            </svg>
                            Tentukan harga yang kompetitif untuk menarik pembeli
                        </p>

                        <div class="mt-4 p-4 bg-gradient-to-br from-yellow-50 to-amber-50 border border-yellow-200 rounded-lg">
                            <div class="flex gap-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/>
                                </svg>
                                <div class="text-xs text-yellow-800 space-y-1">
                                    <p class="font-bold">Tips Pricing:</p>
                                    <p>• Riset harga kompetitor</p>
                                    <p>• Hitung HPP + margin</p>
                                    <p>• Berikan harga psikologis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stok --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">Stok Produk</h2>
                    </div>
                    
                    <div class="p-6">
                        <label class="text-sm font-semibold text-gray-900 mb-3 block">Jumlah Stok</label>
                        <input type="number" 
                               name="stock"
                               value="{{ old('stock', $product->stock) }}" 
                               min="0"
                               class="input-primary w-full px-4 py-3 border border-gray-300 rounded-lg text-lg font-semibold focus:outline-none transition-all"
                               placeholder="0">
                        <p class="mt-3 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                            </svg>
                            Stok otomatis berkurang saat ada transaksi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// ============================================
// CRITICAL: Override parent layout constraints
// FIXED: Navbar baru 80px (topbar 24px + main nav 56px)
// ============================================
(function() {
    'use strict';
    
    const NAVBAR_HEIGHT = 80; // FIXED: topbar (24px) + main nav (56px)
    
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.fixed-header-nav');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('toggleSidebar');
        
        function updateHeaderPosition() {
            if (!header) return;
            
            let sidebarWidth = 0;
            if (sidebar && window.innerWidth >= 1024) {
                const sidebarRect = sidebar.getBoundingClientRect();
                sidebarWidth = sidebarRect.width;
            }
            
            const isMobile = window.innerWidth < 1024;
            
            header.style.position = 'fixed';
            header.style.top = (NAVBAR_HEIGHT + 4) + 'px'; // FIXED: 80px + 4px margin untuk breathing space
            header.style.left = isMobile ? '0' : sidebarWidth + 'px';
            header.style.right = 'auto';
            header.style.zIndex = '40';
            header.style.backgroundColor = 'white';
            header.style.width = isMobile ? '100vw' : `calc(100vw - ${sidebarWidth}px)`;
            header.style.marginLeft = '0';
            header.style.boxSizing = 'border-box';
            header.style.maxWidth = '100%';
        }
        
        setTimeout(updateHeaderPosition, 100);
        
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(updateHeaderPosition, 150);
        });
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                setTimeout(updateHeaderPosition, 350);
            });
        }
        
        if (sidebar) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        setTimeout(updateHeaderPosition, 350);
                    }
                });
            });
            
            observer.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
        
        if (mainContent) {
            mainContent.style.overflow = 'visible';
            mainContent.style.overflowY = 'visible';
            mainContent.style.overflowX = 'visible';
            mainContent.style.backgroundColor = '#F5F5F5';
            mainContent.style.height = 'auto';
            mainContent.style.minHeight = 'auto';
            mainContent.classList.remove('overflow-y-auto');
            mainContent.classList.remove('overflow-auto');
        }
        
        const container = document.querySelector('.product-add-container');
        if (container) {
            container.style.overflow = 'visible';
            container.style.overflowX = 'hidden';
            container.style.position = 'relative';
            container.style.backgroundColor = '#F5F5F5';
        }
        
        const flexContainer = document.querySelector('.flex.pt-14.h-screen');
        if (flexContainer) {
            flexContainer.style.height = 'auto';
            flexContainer.style.minHeight = 'auto';
        }
    });
    
    setTimeout(function() {
        const mainContent = document.getElementById('main-content');
        if (mainContent) {
            mainContent.style.overflow = 'visible';
            mainContent.style.overflowY = 'visible';
            mainContent.classList.remove('overflow-y-auto');
        }
    }, 100);
})();

// ============================================
// Prevent over-scrolling - ENHANCED
// ============================================
(function() {
    'use strict';
    
    let ticking = false;
    
    function preventOverScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        const maxScroll = scrollHeight - clientHeight;
        
        if (scrollTop >= maxScroll) {
            window.scrollTo({
                top: maxScroll,
                behavior: 'instant'
            });
        }
        
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(preventOverScroll);
            ticking = true;
        }
    }, { passive: true });
    
    window.addEventListener('wheel', function(e) {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        if (scrollTop + clientHeight >= scrollHeight - 1 && e.deltaY > 0) {
            e.preventDefault();
        }
    }, { passive: false });
    
    let touchStartY = 0;
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    }, { passive: true });
    
    document.addEventListener('touchmove', function(e) {
        const touchY = e.touches[0].clientY;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        if (scrollTop + clientHeight >= scrollHeight - 1 && touchY < touchStartY) {
            e.preventDefault();
        }
    }, { passive: false });
})();

// ============================================
// Character Counter
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('productName');
    const nameCount = document.getElementById('nameCount');
    if (nameInput && nameCount) {
        nameInput.addEventListener('input', function() {
            nameCount.textContent = this.value.length;
        });
    }

    const descInput = document.getElementById('productDesc');
    const descCount = document.getElementById('descCount');
    if (descInput && descCount) {
        descInput.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    }

    const priceInput = document.getElementById('priceInput');
    if (priceInput) {
        priceInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = Math.round(this.value / 100) * 100;
            }
        });
    }
});

// ============================================
// Image Preview Functions
// ============================================
function previewNewImage(event, slotNumber) {
    const file = event.target.files[0];
    
    if (!file) return;
    
    if (file.size > 2097152) {
        alert('Gambar terlalu besar! Maksimal 2MB.');
        event.target.value = '';
        return;
    }
    
    if (!file.type.match('image.*')) {
        alert('File harus berupa gambar!');
        event.target.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const newPreview = document.getElementById(`new-preview-${slotNumber}`);
        const newPreviewImg = document.getElementById(`new-preview-img-${slotNumber}`);
        const existingPreview = document.getElementById(`existing-preview-${slotNumber}`);
        const uploadPlaceholder = document.getElementById(`upload-placeholder-${slotNumber}`);
        
        newPreviewImg.src = e.target.result;
        newPreview.classList.remove('hidden');
        
        if (existingPreview) {
            existingPreview.closest('.group').style.display = 'none';
        }
        if (uploadPlaceholder) {
            uploadPlaceholder.closest('label').style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
}

function cancelNewImage(slotNumber) {
    const fileInput = document.getElementById(`new-image-${slotNumber}`);
    const newPreview = document.getElementById(`new-preview-${slotNumber}`);
    const existingPreview = document.getElementById(`existing-preview-${slotNumber}`);
    const uploadPlaceholder = document.getElementById(`upload-placeholder-${slotNumber}`);
    
    fileInput.value = '';
    newPreview.classList.add('hidden');
    
    if (existingPreview) {
        existingPreview.closest('.group').style.display = 'block';
    }
    if (uploadPlaceholder) {
        uploadPlaceholder.closest('label').style.display = 'flex';
    }
}

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

// ============================================
// VARIANT MANAGEMENT
// ============================================
let variantIndex = {{ $groupedVariants->count() ?? 0 }};

document.addEventListener('DOMContentLoaded', function() {
    const btnTambah = document.getElementById('btn-tambah-varian');
    if (btnTambah) {
        const newBtn = btnTambah.cloneNode(true);
        btnTambah.parentNode.replaceChild(newBtn, btnTambah);
        
        const freshBtn = document.getElementById('btn-tambah-varian');
        freshBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            tambahVarianBaru();
        });
    }
});

function tambahVarianBaru() {
    const wrapper = document.getElementById('variant-wrapper');
    if (!wrapper) return;
    
    const emptyMsg = document.getElementById('empty-message');
    if (emptyMsg) emptyMsg.remove();

    variantIndex++;
    
    const newRow = document.createElement('div');
    newRow.className = 'variant-card bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-xl p-5 variant-row';
    newRow.id = `variant-${variantIndex}`;
    newRow.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-white text-sm"
                     style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);">
                    ${variantIndex}
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Varian ${variantIndex}</h3>
                    <p class="text-xs text-gray-500">Isi informasi varian produk</p>
                </div>
            </div>
            <button type="button"
                    onclick="hapusVarianIni(this, ${variantIndex})"
                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold text-gray-900 mb-2 block">Nama Varian</label>
                <input type="text"
                       name="variants[${variantIndex - 1}][name]"
                       placeholder="Contoh: Ukuran, Warna, Tipe"
                       class="input-primary w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
            </div>

            <div>
                <label class="text-xs font-bold text-gray-900 mb-2 block">Opsi Varian (pisahkan dengan koma)</label>
                <input type="text"
                       name="variants[${variantIndex - 1}][values]"
                       placeholder="Contoh: S, M, L, XL"
                       class="input-primary w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
                <p class="text-xs text-gray-500 mt-1.5">💡 Pisahkan setiap opsi dengan koma</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-gray-900 mb-2 block">Tambahan Harga</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-xs font-semibold">Rp</span>
                        <input type="number"
                               name="variants[${variantIndex - 1}][price_modifier]"
                               value=""
                               min="0"
                               placeholder="0"
                               class="input-primary w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-900 mb-2 block">Stok</label>
                    <input type="number"
                           name="variants[${variantIndex - 1}][stock]"
                           value=""
                           min="0"
                           placeholder="0"
                           class="input-primary w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all">
                </div>
            </div>
        </div>
    `;

    wrapper.appendChild(newRow);
}

function hapusVarianIni(button, id) {
    const row = document.getElementById(`variant-${id}`);
    if (row) {
        row.style.opacity = '0';
        row.style.transform = 'translateY(-10px)';
        setTimeout(() => row.remove(), 300);
    }
    
    const wrapper = document.getElementById('variant-wrapper');
    setTimeout(() => {
        const remainingRows = wrapper.querySelectorAll('.variant-row');
        
        if (remainingRows.length === 0) {
            const emptyMsg = document.createElement('div');
            emptyMsg.id = 'empty-message';
            emptyMsg.className = 'text-center py-16 px-4';
            emptyMsg.innerHTML = `
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-900 mb-1">Belum Ada Varian</h3>
                <p class="text-xs text-gray-500 mb-4">Klik tombol "Tambah Varian" untuk menambahkan</p>
                <button type="button"
                        onclick="tambahVarianBaru()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold border-2 border-sky-500 text-sky-600 rounded-lg hover:bg-sky-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Varian Sekarang
                </button>
            `;
            wrapper.appendChild(emptyMsg);
        }
    }, 310);
}

document.getElementById('priceInput').addEventListener('input', function () {
    this.value = Math.floor(this.value || 0);
});
</script>

@endsection