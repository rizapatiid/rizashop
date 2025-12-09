@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Manajemen Produk</h1>
            <p class="text-sm text-gray-500">Kelola produk yang ditampilkan di toko.</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count() === 0)
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            Belum ada produk. Klik <strong>Tambah Produk</strong> untuk menambahkan.
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $loop->iteration + ($products->currentPage()-1) * $products->perPage() }}
                            </td>

                            {{-- Produk + gambar --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/'.$product->image_path) }}"
                                             alt="{{ $product->name }}"
                                             class="h-12 w-12 rounded object-cover border border-gray-200">
                                    @else
                                        <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center text-[10px] text-gray-500">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $product->name }}
                                        </div>
                                        @if($product->sku)
                                            <div class="text-xs text-gray-500">
                                                SKU: {{ $product->sku }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $product->stock }}
                            </td>

                            <td class="px-4 py-3">
                                @if($product->is_active)
                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded bg-green-100 text-green-800 border border-green-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded bg-red-100 text-red-800 border border-red-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded bg-yellow-500 text-white text-xs font-medium hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST"
                                      class="inline-block ml-2"
                                      onsubmit="return confirm('Hapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded bg-red-600 text-white text-xs font-medium hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Menampilkan <strong>{{ $products->firstItem() }}</strong> - <strong>{{ $products->lastItem() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

