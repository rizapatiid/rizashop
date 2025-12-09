@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Produk</h1>
            <p class="text-sm text-gray-500">Pilih produk yang ingin kamu beli.</p>
        </div>
        <a href="{{ route('shop.cart') }}" class="text-sm font-medium text-blue-600 hover:underline">
            Lihat Keranjang
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 border border-red-100 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if($products->count() === 0)
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            Belum ada produk yang tersedia.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition p-4 flex flex-col">
                    <div class="mb-3">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-40 object-cover rounded border border-gray-200">
                        @else
                            <div class="w-full h-40 flex items-center justify-center bg-gray-100 rounded border text-gray-400 text-xs">
                                Tidak ada gambar
                            </div>
                        @endif
                    </div>

                    <h2 class="text-base font-semibold text-gray-800 mb-1">{{ $product->name }}</h2>

                    @if($product->sku)
                        <div class="text-xs text-gray-400 mb-1">SKU: {{ $product->sku }}</div>
                    @endif

                    <div class="text-lg font-bold text-blue-600 mb-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <div class="text-xs text-gray-500 mb-3">
                        Stok: {{ $product->stock }}
                    </div>

                    <form action="{{ route('shop.cart.add', $product->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <div class="flex items-center gap-2 mb-2">
                            <input type="number" name="qty" value="1" min="1"
                                   class="w-16 border rounded px-2 py-1 text-sm">
                            <span class="text-xs text-gray-500">Qty</span>
                        </div>
                        <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
