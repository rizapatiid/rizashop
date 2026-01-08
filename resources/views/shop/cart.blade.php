@extends('layouts.blank')
@section('title', 'Keranjang Belanja')
@section('page-title', 'Keranjang Belanja')


@section('content')
<style>
/* ====== Modern Cart - Shopee/Tokopedia Style ====== */

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  background: #f5f5f5;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

/* --- Navbar --- */
.page-navbar {
  background: #fff;
  border-bottom: 1px solid #e5e7eb;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: sticky;
  top: 0;
  z-index: 1200;
  padding: 0 16px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.page-navbar-inner {
  max-width: 1200px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.page-navbar-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.page-navbar-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  border-radius: 8px;
  border: none;
  background: transparent;
  cursor: pointer;
  color: #1a1a1a;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.2s;
}

.page-navbar-btn:hover {
  background: #f5f5f5;
}

.page-navbar-title h2 {
  font-size: 18px;
  font-weight: 800;
  color: #1a1a1a;
  letter-spacing: -0.3px;
}

.page-navbar-right {
  width: 100px;
}

/* --- Cart Container --- */
.cart-wrap {
  max-width: 1200px;
  margin: 16px auto;
  padding: 0 16px 180px;
}

/* --- Card Styles --- */
.card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.08);
  overflow: hidden;
  margin-bottom: 16px;
}

.card-header {
  padding: 14px 16px;
  background: #fafafa;
  border-bottom: 1px solid #f0f0f0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.card-header-checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
}

.card-header-checkbox input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #ee4d2d;
  cursor: pointer;
}

.card-header-checkbox label {
  font-weight: 600;
  font-size: 14px;
  color: #1a1a1a;
  cursor: pointer;
}

.card-body {
  padding: 0;
}

/* --- Empty State --- */
.empty-state {
  padding: 60px 20px;
  text-align: center;
}

.empty-icon {
  width: 100px;
  height: 100px;
  margin: 0 auto 20px;
  background: #f5f5f5;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.empty-icon svg {
  width: 50px;
  height: 50px;
  color: #d1d5db;
}

.empty-text {
  color: #6c757d;
  font-size: 15px;
  margin-bottom: 20px;
}

.btn-shop {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: #ee4d2d;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-shop:hover {
  background: #d73211;
}

/* --- Cart Item --- */
.cart-item {
  display: flex;
  gap: 12px;
  padding: 16px;
  border-bottom: 1px solid #f0f0f0;
  transition: all 0.2s;
}

.cart-item:last-child {
  border-bottom: none;
}

.cart-item:hover {
  background: #fafafa;
}

.cart-item-checkbox {
  display: flex;
  align-items: flex-start;
  padding-top: 20px;
}

.cart-item-checkbox input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #ee4d2d;
  cursor: pointer;
}

.cart-item-image {
  width: 80px;
  height: 80px;
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #e9ecef;
  flex-shrink: 0;
}

.cart-item-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.cart-item-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 0;
}

.cart-item-name {
  font-weight: 600;
  font-size: 14px;
  color: #1a1a1a;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.cart-item-variant {
  display: inline-flex;
  align-items: center;
  background: #f0f0f0;
  color: #6c757d;
  padding: 4px 10px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
  width: fit-content;
}

.badge-out {
  background: #fee2e2;
  color: #991b1b;
  padding: 4px 10px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 700;
}

.cart-item-price {
  font-weight: 700;
  font-size: 16px;
  color: #ee4d2d;
  margin-top: auto;
}

.cart-item-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: space-between;
  gap: 12px;
  min-width: 120px;
}

.qty-controls {
  display: flex;
  align-items: center;
  gap: 8px;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  padding: 2px;
  background: #fff;
}

.qty-btn {
  width: 28px;
  height: 28px;
  border: none;
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 16px;
  font-weight: 600;
  color: #6c757d;
  border-radius: 4px;
  transition: all 0.2s;
}

.qty-btn:hover {
  background: #f5f5f5;
  color: #1a1a1a;
}

.qty-btn:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.qty-input {
  width: 50px;
  border: none;
  text-align: center;
  font-size: 14px;
  font-weight: 600;
  color: #1a1a1a;
  background: transparent;
}

.qty-input:focus {
  outline: none;
}

.cart-item-total {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 8px;
}

.item-total-price {
  font-weight: 800;
  font-size: 16px;
  color: #1a1a1a;
}

