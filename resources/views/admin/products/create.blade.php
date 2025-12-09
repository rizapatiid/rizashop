@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Produk</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-100 p-4 text-red-800 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf

        {{-- Nama Produk --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
        </div>

        {{-- SKU & Harga --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">SKU (optional)</label>
                <input type="text" name="sku" value="{{ old('sku') }}"
                       class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" step="100"
                       class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            </div>
        </div>

        {{-- Stok & Status --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                       class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">
            </div>
            <div class="flex items-center mt-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>
        </div>

        {{-- Upload Gambar --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
                       class="mt-1 w-full text-sm text-gray-700">

                <p class="text-xs text-gray-400 mt-1">
                    Format: JPG, JPEG, PNG, WEBP. Maks 2MB.
                </p>
            </div>

            {{-- Preview gambar --}}
            <div class="flex flex-col items-start md:items-end mt-2 md:mt-0">
                <span class="text-sm text-gray-700 mb-1">Preview:</span>
                <img id="imagePreview"
                     src="https://via.placeholder.com/100?text=No+Image"
                     class="h-24 w-24 rounded border object-cover">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" rows="4"
                      class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-400">{{ old('description') }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-2 pt-4">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-700">
                Batal
            </a>

            <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                Simpan Produk
            </button>
        </div>
    </form>
</div>

{{-- Preview Gambar Script --}}
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imagePreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection
