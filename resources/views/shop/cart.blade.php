@extends('layouts.blank')

@section('content')
<style>
/* ====== Local Page Navbar + Cart Page (self-contained styles) ====== */

/* --- local navbar --- */
.page-navbar {
  background: #fff;
  border-bottom: 1px solid #eef2f7;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: sticky;
  top: 0;
  z-index: 1200;
  padding: 0 12px;
  box-shadow: 0 6px 18px rgba(8,10,15,0.02);
}
.page-navbar-inner { max-width:980px; width:100%; display:flex; align-items:center; justify-content:center; position:relative; }
.page-navbar-left { position:absolute; left:12px; display:flex; align-items:center; gap:8px; }
.page-navbar-right { position:absolute; right:12px; width:44px; height:44px; } /* spacer if needed */
.page-navbar-btn {
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 10px; border-radius:10px; border:1px solid transparent; background:transparent; cursor:pointer;
  color:#0f172a; font-weight:700; text-decoration:none;
}
.page-navbar-title { text-align:center; pointer-events:none; }
.page-navbar-title h2 { margin:0; font-size:16px; font-weight:800; letter-spacing:0.6px; text-transform:uppercase; color:#0f172a; }
.page-navbar-sub { margin-top:4px; font-size:12px; color:#64748b; pointer-events:none; }

/* --- page container & cart styles (kept from previous) --- */
.cart-wrap { max-width:980px; margin:18px auto; padding:18px; padding-bottom:160px; }
.card { background:#fff; border:1px solid #eef2f7; border-radius:12px; box-shadow:0 8px 30px rgba(8,10,15,0.04); overflow:hidden; }
.list-wrap { padding:12px; display:flex; flex-direction:column; gap:12px; }
.cart-row { display:grid; grid-template-columns: 36px 1fr 160px 220px 140px; gap:12px; align-items:center; padding:12px; border-radius:10px; background:#fff; border:1px solid #f8fafc; box-shadow:0 2px 8px rgba(15,23,42,0.03); width:100%; }
@media (max-width:760px) {
  .cart-row { grid-template-columns: 36px 1fr auto; align-items:flex-start; }
}
.prod-col { display:flex; gap:12px; align-items:center; }
.prod-thumb { width:64px; height:64px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border:1px solid #f8fafc; }
.prod-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.prod-meta { display:flex; flex-direction:column; gap:6px; }
.price-col { color:#0f172a; font-weight:700; }
.stock-small { color:#64748b; font-size:13px; }
.qty-controls { display:flex; gap:8px; align-items:center; justify-content:flex-start; }
.qty-btn { width:36px; height:36px; border-radius:8px; border:1px solid #e6eef6; background:#fff; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; font-weight:700; font-size:18px; line-height:1; }
.qty-input { width:80px; padding:6px 8px; border-radius:8px; border:1px solid #e6eef6; text-align:center; }
.total-col { display:flex; flex-direction:column; gap:8px; align-items:flex-end; justify-content:center; min-width:140px; }
.item-total-row { display:flex; gap:8px; align-items:center; justify-content:flex-end; }
.item-total { font-weight:800; color:#0f172a; }
.btn-trash { background:transparent; border:0; cursor:pointer; padding:6px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; }
.btn-trash:hover { background:#fff0f6; }
.badge-out { background:#fee2e2; color:#9f1239; font-weight:700; padding:6px 8px; border-radius:999px; font-size:12px; }

/* sticky footer */
.sticky-footer { position:fixed; left:0; right:0; bottom:0; z-index:1100; background:linear-gradient(180deg,#ffffff, #fbfdff); border-top:1px solid #e6eef6; box-shadow:0 -12px 40px rgba(8,10,15,0.06); padding:12px 0; }
.sticky-inner { max-width:980px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:12px; padding:0 18px; }
.sticky-left { display:flex; align-items:center; gap:12px; }
.select-all-label { font-size:14px; color:#374151; margin-left:8px; }
.sticky-right { display:flex; align-items:center; gap:16px; }
.selected-total { font-weight:800; font-size:15px; color:#0f172a; text-align:right; }
.btn { padding:10px 14px; border-radius:10px; font-weight:700; border:1px solid transparent; cursor:pointer; }
.btn-primary { background:linear-gradient(90deg,#7c3aed 0%,#6d28d9 100%); color:#fff; box-shadow:0 8px 24px rgba(99,102,241,0.08); }
.btn-ghost { background:#fff; border:1px solid #e6eef6; color:#0f172a; }

/* small screens */
@media (max-width:520px) {
  .page-navbar-left { left:8px; }
  .page-navbar-right { right:8px; }
  .prod-thumb { width:48px; height:48px; }
  .qty-input { width:64px; }
  .cart-wrap { padding-bottom:220px; }
}
</style>

<!-- LOCAL NAVBAR: no external navbar included -->
<nav class="page-navbar" role="navigation" aria-label="Page navbar">
  <div class="page-navbar-inner">
    <div class="page-navbar-left" aria-hidden="false">
      <!-- Back button: tries history.back(); falls back to shop.index -->
      <button class="page-navbar-btn" onclick="(function(){ if(history.length>1){ history.back(); } else { window.location.href='{{ route('shop.index') }}'; } })();" aria-label="Kembali">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        Kembali
      </button>
    </div>

    <div class="page-navbar-title" aria-hidden="true">
      <div style="text-bold; display:flex;flex-direction:column;align-items:center;">
        <h2>KERANJANG SAYA</h2>
 
      </div>
    </div>

    <div class="page-navbar-right" aria-hidden="true"><!-- spacer --></div>
  </div>
</nav>

<!-- PAGE CONTENT -->
<div class="cart-wrap" role="main">
  <div class="card" aria-live="polite">
    @if(empty($cart) || count($cart) === 0)
      <div style="padding:28px;text-align:center;color:#64748b;">Keranjang masih kosong.</div>
    @else
      <div class="list-wrap" id="cart-list">
        @foreach($cart as $item)
          @php
            $id = $item['id'] ?? $loop->index;
            $stock = $item['stock'] ?? null;
            $isOut = isset($stock) && intval($stock) <= 0;
          @endphp

          <div class="cart-row" data-item-id="{{ $id }}" data-price="{{ $item['price'] ?? 0 }}">
            <div>
              <input type="checkbox" class="item-checkbox" data-item-id="{{ $id }}" aria-label="Pilih {{ $item['name'] }}" />
            </div>

            <div class="prod-col">
              <div class="prod-thumb" aria-hidden="true">
                @if(!empty($item['image']))
                  <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                @else
                  <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:12px;">No Image</div>
                @endif
              </div>
              <div class="prod-meta">
                <div style="font-weight:700;color:#0f172a;">{{ $item['name'] }}</div>
                @if($isOut)
                  <div><span class="badge-out">Stok Habis</span></div>
                @else
                  <div class="stock-small">Stok: {{ isset($stock) ? $stock : '—' }}</div>
                @endif
              </div>
            </div>

            <div class="price-col" aria-label="Harga">
              Rp {{ number_format($item['price'],0,',','.') }}
            </div>

            <div>
              @if($isOut)
                <div style="color:#9ca3af;font-size:14px;">Tidak bisa diubah — stok habis</div>
              @else
                <div class="qty-controls" role="group" aria-label="Quantity controls">
                  <button class="qty-btn" data-item-id="{{ $id }}" data-action="decrease" aria-label="Kurangi jumlah">−</button>
                  <input type="number" class="qty-input item-qty" data-item-id="{{ $id }}" min="1" value="{{ $item['qty'] }}" aria-label="Jumlah {{ $item['name'] }}" />
                  <button class="qty-btn" data-item-id="{{ $id }}" data-action="increase" aria-label="Tambah jumlah">+</button>
                </div>
              @endif
            </div>

            <div class="total-col" aria-label="Subtotal & aksi">
              <div class="item-total-row">
                <div class="item-total">Rp {{ number_format(($item['price'] * $item['qty']),0,',','.') }}</div>
                <button class="btn-trash btn-remove-single" data-remove-id="{{ $id }}" aria-label="Hapus {{ $item['name'] }}" title="Hapus item" style="margin-left:6px;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

<!-- sticky footer -->
<div class="sticky-footer" role="region" aria-label="Cart actions">
  <div class="sticky-inner">
    <div class="sticky-left">
      <input type="checkbox" id="select-all-bottom" class="checkbox" />
      <label for="select-all-bottom" class="select-all-label">Pilih semua</label>
      <div style="margin-left:10px;color:#64748b;font-size:13px;">(centang item yang ingin dibayar)</div>
    </div>

    <div class="sticky-right" style="align-items:center;">
      <div style="display:flex;flex-direction:column;align-items:flex-end;margin-right:12px;">
        <div style="color:#64748b;font-size:13px;">Total</div>
        <div class="selected-total" id="selected-total">Rp 0</div>
      </div>

      <!-- <form id="checkout-form" action="{{ route('shop.checkout') }}" method="POST" style="margin:0;">
        @csrf
        <button id="checkout-btn" type="submit" class="btn btn-primary" disabled>Checkout (Simulasi)</button>
      </form> -->

        <form id="checkout-form" action="{{ route('checkout.start') }}" method="POST" style="margin:0;">
            @csrf
            <button id="checkout-btn" type="submit" class="btn btn-primary" disabled>Checkout</button>
        </form>



    </div>
  </div>
</div>

<!-- confirm modal -->
<div id="cart-confirm-modal" style="display:none;position:fixed;inset:0;align-items:center;justify-content:center;z-index:99999;">
  <div style="position:absolute;inset:0;background:rgba(2,6,23,0.45);" data-close></div>
  <div style="position:relative;z-index:3;width:420px;background:#fff;border-radius:12px;padding:18px;box-shadow:0 20px 60px rgba(2,6,23,0.3);">
    <div style="font-weight:800;color:#0f172a;margin-bottom:8px;" id="cart-confirm-title">Konfirmasi Penghapusan</div>
    <div style="color:#64748b;margin-bottom:16px;" id="cart-confirm-msg">Apakah Anda yakin ingin menghapus item ini?</div>
    <div style="display:flex;gap:8px;justify-content:flex-end;">
      <button id="cart-confirm-cancel" class="btn btn-ghost">Batal</button>
      <button id="cart-confirm-ok" class="btn btn-primary">Hapus</button>
    </div>
  </div>
</div>



<!-- JS: same cart logic (realtime qty, debounce save, checkbox, checkout, confirm remove) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const qs = s => document.querySelector(s);
  const qsa = s => Array.from(document.querySelectorAll(s));
  const cartApi = {
    updateQty: (id) => `/keranjang/item/${id}`,   // PATCH { qty }
    removeItem: (id) => `/keranjang/item/${id}`, // DELETE
  };
  const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

  const selectBottom = qs('#select-all-bottom');
  const selectedTotalNode = qs('#selected-total');
  const checkoutBtn = qs('#checkout-btn');
  const checkoutForm = qs('#checkout-form');
  const confirmModal = qs('#cart-confirm-modal');
  const confirmOk = qs('#cart-confirm-ok');
  const confirmCancel = qs('#cart-confirm-cancel');

  function fmt(n){ return 'Rp ' + (Number(n)||0).toLocaleString('id-ID'); }
  function toast(msg, ms=2000){ const d=document.createElement('div'); d.textContent=msg; Object.assign(d.style,{position:'fixed',right:'18px',bottom:'18px',background:'#111827',color:'#fff',padding:'10px 14px',borderRadius:'8px',zIndex:99999}); document.body.appendChild(d); setTimeout(()=> d.remove(), ms); }

  function itemCheckboxes(){ return qsa('.item-checkbox'); }
  function cartRows(){ return qsa('.cart-row'); }

  function debounce(fn, wait=400){
    let t;
    return (...args) => { clearTimeout(t); t = setTimeout(()=> fn(...args), wait); };
  }

  function recalcTotals(){
    const rows = cartRows();
    let selectedTotal = 0;
    let hasSelectedValid = false;
    rows.forEach(r => {
      const price = parseFloat(r.dataset.price) || 0;
      const qtyEl = r.querySelector('.item-qty');
      const qty = qtyEl ? (parseInt(qtyEl.value)||1) : 1;
      const checkbox = r.querySelector('.item-checkbox');
      const totalEl = r.querySelector('.item-total');
      if (totalEl) totalEl.textContent = fmt(price * qty);
      if (checkbox && checkbox.checked) {
        if (!r.querySelector('.badge-out')) {
          selectedTotal += price * qty;
          hasSelectedValid = true;
        }
      }
    });

    selectedTotalNode.textContent = fmt(selectedTotal);
    checkoutBtn.disabled = !hasSelectedValid;
    updateSelectAllState();
  }

  function updateSelectAllState(){
    const boxes = itemCheckboxes();
    if (!boxes.length) {
      if (selectBottom) { selectBottom.checked = false; selectBottom.indeterminate = false; }
      return;
    }
    const checkedCount = boxes.filter(b => b.checked).length;
    const all = checkedCount === boxes.length;
    const none = checkedCount === 0;
    if (selectBottom) {
      if (all) { selectBottom.checked = true; selectBottom.indeterminate = false; }
      else if (none) { selectBottom.checked = false; selectBottom.indeterminate = false; }
      else { selectBottom.checked = false; selectBottom.indeterminate = true; }
    }
  }

  async function sendUpdateQty(id, qty){
    try {
      await fetch(cartApi.updateQty(id), {
        method: 'PATCH',
        headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf},
        body: JSON.stringify({qty})
      });
    } catch(err){
      console.error('updateQty err', err);
      toast('Gagal menyimpan jumlah ke server');
    }
  }
  const debouncedUpdate = debounce((id, qty) => sendUpdateQty(id, qty), 400);

  function openConfirm({title, msg, action}){
    qs('#cart-confirm-title').textContent = title || 'Konfirmasi';
    qs('#cart-confirm-msg').textContent = msg || '';
    confirmModal.style.display = 'flex';
    confirmOk._action = action;
  }
  function closeConfirm(){ confirmModal.style.display = 'none'; confirmOk._action = null; }

  confirmOk.addEventListener('click', async () => {
    const a = confirmOk._action;
    if (typeof a === 'function') {
      try { await a(); } catch(e){ console.error(e); }
    }
    closeConfirm();
  });
  confirmCancel.addEventListener('click', closeConfirm);
  qsa('[data-close]').forEach(el => el.addEventListener('click', closeConfirm));

  document.addEventListener('click', async (e) => {
    const qtyBtn = e.target.closest('.qty-btn');
    if (qtyBtn && qtyBtn.dataset.itemId) {
      const id = qtyBtn.dataset.itemId;
      const action = qtyBtn.dataset.action;
      const input = document.querySelector(`.item-qty[data-item-id="${id}"]`);
      if (!input) return;
      let qty = parseInt(input.value) || 1;
      if (action === 'increase') qty = qty + 1;
      else if (action === 'decrease') qty = Math.max(1, qty - 1);
      input.value = qty;

      const row = document.querySelector(`.cart-row[data-item-id="${id}"]`);
      if (row) {
        const price = parseFloat(row.dataset.price) || 0;
        const totalEl = row.querySelector('.item-total');
        if (totalEl) totalEl.textContent = fmt(price * qty);
      }

      recalcTotals();
      sendUpdateQty(id, qty);
      return;
    }

    const removeBtn = e.target.closest('.btn-remove-single');
    if (removeBtn) {
      const id = removeBtn.dataset.removeId;
      if (!id) return;
      openConfirm({
        title: 'Hapus item?',
        msg: 'Yakin ingin menghapus item ini dari keranjang?',
        action: async () => {
          const row = document.querySelector(`.cart-row[data-item-id="${id}"]`);
          if (row) row.remove();
          recalcTotals();
          toast('Item dihapus');
          try {
            await fetch(cartApi.removeItem(id), {
              method: 'DELETE',
              headers: {'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf}
            });
          } catch(err){ console.error('remove err', err); toast('Gagal menghapus di server'); }
        }
      });
      return;
    }
  });

  document.addEventListener('input', (e) => {
    if (e.target.matches('.item-qty')) {
      const id = e.target.dataset.itemId;
      let qty = parseInt(e.target.value) || 1;
      if (qty < 1) qty = 1;
      e.target.value = qty;

      const row = document.querySelector(`.cart-row[data-item-id="${id}"]`);
      if (row) {
        const price = parseFloat(row.dataset.price) || 0;
        const totalEl = row.querySelector('.item-total');
        if (totalEl) totalEl.textContent = fmt(price * qty);
      }

      recalcTotals();
      debouncedUpdate(id, qty);
      return;
    }
  });

  document.addEventListener('change', (e) => {
    if (e.target.matches('.item-checkbox')) { recalcTotals(); return; }
  });

  if (selectBottom) {
    selectBottom.addEventListener('change', (ev) => {
      const checked = !!ev.target.checked;
      itemCheckboxes().forEach(cb => cb.checked = checked);
      selectBottom.indeterminate = false;
      recalcTotals();
    });
  }

  if (checkoutForm) {
    checkoutForm.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const checkedBoxes = itemCheckboxes().filter(cb => cb.checked);
      if (!checkedBoxes.length) { toast('Pilih minimal 1 item untuk checkout'); return; }

      qsa('#checkout-form input[name^="items"]').forEach(i => i.remove());

      checkedBoxes.forEach(cb => {
        const id = cb.dataset.itemId;
        const row = document.querySelector(`.cart-row[data-item-id="${id}"]`);
        if (!row) return;
        if (row.querySelector('.badge-out')) return;
        const qtyEl = row.querySelector('.item-qty');
        const qty = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `items[${id}][qty]`;
        input.value = qty;
        checkoutForm.appendChild(input);

        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `items[${id}][id]`;
        inputId.value = id;
        checkoutForm.appendChild(inputId);
      });

      const created = qsa('#checkout-form input[name^="items"]');
      if (!created.length) { toast('Tidak ada item valid untuk checkout (mungkin stok habis)'); return; }

      checkoutForm.submit();
    });
  }

  // initial totals
  recalcTotals();

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (confirmModal && confirmModal.style.display === 'flex') closeConfirm();
    }
  });

  function closeConfirm(){ confirmModal.style.display = 'none'; confirmOk._action = null; }
  window.tk_closeConfirm = closeConfirm;
});
</script>
@endsection
