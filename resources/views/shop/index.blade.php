@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">

    <h1 class="text-xl font-bold mb-4">Produk</h1>

    @if($products->count() === 0)
        <div class="text-gray-500">Belum ada produk</div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($products as $product)
                <a href="{{ route('shop.show', $product->id) }}"
                   class="border rounded-lg p-3 hover:shadow transition block">

                    <div class="h-36 bg-gray-100 flex items-center justify-center rounded mb-2">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 class="h-full object-cover">
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </div>

                    <div class="font-semibold text-sm truncate">
                        {{ $product->name }}
                    </div>

                    <div class="text-xs text-gray-500">
                        Stok: {{ $product->stock }}
                    </div>

                    <div class="text-sm font-bold text-blue-600 mt-1">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
