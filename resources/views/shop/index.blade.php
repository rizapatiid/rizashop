@extends('layouts.app')
@section('title', 'Semua Produk')
@section('page-title', 'Semua Produk')

@section('content')
<div class="shop-container">

    {{-- ================= FILTER KATEGORI (STICKY) ================= --}}
    <div class="category-filter-sticky">
        <div class="category-filter">

            {{-- SEMUA --}}
            <a href="{{ route('shop.index') }}"
               class="category-pill {{ request('category') ? '' : 'active' }}">
                SEMUA
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
                   class="category-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach

        </div>
    </div>

    {{-- ================= PRODUK ================= --}}
    @if($products->count() === 0)
        <div class="empty-box">
            Produk tidak ditemukan
        </div>
    @else

    <div class="product-grid">
        @foreach($products as $product)
        <a href="{{ route('shop.show', $product->id) }}" class="product-card">

            {{-- IMAGE --}}
            <div class="product-image">
                @if($product->image_path)
                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                @else
                    <span>No Image</span>
                @endif

                {{-- STOCK --}}
                @if($product->stock > 0)
                    <div class="badge-ready">READY</div>
                @else
                    <div class="badge-out">HABIS</div>
                @endif

                {{-- TYPE --}}
                <div class="badge-type">
                    {{ strtoupper($product->product_type) }}
                </div>
            </div>

            {{-- BODY --}}
            <div class="product-body">
                <div class="product-category">
                    {{ $product->category->name ?? '-' }}
                </div>
                <div class="product-name">
                    {{ $product->name }}
                </div>
                <div class="product-stock">
                    Stok: <strong>{{ $product->stock }}</strong>
                </div>
                <div class="product-price">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>

        </a>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $products->withQueryString()->links() }}
    </div>

    @endif
</div>

{{-- ================= STYLE ================= --}}
<style>
/* ===== BASE ===== */
.shop-container{
    max-width:1400px;
    margin:auto;
    padding:14px;
    font-family:system-ui,-apple-system,BlinkMacSystemFont,sans-serif;
}

/* ===== STICKY FILTER ===== */
.category-filter-sticky{
    position:sticky;
    top:0;
    z-index:40;
    background:#ffffff;
    padding:10px 0 12px;
    margin-bottom:18px;
    border-bottom:1px solid #e5e7eb;
}

/* FILTER BAR */
.category-filter{
    display:flex;
    gap:10px;
    overflow-x:auto;
    padding:0 2px;
}

.category-filter::-webkit-scrollbar{
    height:5px;
}
.category-filter::-webkit-scrollbar-thumb{
    background:#e5e7eb;
    border-radius:6px;
}

/* CATEGORY PILL */
.category-pill{
    padding:10px 18px;
    border-radius:12px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    white-space:nowrap;
    color:#374151;
    background:#ffffff;
    border:1px solid #e5e7eb;
    transition:all .25s ease;
}

.category-pill:hover{
    background:#f8fafc;
    border-color:#c7d2fe;
}

/* ACTIVE */
.category-pill.active{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#ffffff;
    border-color:#1d4ed8;
    box-shadow:0 8px 18px rgba(37,99,235,.35);
}

/* ===== EMPTY ===== */
.empty-box{
    background:#fff;
    border:1px solid #e5e7eb;
    padding:26px;
    text-align:center;
    border-radius:12px;
    color:#6b7280;
}

/* ===== GRID ===== */
.product-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:14px;
}
@media (min-width:1024px){
    .product-grid{
        grid-template-columns:repeat(6,1fr);
    }
}

/* ===== CARD ===== */
.product-card{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    color:inherit;
    border:1px solid #f1f5f9;
    transition:.25s;
}
.product-card:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(0,0,0,.1);
}

/* ===== IMAGE ===== */
.product-image{
    position:relative;
    aspect-ratio:1/1;
    background:#f8fafc;
}
.product-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}
.product-image span{
    font-size:12px;
    color:#94a3b8;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100%;
}

/* BADGES */
.badge-ready{
    position:absolute;
    top:8px;
    right:8px;
    background:#16a34a;
    color:#fff;
    font-size:10px;
    font-weight:700;
    padding:4px 9px;
    border-radius:999px;
}
.badge-out{
    position:absolute;
    top:8px;
    right:8px;
    background:#ef4444;
    color:#fff;
    font-size:10px;
    font-weight:700;
    padding:4px 9px;
    border-radius:999px;
}
.badge-type{
    position:absolute;
    bottom:8px;
    left:8px;
    background:rgba(0,0,0,.65);
    color:#fff;
    font-size:10px;
    padding:4px 8px;
    border-radius:6px;
}

/* ===== BODY ===== */
.product-body{
    padding:10px;
}
.product-category{
    font-size:10px;
    font-weight:700;
    color:#2563eb;
    text-transform:uppercase;
}
.product-name{
    font-size:13px;
    font-weight:600;
    line-height:1.25;
    margin:2px 0;
}
.product-stock{
    font-size:11px;
    color:#374151;
}
.product-price{
    font-size:15px;
    font-weight:800;
    color:#f97316;
}

/* ===== PAGINATION ===== */
.pagination-wrap{
    margin-top:24px;
}
</style>
@endsection
