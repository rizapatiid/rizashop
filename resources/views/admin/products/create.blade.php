@extends('layouts.nav_masterdashboard')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

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
    /* Override the parent layout's h-screen and overflow-y-auto */
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

    /* CRITICAL: Remove overflow from main-content for sticky to work */
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
    
    /* Main content area background */
    #main-content {
        background-color: #F5F5F5 !important;
    }
    
    /* Product add container */
    .product-add-container {
        background-color: #F5F5F5;
        min-height: calc(100vh - 56px);
    }

    /* Prevent over-scrolling and rubber banding */
    html, body {
        max-width: 100%;
        overscroll-behavior: none !important;
        overscroll-behavior-y: none !important;
        overscroll-behavior-x: none !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Prevent body from being taller than content */
    body {
        position: relative;
    }
    
    /* Fix for preventing extra scroll space */
    #app, .min-h-screen {
        min-height: auto !important;
    }

    /* Custom Input Focus */
    .input-primary:focus {
        border-color: var(--tokoriza-blue);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }

    /* Image Upload Area */
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

    /* Variant Card Animation */
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

    /* Radio Card Styles */
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

    /* Remove spinner from number input */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Scrollbar */
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

    /* Button Ripple Effect */
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

    /* Progress Steps */
    .step-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step::after {
        content: '';
        position: absolute;
        top: 15px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #E5E7EB;
        z-index: -1;
    }

    .step:last-child::after {
        display: none;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #E5E7EB;
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .step.active .step-circle {
        background: var(--shopee-orange);
        color: white;
    }

    .step.completed .step-circle {
        background: #10B981;
        color: white;
    }

    /* Badge Styles */
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

    /* Image Preview Overlay */
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

    /* Tooltip */
    .tooltip {
        position: relative;
    }

    .tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1F2937;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        margin-bottom: 8px;
        z-index: 1000;
    }

    .tooltip:hover::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-top-color: #1F2937;
        margin-bottom: 2px;
    }

    /* Fixed Header Enforcement */
    .fixed-header-nav {
        position: fixed !important;
        top: 56px !important; /* Offset dari top navbar parent (h-14 = 56px) */
        left: 0 !important; /* Mulai dari kiri main-content */
        right: 0 !important;
        z-index: 40 !important;
        background: white !important;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-left: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    
    /* Adjust left offset based on sidebar width */
    @media (min-width: 1024px) {
        .fixed-header-nav {
            left: 240px !important; /* Default sidebar width */
            width: calc(100% - 240px) !important;
        }
        
        body.sidebar-collapsed .fixed-header-nav,
        .sidebar-collapsed ~ * .fixed-header-nav {
            left: 72px !important; /* Collapsed sidebar width */
            width: calc(100% - 72px) !important;
        }
    }
    
    /* Mobile adjustment */
    @media (max-width: 1023px) {
        .fixed-header-nav {
            left: 0 !important;
            width: 100% !important;
        }
    }
    
    /* Adjust for collapsed sidebar */
    @media (min-width: 1024px) {
        body.sidebar-collapsed .fixed-header-nav {
            left: 72px !important;
        }
    }
    
    /* Mobile adjustment */
    @media (max-width: 1023px) {
        .fixed-header-nav {
            left: 0 !important;
        }
    }

    /* Add padding to form to compensate for fixed header */
    .form-with-fixed-header {
        padding-top: 80px; /* Height of fixed header */
    }

    /* Ensure parent allows sticky positioning */
    .product-add-container {
        position: relative;
        overflow: visible !important;
    }
</style>

<div class="product-add-container">
    {{-- Top Navigation Bar --}}
    <div class="fixed-header-nav bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="h-16 flex items-center justify-between px-6 pr-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div class="h-8 w-px bg-gray-200"></div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Tambah Produk</h1>
                    <p class="text-xs text-gray-500">Kelola produk yang akan Anda jual</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <button type="button" 
                        onclick="if(confirm('Yakin ingin mereset form?')) document.getElementById('productForm').reset();"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </span>
                </button>
                <button type="submit" 
                        form="productForm"
                        class="btn-primary px-6 py-2.5 text-sm font-semibold text-white rounded-lg transition-all"
                        style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Produk
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
    <form action="{{ route('admin.products.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          id="productForm"
          class="form-with-fixed-header px-6 pb-6">
        @csrf

        <div class="grid grid-cols-12 gap-6">
            {{-- Left Content - 8 cols --}}
            <div class="col-span-12 lg:col-span-8 space-y-5">

                {{-- Informasi Dasar --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-bold text-gray-900">Informasi Dasar</h2>
                            <span class="badge-required">WAJIB</span>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-6">
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
                                   value="{{ old('name') }}" 
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
                                <span class="text-xs font-medium text-gray-400"><span id="nameCount">0</span>/120</span>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <p class="text-xs text-gray-500 mt-0.5">Gambar pertama akan menjadi cover produk</p>
                            </div>
                            <span class="badge-required">WAJIB</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-6 gap-4">
                            {{-- Main Image --}}
                            <div class="col-span-2">
                                <input type="file" 
                                       name="images[]" 
                                       accept="image/jpeg,image/jpg,image/png,image/webp" 
                                       id="image-1" 
                                       onchange="previewImage(event, 1)"
                                       class="hidden"
                                       required>
                                <label for="image-1" class="upload-area block relative border-2 border-dashed border-gray-300 rounded-lg cursor-pointer group aspect-square">
                                    <div id="preview-1" class="w-full h-full flex flex-col items-center justify-center p-4">
                                        <div class="upload-icon">
                                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-600 mb-1">Gambar Utama</span>
                                        <span class="text-xs text-gray-400">Klik untuk upload</span>
                                    </div>
                                    <div class="absolute top-2 left-2 z-10">
                                        <span class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">COVER</span>
                                    </div>
                                    <button type="button" 
                                            onclick="clearImage(1); event.stopPropagation();" 
                                            id="clear-1"
                                            class="hidden absolute top-2 right-2 z-10 w-7 h-7 bg-red-500 text-white rounded-full items-center justify-center hover:bg-red-600 shadow-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </label>
                            </div>

                            {{-- Additional Images --}}
                            @for($i = 2; $i <= 5; $i++)
                            <div>
                                <input type="file" 
                                       name="images[]" 
                                       accept="image/jpeg,image/jpg,image/png,image/webp" 
                                       id="image-{{ $i }}" 
                                       onchange="previewImage(event, {{ $i }})"
                                       class="hidden">
                                <label for="image-{{ $i }}" class="upload-area block relative border-2 border-dashed border-gray-300 rounded-lg cursor-pointer group aspect-square">
                                    <div id="preview-{{ $i }}" class="w-full h-full flex flex-col items-center justify-center p-3">
                                        <div class="upload-icon">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-2">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $i }}/5</span>
                                    </div>
                                    <button type="button" 
                                            onclick="clearImage({{ $i }}); event.stopPropagation();" 
                                            id="clear-{{ $i }}"
                                            class="hidden absolute top-1 right-1 z-10 w-6 h-6 bg-red-500 text-white rounded-full items-center justify-center hover:bg-red-600 shadow-lg transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </label>
                            </div>
                            @endfor
                        </div>

                        {{-- Tips Box --}}
                        <div class="mt-5 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-blue-900 mb-2">Tips Foto Produk Berkualitas</h4>
                                    <ul class="text-xs text-blue-800 space-y-1.5">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span>Format: JPG, PNG, WEBP • Ukuran: min. 300x300px (ideal 1000x1000px) • Max 2MB per foto</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span>Gunakan pencahayaan terang, background bersih, tampilkan dari berbagai sudut</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                            </svg>
                                            <span>Foto asli produk Anda, jangan ambil dari internet untuk menghindari pelanggaran hak cipta</span>
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
                                  placeholder="Jelaskan detail produk Anda. Contoh:&#10;&#10;✅ Bahan: Cotton Combed 30s&#10;✅ Ukuran: All Size (LD: 100cm, Panjang: 70cm)&#10;✅ Berat: ±200 gram&#10;✅ Warna: Hitam, Putih, Navy, Abu&#10;✅ Sablon: Rubber / Plastisol&#10;✅ Nyaman dipakai sehari-hari&#10;✅ Tidak mudah luntur&#10;&#10;Keunggulan:&#10;• Bahan lembut & adem&#10;• Jahitan rapi & kuat&#10;• Tersedia berbagai ukuran">{{ old('description') }}</textarea>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-500">Deskripsi detail membantu pembeli memahami produk Anda</p>
                            <span class="text-xs font-medium text-gray-400"><span id="descCount">0</span>/3000</span>
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
                                   value="{{ old('sku') }}"
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
                                           {{ old('product_type') == $type['value'] ? 'checked' : '' }}
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
                                <p class="text-xs text-gray-500 mt-0.5">Tambahkan variasi seperti ukuran, warna, tipe</p>
                            </div>
                            <button type="button" 
                                    onclick="addVariant()"
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
                        <div id="variantsContainer" class="space-y-4">
                            <div id="emptyVariants" class="text-center py-16 px-4">
                                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-900 mb-1">Belum Ada Varian</h3>
                                <p class="text-xs text-gray-500 mb-4">Tambahkan varian untuk memberikan pilihan kepada pembeli</p>
                                <button type="button" 
                                        onclick="addVariant()"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold border-2 border-sky-500 text-sky-600 rounded-lg hover:bg-sky-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Varian Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Sidebar - 4 cols --}}
            <div class="col-span-12 lg:col-span-4 space-y-5">
                
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
                                   value="{{ old('price') }}" 
                                   min="0" 
                                   step="100" 
                                   required
                                   id="priceInput"
                                   class="input-primary w-full pl-14 pr-4 py-4 border border-gray-300 rounded-lg text-2xl font-bold focus:outline-none transition-all"
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
                               value="{{ old('stock') }}" 
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

                {{-- Progress Form --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">Progress Pengisian</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-700">Kelengkapan Data</span>
                            <span class="text-2xl font-bold bg-gradient-to-r from-sky-500 to-blue-600 bg-clip-text text-transparent" id="progressPercent">0%</span>
                        </div>
                        
                        {{-- Progress Bar --}}
                        <div class="relative w-full h-3 bg-gray-200 rounded-full overflow-hidden mb-4">
                            <div id="progressBar" 
                                 class="h-full rounded-full transition-all duration-500 ease-out"
                                 style="width: 0%; background: linear-gradient(90deg, #0EA5E9 0%, #0284C7 100%);"></div>
                        </div>

                        {{-- Checklist Items --}}
                        <div class="space-y-2.5">
                            <div class="flex items-start gap-2 text-xs" id="check-name">
                                <svg class="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-400">Nama produk (min. 10 karakter)</span>
                            </div>
                            
                            <div class="flex items-start gap-2 text-xs" id="check-category">
                                <svg class="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-400">Kategori produk</span>
                            </div>
                            
                            <div class="flex items-start gap-2 text-xs" id="check-image">
                                <svg class="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-400">Gambar utama produk</span>
                            </div>
                            
                            <div class="flex items-start gap-2 text-xs" id="check-type">
                                <svg class="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-400">Jenis produk</span>
                            </div>
                            
                            <div class="flex items-start gap-2 text-xs" id="check-price">
                                <svg class="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-400">Harga produk</span>
                            </div>
                        </div>

                        {{-- Status Message --}}
                        <div class="mt-5 p-3 rounded-lg" id="statusMessage" style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border: 1px solid #FCD34D;">
                            <p class="text-xs font-semibold text-yellow-800">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                                </svg>
                                Lengkapi semua data wajib untuk melanjutkan
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
// CRITICAL: Override parent layout constraints
(function() {
    'use strict';
    
    // CRITICAL: Make header fixed instead of sticky
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.fixed-header-nav');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('toggleSidebar');
        
        function updateHeaderPosition() {
            if (!header) return;
            
            // Get actual sidebar width
            let sidebarWidth = 0;
            if (sidebar && window.innerWidth >= 1024) {
                const sidebarRect = sidebar.getBoundingClientRect();
                sidebarWidth = sidebarRect.width;
            }
            
            // Check if mobile
            const isMobile = window.innerWidth < 1024;
            
            // Set position - header starts from left edge of main-content
            header.style.position = 'fixed';
            header.style.top = '56px'; // Top navbar height
            header.style.left = isMobile ? '0' : sidebarWidth + 'px';
            header.style.right = 'auto';
            header.style.zIndex = '40';
            header.style.backgroundColor = 'white';
            header.style.width = isMobile ? '100%' : `calc(100vw - ${sidebarWidth}px)`;
            header.style.marginLeft = '0';
            header.style.boxSizing = 'border-box';
            header.style.maxWidth = '100%';
            
            console.log('Header updated - Sidebar width:', sidebarWidth, 'Header width:', header.style.width);
        }
        
        // Initial positioning
        setTimeout(updateHeaderPosition, 100);
        
        // Update on window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(updateHeaderPosition, 150);
        });
        
        // Watch for sidebar toggle - IMPORTANT!
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                console.log('Sidebar toggle clicked');
                // Wait for sidebar animation to complete (transition duration is 300ms)
                setTimeout(updateHeaderPosition, 350);
            });
        }
        
        // Watch for sidebar class changes using MutationObserver
        if (sidebar) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        console.log('Sidebar class changed');
                        setTimeout(updateHeaderPosition, 350);
                    }
                });
            });
            
            observer.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
        
        // Remove overflow from main-content
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
        
        // Ensure parent container
        const container = document.querySelector('.product-add-container');
        if (container) {
            container.style.overflow = 'visible';
            container.style.position = 'relative';
            container.style.backgroundColor = '#F5F5F5';
        }
        
        // Target the flex container
        const flexContainer = document.querySelector('.flex.pt-14.h-screen');
        if (flexContainer) {
            flexContainer.style.height = 'auto';
            flexContainer.style.minHeight = 'auto';
        }
    });
    
    // Double check after delay
    setTimeout(function() {
        const mainContent = document.getElementById('main-content');
        if (mainContent) {
            mainContent.style.overflow = 'visible';
            mainContent.style.overflowY = 'visible';
            mainContent.classList.remove('overflow-y-auto');
        }
    }, 100);
})();

