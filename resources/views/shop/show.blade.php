@extends('layouts.app')
@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
<div class="pd-container">
    
    <a href="{{ route('shop.index') }}" class="pd-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    <div class="pd-grid">
        
        {{-- LEFT: Gallery --}}
        <div class="pd-gallery">
            <div class="pd-main-img">
                <img id="mainImg" src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}">
            </div>
            
            @if(count($product->all_images) > 1)
            <div class="pd-thumbs">
                @foreach($product->all_images as $i => $img)
                <div class="pd-thumb {{ $i===0?'active':'' }}" data-src="{{ asset('storage/'.$img) }}">
                    <img src="{{ asset('storage/'.$img) }}" alt="View {{ $i+1 }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- RIGHT: Info --}}
        <div class="pd-info">
            
            <div class="pd-badge-group">
                <span class="pd-badge pd-badge-cat">{{ $product->category->name ?? 'Uncategorized' }}</span>
                <span class="pd-badge pd-badge-type">{{ ucfirst($product->product_type) }}</span>
            </div>

            <h1 class="pd-name">{{ $product->name }}</h1>

            <div class="pd-meta">
                <span>SKU {{ $product->sku ?? '-' }}</span>
            </div>

            <div class="pd-price-box">
                <span class="pd-price-label">Harga</span>
                <div id="priceDisplay" class="pd-price">Rp {{ number_format($product->price,0,',','.') }}</div>
            </div>

            {{-- Description --}}
            <div class="pd-section">
                <button class="pd-toggle-desc" onclick="toggleDesc()">
                    <span>Deskripsi Produk</span>
                    <svg id="descIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div id="descContent" class="pd-desc">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            {{-- Variants --}}
            @if($product->variants->count())
            @php $groups=$product->variants->groupBy('variant_name'); @endphp
            @foreach($groups as $g=>$items)
            <div class="pd-section variant-group" data-group="{{ $g }}">
                <div class="pd-section-label">{{ $g }}</div>
                <div class="pd-variant-list">
                    @foreach($items as $v)
                    <button class="pd-variant {{ $v->stock <= 0 ? 'disabled' : '' }}"
                            data-group="{{ $g }}"
                            data-id="{{ $v->id }}"
                            data-price="{{ $v->price_modifier }}"
                            data-stock="{{ $v->stock }}"
                            {{ $v->stock <= 0 ? 'disabled' : '' }}>
                        <span class="var-name">{{ $v->variant_value }}</span>
                        @if($v->price_modifier!=0)
                        <span class="var-price">{{ $v->price_modifier>0?'+':'-' }}{{ number_format(abs($v->price_modifier),0,',','.') }}</span>
                        @endif
                        @if($v->stock <= 0)
                        <span class="var-badge-out">HABIS</span>
                        @endif
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            <div class="pd-section">
                <div class="pd-stock {{ $product->stock > 0 ? 'in-stock' : 'out-stock' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    @if($product->stock > 0)
                    <span>Stok: <strong>{{ $product->stock }}</strong></span>
                    @else
                    <span>Stok Habis</span>
                    @endif
                </div>
            </div>
            @endif

            {{-- Quantity --}}
            <div class="pd-section">
                <div class="pd-section-label">Jumlah</div>
                <div class="pd-qty">
                    <button onclick="changeQty(-1)">−</button>
                    <input id="qtyInput" type="number" value="1" min="1" readonly>
                    <button onclick="changeQty(1)">+</button>
                </div>
            </div>

            {{-- Actions --}}
            <div class="pd-actions">
                <button id="btnCart" class="pd-btn pd-btn-sec" {{ $product->stock <= 0 && !$product->variants->count() ? 'disabled' : '' }}>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Keranjang
                </button>
                <button id="btnBuy" class="pd-btn pd-btn-pri" {{ $product->stock <= 0 && !$product->variants->count() ? 'disabled' : '' }}>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    Beli Sekarang
                </button>
            </div>

            <div id="msgBox" class="pd-msg"></div>

        </div>
    </div>

    {{-- Recommendations --}}
    @if(isset($recommends) && $recommends->count())
    <div class="pd-rec-section">
        <h2 class="pd-rec-title">Produk Lainnya</h2>
        <div class="pd-rec-grid">
            @foreach($recommends as $r)
            <a href="{{ route('shop.show',$r->id) }}" class="pd-rec-card">
                <div class="rec-img">
                    <img src="{{ asset('storage/'.$r->main_image) }}" alt="{{ $r->name }}">
                    
                    {{-- STOCK BADGE --}}
                    @if($r->stock > 0)
                        <div class="rec-badge-ready">READY</div>
                    @else
                        <div class="rec-badge-out">HABIS</div>
                    @endif
                    
                    {{-- TYPE BADGE --}}
                    <div class="rec-badge-type">{{ strtoupper($r->product_type) }}</div>
                </div>
                <div class="rec-body">
                    <div class="rec-cat">{{ $r->category->name ?? '-' }}</div>
                    <div class="rec-name">{{ $r->name }}</div>
                    <div class="rec-stock">Stok: <strong>{{ $r->stock }}</strong></div>
                    <div class="rec-price">Rp {{ number_format($r->price,0,',','.') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;900&display=swap');

* { 
    box-sizing: border-box; 
    margin: 0; 
    padding: 0; 
}

body {
    font-family: 'DM Sans', -apple-system, sans-serif;
    -webkit-font-smoothing: antialiased;
    background: #fafafa;
}

/* Container */
.pd-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px 16px;
}

/* Back Button */
.pd-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    color: #6b7280;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    margin-bottom: 16px;
}
.pd-back:hover {
    background: #f9fafb;
    color: #111827;
}

