<x-app-layout>
  

    <div class="dashboard-content">

        {{-- ================= PROMO BLIBLI STYLE ================= --}}
@if(isset($banners) && $banners->count())
<section class="blibli-promo">

    <div class="blibli-slider">

        <div class="blibli-track" id="blibliTrack">
            @foreach($banners as $index => $banner)
                @php
                    $link = null;
                    if ($banner->product_id) {
                        $link = route('shop.show', $banner->product_id);
                    } elseif ($banner->link_url) {
                        $link = $banner->link_url;
                    }
                @endphp

                <div class="blibli-slide {{ $index === 0 ? 'active' : '' }}">
                    @if($link)<a href="{{ $link }}">@endif
                        <img src="{{ asset('storage/'.$banner->image_path) }}"
                             alt="{{ $banner->title }}">
                    @if($link)</a>@endif
                </div>
            @endforeach
        </div>

        {{-- NAV --}}
        @if($banners->count() > 1)
        <!-- <button class="blibli-nav prev" onclick="blibliPrev()">‹</button>
        <button class="blibli-nav next" onclick="blibliNext()">›</button> -->

        <div class="blibli-dots">
            @foreach($banners as $i => $b)
                <button class="dot {{ $i===0?'active':'' }}"
                        onclick="blibliGo({{ $i }})"></button>
            @endforeach
        </div>
        @endif

    </div>

</section>
@endif

{{-- ================= KATEGORI MANUAL ================= --}}
<div class="category-manual-wrap">
    <div class="category-manual-grid">

        {{-- PAKAIAN --}}
        <a href="/produk?category=pakaian" class="cat-item">
            <div class="cat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4l4-2 4 2 4-2 4 2v4l-4 2v10H8V10L4 8z"/>
                </svg>
            </div>
            <span>Pakaian</span>
        </a>

        {{-- ELEKTRONIK --}}
        <a href="/produk?category=elektronik" class="cat-item">
            <div class="cat-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="7" y="7" width="10" height="10"/>
                    <path d="M3 7h4M3 12h4M3 17h4M17 7h4M17 12h4M17 17h4"/>
                </svg>
            </div>
            <span>Elektronik</span>
        </a>

        {{-- MAKANAN --}}
        <a href="/produk?category=makanan-minuman" class="cat-item">
            <div class="cat-icon orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 3h12l-1 17H7L6 3z"/>
                    <path d="M10 7h4"/>
                </svg>
            </div>
            <span>Makanan</span>
        </a>

        {{-- AKSESORIS --}}
        <a href="/produk?category=aksesoris" class="cat-item">
            <div class="cat-icon green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"/>
                    <path d="M12 7v5l3 2"/>
                    <path d="M9 2h6M9 22h6"/>
                </svg>
            </div>
            <span>Aksesoris</span>
        </a>

        {{-- OLAHRAGA --}}
        <a href="/produk?category=olahraga" class="cat-item">
            <div class="cat-icon red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M3 12h18M12 3v18"/>
                </svg>
            </div>
            <span>Olahraga</span>
        </a>

        {{-- KESEHATAN --}}
        <a href="/produk?category=kesehatan" class="cat-item">
            <div class="cat-icon pink">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l8.8 8.6 8.8-8.6a5.5 5.5 0 0 0 0-7.8z"/>
                </svg>
            </div>
            <span>Kesehatan</span>
        </a>

        {{-- RUMAH TANGGA --}}
        <a href="/produk?category=rumah-tangga" class="cat-item">
            <div class="cat-icon teal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10l9-7 9 7"/>
                    <path d="M5 10v10h14V10"/>
                </svg>
            </div>
            <span>Rumah Tangga</span>
        </a>

        {{-- MAINAN --}}
        <a href="/produk?category=mainan-hobi" class="cat-item">
            <div class="cat-icon yellow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="8" width="18" height="8" rx="4"/>
                    <path d="M8 12h4M10 10v4"/>
                    <circle cx="17" cy="11" r="1"/>
                    <circle cx="17" cy="13" r="1"/>
                </svg>
            </div>
            <span>Mainan</span>
        </a>

        {{-- SMARTPHONE --}}
        <a href="/produk?category=handphone" class="cat-item">
            <div class="cat-icon indigo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="7" y="2" width="10" height="20" rx="2"/>
                    <circle cx="12" cy="18" r="1"/>
                </svg>
            </div>
            <span>Smartphone</span>
        </a>
        {{-- SUKU CADANG --}}