// Prevent over-scrolling - ENHANCED
(function() {
    'use strict';
    
    let ticking = false;
    
    function preventOverScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        const maxScroll = scrollHeight - clientHeight;
        
        // Hard stop at bottom
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
    
    // Also prevent wheel events at bottom
    window.addEventListener('wheel', function(e) {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        if (scrollTop + clientHeight >= scrollHeight - 1 && e.deltaY > 0) {
            e.preventDefault();
        }
    }, { passive: false });
    
    // Prevent touch overscroll on mobile
    let touchStartY = 0;
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    }, { passive: true });
    
    document.addEventListener('touchmove', function(e) {
        const touchY = e.touches[0].clientY;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        // Prevent pull-down at bottom
        if (scrollTop + clientHeight >= scrollHeight - 1 && touchY < touchStartY) {
            e.preventDefault();
        }
    }, { passive: false });
})();

// Character Counter
document.addEventListener('DOMContentLoaded', function() {
    // Product Name Counter
    const nameInput = document.getElementById('productName');
    const nameCount = document.getElementById('nameCount');
    if (nameInput && nameCount) {
        nameInput.addEventListener('input', function() {
            nameCount.textContent = this.value.length;
            updateProgress();
        });
    }

    // Description Counter
    const descInput = document.getElementById('productDesc');
    const descCount = document.getElementById('descCount');
    if (descInput && descCount) {
        descInput.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    }

    // Price Formatter
    const priceInput = document.getElementById('priceInput');
    if (priceInput) {
        priceInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = Math.round(this.value / 100) * 100;
            }
        });
        priceInput.addEventListener('input', updateProgress);
    }

    // Category Change
    const categorySelect = document.querySelector('select[name="category_id"]');
    if (categorySelect) {
        categorySelect.addEventListener('change', updateProgress);
    }

    // Product Type Change
    const typeRadios = document.querySelectorAll('input[name="product_type"]');
    typeRadios.forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    // Initial check
    updateProgress();
});

