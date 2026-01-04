@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-6xl">
    <style>
        /* ringan: layout checkout */
        .checkout-grid { display:grid; gap:18px; grid-template-columns: 1fr; }
        @media(min-width:1024px){ .checkout-grid { grid-template-columns: 420px 1fr; } }

        .card {
            background:#fff; border:1px solid #eef2f7; border-radius:12px; padding:16px; box-shadow:0 8px 20px rgba(2,6,23,0.04);
        }

        .address-row { display:flex; gap:12px; align-items:flex-start; padding:10px; border-radius:10px; border:1px solid transparent; transition:all .12s ease; }
        .address-row:hover { border-color:#e6f0fb; background:#fbfdff; }
        .address-radio { margin-top:6px; }

        .ship-row { display:flex; justify-content:space-between; align-items:center; padding:10px; border-radius:10px; border:1px solid transparent; transition:all .12s ease; }
        .ship-row:hover { border-color:#e6f0fb; background:#fbfdff; }

        .product-row { display:flex; gap:12px; align-items:center; padding:10px 0; border-bottom:1px dashed #f1f5f9 }
        .product-row:last-child { border-bottom:none; }

        .img-thumb { width:72px; height:72px; border-radius:8px; overflow:hidden; background:#f8fafc; display:flex; align-items:center; justify-content:center; }
        .img-thumb img { width:100%; height:100%; object-fit:cover; display:block; }

        .muted { color:#6b7280; font-size:13px; }

        .summary-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-weight:700; }

        .btn-primary { background:#0ea5e9; color:#fff; padding:10px 14px; border-radius:10px; border:none; cursor:pointer; font-weight:800; }
        .btn-ghost { background:transparent; border:1px solid #e6eef8; color:#0f172a; padding:8px 12px; border-radius:8px; cursor:pointer; }
    </style>

    <h1 class="text-2xl font-bold mb-4">Checkout</h1>

    {{-- error / success messages --}}
    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-800">
        <strong>Ada kesalahan:</strong>
        <ul class="mt-2">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(session('error'))
      <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-800">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-50 border border-green-100 text-green-800">{{ session('success') }}</div>
    @endif

    {{-- FORM WRAPS THE ENTIRE GRID (RELIABLE SUBMIT) --}}
    <form id="checkoutForm" action="{{ route('checkout.place') }}" method="POST" novalidate>
        @csrf

        <div class="checkout-grid">
            <!-- column kiri: alamat + pengiriman -->
            <div class="card">
                <h2 class="text-lg font-semibold mb-3">Pilih Alamat Pengiriman</h2>

                @if($addresses->isEmpty())
                    <div class="mb-3 muted">
                        Belum ada alamat tersimpan. <a href="{{ route('profile.edit') }}#address" class="text-blue-600 underline">Tambah alamat</a>
                    </div>
                @endif

                <div class="space-y-3 mb-4">
                    @foreach($addresses as $addr)
                        <label class="address-row" for="addr-{{ $addr->id }}">
                            <input class="address-radio" type="radio" name="address_id" id="addr-{{ $addr->id }}" value="{{ $addr->id }}" {{ $addr->is_primary ? 'checked' : '' }}>
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="font-weight:700;">{{ $addr->label ?? $addr->recipient_name ?? 'Alamat' }}</div>
                                    @if($addr->is_primary)
                                        <div style="font-size:12px;padding:4px 8px;background:#ecf8ff;border-radius:8px;color:#0369a1;">Utama</div>
                                    @endif
                                </div>
                                <div class="muted mt-1" style="white-space:pre-line;">{!! e($addr->address_full) !!}{{ $addr->village ? ', ' . e($addr->village) : '' }}{{ $addr->subdistrict ? ', ' . e($addr->subdistrict) : '' }}{{ $addr->city ? ', ' . e($addr->city) : '' }}{{ $addr->province ? ', ' . e($addr->province) : '' }}{{ $addr->postal_code ? ' - ' . e($addr->postal_code) : '' }}</div>
                                <div class="muted mt-2">Penerima: {{ e($addr->recipient_name) }} · {{ $addr->phone_country ?? '' }} {{ $addr->phone ?? '' }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('profile.edit') }}#address" class="btn-ghost">Tambah / Kelola Alamat</a>
                </div>

                <h2 class="text-lg font-semibold mb-3">Pilih Pengiriman</h2>
                <div class="space-y-2 mb-4">
                    @foreach($shippingOptions as $ship)
                        <label class="ship-row" for="ship-{{ $ship['id'] }}">
                            <input type="radio" name="shipping_method" id="ship-{{ $ship['id'] }}" value="{{ $ship['id'] }}" data-cost="{{ $ship['cost'] }}" {{ $loop->first ? 'checked' : '' }}>
                            <div style="flex:1;">
                                <div style="font-weight:700;">{{ $ship['label'] }}</div>
                                <div class="muted">Estimasi: 1-3 hari kerja</div>
                            </div>
                            <div style="font-weight:700;">
                                Rp {{ number_format($ship['cost'],0,',','.') }}
                            </div>
                        </label>
                    @endforeach
                </div>

                <div>
                    <label class="muted">Catatan untuk penjual (opsional)</label>
                    <textarea name="notes" class="w-full border rounded p-2 mt-1" rows="3" placeholder="Contoh: Tolong bungkus rapih..."></textarea>
                </div>

                <!-- hidden fields: shipping_cost akan diisi oleh JS -->
                <input type="hidden" name="shipping_cost" id="shipping_cost" value="">
            </div>

            <!-- column kanan: ringkasan order -->
            <div class="card">
                <h2 class="text-lg font-semibold mb-3">Ringkasan Pesanan</h2>

                <div class="mb-4">
                    @foreach($cart as $c)
                        <div class="product-row">
                            <div class="img-thumb">
                                @if(!empty($c['image']))
                                    <img src="{{ asset('storage/' . ltrim($c['image'], '/')) }}" alt="{{ $c['name'] }}">
                                @else
                                    <div class="muted text-xs">No Image</div>
                                @endif
                            </div>

                            <div style="flex:1;">
                                <div style="font-weight:700;">{{ $c['name'] }}</div>
                                <div class="muted">Qty: {{ $c['qty'] }}</div>
                            </div>

                            <div style="text-align:right;">
                                <div style="font-weight:800;">Rp {{ number_format(($c['price'] ?? 0) * $c['qty'],0,',','.') }}</div>
                                <div class="muted text-sm">Rp {{ number_format($c['price'] ?? 0,0,',','.') }} /pcs</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr class="my-3">

                <div class="summary-row">
                    <div class="muted">Subtotal</div>
                    <div id="subtotal_display" style="font-weight:800;">Rp {{ number_format($subtotal,0,',','.') }}</div>
                </div>

                <div class="summary-row">
                    <div class="muted">Biaya Pengiriman</div>
                    <div id="shipping_display" style="font-weight:800;">Rp 0</div>
                </div>

                <div class="summary-row" style="font-size:18px;">
                    <div>Total</div>
                    <div id="total_display" style="font-weight:900;">Rp {{ number_format($subtotal,0,',','.') }}</div>
                </div>

                <div class="mt-4">
                    <!-- tombol submit form -->
                    <button id="placeOrderBtn" class="btn-primary w-full" type="submit" disabled>Place Order</button>
                </div>

                <div class="mt-3 muted text-sm">
                    Setelah klik <strong>Place Order</strong>, kamu akan diarahkan ke halaman ringkasan order. (Implementasi pembayaran / konfirmasi akan dibuat berikutnya).
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    (function(){
        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const shippingCostInput = document.getElementById('shipping_cost');
        const shippingDisplay = document.getElementById('shipping_display');
        const subtotal = Number(@json($subtotal)) || 0;
        const subtotalDisplay = document.getElementById('subtotal_display');
        const totalDisplay = document.getElementById('total_display');
        const placeBtn = document.getElementById('placeOrderBtn');
        const checkoutForm = document.getElementById('checkoutForm');

        function formatRupiah(n){
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function updateShippingAndTotal(){
            let selected = document.querySelector('input[name="shipping_method"]:checked');
            let cost = 0;
            if (selected) {
                cost = Number(selected.dataset.cost || 0);
            }
            shippingCostInput.value = cost;
            shippingDisplay.textContent = formatRupiah(cost);
            totalDisplay.textContent = formatRupiah(subtotal + cost);
            // enable place order only when an address is selected and shipping chosen
            const addressSelected = !!document.querySelector('input[name="address_id"]:checked');
            placeBtn.disabled = !(addressSelected && !!selected);
        }

        // If no address is checked, check the first one automatically (helpful)
        const addressRadios = document.querySelectorAll('input[name="address_id"]');
        if (addressRadios.length && !document.querySelector('input[name="address_id"]:checked')) {
            addressRadios[0].checked = true;
        }

        // initial set (choose first shipping)
        updateShippingAndTotal();

        shippingRadios.forEach(r=>{
            r.addEventListener('change', updateShippingAndTotal);
        });

        // address change enables place button if shipping chosen too
        document.querySelectorAll('input[name="address_id"]').forEach(a=>{
            a.addEventListener('change', updateShippingAndTotal);
        });

        // ensure shipping_cost sent on submit (in case user disabled JS)
        checkoutForm.addEventListener('submit', function(e){
            // ensure shipping_cost present
            const sc = shippingCostInput.value;
            if (sc === '') {
                const sel = document.querySelector('input[name="shipping_method"]:checked');
                shippingCostInput.value = sel ? sel.dataset.cost : 0;
            }

            // basic client validation
            const addressSelected = !!document.querySelector('input[name="address_id"]:checked');
            if (!addressSelected) {
                e.preventDefault();
                alert('Pilih alamat pengiriman terlebih dahulu.');
                return false;
            }

            // disable button to prevent double-submit
            placeBtn.disabled = true;
            placeBtn.textContent = 'Processing...';
        });
    })();
</script>
@endsection
