{{-- navbar_blade.php (final — select-all auto-check when all items checked) --}}
<style>
/* ====== Navbar + Mini-cart + Confirm Modal ====== */
.tk-nav {
  background:#fff;
  border-bottom:1px solid #eef2f7;
  font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;
  position:sticky;
  top:0;
  z-index:1600;
  backdrop-filter:saturate(120%) blur(2px);
  -webkit-backdrop-filter:saturate(120%) blur(2px);
}
.tk-container { max-width:1280px; margin:0 auto; padding:0 18px; }
.tk-row { display:flex; align-items:center; justify-content:space-between; height:72px; gap:12px; }

/* LEFT */
.tk-left { display:flex; align-items:center; gap:12px; margin-right:auto; }
.tk-logo img { height:36px; display:block; }

/* CENTER */
.tk-center { display:flex; align-items:center; gap:20px; margin:0 auto; }
.tk-menu { display:flex; gap:20px; align-items:center; }
.tk-menu a { color:#0f172a; text-decoration:none; font-weight:600; padding:6px 10px; border-radius:8px; font-size:15px; }
.tk-menu a:hover { background:#f8fafc; }

/* search */
.tk-search { display:flex; align-items:center; background:#fff; border:1px solid #e6eef6; padding:8px 12px; border-radius:999px; min-width:380px; }
.tk-search input { border:0; outline:0; font-size:14px; width:100%; min-width:220px; }
.tk-search .search-icon { margin-left:8px; display:flex; align-items:center; justify-content:center; }

/* ACTIONS RIGHT */
.tk-actions { display:flex; align-items:center; gap:12px; margin-left:auto; }
.icon-btn { display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; border-radius:12px; background:transparent; border:1px solid transparent; cursor:pointer; padding:0; }
.icon-btn:hover { background:#f8fafc; }
.icon-btn svg { width:20px; height:20px; }

.badge { position:relative; transform:translate(8px,-10px); background:#7c3aed; color:#fff; font-size:11px; min-width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; border-radius:999px; padding:0 6px; font-weight:700; box-shadow:0 4px 10px rgba(124,58,237,0.12); }
.badge.hidden { display:none !important; }

/* MINI CART panel */
.tk-mini-cart { position:absolute; right:0; margin-top:8px; width:420px; max-height:600px; background:#fff; border:1px solid #e6eef6; box-shadow:0 18px 40px rgba(8,10,15,0.08); border-radius:12px; overflow:hidden; z-index:1500; display:none; }
.tk-mini-cart.show { display:block; }

.tk-mini-head { padding:14px 16px; display:flex; gap:10px; align-items:center; justify-content:space-between; border-bottom:1px solid #f1f5f9; background:linear-gradient(180deg,#ffffff 0%,#fbfdff 100%); }
.tk-mini-head .title { display:flex; gap:12px; align-items:center; font-weight:800; color:#0f172a; font-size:15px; }
.tk-mini-head .summary { font-size:13px; color:#64748b; }

/* body */
.tk-mini-body { max-height:380px; overflow:auto; padding:8px 8px; background:#fff; }

/* item layout: checkbox | thumb | meta | right */
.tk-mini-item { display:grid; grid-template-columns:36px 64px 1fr auto; gap:12px; align-items:center; padding:10px; border-radius:10px; margin:8px; background:#fff; border:1px solid #f8fafc; box-shadow:0 2px 6px rgba(15,23,42,0.02); }
.item-checkbox { width:18px; height:18px; margin-left:6px; }

/* thumb */
.tk-mini-thumb { width:64px; height:64px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.tk-mini-thumb img { width:100%; height:100%; object-fit:cover; display:block; }

/* meta */
.tk-mini-meta { min-width:0; display:flex; flex-direction:column; gap:6px; }
.tk-mini-title { font-weight:700; font-size:0.95rem; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.tk-mini-sub { font-size:13px; color:#64748b; display:flex; gap:8px; align-items:center; }

/* controls */
.tk-mini-controls { display:flex; gap:8px; align-items:center; margin-top:6px; flex-wrap:wrap; }
.qty-btn { width:28px; height:28px; border-radius:8px; border:1px solid #e6eef6; background:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; font-size:16px; line-height:1; }
.qty-input { width:56px; padding:6px 8px; border-radius:8px; border:1px solid #e6eef6; text-align:center; }

/* right */
.item-right { display:flex; flex-direction:column; align-items:flex-end; gap:6px; }
.item-total { font-weight:800; white-space:nowrap; color:#0f172a; text-align:right; font-size:0.95rem; }

/* trash */
.btn-trash { background:transparent; border:0; cursor:pointer; padding:6px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; }
.btn-trash:hover { background:#fff0f6; }

/* bulk actions row (top of mini-body) */
.mini-body-top { display:flex; justify-content:space-between; align-items:center; padding:8px 6px; }

/* empty */
.tk-mini-empty { padding:36px; text-align:center; color:#64748b; display:flex; flex-direction:column; gap:12px; align-items:center; }

/* footer */
.tk-mini-footer { padding:12px 16px; border-top:1px solid #f1f5f9; background:#fff; display:flex; flex-direction:column; gap:10px; }
.tk-mini-totals { display:flex; justify-content:space-between; align-items:center; gap:12px; }
.tk-mini-totals .label { color:#64748b; font-size:14px; }
.tk-mini-totals .amount { font-weight:800; font-size:16px; color:#0f172a; }

.tk-actions-row { display:flex; gap:8px; }
.btn-ghost { padding:10px 12px; border-radius:10px; border:1px solid #e6eef6; background:#fff; color:#0f172a; text-decoration:none; font-weight:700; flex:1; text-align:center; }
.btn-primary { padding:10px 12px; border-radius:10px; background:linear-gradient(90deg,#7c3aed 0%,#6d28d9 100%); color:#fff; font-weight:800; text-decoration:none; flex:1; text-align:center; box-shadow:0 8px 24px rgba(99,102,241,0.09); }

/* profile */
.tk-profile-btn { display:inline-flex; align-items:center; gap:8px; padding:6px; border-radius:12px; cursor:pointer; border:1px solid transparent; background:transparent; }
.tk-avatar { width:44px; height:44px; border-radius:999px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#e6eef6; font-weight:700; color:#0f172a; border:1px solid #f1f5f9; }
.tk-avatar img { width:100%; height:100%; object-fit:cover; display:block; border-radius:999px; }

.tk-profile-dropdown { position:absolute; right:0; margin-top:8px; width:260px; background:#fff; border:1px solid #e6eef6; border-radius:12px; box-shadow:0 12px 40px rgba(8,10,15,0.08); overflow:hidden; z-index:1500; display:none; }
.tk-profile-dropdown.show { display:block; }
.tk-profile-top { padding:12px 14px; background:#fff; border-bottom:1px solid #f1f5f9; }
.tk-profile-link { display:block; padding:10px 14px; text-decoration:none; color:#0f172a; }

.guest-actions { display:flex; gap:10px; align-items:center; }
.btn-login-pill { padding:10px 20px; border-radius:999px; font-weight:700; font-size:15px; }

/* confirm modal */
#tk-confirm-modal { position:fixed; inset:0; display:none; align-items:center; justify-content:center; z-index:99999; }
#tk-confirm-modal.show { display:flex; }
.tk-confirm-backdrop { position:absolute; inset:0; background:rgba(2,6,23,0.45); }
.tk-confirm-box { position:relative; z-index:3; width:420px; max-width:94%; background:#fff; border-radius:12px; padding:18px; box-shadow:0 20px 60px rgba(2,6,23,0.3); }
.tk-confirm-title { font-weight:800; margin-bottom:8px; color:#0f172a; }
.tk-confirm-msg { color:#64748b; margin-bottom:16px; }
.tk-confirm-actions { display:flex; gap:8px; justify-content:flex-end; }

/* responsive */
@media (max-width:980px) {
  .tk-menu { display:none; }
  .tk-search { min-width:200px; }
  .tk-mini-cart { right:10px; left:auto; width:340px; }
}
@media (max-width:720px) {
  .tk-search { display:none; }
  .guest-actions .btn-ghost { display:none; }
}
</style>

<nav class="tk-nav" aria-label="Main nav">
  <div class="tk-container">
    <div class="tk-row">

      {{-- LEFT --}}
      <div class="tk-left" style="margin-left:0;">
        <a class="tk-logo" href="{{ route('dashboard') }}" aria-label="Home">
          <img src="{{ asset('images/logo/logo_tokoriza.png') }}" alt="Logo">
        </a>
      </div>

      {{-- CENTER --}}
      <div class="tk-center" role="navigation" aria-label="Primary">
        <div class="tk-menu" aria-hidden="false">
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a>
          <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.index') ? 'active' : '' }}">Produk</a>
           <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('shop.index') ? 'active' : '' }}">Pesanan</a>

 
        </div>

        <form class="tk-search" role="search" action="{{ route('shop.index') }}" method="GET" aria-label="Search products">
          <input type="search" name="q" placeholder="Search products" value="{{ request('q') }}" aria-label="Search products">
          <button type="submit" class="search-icon" aria-label="Search">
            <svg viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" aria-hidden="true">
              <circle cx="11" cy="11" r="6"></circle>
              <path d="M21 21l-4.35-4.35"></path>
            </svg>
          </button>
        </form>
      </div>

      {{-- RIGHT --}}
      <div class="tk-actions" style="margin-right:0;">

        @php
          $cart = session('cart', []);
          $cartCount = collect($cart)->sum('qty');
          $cartTotal = collect($cart)->reduce(fn($c,$i)=> $c + ($i['price']*$i['qty']), 0);
        @endphp

        {{-- CART --}}
        <div style="position:relative;">
          <button id="tk-cart-btn" class="icon-btn" aria-haspopup="true" aria-expanded="false" title="Keranjang">
            <svg viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M6 2h12l1.5 4H4.5L6 2z"></path>
              <path d="M3 6h18v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6z"></path>
              <path d="M16 11a4 4 0 0 1-8 0"></path>
            </svg>

            @if($cartCount>0)
              <span class="badge" id="tk-cart-badge">{{ $cartCount }}</span>
            @else
              <span class="badge hidden" id="tk-cart-badge" aria-hidden="true"></span>
            @endif
          </button>

          {{-- MINI CART --}}
          <div id="tk-mini-cart" class="tk-mini-cart" aria-hidden="true">
            <div class="tk-mini-head">
              <div class="title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M3 3h2l.4 2M7 13h10l4-8H5.4"></path>
                  <circle cx="10" cy="20" r="1"></circle>
                  <circle cx="18" cy="20" r="1"></circle>
                </svg>
                Keranjang
              </div>
              <div class="summary" id="tk-mini-count">@if($cartCount>0){{ $cartCount }} item • Rp {{ number_format($cartTotal,0,',','.') }}@else 0 item @endif</div>
            </div>

            @if($cartCount === 0)
              <div class="tk-mini-body">
                <div class="tk-mini-empty">
                  <svg width="84" height="64" viewBox="0 0 84 64" fill="none" aria-hidden="true">
                    <rect x="6" y="12" width="72" height="40" rx="8" fill="#f8fafc"></rect>
                    <path d="M24 28h36v4H24z" fill="#e6eef6"></path>
                    <path d="M24 36h36v4H24z" fill="#e6eef6"></path>
                  </svg>
                  <div style="font-weight:700;color:#0f172a;">Keranjang kosong</div>
                  <div style="font-size:13px;color:#64748b;">Tambahkan produk ke keranjang untuk mulai belanja.</div>
                </div>
              </div>
            @else
              <div class="tk-mini-body" id="tk-mini-body">
                <div class="mini-body-top">
                  <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" id="tk-select-all" title="Pilih semua" />
                    <label for="tk-select-all" class="small">Pilih semua</label>
                  </div>
                  <div class="bulk-actions" style="display:flex;gap:8px;align-items:center;">
                    <button id="tk-delete-selected" class="btn-ghost" type="button" title="Hapus Terpilih">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                        <path d="M10 11v6"></path>
                        <path d="M14 11v6"></path>
                      </svg>
                    </button>
                  </div>
                </div>

                <div id="tk-mini-items">
                  @foreach($cart as $loopIndex => $item)
                    @php $id = $item['id'] ?? $loopIndex; @endphp
                    <div class="tk-mini-item" data-item-id="{{ $id }}" data-price="{{ $item['price'] ?? 0 }}">
                      {{-- per-item checkbox --}}
                      <div style="display:flex;align-items:center;justify-content:flex-start;">
                        <input type="checkbox" class="item-checkbox" data-item-id="{{ $id }}" title="Pilih item">
                      </div>

                      <div class="tk-mini-thumb">
                        @if(!empty($item['image']))
                          <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                        @else
                          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#94a3b8;">No Img</div>
                        @endif
                      </div>

                      <div class="tk-mini-meta">
                        <div class="tk-mini-title" title="{{ $item['name'] }}">{{ $item['name'] }}</div>
                        <div class="tk-mini-sub">
                          <div>Rp {{ number_format($item['price'],0,',','.') }}</div>
                        </div>

                        <div class="tk-mini-controls">
                          <button class="qty-btn btn-decrease" type="button" data-item-id="{{ $id }}">−</button>
                          <input type="number" min="1" class="qty-input item-qty" data-item-id="{{ $id }}" value="{{ $item['qty'] }}">
                          <button class="qty-btn btn-increase" type="button" data-item-id="{{ $id }}">+</button>
                        </div>
                      </div>

                      <div class="item-right">
                        <div class="item-total">Rp {{ number_format(($item['price']*$item['qty']),0,',','.') }}</div>

                        {{-- trash icon (single remove) --}}
                        <button class="btn-trash btn-remove-single" data-remove-id="{{ $id }}" title="Hapus item">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                            <path d="M10 11v6"></path>
                            <path d="M14 11v6"></path>
                          </svg>
                        </button>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="tk-mini-footer">
                <div class="tk-mini-totals">
                  <div class="label">Total</div>
                  <div class="amount" id="tk-mini-total">Rp {{ number_format($cartTotal,0,',','.') }}</div>
                </div>

                <div class="tk-actions-row">
                  <a href="{{ route('shop.cart') }}" id="tk-view-cart" class="btn-ghost">Lihat Keranjang</a>
                  <!-- <button id="tk-checkout" class="btn-primary">Checkout</button> -->
                </div>
                
              </div>
            @endif
          </div>
        </div>

        {{-- PROFILE / AUTH --}}
        @auth
          <div style="position:relative;">
            <button id="tk-profile-btn" class="tk-profile-btn" aria-haspopup="true" aria-expanded="false" title="Akun">
              @if(Auth::user()->profile_photo)
                <div class="tk-avatar"><img src="{{ asset('storage/profile/'.Auth::user()->profile_photo) }}" alt="avatar"></div>
              @else
                <div class="tk-avatar">{{ strtoupper(mb_substr(Auth::user()->name,0,1,'UTF-8')) }}</div>
              @endif
            </button>

            <div id="tk-profile-dropdown" class="tk-profile-dropdown" aria-hidden="true">
              <div class="tk-profile-top">
                <div style="font-weight:700;">{{ Auth::user()->name }}</div>
                <div class="text-muted" style="margin-top:4px;">{{ Auth::user()->email }}</div>
              </div>

              <a class="tk-profile-link" href="{{ route('profile.edit') }}">Akun Saya</a>
              <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="tk-profile-link" style="color:#dc2626;text-align:left;">Logout</button>
              </form>
            </div>
          </div>
        @else
          <div class="guest-actions">
            <a href="{{ route('register') }}" class="btn-ghost">Daftar</a>
            <a href="{{ route('login') }}" class="btn-primary btn-login-pill">Masuk</a>
          </div>
        @endauth

      </div>
    </div>
  </div>

  {{-- Mobile drawer --}}
  <div id="tk-mobile" class="tk-mobile" aria-hidden="true" style="display:none;">
    <div class="panel">
      <div style="display:flex;align-items:center;justify-content:space-between;">
        <a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo/logo_tokoriza.png') }}" alt="tok" style="height:34px;"></a>
        <button id="tk-mobile-close">✕</button>
      </div>

      <div style="margin-top:18px;display:flex;flex-direction:column;gap:8px;">
        <a href="{{ route('dashboard') }}" class="small">Home</a>
        <a href="{{ route('shop.index') }}" class="small">Produk</a>
        <a href="{{ route('shop.cart') }}" class="small">Keranjang @if($cartCount>0)({{ $cartCount }})@endif</a>
      </div>

      <div style="margin-top:18px;">
        @auth
          <div style="display:flex;gap:12px;align-items:center;">
            @if(Auth::user()->profile_photo)
              <img src="{{ asset('storage/profile/'.Auth::user()->profile_photo) }}" alt="avatar" style="width:48px;height:48px;border-radius:999px;object-fit:cover;">
            @else
              <div class="tk-avatar" style="width:48px;height:48px;">{{ strtoupper(mb_substr(Auth::user()->name,0,1,'UTF-8')) }}</div>
            @endif
            <div>
              <div style="font-weight:700;">{{ Auth::user()->name }}</div>
              <div class="text-muted">{{ Auth::user()->email }}</div>
            </div>
          </div>

          <a href="{{ route('profile.edit') }}" class="small">Akun Saya</a>
          <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="small" style="color:#dc2626;text-align:left;">Logout</button></form>
        @else
          <a href="{{ route('register') }}" class="btn-ghost" style="display:block;text-align:center;">Daftar</a>
          <a href="{{ route('login') }}" class="btn-primary" style="display:block;text-align:center;margin-top:8px;">Masuk</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

{{-- CONFIRMATION MODAL --}}
<div id="tk-confirm-modal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="tk-confirm-backdrop" data-close-modal></div>
  <div class="tk-confirm-box" role="document" aria-labelledby="tk-confirm-title">
    <div class="tk-confirm-title" id="tk-confirm-title">Konfirmasi Penghapusan</div>
    <div class="tk-confirm-msg" id="tk-confirm-msg">Apakah Anda yakin ingin menghapus item ini dari keranjang? Tindakan ini tidak dapat dibatalkan.</div>
    <div class="tk-confirm-actions">
      <button id="tk-confirm-cancel" class="btn-ghost" type="button">Batal</button>
      <button id="tk-confirm-ok" class="btn-primary" type="button">Hapus</button>
    </div>
  </div>
</div>

{{-- JS --}}
<script>
(function(){
  const qs = s => document.querySelector(s);
  const qsa = s => Array.from(document.querySelectorAll(s));

  // DOM refs
  const cartBtn = qs('#tk-cart-btn');
  const miniCart = qs('#tk-mini-cart');
  const miniItemsWrap = qs('#tk-mini-items');
  const miniCount = qs('#tk-mini-count');
  const cartBadge = qs('#tk-cart-badge');
  const miniTotal = qs('#tk-mini-total');
  const selectAll = qs('#tk-select-all');
  const deleteSelectedBtn = qs('#tk-delete-selected');
  const profileBtn = qs('#tk-profile-btn');
  const profileDrop = qs('#tk-profile-dropdown');
  const checkoutBtn = qs('#tk-checkout');
  const viewCartLink = qs('#tk-view-cart');

  // confirm modal refs
  const confirmModal = qs('#tk-confirm-modal');
  const confirmMsg = qs('#tk-confirm-msg');
  const confirmOk = qs('#tk-confirm-ok');
  const confirmCancel = qs('#tk-confirm-cancel');

  // CSRF token
  const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

  const cartApi = {
    updateQty: (id) => `/keranjang/item/${id}`,
    removeItem: (id) => `/keranjang/item/${id}`,
  };

  function fmt(n){ return 'Rp ' + (Number(n)||0).toLocaleString('id-ID'); }

  function toast(msg, ms=2000){
    const d = document.createElement('div');
    d.textContent = msg;
    Object.assign(d.style, {position:'fixed', right:'18px', bottom:'18px', background:'#111827', color:'#fff', padding:'10px 14px', borderRadius:'8px', zIndex:99999});
    document.body.appendChild(d);
    setTimeout(()=> d.remove(), ms);
  }

  // recalc totals and badge
  function recalcTotals(){
    const items = qsa('.tk-mini-item');
    let total = 0;
    let count = 0;
    items.forEach(it => {
      const price = parseFloat(it.dataset.price) || 0;
      const qtyEl = it.querySelector('.item-qty');
      const qty = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;
      total += price * qty;
      count += qty;
      const subtotalEl = it.querySelector('.item-subtotal');
      if (subtotalEl) subtotalEl.textContent = fmt(price * qty); // safe: element may not exist
      const totalEl = it.querySelector('.item-total');
      if (totalEl) totalEl.textContent = fmt(price * qty);
    });

    if (miniTotal) miniTotal.textContent = fmt(total);

    if (cartBadge) {
      if (count > 0) {
        cartBadge.classList.remove('hidden');
        cartBadge.textContent = count;
        cartBadge.setAttribute('aria-hidden','false');
      } else {
        cartBadge.classList.add('hidden');
        cartBadge.textContent = '';
        cartBadge.setAttribute('aria-hidden','true');
      }
    }
    if (miniCount) miniCount.textContent = count > 0 ? `${count} item • ${fmt(total)}` : '0 item';

    // update select-all checkbox state after anything changes
    updateSelectAllState();
  }

  // update select-all checkbox to reflect item checkbox states
  function updateSelectAllState() {
    if (!selectAll) return;
    const boxes = qsa('.item-checkbox');
    if (!boxes.length) {
      selectAll.checked = false;
      selectAll.indeterminate = false;
      return;
    }
    const checked = boxes.filter(b => b.checked).length;
    if (checked === boxes.length) {
      selectAll.checked = true;
      selectAll.indeterminate = false;
    } else if (checked === 0) {
      selectAll.checked = false;
      selectAll.indeterminate = false;
    } else {
      selectAll.checked = false;
      selectAll.indeterminate = true;
    }
  }

  // show/hide modal helpers
  function openConfirm({title, msg, action}) {
    confirmModal.classList.add('show');
    confirmModal.setAttribute('aria-hidden','false');
    qs('#tk-confirm-title').textContent = title || 'Konfirmasi';
    confirmMsg.textContent = msg || '';
    confirmOk._action = action;
  }
  function closeConfirm() {
    confirmModal.classList.remove('show');
    confirmModal.setAttribute('aria-hidden','true');
    confirmOk._action = null;
  }
  confirmOk.addEventListener('click', async () => {
    const action = confirmOk._action;
    if (!action) { closeConfirm(); return; }
    try { await action(); } catch(e){ console.error(e); }
    closeConfirm();
  });
  confirmCancel.addEventListener('click', closeConfirm);
  document.querySelectorAll('[data-close-modal]').forEach(el => el.addEventListener('click', closeConfirm));

  // cart toggle
  if (cartBtn && miniCart) {
    cartBtn.addEventListener('click', e => {
      e.stopPropagation();
      const open = miniCart.classList.toggle('show');
      cartBtn.setAttribute('aria-expanded', open?'true':'false');
      if (profileDrop) profileDrop.classList.remove('show');
      // ensure select-all state correct when opening
      updateSelectAllState();
    });
    document.addEventListener('click', e => {
      if (!miniCart.contains(e.target) && !cartBtn.contains(e.target)) {
        miniCart.classList.remove('show');
        cartBtn.setAttribute('aria-expanded','false');
      }
    });
  }

  // profile toggle
  if (profileBtn && profileDrop) {
    profileBtn.addEventListener('click', e => {
      e.stopPropagation();
      const vis = profileDrop.classList.toggle('show');
      profileBtn.setAttribute('aria-expanded', vis?'true':'false');
      if (miniCart) miniCart.classList.remove('show');
    });
    document.addEventListener('click', e => {
      if (!profileDrop.contains(e.target) && !profileBtn.contains(e.target)) profileDrop.classList.remove('show');
    });
  }

  // delegated: increase/decrease buttons
  document.addEventListener('click', async (e) => {
    const inc = e.target.closest('.btn-increase');
    const dec = e.target.closest('.btn-decrease');

    if (inc || dec) {
      const isInc = !!inc;
      const el = isInc ? inc : dec;
      const id = el.dataset.itemId;
      const input = document.querySelector(`.item-qty[data-item-id="${id}"]`);
      if (!input) return;
      let qty = parseInt(input.value) || 1;
      qty = isInc ? qty + 1 : Math.max(1, qty - 1);
      input.value = qty;
      const itemEl = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
      const price = parseFloat(itemEl.dataset.price) || 0;
      const subtotal = itemEl.querySelector('.item-subtotal');
      if (subtotal) subtotal.textContent = fmt(price * qty);
      const totalEl = itemEl.querySelector('.item-total');
      if (totalEl) totalEl.textContent = fmt(price * qty);
      recalcTotals();
      try {
        await fetch(cartApi.updateQty(id), {
          method: 'PATCH',
          headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf},
          body: JSON.stringify({qty})
        });
      } catch(err){
        console.error('updateQty err', err);
        toast('Gagal memperbarui jumlah');
      }
      return;
    }
  });

  // quantity input change
  document.addEventListener('change', async (e) => {
    if (e.target.matches('.item-qty')) {
      const id = e.target.dataset.itemId;
      let qty = parseInt(e.target.value) || 1;
      if (qty < 1) qty = 1;
      e.target.value = qty;
      const itemEl = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
      if (itemEl) {
        const price = parseFloat(itemEl.dataset.price) || 0;
        const subtotal = itemEl.querySelector('.item-subtotal');
        if (subtotal) subtotal.textContent = fmt(price * qty);
        const totalEl = itemEl.querySelector('.item-total');
        if (totalEl) totalEl.textContent = fmt(price * qty);
      }
      recalcTotals();
      try {
        await fetch(cartApi.updateQty(id), {
          method: 'PATCH',
          headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf},
          body: JSON.stringify({qty})
        });
      } catch(err){ console.error('update err', err); toast('Gagal memperbarui jumlah'); }
      return;
    }

    // item-checkbox change -> update select-all state
    if (e.target.matches('.item-checkbox')) {
      updateSelectAllState();
      return;
    }
  });

  // single remove via trash: open confirm -> optimistic remove + DELETE
  document.addEventListener('click', (e) => {
    const removeBtn = e.target.closest('.btn-remove-single');
    if (!removeBtn) return;
    const id = removeBtn.dataset.removeId;
    if (!id) return;

    openConfirm({
      title: 'Hapus item?',
      msg: 'Yakin ingin menghapus item ini dari keranjang?',
      action: async () => {
        const node = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
        if (node) node.remove();
        recalcTotals();
        toast('Item dihapus');
        try {
          await fetch(cartApi.removeItem(id), { method: 'DELETE', headers: {'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf} });
        } catch(err){ console.error('remove err', err); }
        // ensure select-all updated after server call / removal
        updateSelectAllState();
      }
    });
  });

  // select-all toggles individual checkboxes
  if (selectAll) {
    selectAll.addEventListener('change', (e) => {
      const checked = !!e.target.checked;
      qsa('.item-checkbox').forEach(cb => cb.checked = checked);
      // ensure indeterminate cleared
      selectAll.indeterminate = false;
    });
  }

  // bulk delete: gather checked .item-checkbox:checked
  if (deleteSelectedBtn) {
    deleteSelectedBtn.addEventListener('click', () => {
      const checkedBoxes = qsa('.item-checkbox:checked');
      const ids = checkedBoxes.map(cb => cb.dataset.itemId).filter(Boolean);
      if (!ids.length) { toast('Belum ada item terpilih'); return; }

      openConfirm({
        title: `Hapus ${ids.length} item?`,
        msg: `Yakin ingin menghapus ${ids.length} item terpilih dari keranjang?`,
        action: async () => {
          ids.forEach(id => {
            const node = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
            if (node) node.remove();
          });
          recalcTotals();
          toast('Item terpilih dihapus');

          try {
            await Promise.all(ids.map(id => fetch(cartApi.removeItem(id), { method: 'DELETE', headers: {'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf} })));
          } catch(err){ console.error('bulk remove err', err); }
          // after bulk remove, update select-all
          updateSelectAllState();
        }
      });
    });
  }

  // checkout
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', () => {
      window.location.href = "{{ route('shop.cart') }}";
    });
  }

  // init
  recalcTotals();

  // close on Esc
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (confirmModal && confirmModal.classList.contains('show')) closeConfirm();
      if (miniCart) miniCart.classList.remove('show');
      if (profileDrop) profileDrop.classList.remove('show');
    }
  });

  // ensure closeConfirm exists
  function closeConfirm(){ confirmModal.classList.remove('show'); confirmModal.setAttribute('aria-hidden','true'); confirmOk._action = null; }
  window.tk_closeConfirm = closeConfirm;

})();
</script>