/* Main Grid */
.pd-grid {
    display: grid;
    grid-template-columns: 420px 1fr;
    gap: 32px;
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #f3f4f6;
}

/* Gallery */
.pd-gallery {
    position: sticky;
    top: 20px;
    height: fit-content;
}

.pd-main-img {
    width: 100%;
    height: 400px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
.pd-main-img img {
    max-width: 85%;
    max-height: 85%;
    object-fit: contain;
}

.pd-thumbs {
    display: flex;
    gap: 8px;
    margin-top: 12px;
    overflow-x: auto;
    padding: 2px;
}
.pd-thumbs::-webkit-scrollbar { height: 4px; }
.pd-thumbs::-webkit-scrollbar-track { background: #f3f4f6; border-radius: 4px; }
.pd-thumbs::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

.pd-thumb {
    width: 64px;
    height: 64px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    flex-shrink: 0;
    transition: all 0.2s;
    opacity: 0.5;
}
.pd-thumb:hover { opacity: 1; }
.pd-thumb.active {
    border-color: #3b82f6;
    opacity: 1;
}
.pd-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Info Section */
.pd-info {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.pd-badge-group {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.pd-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.pd-badge-cat {
    background: #dbeafe;
    color: #1e40af;
}
.pd-badge-type {
    background: #f3f4f6;
    color: #6b7280;
}

.pd-name {
    font-size: 26px;
    font-weight: 900;
    color: #111827;
    line-height: 1.2;
}

.pd-meta {
    font-size: 12px;
    color: #9ca3af;
    font-weight: 500;
}

/* Price Box */
.pd-price-box {
    padding: 14px 18px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 10px;
    border: 1.5px solid #fbbf24;
}
.pd-price-label {
    font-size: 10px;
    font-weight: 700;
    color: #92400e;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: block;
    margin-bottom: 2px;
}
.pd-price {
    font-size: 28px;
    font-weight: 900;
    color: #b45309;
}

/* Sections */
.pd-section {
    padding: 12px 0;
    border-top: 1px solid #f3f4f6;
}
.pd-section:first-of-type { border-top: none; }

.pd-section-label {
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}

/* Toggle Description */
.pd-toggle-desc {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
}
.pd-toggle-desc:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}
.pd-toggle-desc svg {
    transition: transform 0.3s;
    flex-shrink: 0;
}
.pd-toggle-desc.open svg {
    transform: rotate(180deg);
}

.pd-desc {
    max-height: 0;
    overflow: hidden;
    font-size: 13px;
    line-height: 1.6;
    color: #6b7280;
    transition: max-height 0.4s ease, padding 0.4s ease;
}
.pd-desc.open {
    max-height: 1000px;
    padding-top: 12px;
}

/* Stock Badge */
.pd-stock {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
}
.pd-stock.in-stock {
    background: #d1fae5;
    color: #065f46;
}
.pd-stock.out-stock {
    background: #fee2e2;
    color: #991b1b;
}

/* Variants */
.pd-variant-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.pd-variant {
    position: relative;
    padding: 8px 14px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.pd-variant:hover:not(:disabled) {
    border-color: #3b82f6;
    background: #eff6ff;
}
.pd-variant.active {
    border-color: #3b82f6;
    background: #dbeafe;
    color: #1e40af;
}
.var-name { font-weight: 700; }
.var-price { 
    font-size: 11px; 
    color: #6b7280; 
}
.pd-variant.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    background: #f9fafb;
}
.var-badge-out {
    position: absolute;
    top: -8px;
    right: -8px;
    padding: 3px 7px;
    background: #ef4444;
    color: #fff;
    border-radius: 6px;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
}

/* Quantity */
.pd-qty {
    display: inline-flex;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
}
.pd-qty button {
    width: 36px;
    height: 36px;
    border: none;
    background: #f9fafb;
    color: #6b7280;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.pd-qty button:hover {
    background: #f3f4f6;
    color: #111827;
}
.pd-qty input {
    width: 50px;
    height: 36px;
    border: none;
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    background: #fff;
}

/* Actions */
.pd-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.pd-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.pd-btn-sec {
    background: #fff;
    color: #374151;
    border: 1.5px solid #d1d5db;
}
.pd-btn-sec:hover:not(:disabled) {
    background: #f9fafb;
    border-color: #9ca3af;
}

.pd-btn-pri {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.pd-btn-pri:hover:not(:disabled) {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
}

.pd-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Message */
.pd-msg {
    padding: 10px 14px;
    background: #fef2f2;
    border: 1.5px solid #fca5a5;
    border-radius: 8px;
    color: #991b1b;
    font-size: 13px;
    font-weight: 600;
    display: none;
}
.pd-msg.show {
    display: block;
}

/* Recommendations */
.pd-rec-section {
    margin-top: 40px;
}

.pd-rec-title {
    font-size: 20px;
    font-weight: 900;
    color: #111827;
    margin-bottom: 16px;
}

.pd-rec-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}
@media(min-width: 1024px) {
    .pd-rec-grid {
        grid-template-columns: repeat(6, 1fr);
    }
}

.pd-rec-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #f1f5f9;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s;
}
.pd-rec-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.1);
}