// Progress Tracker
function updateProgress() {
    let completed = 0;
    const total = 5;

    // Check Nama Produk (min 10 characters)
    const nameInput = document.getElementById('productName');
    const nameCheck = document.getElementById('check-name');
    if (nameInput && nameInput.value.length >= 10) {
        completed++;
        markAsCompleted(nameCheck);
    } else {
        markAsIncomplete(nameCheck);
    }

    // Check Kategori
    const categorySelect = document.querySelector('select[name="category_id"]');
    const categoryCheck = document.getElementById('check-category');
    if (categorySelect && categorySelect.value) {
        completed++;
        markAsCompleted(categoryCheck);
    } else {
        markAsIncomplete(categoryCheck);
    }

    // Check Gambar Utama
    const imageInput = document.getElementById('image-1');
    const imageCheck = document.getElementById('check-image');
    if (imageInput && imageInput.files.length > 0) {
        completed++;
        markAsCompleted(imageCheck);
    } else {
        markAsIncomplete(imageCheck);
    }

    // Check Jenis Produk
    const typeRadio = document.querySelector('input[name="product_type"]:checked');
    const typeCheck = document.getElementById('check-type');
    if (typeRadio) {
        completed++;
        markAsCompleted(typeCheck);
    } else {
        markAsIncomplete(typeCheck);
    }

    // Check Harga
    const priceInput = document.getElementById('priceInput');
    const priceCheck = document.getElementById('check-price');
    if (priceInput && priceInput.value && parseFloat(priceInput.value) > 0) {
        completed++;
        markAsCompleted(priceCheck);
    } else {
        markAsIncomplete(priceCheck);
    }

    // Update Progress Bar
    const percentage = Math.round((completed / total) * 100);
    const progressBar = document.getElementById('progressBar');
    const progressPercent = document.getElementById('progressPercent');
    const statusMessage = document.getElementById('statusMessage');

    if (progressBar) {
        progressBar.style.width = percentage + '%';
    }
    
    if (progressPercent) {
        progressPercent.textContent = percentage + '%';
    }

    // Update Status Message
    if (statusMessage) {
        if (percentage === 100) {
            statusMessage.style.background = 'linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%)';
            statusMessage.style.border = '1px solid #6EE7B7';
            statusMessage.innerHTML = `
                <p class="text-xs font-semibold text-emerald-800">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Semua data wajib sudah lengkap! Siap disimpan.
                </p>
            `;
        } else if (percentage >= 60) {
            statusMessage.style.background = 'linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%)';
            statusMessage.style.border = '1px solid #93C5FD';
            statusMessage.innerHTML = `
                <p class="text-xs font-semibold text-blue-800">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                    </svg>
                    Hampir selesai! Lengkapi ${total - completed} data lagi.
                </p>
            `;
        } else {
            statusMessage.style.background = 'linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%)';
            statusMessage.style.border = '1px solid #FCD34D';
            statusMessage.innerHTML = `
                <p class="text-xs font-semibold text-yellow-800">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                    </svg>
                    Lengkapi semua data wajib untuk melanjutkan
                </p>
            `;
        }
    }
}