<a href="/produk?category=suku-cadang" class="cat-item">
    <div class="cat-icon gray">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V22a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H2a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3h.1A1.7 1.7 0 0 0 9 3.1V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5h.1a1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9v.1a1.7 1.7 0 0 0 1.5 1H22a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
        </svg>
    </div>
    <span>Suku Cadang</span>
</a>

{{-- TICKET --}}
<a href="/produk?category=ticket" class="cat-item">
    <div class="cat-icon cyan">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 7h18v4a2 2 0 0 0 0 4v4H3v-4a2 2 0 0 0 0-4z"/>
            <path d="M8 7v10"/>
        </svg>
    </div>
    <span>Ticket</span>
</a>

{{-- VOUCHER --}}
<a href="/produk?category=voucher" class="cat-item">
    <div class="cat-icon gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 12a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2"/>
            <path d="M4 12V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6"/>
            <path d="M12 4v16"/>
        </svg>
    </div>
    <span>Voucher</span>
</a>


    </div>
    <div class="category-dots" id="categoryDots"></div>

</div>

{{-- ================= PRODUK PER KATEGORI ================= --}}
<div class="shop-container">

@foreach($categories as $category)

    @if($category->products->count())

    {{-- JUDUL KATEGORI --}}
    <div style="margin:28px 0 12px;">
        <h2 style="font-size:18px;font-weight:800;color:#111827;">
            {{ $category->name }}
        </h2>
    </div>

    {{-- GRID PRODUK (SAMA PERSIS) --}}
    <div class="product-grid">
        @foreach($category->products as $product)
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

    @endif

@endforeach

</div>


       

<style>
/* ===== BASE ===== */
.shop-container{
    max-width:1400px;
    margin:auto;
    padding:14px;
    font-family:system-ui,-apple-system,BlinkMacSystemFont,sans-serif;
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

    /* ================= HOME SECTION ================= */
.home-section-wrap{
    max-width:1280px;
    margin:0 auto 40px;
    padding:0 16px;
}

/* HEADER KATEGORI */
.home-category-section{
    margin-bottom:36px;
}

.home-category-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:14px;
}

.home-category-header h2{
    font-size:18px;
    font-weight:800;
    color:#111827;
}

.home-category-header .see-all{
    font-size:13px;
    font-weight:600;
    color:#2563eb;
    text-decoration:none;
}

/* GRID PRODUK */
.home-product-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:14px;
}

@media(min-width:1024px){
    .home-product-grid{
        grid-template-columns:repeat(6,1fr);
    }
}

/* CARD */
.home-product-card{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    color:inherit;
    border:1px solid #f1f5f9;
    transition:.25s;
}

.home-product-card:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(0,0,0,.1);
}

/* IMAGE */
.hp-image{
    position:relative;
    aspect-ratio:1/1;
    background:#f8fafc;
}

.hp-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* BADGE */
.hp-badge{
    position:absolute;
    top:8px;
    right:8px;
    font-size:10px;
    font-weight:700;
    padding:4px 9px;
    border-radius:999px;
    color:#fff;
}

