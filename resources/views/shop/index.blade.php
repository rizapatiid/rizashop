@extends('layouts.app')

@section('content')
<div class="relative">
    <style>
        :root{
            --primary: #0ea5e9;
            --primary-600: #0891b2;
            --accent: #06b6d4;
            --success: #10b981;
            --muted: #6b7280;
            --bg: #ffffff;
            --card-border: #e6eef8;
            --shadow-lg: 0 25px 60px rgba(2,6,23,0.18);
            --shadow-md: 0 10px 30px rgba(2,6,23,0.08);
            --radius: 12px;
            --glass: rgba(255,255,255,0.6);
        }

        /* Container & header */
        .container-ui { max-width:1260px; margin:28px auto; padding:20px; font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial; color:#0f172a; }
        .header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px; }
        .title { font-size:20px; font-weight:700; }
        .subtitle { font-size:13px; color:var(--muted); }

        /* Grid (image, name, stock only) */
        .grid { display:grid; gap:16px; grid-template-columns: repeat(1,1fr); }
        @media (min-width:640px){ .grid { grid-template-columns: repeat(2,1fr); } }
        @media (min-width:768px){ .grid { grid-template-columns: repeat(3,1fr); } }
        @media (min-width:1024px){ .grid { grid-template-columns: repeat(4,1fr); } }
        @media (min-width:1280px){ .grid { grid-template-columns: repeat(6,1fr); } }

        .card {
            background:var(--bg);
            border:1px solid var(--card-border);
            border-radius:10px;
            box-shadow:var(--shadow-md);
            padding:10px;
            display:flex;
            flex-direction:column;
            align-items:center;
            text-align:center;
            gap:8px;
            cursor:pointer;
            transition:transform .12s ease, box-shadow .12s ease;
        }
        .card:focus { outline:3px solid rgba(14,165,233,0.12); }
        .card:hover { transform:translateY(-6px); box-shadow:var(--shadow-lg); }

        .img-box { width:100%; height:140px; border-radius:8px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f8fafc; }
        .img-box img{ width:100%; height:100%; object-fit:cover; display:block; }

        .name { font-weight:600; font-size:14px; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .stock { font-size:12px; color:var(--muted); }

        /* toast bottom-right */
        .toast { position:fixed; right:20px; bottom:20px; z-index:90; min-width:260px; padding:12px 16px; background:rgba(17,24,39,0.96); color:#fff; border-radius:10px; box-shadow:0 8px 30px rgba(2,6,23,0.3); display:flex; gap:10px; align-items:center; transform:translateY(10px); opacity:0; pointer-events:none; transition:all .25s ease; }
        .toast.show { opacity:1; transform:translateY(0); pointer-events:auto; }

        /* Modern modal */
        .modal-root { position:fixed; inset:0; display:none; align-items:center; justify-content:center; z-index:100; padding:20px; }
        .modal-root.show { display:flex; }
        .modal-backdrop { position:absolute; inset:0; background:linear-gradient(180deg, rgba(2,6,23,0.45), rgba(2,6,23,0.55)); backdrop-filter: blur(4px); }

        .modal-card {
            position:relative;
            width:100%;
            max-width:980px;
            border-radius:16px;
            overflow:hidden;
            box-shadow:var(--shadow-lg);
            transform:translateY(8px) scale(.98);
            opacity:0;
            transition:all .22s cubic-bezier(.2,.9,.22,1);
            display:grid;
            grid-template-columns:1fr;
            background: linear-gradient(180deg,#fff,#f8fbfd);
        }
        .modal-root.show .modal-card { transform:translateY(0) scale(1); opacity:1; }

        @media(min-width:900px){
            .modal-card { grid-template-columns: 420px 1fr; }
        }

        .modal-left { padding:18px; display:flex; align-items:center; justify-content:center; background:linear-gradient(180deg,#f8fbfd,#ffffff); }
        .modal-left .img-wrap { width:100%; height:420px; border-radius:12px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:linear-gradient(180deg,#f1f5f9,#ffffff); }
        .modal-left img { width:100%; height:100%; object-fit:contain; display:block; }

        .modal-right { padding:20px 20px 28px 20px; display:flex; flex-direction:column; gap:12px; }
        .modal-head { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .modal-title { font-size:18px; font-weight:800; color:#0f172a; }
        .modal-sku { font-size:12px; color:var(--muted); }

        .modal-price { font-size:20px; font-weight:900; color:var(--primary); }
        .modal-stock { font-size:13px; color:var(--muted); }
        .modal-desc { color:#334155; font-size:14px; line-height:1.45; margin-top:6px; max-height:160px; overflow:auto; padding-right:6px; }

        /* mini info row */
        .info-row { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }

        /* stepper */
        .controls { display:flex; gap:12px; align-items:center; margin-top:10px; }
        .stepper { display:inline-flex; align-items:center; gap:8px; border-radius:10px; background:#fff; padding:6px; border:1px solid var(--card-border); box-shadow:0 6px 18px rgba(2,6,23,0.04); }
        .step-btn { width:40px; height:40px; display:grid; place-items:center; border-radius:8px; background:linear-gradient(180deg,#fff,#f8fafc); border:1px solid #e9f2f6; cursor:pointer; font-weight:700; }
        .step-value { min-width:64px; text-align:center; font-weight:800; font-size:16px; }

        /* actions */
        .modal-actions { display:flex; gap:12px; margin-top:16px; align-items:center; }
        .btn { padding:10px 14px; border-radius:10px; font-weight:800; cursor:pointer; border:none; }
        .btn-primary { background:linear-gradient(180deg,var(--primary),var(--primary-600)); color:#fff; box-shadow:0 6px 18px rgba(14,165,233,0.18); }
        .btn-ghost { background:transparent; border:1px solid var(--card-border); color:#0f172a; }

        .btn-checkout { background:linear-gradient(180deg,var(--success), #059669); color:#fff; box-shadow:0 6px 18px rgba(16,185,129,0.14); }

        /* close icon */
        .close-icon { width:40px; height:40px; display:grid; place-items:center; border-radius:8px; background:transparent; border:1px solid transparent; cursor:pointer; transition:all .12s ease; }
        .close-icon:hover { background:rgba(2,6,23,0.04); }

        /* small helpers */
        .muted { color:var(--muted); font-size:13px; }
        .flex-right { margin-left:auto; display:flex; gap:8px; align-items:center; }
    </style>

    <div class="container-ui">
        <div class="header">
            <div>
                <div class="title">Produk</div>
                <div class="subtitle">Klik produk untuk melihat detail dan tambahkan ke keranjang.</div>
            </div>
            <!-- intentionally removed cart link per request -->
        </div>

        @if($products->count() === 0)
            <div style="background:#fff;padding:18px;border-radius:10px;color:var(--muted);text-align:center;">Belum ada produk yang tersedia.</div>
        @else
            <div class="grid" id="productGrid">
                @foreach($products as $product)
                    <div class="card product-card" tabindex="0"
                         data-id="{{ $product->id }}"
                         data-name="{{ addslashes($product->name) }}"
                         data-price="{{ $product->price }}"
                         data-sku="{{ $product->sku ?? '' }}"
                         data-stock="{{ $product->stock }}"
                         data-desc="{{ addslashes($product->description ?? '') }}"
                         data-image="{{ $product->image_path ? asset('storage/'.$product->image_path) : '' }}"
                         data-add-url="{{ route('shop.cart.add', $product->id) }}">
                        <div class="img-box" aria-hidden="true">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <div class="muted">Tidak ada gambar</div>
                            @endif
                        </div>

                        <div class="name">{{ $product->name }}</div>
                        <div class="stock">Stok: {{ $product->stock }}</div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top:16px;">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Toast bottom-right -->
    <div id="toast" class="toast" role="status" aria-live="polite">
        <div id="toast-msg">Berhasil ditambahkan ke keranjang</div>
    </div>

    <!-- Modal (modern UI) -->
    <div id="modalRoot" class="modal-root" aria-hidden="true">
        <div class="modal-backdrop" id="modalBackdrop"></div>

        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-left">
                <div class="img-wrap">
                    <img id="modalImg" src="/images/no-image.png" alt="Foto produk">
                </div>
            </div>

            <div class="modal-right">
                <div class="modal-head">
                    <div>
                        <div id="modalTitle" class="modal-title">Nama Produk</div>
                        <div id="modalSku" class="modal-sku">SKU: -</div>
                    </div>

                    <div class="flex-right">
                        <button id="modalClose" class="close-icon" aria-label="Tutup modal">&times;</button>
                    </div>
                </div>

                <div class="info-row">
                    <div id="modalPrice" class="modal-price">Rp 0</div>
                    <div id="modalStock" class="modal-stock">Stok: -</div>
                    <div class="muted" style="margin-left:auto;" id="modalQtyHint"></div>
                </div>

                <div id="modalDesc" class="modal-desc">Deskripsi singkat produk...</div>

                <div class="controls" aria-label="Kontrol jumlah">
                    <div class="stepper" role="group" aria-label="Pilih jumlah">
                        <button id="stepMinus" class="step-btn" aria-label="Kurangi jumlah">−</button>
                        <div id="stepValue" class="step-value">1</div>
                        <button id="stepPlus" class="step-btn" aria-label="Tambah jumlah">+</button>
                    </div>

                    <div class="muted" id="modalQtyInfo">1 item</div>
                </div>

                <div class="modal-actions">
                    <button id="modalAdd" class="btn btn-primary" aria-live="polite">Tambah ke Keranjang</button>
                    <button id="modalCheckout" class="btn btn-checkout">Checkout</button>
                    <!-- bottom "Tutup" button removed per request; only top-right × remains -->
                </div>

                <!-- Hidden fallback form to submit if JS disabled -->
                <form id="modalFallbackForm" method="POST" action="" style="display:none;">
                    @csrf
                    <input type="hidden" name="qty" id="modalHiddenQty" value="1">
                </form>
            </div>
        </div>
    </div>

    <script>
    (function(){
        /* ---------- Utilities ---------- */
        function rupiah(n){
            if (n === null || n === undefined || isNaN(Number(n))) return 'Rp 0';
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        function showToast(msg, isError){
            const toast = document.getElementById('toast');
            const tm = document.getElementById('toast-msg');
            tm.textContent = msg || (isError ? 'Terjadi kesalahan' : 'Berhasil');
            toast.style.background = isError ? '#991b1b' : 'rgba(17,24,39,0.96)';
            toast.classList.add('show');
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(()=> toast.classList.remove('show'), 1800);
        }

        const CSRF_TOKEN = '{{ csrf_token() }}';

        function setBtnLoading(btn, isLoading){
            if(!btn) return;
            if(isLoading){
                btn.disabled = true;
                btn.dataset.orig = btn.innerHTML;
                btn.innerHTML = '...';
            } else {
                btn.disabled = false;
                if(btn.dataset.orig) btn.innerHTML = btn.dataset.orig;
            }
        }

        async function postAddToCart(url, qty, triggerBtn = null){
            if(!url){
                showToast('URL tidak valid', true);
                return { ok:false };
            }
            qty = Number(qty) || 1;
            if(qty < 1) qty = 1;

            const fd = new FormData();
            fd.append('qty', qty);
            fd.append('_token', CSRF_TOKEN);

            try {
                if (triggerBtn) setBtnLoading(triggerBtn, true);

                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: fd,
                    credentials: 'same-origin'
                });

                let data = null;
                try { data = await res.json(); } catch(e){ /* not json */ }

                if(res.ok){
                    const message = (data && (data.message || data.msg)) ? (data.message || data.msg) : 'Berhasil ditambahkan ke keranjang';
                    showToast(message, false);
                    // update navbar badge if server returned cart_count (optional)
                    if (data && data.cart_count !== undefined) {
                        const el = document.querySelector('.cart-badge');
                        if (el) el.textContent = data.cart_count;
                    }
                    return { ok:true, data };
                } else {
                    let msg = 'Gagal menambahkan ke keranjang';
                    if (data && (data.message || data.msg)) msg = data.message || data.msg;
                    else if (res.status === 419) msg = 'Session kadaluarsa (CSRF). Refresh halaman.';
                    showToast(msg, true);
                    return { ok:false, data };
                }
            } catch(err){
                console.error('postAddToCart error', err);
                showToast('Terjadi kesalahan jaringan', true);
                return { ok:false, data:null };
            } finally {
                if (triggerBtn) setBtnLoading(triggerBtn, false);
            }
        }

        /* ---------- Modal logic (UI improved) ---------- */
        const cards = Array.from(document.querySelectorAll('.product-card'));
        const modalRoot = document.getElementById('modalRoot');
        const modalBackdrop = document.getElementById('modalBackdrop');
        const modalClose = document.getElementById('modalClose');

        const modalImg = document.getElementById('modalImg');
        const modalTitle = document.getElementById('modalTitle');
        const modalSku = document.getElementById('modalSku');
        const modalPrice = document.getElementById('modalPrice');
        const modalStock = document.getElementById('modalStock');
        const modalDesc = document.getElementById('modalDesc');
        const modalQtyInfo = document.getElementById('modalQtyInfo');
        const modalQtyHint = document.getElementById('modalQtyHint');
        const stepValue = document.getElementById('stepValue');

        const stepMinus = document.getElementById('stepMinus');
        const stepPlus = document.getElementById('stepPlus');
        const modalAdd = document.getElementById('modalAdd');
        const modalCheckout = document.getElementById('modalCheckout');

        let activeProduct = null;
        let activeQty = 1;

        function openModalFromCard(card){
            const d = card.dataset;
            if(!d || !d.id){
                showToast('Data produk tidak ditemukan', true);
                return;
            }

            activeProduct = {
                id: d.id,
                name: d.name,
                price: d.price,
                sku: d.sku,
                stock: d.stock,
                desc: d.desc,
                image: d.image,
                addUrl: d.addUrl
            };

            modalImg.src = activeProduct.image || '/images/no-image.png';
            modalImg.alt = activeProduct.name || 'produk';
            modalTitle.textContent = activeProduct.name || 'Detail Produk';
            modalSku.textContent = activeProduct.sku ? 'SKU: ' + activeProduct.sku : '';
            modalPrice.textContent = activeProduct.price ? rupiah(activeProduct.price) : '';
            modalStock.textContent = 'Stok: ' + (activeProduct.stock ?? '-');
            modalDesc.textContent = activeProduct.desc || 'Tidak ada deskripsi.';
            modalQtyHint.textContent = ''; // reserved for hints

            activeQty = 1;
            stepValue.textContent = activeQty;
            modalQtyInfo.textContent = activeQty + ' item';

            // fallback form action (progressive enhancement)
            const modalFallbackForm = document.getElementById('modalFallbackForm');
            if (modalFallbackForm) modalFallbackForm.action = activeProduct.addUrl || '';

            modalRoot.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(){
            modalRoot.classList.remove('show');
            document.body.style.overflow = '';
        }

        cards.forEach(card => {
            card.addEventListener('click', function(e){
                if (e.target.closest('form')) return;
                openModalFromCard(card);
            });
            card.addEventListener('keydown', function(e){
                if(e.key === 'Enter' || e.key === ' '){
                    e.preventDefault();
                    openModalFromCard(card);
                }
            });
        });

        modalClose.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeModal();
        });

        // Stepper with stock limit and visual cue
        stepMinus.addEventListener('click', function(){
            if(activeQty <= 1) return;
            activeQty = Math.max(1, activeQty - 1);
            stepValue.textContent = activeQty;
            modalQtyInfo.textContent = activeQty + ' item';
        });

        stepPlus.addEventListener('click', function(){
            const max = Number(activeProduct?.stock) || 999999;
            if(activeQty >= max){
                // subtle hint
                modalQtyHint.textContent = 'Mencapai batas stok';
                setTimeout(()=> { modalQtyHint.textContent = ''; }, 900);
                return;
            }
            activeQty = activeQty + 1;
            stepValue.textContent = activeQty;
            modalQtyInfo.textContent = activeQty + ' item';
        });

        /* Modal Add: use URL from card (addUrl) */
        modalAdd.addEventListener('click', async function(){
            if(!activeProduct || !activeProduct.id){
                showToast('Produk belum dipilih', true);
                return;
            }
            const action = activeProduct.addUrl;
            const result = await postAddToCart(action, activeQty, modalAdd);
            if(result.ok){
                // keep modal open briefly so user sees toast, then refresh
                setTimeout(()=> window.location.reload(), 1100);
            }
        });

        /* Checkout: add then redirect */
        modalCheckout.addEventListener('click', async function(){
            if(!activeProduct || !activeProduct.id){
                showToast('Produk belum dipilih', true);
                return;
            }
            const action = activeProduct.addUrl;
            const result = await postAddToCart(action, activeQty, modalCheckout);
            if(result.ok){
                setTimeout(()=> { window.location.href = `{{ route('shop.checkout') }}`; }, 700);
            }
        });

        /* Accessibility: keyboard on stepper values */
        stepValue.addEventListener('keydown', function(e){
            if(e.key === 'ArrowUp' || e.key === '+') stepPlus.click();
            if(e.key === 'ArrowDown' || e.key === '-') stepMinus.click();
        });

    })();
    </script>
</div>
@endsection
