@extends('layouts.app')

@section('content')
<div class="sp-wrap">

    <a href="{{ route('shop.index') }}" class="sp-back">← Kembali ke Produk</a>

    {{-- ================= DETAIL ================= --}}
    <div class="sp-card">

        {{-- LEFT --}}
        <div>
            <div class="sp-image-box">
                <img id="spMainImage" src="{{ asset('storage/'.$product->main_image) }}">
            </div>

            @if(count($product->all_images))
            <div class="sp-thumb-row">
                @foreach($product->all_images as $i => $img)
                    <img src="{{ asset('storage/'.$img) }}"
                         class="sp-thumb {{ $i===0?'active':'' }}"
                         onclick="spChangeImage(this)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- RIGHT --}}
        <div class="sp-right">

            <h1 class="sp-title">{{ $product->name }}</h1>

            <div class="sp-meta">
                SKU: {{ $product->sku ?? '-' }} • {{ $product->category->name ?? '-' }}
            </div>

            {{-- PRICE --}}
            <div id="spPrice" class="sp-price">
                Rp {{ number_format($product->price,0,',','.') }}
            </div>

            {{-- DESC --}}
            <div class="sp-desc-wrap">
                <div id="spDesc" class="sp-desc collapsed">
                    {!! nl2br(e($product->description)) !!}
                </div>
                <button id="spDescToggle" class="sp-desc-toggle">
                    Lihat Selengkapnya
                </button>
            </div>

            {{-- VARIANT --}}
            @if($product->variants->count())
            @php $groups=$product->variants->groupBy('variant_name'); @endphp
            @foreach($groups as $g=>$items)
            <div class="variant-group" data-group="{{ $g }}">
                <div class="sp-variant-title">Pilih {{ $g }}</div>
                <div class="sp-variant-options">
                    @foreach($items as $v)
                    <button type="button"
                            class="sp-variant-btn"
                            data-group="{{ $g }}"
                            data-id="{{ $v->id }}"
                            data-price="{{ $v->price_modifier }}">
                        {{ $v->variant_value }}
                        @if($v->price_modifier!=0)
                            <small>{{ $v->price_modifier>0?'+':'' }}Rp {{ number_format($v->price_modifier,0,',','.') }}</small>
                        @endif
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach
            @endif

            {{-- QTY --}}
            <div class="sp-qty">
                <span>Jumlah</span>
                <div class="qty-box">
                    <button onclick="qty.value=Math.max(1,qty.value-1)">−</button>
                    <input id="qty" type="number" min="1" value="1">
                    <button onclick="qty.value++">+</button>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="sp-action">
                <button id="btnAdd" class="sp-btn-outline">Tambah ke Keranjang</button>
                <button id="btnCheckout" class="sp-btn-primary">Checkout</button>
            </div>

            <div id="msg" class="sp-msg"></div>
        </div>
    </div>

    {{-- ================= REKOMENDASI ================= --}}
    @if(isset($recommends) && $recommends->count())
    <div class="sp-rec">
        <h3 class="sp-rec-title">Rekomendasi Produk</h3>

        <div class="sp-rec-grid">
            @foreach($recommends as $r)
            <a href="{{ route('shop.show',$r->id) }}" class="sp-rec-card">

                <div class="sp-rec-image">
                    <img src="{{ asset('storage/'.$r->main_image) }}">

                    {{-- BADGE READY --}}
                    @if($r->stock > 0)
                        <div class="sp-badge-ready">READY</div>
                    @else
                        <div class="sp-badge-out">HABIS</div>
                    @endif

                    {{-- BADGE TYPE --}}
                    <div class="sp-badge-type">
                        {{ strtoupper($r->product_type) }}
                    </div>
                </div>

                <div class="sp-rec-body">
                    <div class="sp-rec-category">
                        {{ $r->category->name ?? '-' }}
                    </div>
                    <div class="sp-rec-name">
                        {{ $r->name }}
                    </div>
                    <div class="sp-rec-price">
                        Rp {{ number_format($r->price,0,',','.') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- ================= STYLE (ISOLATED) ================= --}}