.hp-badge.ready{background:#16a34a}
.hp-badge.out{background:#ef4444}

/* BODY */
.hp-body{
    padding:10px;
}

.hp-name{
    font-size:13px;
    font-weight:600;
    line-height:1.3;
    margin-bottom:4px;
}

.hp-price{
    font-size:14px;
    font-weight:800;
    color:#f97316;
}

/* ===== BASE ===== */
.dashboard-content{background:#f5f5f5;min-height:100vh}

/* ================= BLIBLI PROMO ================= */
.blibli-promo{
    max-width:1440px;
    margin:0 auto 24px;
    margin-top : 20px;
    padding:0 16px;
}

.blibli-slider{
    position:relative;
    overflow:hidden;
}

/* TRACK */
.blibli-track{
    display:flex;
    transition:transform .6s ease;
}

/* SLIDE */
.blibli-slide{
    flex:0 0 100%;
    padding:0 12px;   /* jarak visual, BUKAN gap */
    box-sizing:border-box;
}

.blibli-slide.active{
    opacity:1 !important;
    transform:none !important;
}

/* IMAGE – DESKTOP */
.blibli-slide img{
    width:100%;
    aspect-ratio:4 / 1;   /* 2000 x 500 */
    object-fit:cover;
    object-position:center;
    border-radius:28px;
    box-shadow:none !important;
    background:transparent;
}

/* NAV */
.blibli-nav{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:44px;
    height:44px;
    border-radius:50%;
    background:#fff;
    border:none;
    font-size:26px;
    font-weight:700;
    color:#2563eb;
    cursor:pointer;
    box-shadow:0 10px 22px rgba(0,0,0,.3);
    z-index:10;
}
.blibli-nav.prev{left:0}
.blibli-nav.next{right:0}

/* DOT */
.blibli-dots{
    position:absolute;
    bottom:14px;
    right:32px;
    display:flex;
    gap:6px;
}
.blibli-dots .dot{
    width:22px;
    height:6px;
    border-radius:999px;
    background:#e5e7eb;
    border:none;
    cursor:pointer;
}
.blibli-dots .dot.active{
    background:#2563eb;
}

/* ================= MOBILE (4:1 TETAP) ================= */
@media(max-width:768px){
    .blibli-promo{
        padding:0 12px;
    }

    .blibli-track{
        gap:0;
    }

    .blibli-slide{
        opacity:1;
        transform:scale(1);
    }

    .blibli-slide img{
        aspect-ratio:4 / 1;     /* TETAP 2000x500 */
        border-radius:18px;
        box-shadow:0 10px 22px rgba(0,0,0,.22);
    }

    .blibli-nav{
        width:34px;
        height:34px;
        font-size:20px;
    }

    .blibli-dots{
        right:50%;
        transform:translateX(50%);
        bottom:10px;
    }

    .blibli-dots .dot{
        width:18px;
        height:5px;
    }
}
/* ================= MENU CEPAT + DOT (FINAL) ================= */
.category-manual-wrap{
    max-width:1280px;
    margin:10px auto 26px;
    padding:0 16px;
}

/* ===== GRID ===== */
.category-manual-grid{
    display:flex;
    gap:14px;
    overflow-x:auto;
    padding:10px 4px 14px;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
}

.category-manual-grid::-webkit-scrollbar{display:none}
.category-manual-grid{scrollbar-width:none}

/* ITEM */
.cat-item{
    min-width:88px;
    background:transparent;  
    border-radius:16px;
    padding:14px 6px;
    text-align:center;
    text-decoration:none;
    color:#111827;
    flex-shrink:0;
    scroll-snap-align:start;
    box-shadow:none;
}

/* ICON */
.cat-icon{
    width:46px;
    height:46px;
    border-radius:14px;
    margin:0 auto 6px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}

.cat-icon svg{
    width:22px;
    height:22px;
}

.cat-item span{
    font-size:11px;
    font-weight:700;
    line-height:1.2;
    display:block;
}

/* ===== DOT ===== */
.category-dots{
    display:flex;
    justify-content:center;
    gap:6px;
    margin-top:6px;
}

.category-dots .dot{
    width:16px;
    height:5px;
    border-radius:999px;
    background:#e5e7eb;
    transition:.3s;
}

.category-dots .dot.active{
    background:#2563eb;
}

/* ================= MOBILE: RAPATKAN JARAK SAJA ================= */
@media(max-width:768px){

    /* jarak antar item dipersempit */
    .category-manual-grid{
        gap:0.2px;                 /* sebelumnya 8 / 10 / 14 */
        padding-bottom:6px;
    }

    /* ukuran item TETAP, hanya padding dirapikan */
    .cat-item{
        padding:4px 4px;         /* sebelumnya lebih lebar */
        min-width:88px;          /* ⛔ JANGAN DIUBAH */
    }

    /* icon & teks TETAP */
    .cat-icon{
        width:48px;
        height:48px;
        margin-bottom:4px;
    }

    .cat-icon svg{
        width:22px;
        height:22px;
    }

    .cat-item span{
        font-size:11px;
        font-weight:700;
    }

    /* DOT dirapatkan (BUKAN dikecilkan drastis) */
    .category-dots{
        gap:3px;
        margin-top:4px;
    }

    .category-dots .dot{
        width:14px;
        height:4px;
    }
}


/* ===== WARNA ICON ===== */
.blue{background:#2563eb}
.purple{background:#7c3aed}
.orange{background:#f97316}
.green{background:#16a34a}
.red{background:#dc2626}
.pink{background:#ec4899}
.teal{background:#0d9488}
.yellow{background:#facc15;color:#000}
.indigo{background:#4f46e5}
.gray{background:#6b7280}
.cyan{background:#06b6d4}
.gold{background:#f59e0b}



/* RESPONSIVE */
@media(max-width:640px){
    .promo-slider-container{height:220px}
    .slide-title{font-size:20px}
}
</style>


<script>
(function(){

    const track = document.getElementById('blibliTrack');
    if(!track) return;

    const slides = track.querySelectorAll('.blibli-slide');
    const dots   = document.querySelectorAll('.blibli-dots .dot');

    let current = 0;
    const total = slides.length;

    if(total <= 1) return;

    function update(){
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        slides[current].classList.add('active');
        if(dots[current]) dots[current].classList.add('active');

        const slideWidth = slides[0].offsetWidth;
        track.style.transform = `translateX(-${current * slideWidth}px)`;
    }

    function next(){
        current = (current + 1) % total;
        update();
    }

    function prev(){
        current = (current - 1 + total) % total;
        update();
    }

    // expose ke tombol
    window.blibliNext = next;
    window.blibliPrev = prev;
    window.blibliGo = (i) => {
        current = i;
        update();
    };

    // AUTO (SAMA SEPERTI KODE ASLI KAMU)
    setInterval(next, 5000);

    // INIT
    update();

})();


(function(){
    const grid = document.querySelector('.category-manual-grid');
    const dotsWrap = document.getElementById('categoryDots');
    if(!grid || !dotsWrap) return;

    const TOTAL_PAGES = 3; // ⬅️ KUNCI UTAMA (DOT = 3)

    function buildDots(){
        dotsWrap.innerHTML = '';
        for(let i=0;i<TOTAL_PAGES;i++){
            const dot = document.createElement('div');
            dot.className = 'dot' + (i === 0 ? ' active' : '');
            dotsWrap.appendChild(dot);
        }
    }

    function updateDots(){
        const maxScroll = grid.scrollWidth - grid.clientWidth;
        const progress = grid.scrollLeft / maxScroll;
        const page = Math.min(
            TOTAL_PAGES - 1,
            Math.round(progress * (TOTAL_PAGES - 1))
        );

        dotsWrap.querySelectorAll('.dot').forEach((d,i)=>{
            d.classList.toggle('active', i === page);
        });
    }

    buildDots();
    grid.addEventListener('scroll', () =>
        requestAnimationFrame(updateDots)
    );
})();


</script>
</x-app-layout>