function markAsCompleted(element) {
    if (!element) return;
    const icon = element.querySelector('svg');
    const text = element.querySelector('span');
    if (icon) {
        icon.classList.remove('text-gray-300');
        icon.classList.add('text-green-500');
    }
    if (text) {
        text.classList.remove('text-gray-400');
        text.classList.add('text-gray-900', 'font-medium');
    }
}

function markAsIncomplete(element) {
    if (!element) return;
    const icon = element.querySelector('svg');
    const text = element.querySelector('span');
    if (icon) {
        icon.classList.remove('text-green-500');
        icon.classList.add('text-gray-300');
    }
    if (text) {
        text.classList.remove('text-gray-900', 'font-medium');
        text.classList.add('text-gray-400');
    }
}

// Image Preview
function previewImage(event, slotNumber) {
    const file = event.target.files[0];
    const preview = document.getElementById(`preview-${slotNumber}`);
    const clearBtn = document.getElementById(`clear-${slotNumber}`);
    
    if (!file) return;
    
    // Validate size
    if (file.size > 2097152) { // 2MB
        alert('⚠️ Ukuran gambar terlalu besar!\nMaksimal 2MB per gambar.');
        event.target.value = '';
        return;
    }
    
    // Validate type
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('⚠️ Format gambar tidak didukung!\nGunakan JPG, PNG, atau WEBP.');
        event.target.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.innerHTML = `
            <img src="${e.target.result}" 
                 class="w-full h-full object-cover rounded-lg" 
                 alt="Preview ${slotNumber}">
        `;
        if (clearBtn) {
            clearBtn.classList.remove('hidden');
            clearBtn.classList.add('flex');
        }
        
        // Update progress if main image
        if (slotNumber === 1) {
            updateProgress();
        }
    };
    reader.readAsDataURL(file);
}