<style>
/* ===== SAFE ZONE ===== */
.sp-wrap{max-width:1200px;margin:20px auto;padding:0 16px}
.sp-back{color:#2563eb;font-weight:600;text-decoration:none}

/* CARD */
.sp-card{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:36px;
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:26px;
}

/* IMAGE */
.sp-image-box{
    height:440px;
    background:#f8fafc;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.sp-image-box img{max-width:100%;max-height:100%;object-fit:contain}
.sp-thumb-row{display:flex;gap:10px;margin-top:14px}
.sp-thumb{
    width:70px;height:70px;border-radius:10px;
    border:2px solid transparent;cursor:pointer;opacity:.6
}
.sp-thumb.active{border-color:#2563eb;opacity:1}

/* INFO */
.sp-title{font-size:24px;font-weight:800}
.sp-meta{font-size:12px;color:#6b7280;margin:6px 0 12px}

/* PRICE (FIXED BOLD) */
.sp-price{
    font-size:32px;
    font-weight:900;
    color:#2563eb;
    margin-bottom:14px;
}

/* DESC */
.sp-desc{font-size:14px;line-height:1.7;color:#374151;overflow:hidden}
.sp-desc.collapsed{max-height:110px}
.sp-desc-toggle{border:none;background:none;color:#2563eb;font-weight:600;font-size:13px}

/* VARIANT */
.sp-variant-title{font-weight:700;margin-bottom:6px}
.sp-variant-options{display:flex;flex-wrap:wrap;gap:10px}
.sp-variant-btn{
    padding:11px 16px;border:1.5px solid #d1d5db;
    border-radius:12px;background:#fff;font-weight:600;font-size:13px
}
.sp-variant-btn.active{
    border-color:#2563eb;background:#eff6ff;color:#1d4ed8
}
.sp-variant-btn small{display:block;font-size:11px;color:#6b7280}

/* QTY */
.sp-qty{display:flex;gap:16px;margin:22px 0;align-items:center}
.qty-box{display:flex;border:1px solid #d1d5db;border-radius:12px}
.qty-box button{width:36px;border:none;background:#f1f5f9;font-size:18px}
.qty-box input{width:60px;border:none;text-align:center;font-weight:700}

/* ACTION */
.sp-action{display:flex;gap:16px}
.sp-btn-outline{
    flex:1;padding:15px;border:2px solid #2563eb;
    background:#fff;color:#2563eb;font-weight:800;border-radius:14px
}
.sp-btn-primary{
    flex:1;padding:15px;background:#2563eb;
    color:#fff;font-weight:900;border:none;border-radius:14px
}

/* ===== REKOMENDASI (SAMA DENGAN PRODUK) ===== */
.sp-rec{margin-top:40px}
.sp-rec-title{font-size:18px;font-weight:800;margin-bottom:14px}

.sp-rec-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:14px;
}
@media(min-width:1024px){
    .sp-rec-grid{grid-template-columns:repeat(6,1fr)}
}

.sp-rec-card{
    background:#fff;border-radius:14px;
    overflow:hidden;text-decoration:none;color:inherit;
    border:1px solid #f1f5f9;transition:.25s
}
.sp-rec-card:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(0,0,0,.1);
}

.sp-rec-image{
    position:relative;
    aspect-ratio:1/1;
    background:#f8fafc;
}
.sp-rec-image img{
    width:100%;height:100%;object-fit:cover;
}

/* BADGES */
.sp-badge-ready{
    position:absolute;top:8px;right:8px;
    background:#16a34a;color:#fff;
    font-size:10px;font-weight:700;
    padding:4px 9px;border-radius:999px;
}
.sp-badge-out{
    position:absolute;top:8px;right:8px;
    background:#ef4444;color:#fff;
    font-size:10px;font-weight:700;
    padding:4px 9px;border-radius:999px;
}
.sp-badge-type{
    position:absolute;bottom:8px;left:8px;
    background:rgba(0,0,0,.65);
    color:#fff;font-size:10px;
    padding:4px 8px;border-radius:6px;
}

/* BODY */
.sp-rec-body{padding:10px}
.sp-rec-category{
    font-size:10px;font-weight:700;
    color:#2563eb;text-transform:uppercase
}
.sp-rec-name{
    font-size:13px;font-weight:600;
    line-height:1.25;margin:2px 0
}
.sp-rec-price{
    font-size:15px;
    font-weight:900;
    color:#f97316;
}

@media(max-width:900px){
    .sp-card{grid-template-columns:1fr}
}
</style>

{{-- ================= SCRIPT (SYSTEM TETAP) ================= --}}
<script>
(function(){
    const thumbs=[...document.querySelectorAll('.sp-thumb')];
    const main=document.getElementById('spMainImage');
    let index=0,timer;

    function setActive(i){
        thumbs.forEach(t=>t.classList.remove('active'));
        thumbs[i].classList.add('active');
        main.src=thumbs[i].src;
        index=i;
    }

    window.spChangeImage=(el)=>{
        setActive(thumbs.indexOf(el));
        clearInterval(timer);
        timer=setInterval(autoSlide,10000);
    }

    function autoSlide(){
        index=(index+1)%thumbs.length;
        setActive(index);
    }

    if(thumbs.length>1){
        timer=setInterval(autoSlide,10000);
    }

    const desc=document.getElementById('spDesc');
    const toggle=document.getElementById('spDescToggle');
    toggle.onclick=()=>{
        desc.classList.toggle('collapsed');
        toggle.textContent=desc.classList.contains('collapsed')
            ? 'Lihat Selengkapnya'
            : 'Sembunyikan';
    }

    const base={{ $product->price }};
    const price=document.getElementById('spPrice');
    let selected={};

    document.querySelectorAll('.sp-variant-btn').forEach(btn=>{
        btn.onclick=()=>{
            const g=btn.dataset.group;
            document.querySelectorAll(`.sp-variant-btn[data-group="${g}"]`)
                .forEach(b=>b.classList.remove('active'));
            btn.classList.add('active');
            selected[g]={id:btn.dataset.id,price:parseInt(btn.dataset.price)};
            let t=base;Object.values(selected).forEach(v=>t+=v.price);
            price.textContent='Rp '+t.toLocaleString('id-ID');
        }
    });

    async function submit(go){
        if(document.querySelectorAll('.variant-group').length!==Object.keys(selected).length){
            msg.textContent='Silakan pilih semua varian';
            return;
        }
        const variant_id=Object.values(selected).map(v=>v.id).join(',');
        const r=await fetch("{{ route('shop.cart.add',$product->id) }}",{
            method:'POST',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest'},
            body:new URLSearchParams({qty:qty.value,variant_id})
        });
        if(r.ok) go
            ? location.href="{{ route('checkout.index') }}"
            : location.reload();
    }

    btnAdd.onclick=()=>submit(false);
    btnCheckout.onclick=()=>submit(true);
})();
</script>
@endsection
