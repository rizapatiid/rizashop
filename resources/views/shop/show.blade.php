@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4">

    <a href="{{ route('shop.index') }}"
       class="text-sm text-blue-600 mb-4 inline-block">
        ← Kembali ke produk
    </a>

    <div class="grid md:grid-cols-2 gap-6 bg-white p-6 rounded-lg shadow">

        <!-- IMAGES -->
        <div>
            <div class="bg-gray-100 rounded h-80 flex items-center justify-center mb-3">
                <img id="mainImage"
                     src="{{ asset('storage/'.$product->main_image) }}"
                     class="h-full object-contain">
            </div>

            @if(count($product->all_images))
                <div class="flex gap-2">
                    @foreach($product->all_images as $img)
                        <img src="{{ asset('storage/'.$img) }}"
                             onclick="document.getElementById('mainImage').src=this.src"
                             class="w-16 h-16 object-cover rounded border cursor-pointer">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- INFO -->
        <div>
            <h1 class="text-2xl font-bold">{{ $product->name }}</h1>

            <div class="text-sm text-gray-500 mb-2">
                SKU: {{ $product->sku ?? '-' }}
            </div>

            <div class="flex gap-2 text-xs mb-3">
                <span class="px-2 py-1 bg-gray-100 rounded">
                    {{ $product->category->name ?? '-' }}
                </span>
                <span class="px-2 py-1 bg-gray-100 rounded">
                    {{ ucfirst($product->product_type) }}
                </span>
            </div>

            <div class="text-2xl font-bold text-blue-600 mb-2">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <p class="text-sm text-gray-700 mb-4">
                {{ $product->description }}
            </p>

            <!-- VARIANT -->
            @if($product->variants->count())
                <div class="mb-4">
                    <label class="text-sm font-semibold">Pilih Varian</label>
                    <select id="variant"
                            class="w-full border rounded px-3 py-2 mt-1">
                        <option value="">-- Pilih Varian --</option>
                        @foreach($product->variants as $v)
                            <option value="{{ $v->id }}"
                                    data-price="{{ $v->price_modifier }}">
                                {{ $v->variant_name }} - {{ $v->variant_value }}
                                @if($v->price_modifier != 0)
                                    ({{ $v->price_modifier > 0 ? '+' : '' }}
                                    Rp {{ number_format($v->price_modifier,0,',','.') }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- QTY -->
            <div class="flex items-center gap-3 mb-4">
                <label class="text-sm">Jumlah</label>
                <input id="qty"
                       type="number"
                       value="1"
                       min="1"
                       class="w-20 border rounded px-2 py-1">
            </div>

            <div class="flex gap-3">
                <button id="btnAdd"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Tambah ke Keranjang
                </button>

                <button id="btnCheckout"
                        class="px-4 py-2 bg-green-600 text-white rounded">
                    Checkout
                </button>
            </div>

            <div id="msg" class="hidden mt-4 text-sm px-3 py-2 rounded"></div>
        </div>
    </div>
</div>

<script>
(function () {
    const btnAdd = document.getElementById('btnAdd');
    const btnCheckout = document.getElementById('btnCheckout');
    const qty = document.getElementById('qty');
    const variant = document.getElementById('variant');
    const msg = document.getElementById('msg');

    async function submit(redirect = false) {
        const data = {
            qty: qty.value || 1,
            variant_id: variant ? variant.value : null
        };

        try {
            const res = await fetch("{{ route('shop.cart.add', $product->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams(data)
            });

            const json = await res.json();
            if (!res.ok) throw new Error(json.message);

            msg.className = 'mt-4 text-sm px-3 py-2 rounded bg-green-100 text-green-700';
            msg.textContent = 'Berhasil ditambahkan ke keranjang';
            msg.classList.remove('hidden');

            setTimeout(() => {
                redirect
                    ? window.location.href = "{{ route('checkout.index') }}"
                    : window.location.reload();
            }, 800);

        } catch (e) {
            msg.className = 'mt-4 text-sm px-3 py-2 rounded bg-red-100 text-red-700';
            msg.textContent = e.message || 'Gagal';
            msg.classList.remove('hidden');
        }
    }

    btnAdd.onclick = () => submit(false);
    btnCheckout.onclick = () => submit(true);
})();
</script>
@endsection