function clearImage(slotNumber) {
    const input = document.getElementById(`image-${slotNumber}`);
    const preview = document.getElementById(`preview-${slotNumber}`);
    const clearBtn = document.getElementById(`clear-${slotNumber}`);
    
    input.value = '';
    
    if (slotNumber === 1) {
        preview.innerHTML = `
            <div class="upload-icon">
                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-600 mb-1">Gambar Utama</span>
            <span class="text-xs text-gray-400">Klik untuk upload</span>
        `;
        updateProgress();
    } else {
        preview.innerHTML = `
            <div class="upload-icon">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>
            <span class="text-xs text-gray-500">${slotNumber}/5</span>
        `;
    }
    
    if (clearBtn) {
        clearBtn.classList.add('hidden');
        clearBtn.classList.remove('flex');
    }
}

// Variant Management
let variantCount = 0;

function addVariant() {
    const emptyState = document.getElementById('emptyVariants');
    if (emptyState) {
        emptyState.remove();
    }
    
    variantCount++;
    const container = document.getElementById('variantsContainer');
    
    const variantDiv = document.createElement('div');
    variantDiv.className = 'variant-card bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-xl p-5';
    variantDiv.id = `variant-${variantCount}`;
    variantDiv.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-white text-sm"
                     style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);">
                    ${variantCount}
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Varian ${variantCount}</h3>
                    <p class="text-xs text-gray-500">Isi informasi varian produk</p>
                </div>
            </div>
            <button type="button" 
                    onclick="removeVariant(${variantCount})" 
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
                       name="variants[${variantCount}][name]" 
                       class="input-primary w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all"
                       placeholder="Contoh: Ukuran, Warna, Tipe">
            </div>
            
            <div>
                <label class="text-xs font-bold text-gray-900 mb-2 block">Opsi Varian (pisahkan dengan koma)</label>
                <input type="text" 
                       name="variants[${variantCount}][values]" 
                       class="input-primary w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all"
                       placeholder="Contoh: S, M, L, XL">
                <p class="text-xs text-gray-500 mt-1.5">💡 Pisahkan setiap opsi dengan koma</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-gray-900 mb-2 block">Tambahan Harga</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-xs font-semibold">Rp</span>
                        <input type="number" 
                               name="variants[${variantCount}][price_modifier]" 
                               value="" 
                               min="0"
                               class="input-primary w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all"
                               placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-900 mb-2 block">Stok</label>
                    <input type="number" 
                           name="variants[${variantCount}][stock]" 
                           value="" 
                           min="0"
                           class="input-primary w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none transition-all"
                           placeholder="0">
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(variantDiv);
}

function removeVariant(id) {
    const element = document.getElementById(`variant-${id}`);
    if (element) {
        element.style.opacity = '0';
        element.style.transform = 'translateY(-10px)';
        setTimeout(() => element.remove(), 300);
    }
    
    const container = document.getElementById('variantsContainer');
    setTimeout(() => {
        if (container.children.length === 0) {
            container.innerHTML = `
                <div id="emptyVariants" class="text-center py-16 px-4">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Belum Ada Varian</h3>
                    <p class="text-xs text-gray-500 mb-4">Tambahkan varian untuk memberikan pilihan kepada pembeli</p>
                    <button type="button" 
                            onclick="addVariant()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold border-2 border-sky-500 text-sky-600 rounded-lg hover:bg-sky-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Varian Sekarang
                    </button>
                </div>
            `;
        }
    }, 310);
}
</script>

@endsection