.btn-delete {
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 8px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.btn-delete:hover {
  background: #fee2e2;
}

.btn-delete svg {
  width: 18px;
  height: 18px;
  color: #ef4444;
}

/* --- Sticky Footer --- */
.sticky-footer {
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1100;
  background: #fff;
  border-top: 2px solid #f0f0f0;
  box-shadow: 0 -2px 8px rgba(0,0,0,0.08);
  padding: 16px 0;
}

.sticky-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 0 16px;
}

.sticky-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.sticky-checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
}

.sticky-checkbox input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #ee4d2d;
  cursor: pointer;
}

.sticky-checkbox label {
  font-size: 14px;
  font-weight: 600;
  color: #1a1a1a;
  cursor: pointer;
}

.sticky-info {
  color: #6c757d;
  font-size: 13px;
}

.sticky-right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.sticky-total {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.sticky-total-label {
  color: #6c757d;
  font-size: 13px;
  margin-bottom: 2px;
}

.sticky-total-value {
  font-weight: 900;
  font-size: 20px;
  color: #ee4d2d;
}

.btn {
  padding: 12px 32px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
}

.btn-primary {
  background: #ee4d2d;
  color: #fff;
  box-shadow: 0 2px 8px rgba(238, 77, 45, 0.3);
}

.btn-primary:hover:not(:disabled) {
  background: #d73211;
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-ghost {
  background: #fff;
  border: 1px solid #e5e7eb;
  color: #495057;
}

.btn-ghost:hover {
  border-color: #ee4d2d;
  color: #ee4d2d;
}

/* --- Modal --- */
.modal {
  display: none;
  position: fixed;
  inset: 0;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.modal.show {
  display: flex;
}

.modal-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
}

.modal-content {
  position: relative;
  z-index: 3;
  width: 400px;
  max-width: 90%;
  background: #fff;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-title {
  font-weight: 800;
  font-size: 18px;
  color: #1a1a1a;
  margin-bottom: 12px;
}

.modal-message {
  color: #6c757d;
  font-size: 14px;
  margin-bottom: 24px;
  line-height: 1.6;
}

.modal-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
}

/* --- Responsive --- */
@media (max-width: 768px) {
  .cart-wrap {
    padding: 0 12px 200px;
  }
  
  .cart-item {
    flex-wrap: wrap;
    position: relative;
  }
  
  .cart-item-checkbox {
    padding-top: 10px;
  }
  
  .cart-item-image {
    width: 70px;
    height: 70px;
  }
  
  .cart-item-info {
    flex: 1 1 100%;
    order: 2;
  }
  
  .cart-item-actions {
    flex: 1 1 100%;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    order: 3;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed #e9ecef;
  }
  
  .cart-item-price {
    margin-top: 0;
  }
  
  .sticky-inner {
    flex-wrap: wrap;
  }
  
  .sticky-left {
    flex: 1 1 100%;
    margin-bottom: 12px;
  }
  
  .sticky-right {
    flex: 1 1 100%;
    justify-content: space-between;
  }
  
  .page-navbar-title h2 {
    font-size: 16px;
  }
}

@media (max-width: 480px) {
  .qty-controls {
    gap: 4px;
  }
  
  .qty-btn {
    width: 24px;
    height: 24px;
    font-size: 14px;
  }
  
  .qty-input {
    width: 40px;
  }
  
  .sticky-info {
    display: none;
  }
  
  .btn {
    padding: 10px 24px;
    font-size: 13px;
  }
}
</style>

<!-- Navbar -->
<nav class="page-navbar">
  <div class="page-navbar-inner">
    <div class="page-navbar-left">
      <button class="page-navbar-btn" onclick="(function(){ if(history.length>1){ history.back(); } else { window.location.href='{{ route('shop.index') }}'; } })();" aria-label="Kembali">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        Kembali
      </button>
    </div>

    <div class="page-navbar-title">
      <h2>Keranjang Belanja</h2>
    </div>

    <div class="page-navbar-right"></div>
  </div>
</nav>

<!-- Cart Content -->
<div class="cart-wrap">
  @if(empty($cart) || count($cart) === 0)
    <!-- Empty State -->
    <div class="card">
      <div class="empty-state">
        <div class="empty-icon">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
        </div>
        <div class="empty-text">Keranjang belanja Anda masih kosong</div>
        <a href="{{ route('shop.index') }}" class="btn-shop">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          Mulai Belanja
        </a>
      </div>
    </div>
  @else
    <!-- Cart Items Card -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-checkbox">
          <input type="checkbox" id="select-all-top" />
          <label for="select-all-top">Pilih Semua Produk</label>
        </div>
      </div>
      
      <div class="card-body" id="cart-list">
        @foreach($cart as $key => $item)
          @php
            // Support both formats: "123" and "123:456"
            $itemId = $key;
            $productId = $item['product_id'] ?? (strpos($key, ':') !== false ? explode(':', $key)[0] : $key);
            $variantId = $item['variant_id'] ?? (strpos($key, ':') !== false ? explode(':', $key)[1] : null);
            
            $stock = $item['stock'] ?? null;
            $isOut = isset($stock) && intval($stock) <= 0;
          @endphp

          <div class="cart-item" data-item-id="{{ $itemId }}" data-price="{{ $item['price'] ?? 0 }}">
            <!-- Checkbox -->
            <div class="cart-item-checkbox">
              <input type="checkbox" class="item-checkbox" data-item-id="{{ $itemId }}" {{ $isOut ? 'disabled' : '' }} />
            </div>

            <!-- Product Image -->
            <div class="cart-item-image">
              @if(!empty($item['image']))
                <img src="{{ asset('storage/' . ltrim($item['image'], '/')) }}" alt="{{ $item['name'] }}">
              @else
                <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="2" viewBox="0 0 24 24">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                  <circle cx="8.5" cy="8.5" r="1.5"></circle>
                  <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
              @endif
            </div>

            <!-- Product Info -->
            <div class="cart-item-info">
              <div class="cart-item-name">{{ $item['name'] }}</div>
              
@if(!empty($item['variant']))
  <div class="cart-item-variant-row">
    @if(is_array($item['variant']))
      @foreach($item['variant'] as $v)
        <span class="cart-item-variant">{{ $v }}</span>
      @endforeach
    @else
      <span class="cart-item-variant">{{ $item['variant'] }}</span>
    @endif
  </div>
@endif

              
              @if($isOut)
                <div><span class="badge-out">Stok Habis</span></div>
              @endif
              
              <div class="cart-item-price">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</div>
            </div>

            <!-- Actions -->
            <div class="cart-item-actions">
              @if($isOut)
                <div style="color:#9ca3af;font-size:13px;">Tidak tersedia</div>
              @else
                <div class="qty-controls">
                  <button class="qty-btn" data-item-id="{{ $itemId }}" data-action="decrease">−</button>
                  <input type="number" class="qty-input item-qty" data-item-id="{{ $itemId }}" min="1" value="{{ $item['qty'] }}" />
                  <button class="qty-btn" data-item-id="{{ $itemId }}" data-action="increase">+</button>
                </div>
              @endif
              
              <div class="cart-item-total">
                <div class="item-total-price">Rp {{ number_format(($item['price'] ?? 0) * $item['qty'], 0, ',', '.') }}</div>
                <button class="btn-delete btn-remove-single" data-remove-id="{{ $itemId }}" title="Hapus">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>

<!-- Sticky Footer -->
<div class="sticky-footer">
  <div class="sticky-inner">
    <div class="sticky-left">
      <div class="sticky-checkbox">
        <input type="checkbox" id="select-all-bottom" />
        <label for="select-all-bottom">Pilih Semua</label>
      </div>
      <span class="sticky-info">(Centang produk untuk checkout)</span>
    </div>

    <div class="sticky-right">
      <div class="sticky-total">
        <div class="sticky-total-label">Total</div>
        <div class="sticky-total-value" id="selected-total">Rp 0</div>
      </div>

      <form id="checkout-form" action="{{ route('checkout.start') }}" method="POST">
        @csrf
        <button id="checkout-btn" type="submit" class="btn btn-primary" disabled>Checkout</button>
      </form>
    </div>
  </div>
</div>

<!-- Confirm Modal -->
<div id="cart-confirm-modal" class="modal">
  <div class="modal-backdrop" data-close></div>
  <div class="modal-content">
    <div class="modal-title" id="cart-confirm-title">Konfirmasi</div>
    <div class="modal-message" id="cart-confirm-msg">Apakah Anda yakin?</div>
    <div class="modal-actions">
      <button id="cart-confirm-cancel" class="btn btn-ghost">Batal</button>
      <button id="cart-confirm-ok" class="btn btn-primary">Hapus</button>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const qs = s => document.querySelector(s);
  const qsa = s => Array.from(document.querySelectorAll(s));
  
  const cartApi = {
    updateQty: () => `/keranjang/item`,
    removeItem: () => `/keranjang/item`,
  };
  
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  const selectTop = qs('#select-all-top');
  const selectBottom = qs('#select-all-bottom');
  const selectedTotalNode = qs('#selected-total');
  const checkoutBtn = qs('#checkout-btn');
  const checkoutForm = qs('#checkout-form');
  const confirmModal = qs('#cart-confirm-modal');
  const confirmOk = qs('#cart-confirm-ok');
  const confirmCancel = qs('#cart-confirm-cancel');

  function fmt(n) { 
    return 'Rp ' + (Number(n) || 0).toLocaleString('id-ID'); 
  }
  
  function toast(msg, ms = 2000) {
    const d = document.createElement('div');
    d.textContent = msg;
    Object.assign(d.style, {
      position: 'fixed',
      right: '20px',
      bottom: '100px',
      background: '#1a1a1a',
      color: '#fff',
      padding: '12px 20px',
      borderRadius: '8px',
      zIndex: 99999,
      boxShadow: '0 4px 12px rgba(0,0,0,0.3)',
      fontSize: '14px',
      fontWeight: '600'
    });
    document.body.appendChild(d);
    setTimeout(() => d.remove(), ms);
  }

  function itemCheckboxes() { 
    return qsa('.item-checkbox:not(:disabled)'); 
  }
  
  function cartItems() { 
    return qsa('.cart-item'); 
  }

  function debounce(fn, wait = 400) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), wait);
    };
  }

  function recalcTotals() {
    const items = cartItems();
    let selectedTotal = 0;
    let hasSelectedValid = false;

    items.forEach(item => {
      const price = parseFloat(item.dataset.price) || 0;
      const qtyEl = item.querySelector('.item-qty');
      const qty = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;
      const checkbox = item.querySelector('.item-checkbox');
      const totalEl = item.querySelector('.item-total-price');
      
      if (totalEl) {
        totalEl.textContent = fmt(price * qty);
      }
      
      if (checkbox && checkbox.checked && !checkbox.disabled) {
        selectedTotal += price * qty;
        hasSelectedValid = true;
      }
    });

    selectedTotalNode.textContent = fmt(selectedTotal);
    checkoutBtn.disabled = !hasSelectedValid;
    updateSelectAllState();
  }

  function updateSelectAllState() {
    const boxes = itemCheckboxes();
    if (!boxes.length) {
      if (selectTop) {
        selectTop.checked = false;
        selectTop.indeterminate = false;
      }
      if (selectBottom) {
        selectBottom.checked = false;
        selectBottom.indeterminate = false;
      }
      return;
    }

    const checkedCount = boxes.filter(b => b.checked).length;
    const all = checkedCount === boxes.length;
    const none = checkedCount === 0;

    [selectTop, selectBottom].forEach(sel => {
      if (sel) {
        if (all) {
          sel.checked = true;
          sel.indeterminate = false;
        } else if (none) {
          sel.checked = false;
          sel.indeterminate = false;
        } else {
          sel.checked = false;
          sel.indeterminate = true;
        }
      }
    });
  }

  async function sendUpdateQty(id, qty) {
    try {
      await fetch(cartApi.updateQty(), {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ cart_key: id, qty: qty })
      });
    } catch (err) {
      console.error('updateQty error:', err);
      toast('Gagal menyimpan perubahan');
    }
  }

  const debouncedUpdate = debounce((id, qty) => sendUpdateQty(id, qty), 400);

  function openConfirm({ title, msg, action }) {
    qs('#cart-confirm-title').textContent = title || 'Konfirmasi';
    qs('#cart-confirm-msg').textContent = msg || '';
    confirmModal.classList.add('show');
    confirmOk._action = action;
  }

  function closeConfirm() {
    confirmModal.classList.remove('show');
    confirmOk._action = null;
  }

  // Event: Confirm OK
  confirmOk.addEventListener('click', async () => {
    const action = confirmOk._action;
    if (typeof action === 'function') {
      try {
        await action();
      } catch (e) {
        console.error(e);
      }
    }
    closeConfirm();
  });

  // Event: Confirm Cancel
  confirmCancel.addEventListener('click', closeConfirm);

  // Event: Click backdrop
  qsa('[data-close]').forEach(el => {
    el.addEventListener('click', closeConfirm);
  });

  // Event: Qty buttons
  document.addEventListener('click', async (e) => {
    const qtyBtn = e.target.closest('.qty-btn');
    if (qtyBtn && qtyBtn.dataset.itemId) {
      const id = qtyBtn.dataset.itemId;
      const action = qtyBtn.dataset.action;
      const input = document.querySelector(`.item-qty[data-item-id="${id}"]`);
      if (!input) return;

      let qty = parseInt(input.value) || 1;
      if (action === 'increase') {
        qty = qty + 1;
      } else if (action === 'decrease') {
        qty = Math.max(1, qty - 1);
      }
      input.value = qty;

      const item = document.querySelector(`.cart-item[data-item-id="${id}"]`);
      if (item) {
        const price = parseFloat(item.dataset.price) || 0;
        const totalEl = item.querySelector('.item-total-price');
        if (totalEl) {
          totalEl.textContent = fmt(price * qty);
        }
      }

      recalcTotals();
      sendUpdateQty(id, qty);
      return;
    }

    // Remove button
    const removeBtn = e.target.closest('.btn-remove-single');
    if (removeBtn) {
      const id = removeBtn.dataset.removeId;
      if (!id) return;

      openConfirm({
        title: 'Hapus Produk?',
        msg: 'Produk akan dihapus dari keranjang belanja Anda.',
        action: async () => {
          const item = document.querySelector(`.cart-item[data-item-id="${id}"]`);
          if (item) item.remove();
          
          recalcTotals();
          toast('Produk berhasil dihapus');

          try {
            await fetch(cartApi.removeItem(), {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf
              },
              body: JSON.stringify({ cart_key: id })
            });
          } catch (err) {
            console.error('remove error:', err);
          }
        }
      });
      return;
    }
  });

  // Event: Qty input change
  document.addEventListener('input', (e) => {
    if (e.target.matches('.item-qty')) {
      const id = e.target.dataset.itemId;
      let qty = parseInt(e.target.value) || 1;
      if (qty < 1) qty = 1;
      e.target.value = qty;

      const item = document.querySelector(`.cart-item[data-item-id="${id}"]`);
      if (item) {
        const price = parseFloat(item.dataset.price) || 0;
        const totalEl = item.querySelector('.item-total-price');
        if (totalEl) {
          totalEl.textContent = fmt(price * qty);
        }
      }

      recalcTotals();
      debouncedUpdate(id, qty);
    }
  });

  // Event: Checkbox change
  document.addEventListener('change', (e) => {
    if (e.target.matches('.item-checkbox')) {
      recalcTotals();
    }
  });

  // Event: Select all checkboxes
  [selectTop, selectBottom].forEach(sel => {
    if (sel) {
      sel.addEventListener('change', (ev) => {
        const checked = !!ev.target.checked;
        itemCheckboxes().forEach(cb => {
          cb.checked = checked;
        });
        
        // Sync both select-all checkboxes
        [selectTop, selectBottom].forEach(s => {
          if (s) {
            s.checked = checked;
            s.indeterminate = false;
          }
        });
        
        recalcTotals();
      });
    }
  });

  // Event: Checkout form submit
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', (ev) => {
      ev.preventDefault();

      const checkedBoxes = itemCheckboxes().filter(cb => cb.checked);
      if (!checkedBoxes.length) {
        toast('Pilih minimal 1 produk untuk checkout');
        return;
      }

      // Remove old inputs
      qsa('#checkout-form input[name^="items"]').forEach(i => i.remove());

      // Add selected items
      checkedBoxes.forEach(cb => {
        const id = cb.dataset.itemId;
        const item = document.querySelector(`.cart-item[data-item-id="${id}"]`);
        if (!item) return;
        
        const qtyEl = item.querySelector('.item-qty');
        const qty = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;

        const inputQty = document.createElement('input');
        inputQty.type = 'hidden';
        inputQty.name = `items[${id}][qty]`;
        inputQty.value = qty;
        checkoutForm.appendChild(inputQty);

        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `items[${id}][id]`;
        inputId.value = id;
        checkoutForm.appendChild(inputId);
      });

      const created = qsa('#checkout-form input[name^="items"]');
      if (!created.length) {
        toast('Tidak ada produk valid untuk checkout');
        return;
      }

      checkoutForm.submit();
    });
  }

  // Event: ESC to close modal
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (confirmModal && confirmModal.classList.contains('show')) {
        closeConfirm();
      }
    }
  });

  // Initial calculation
  recalcTotals();
});
</script>
@endsection