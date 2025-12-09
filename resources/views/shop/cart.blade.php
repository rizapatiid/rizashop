@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Keranjang Belanja</h1>
            <p class="text-sm text-gray-500">Periksa kembali produk sebelum checkout.</p>
        </div>
        <a href="{{ route('shop.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Produk
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

    @if(empty($cart) || count($cart) === 0)
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            Keranjang masih kosong.
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cart as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/'.$item['image']) }}"
                                                 alt="{{ $item['name'] }}"
                                                 class="h-12 w-12 rounded object-cover border">
                                        @else
                                            <div class="h-12 w-12 flex items-center justify-center bg-gray-100 rounded border text-xs text-gray-400">
                                                No Image
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-800">{{ $item['name'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $item['qty'] }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm">
                                    <form action="{{ route('shop.cart.remove', $item['id']) }}" method="POST"
                                          onsubmit="return confirm('Hapus produk ini dari keranjang?');">
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

            <div class="px-4 py-4 border-t bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Total: <span class="font-semibold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <form action="{{ route('shop.checkout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-md bg-green-600 text-white text-sm font-medium hover:bg-green-700">
                        Checkout (Simulasi)
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