.rec-img {
    position: relative;
    aspect-ratio: 1/1;
    background: #f8fafc;
    overflow: hidden;
}
.rec-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Badges - Same as Index */
.rec-badge-ready {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #16a34a;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 999px;
}
.rec-badge-out {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #ef4444;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 999px;
}
.rec-badge-type {
    position: absolute;
    bottom: 8px;
    left: 8px;
    background: rgba(0,0,0,.65);
    color: #fff;
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 6px;
}

.rec-body {
    padding: 10px;
}
.rec-cat {
    font-size: 10px;
    font-weight: 700;
    color: #2563eb;
    text-transform: uppercase;
}
.rec-name {
    font-size: 13px;
    font-weight: 600;
    line-height: 1.25;
    margin: 2px 0;
}
.rec-stock {
    font-size: 11px;
    color: #374151;
    margin: 2px 0;
}
.rec-price {
    font-size: 15px;
    font-weight: 800;
    color: #f97316;
}

/* Responsive */
@media(max-width: 1024px) {
    .pd-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .pd-gallery { position: static; }
    .pd-rec-grid { grid-template-columns: repeat(3, 1fr); }
}

@media(max-width: 640px) {
    .pd-container { padding: 12px; }
    .pd-grid { padding: 16px; }
    .pd-name { font-size: 22px; }
    .pd-price { font-size: 24px; }
    .pd-rec-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<script>
(()=>{
    // Gallery
    const mainImg = document.getElementById('mainImg');
    const thumbs = document.querySelectorAll('.pd-thumb');
    
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            mainImg.src = this.dataset.src;
        });
    });

    // Description Toggle
    window.toggleDesc = function() {
        const btn = document.querySelector('.pd-toggle-desc');
        const content = document.getElementById('descContent');
        btn.classList.toggle('open');
        content.classList.toggle('open');
    }

    // Price & Variant
    const basePrice = {{ $product->price }};
    const priceEl = document.getElementById('priceDisplay');
    const msgBox = document.getElementById('msgBox');
    const btnCart = document.getElementById('btnCart');
    const btnBuy = document.getElementById('btnBuy');
    const qtyInput = document.getElementById('qtyInput');
    
    let selected = {};
    let hasVariants = {{ $product->variants->count() > 0 ? 'true' : 'false' }};
    let productStock = {{ $product->stock }};

    // Qty
    window.changeQty = function(delta) {
        const val = Math.max(1, parseInt(qtyInput.value) + delta);
        qtyInput.value = val;
    }

    // Variants
    document.querySelectorAll('.pd-variant').forEach(btn => {
        btn.addEventListener('click', function() {
            if(this.disabled) return;
            
            const g = this.dataset.group;
            document.querySelectorAll(`.pd-variant[data-group="${g}"]`)
                .forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            selected[g] = {
                id: this.dataset.id,
                price: parseInt(this.dataset.price),
                stock: parseInt(this.dataset.stock)
            };
            
            updatePrice();
            checkButtons();
        });
    });

    function updatePrice() {
        let total = basePrice;
        Object.values(selected).forEach(v => total += v.price);
        priceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function checkButtons() {
        let canOrder = true;
        msgBox.textContent = '';
        msgBox.classList.remove('show');
        
        if(hasVariants) {
            const groups = document.querySelectorAll('.variant-group').length;
            if(Object.keys(selected).length !== groups) {
                canOrder = false;
            } else {
                for(let k in selected) {
                    if(selected[k].stock <= 0) {
                        canOrder = false;
                        msgBox.textContent = 'Varian yang dipilih stoknya habis';
                        msgBox.classList.add('show');
                        break;
                    }
                }
            }
        } else {
            if(productStock <= 0) canOrder = false;
        }
        
        btnCart.disabled = !canOrder;
        btnBuy.disabled = !canOrder;
    }

    async function submit(checkout) {
        if(hasVariants) {
            const groups = document.querySelectorAll('.variant-group').length;
            if(Object.keys(selected).length !== groups) {
                msgBox.textContent = 'Pilih semua varian';
                msgBox.classList.add('show');
                return;
            }
            
            for(let k in selected) {
                if(selected[k].stock <= 0) {
                    msgBox.textContent = 'Varian habis';
                    msgBox.classList.add('show');
                    return;
                }
            }
        } else if(productStock <= 0) {
            msgBox.textContent = 'Stok habis';
            msgBox.classList.add('show');
            return;
        }
        
        const variantId = hasVariants ? Object.values(selected).map(v => v.id).join(',') : '';
        
        try {
            const res = await fetch("{{ route('shop.cart.add', $product->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    qty: qtyInput.value,
                    variant_id: variantId
                })
            });
            
            if(res.ok) {
                checkout ? location.href="{{ route('checkout.index') }}" : location.reload();
            } else {
                msgBox.textContent = 'Gagal menambahkan';
                msgBox.classList.add('show');
            }
        } catch(e) {
            msgBox.textContent = 'Error. Coba lagi.';
            msgBox.classList.add('show');
        }
    }

    btnCart.addEventListener('click', () => submit(false));
    btnBuy.addEventListener('click', () => submit(true));
    
    checkButtons();
})();
</script>
@endsection