@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Edit Produk</h1>

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
          class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                   class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">SKU (optional)</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                       class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="100"
                       class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                       class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div class="flex items-center mt-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>
        </div>

        {{-- Gambar produk --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <input type="file" name="image" accept="image/*"
                       class="mt-1 w-full text-sm text-gray-700">
                <p class="text-xs text-gray-400 mt-1">
                    Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, WEBP. Maks 2MB.
                </p>
            </div>

            <div class="flex flex-col items-start md:items-end mt-2 md:mt-0">
                <span class="text-sm text-gray-700 mb-1">Gambar Saat Ini:</span>
                @if($product->image_path)
                    <img src="{{ asset('storage/'.$product->image_path) }}"
                         alt="{{ $product->name }}"
                         class="h-24 w-24 rounded object-cover border border-gray-200">
                @else
                    <span class="text-xs text-gray-400">Belum ada gambar</span>
                @endif
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" rows="4"
                      class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-2 pt-4">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-700">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
