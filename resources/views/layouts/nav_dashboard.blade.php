{{-- navbar_blade.php (modern e-commerce style) --}}
<style>
/* ====== Modern E-commerce Navbar ====== */
.tk-nav {
  background: #fff;
  box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
  position: sticky;
  top: 0;
  z-index: 1600;
}

/* Top bar dengan info promo */
.tk-topbar {
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: #fff;
  padding: 8px 0;
  font-size: 13px;
  text-align: center;
}

.tk-topbar a {
  color: #fff;
  text-decoration: underline;
  margin-left: 6px;
}

.tk-container { 
  max-width: 1200px; 
  margin: 0 auto; 
  padding: 0 16px; 
}

.tk-row { 
  display: flex; 
  align-items: center; 
  gap: 16px; 
  padding: 12px 0;
}

/* LEFT - Logo */
.tk-left { 
  display: flex; 
  align-items: center;
  flex-shrink: 0;
}

.tk-logo img { 
  height: 32px; 
  display: block;
  transition: transform 0.2s;
}

.tk-logo:hover img {
  transform: scale(1.05);
}

/* CENTER - Search bar lebih prominent */
.tk-center { 
  flex: 1;
  max-width: 700px;
}

.tk-search { 
  position: relative;
  display: flex; 
  align-items: center; 
  background: #f5f5f5;
  border: 2px solid transparent;
  padding: 0;
  border-radius: 24px;
  overflow: visible;
  transition: all 0.3s;
}

.tk-search:focus-within {
  background: #fff;
  border-color: #7c3aed;
  box-shadow: 0 2px 8px rgba(124, 58, 237, 0.15);
}

.tk-search input { 
  border: 0; 
  outline: 0; 
  font-size: 13px; 
  width: 100%;
  padding: 10px 54px 10px 18px;
  background: transparent;
  border-radius: 24px;
}

.tk-search input::placeholder {
  color: #9ca3af;
}

.tk-search .search-icon {
  background: #7c3aed;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 0;
  transition: all 0.2s;
  flex-shrink: 0;
  position: absolute;
  right: 4px;
  top: 50%;
  transform: translateY(-50%);
}

.tk-search .search-icon:hover {
  background: #6d28d9;
  transform: translateY(-50%) scale(1.05);
}

.tk-search .search-icon svg {
  stroke: #fff;
}

/* Navigation menu - secondary bar */
.tk-navbar-secondary {
  border-top: 1px solid #f0f0f0;
  padding: 12px 0;
}

.tk-menu { 
  display: flex; 
  gap: 32px; 
  align-items: center;
}

.tk-menu a { 
  color: #374151; 
  text-decoration: none; 
  font-weight: 500;
  font-size: 14px;
  padding: 8px 0;
  position: relative;
  transition: color 0.2s;
}

.tk-menu a:hover,
.tk-menu a.active {
  color: #7c3aed;
}

.tk-menu a.active::after {
  content: '';
  position: absolute;
  bottom: -12px;
  left: 0;
  right: 0;
  height: 2px;
  background: #7c3aed;
}

/* RIGHT - Actions */
.tk-actions { 
  display: flex; 
  align-items: center; 
  gap: 8px;
  flex-shrink: 0;
}

.icon-btn { 
  display: inline-flex; 
  align-items: center; 
  justify-content: center; 
  width: 38px; 
  height: 38px; 
  border-radius: 10px;
  background: #fff;
  border: 1px solid #e5e7eb;
  cursor: pointer; 
  padding: 0;
  position: relative;
  transition: all 0.2s;
}

.icon-btn:hover { 
  background: #f9fafb;
  border-color: #7c3aed;
  box-shadow: 0 2px 8px rgba(124, 58, 237, 0.1);
}

.icon-btn:hover svg {
  stroke: #7c3aed;
}

.icon-btn svg { 
  width: 20px; 
  height: 20px;
  transition: stroke 0.2s;
}

.badge { 
  position: absolute;
  top: -4px;
  right: -4px;
  background: #ef4444;
  color: #fff; 
  font-size: 9px; 
  min-width: 16px; 
  height: 16px; 
  display: inline-flex; 
  align-items: center; 
  justify-content: center; 
  border-radius: 10px;
  padding: 0 4px; 
  font-weight: 700;
  border: 2px solid #fff;
}

.badge.hidden { 
  display: none !important; 
}

/* MINI CART - Premium Design */
.tk-mini-cart { 
  position: absolute; 
  right: 0; 
  margin-top: 8px; 
  width: 360px; 
  max-height: 520px; 
  background: #fff; 
  border-radius: 14px;
  box-shadow: 0 12px 48px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05);
  overflow: hidden; 
  z-index: 9999;
  display: none;
  animation: slideDown 0.2s ease-out;
}

.tk-mini-cart.show {
  display: block;
}

/* Prevent body scroll when cart open on mobile */
@media (max-width: 768px) {
  body.cart-open {
    overflow: hidden;
  }
  
  .tk-mini-cart.show {
    position: fixed;
    right: 0;
    left: auto;
    top: 60px;
    margin: 0;
    width: 100vw;
    max-width: 400px;
    max-height: calc(100vh - 70px);
    border-top-right-radius: 0;
  }
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.tk-mini-head { 
  padding: 14px 16px; 
  display: flex; 
  gap: 8px; 
  align-items: center; 
  justify-content: space-between; 
  border-bottom: 1px solid #e5e7eb;
  background: linear-gradient(180deg, #fafafa 0%, #f5f5f5 100%);
}

.tk-mini-head .title { 
  display: flex; 
  gap: 8px; 
  align-items: center; 
  font-weight: 700;
  color: #111827; 
  font-size: 14px;
}

.tk-mini-head .title svg {
  stroke: #7c3aed;
  width: 18px;
  height: 18px;
}

.tk-mini-head .summary { 
  font-size: 11px; 
  color: #6b7280;
  font-weight: 600;
}

/* Cart body */
.tk-mini-body { 
  max-height: 340px; 
  overflow-y: auto; 
  padding: 10px;
  background: #f9fafb;
}

.tk-mini-body::-webkit-scrollbar {
  width: 4px;
}

.tk-mini-body::-webkit-scrollbar-track {
  background: transparent;
}

.tk-mini-body::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 4px;
}

.tk-mini-body::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}

/* Mini cart item - Premium card design */
.tk-mini-item { 
  display: grid; 
  grid-template-columns: 24px 56px 1fr 80px; 
  gap: 10px; 
  align-items: start;
  padding: 12px; 
  border-radius: 10px;
  margin-bottom: 8px;
  background: #fff;
  border: 1px solid #e5e7eb;
  transition: all 0.2s;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.tk-mini-item:hover {
  border-color: #d1d5db;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transform: translateY(-1px);
}

.item-checkbox { 
  width: 14px; 
  height: 14px;
  cursor: pointer;
  accent-color: #7c3aed;
  border-radius: 4px;
  margin: 0;
  align-self: center;
}

/* Thumbnail - Lebih kecil */
.tk-mini-thumb { 
  width: 56px; 
  height: 56px; 
  border-radius: 8px;
  overflow: hidden; 
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  display: flex; 
  align-items: center; 
  justify-content: center;
  flex-shrink: 0;
}

.tk-mini-thumb img { 
  width: 100%; 
  height: 100%; 
  object-fit: cover;
}

/* Meta info - Typography improvement */
.tk-mini-meta { 
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.tk-mini-title { 
  font-weight: 600;
  font-size: 12px;
  color: #111827;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  line-height: 1.3;
  word-break: break-word;
}

.tk-mini-sub { 
  font-size: 10px; 
  color: #6b7280;
  display: flex;
  flex-direction: column;
  gap: 3px;
}

.tk-mini-variant { 
  font-size: 9px; 
  color: #7c3aed;
  background: #f3e8ff;
  padding: 2px 6px; 
  border-radius: 4px;
  display: inline-block;
  width: fit-content;
  font-weight: 600;
}

/* Quantity controls - Compact & Modern */
.tk-mini-controls { 
  display: flex; 
  gap: 5px; 
  align-items: center;
  margin-top: 5px;
}

.qty-btn { 
  width: 24px; 
  height: 24px; 
  border-radius: 5px;
  border: 1px solid #e5e7eb;
  background: #fff;
  cursor: pointer; 
  display: inline-flex; 
  align-items: center; 
  justify-content: center; 
  font-size: 13px;
  font-weight: 600;
  color: #6b7280;
  transition: all 0.2s;
}

.qty-btn:hover {
  background: #f9fafb;
  border-color: #7c3aed;
  color: #7c3aed;
}

.qty-input { 
  width: 36px; 
  padding: 3px; 
  border-radius: 5px;
  border: 1px solid #e5e7eb;
  text-align: center;
  font-size: 11px;
  font-weight: 600;
  color: #111827;
}

/* Right side - Price & Delete - FIXED */
.item-right { 
  display: flex; 
  flex-direction: column; 
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-width: 80px;
  height: 100%;
}

.item-total { 
  font-weight: 700;
  color: #7c3aed;
  font-size: 12px;
  white-space: nowrap;
  text-align: center;
  width: 100%;
}

.btn-trash { 
  background: #fef2f2;
  border: 1px solid #fee2e2;
  cursor: pointer; 
  padding: 6px 8px;
  border-radius: 6px;
  display: inline-flex; 
  align-items: center; 
  justify-content: center;
  transition: all 0.2s;
  width: fit-content;
}

.btn-trash:hover { 
  background: #fee2e2;
  border-color: #fecaca;
  transform: scale(1.05);
}

.btn-trash svg {
  width: 14px;
  height: 14px;
}

/* Bulk actions */
.mini-body-top { 
  display: flex; 
  justify-content: space-between; 
  align-items: center; 
  padding: 0 4px 8px;
  border-bottom: 1px solid #e5e7eb;
  margin-bottom: 8px;
}

.mini-body-top label {
  font-size: 11px;
  color: #6b7280;
  font-weight: 500;
  cursor: pointer;
}

.btn-delete-bulk {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 10px;
  font-size: 11px;
  border-radius: 6px;
  border: 1px solid #fee2e2;
  background: #fff;
  color: #ef4444;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-delete-bulk:hover {
  background: #fef2f2;
  border-color: #fecaca;
}

.btn-delete-bulk svg {
  flex-shrink: 0;
}

.btn-delete-bulk span {
  line-height: 1;
}

/* Empty state */
.tk-mini-empty { 
  padding: 48px 24px;
  text-align: center; 
  color: #9ca3af;
  display: flex; 
  flex-direction: column; 
  gap: 12px; 
  align-items: center;
}

.tk-mini-empty svg {
  opacity: 0.5;
}

/* Footer - Compact */
.tk-mini-footer { 
  padding: 12px 16px;
  border-top: 1px solid #e5e7eb;
  background: linear-gradient(180deg, #fff 0%, #fafafa 100%);
  display: flex; 
  flex-direction: column; 
  gap: 10px;
}

.tk-mini-totals { 
  display: flex; 
  justify-content: space-between; 
  align-items: center;
}

.tk-mini-totals .label { 
  color: #6b7280;
  font-size: 12px;
  font-weight: 600;
}

.tk-mini-totals .amount { 
  font-weight: 800;
  font-size: 16px; 
  color: #7c3aed;
}

.tk-actions-row { 
  display: flex; 
  gap: 6px;
}

.btn-ghost { 
  padding: 10px 14px;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  background: #fff;
  color: #374151;
  text-decoration: none; 
  font-weight: 600;
  flex: 1; 
  text-align: center;
  font-size: 12px;
  transition: all 0.2s;
}

.btn-ghost:hover {
  background: #f9fafb;
  border-color: #7c3aed;
  color: #7c3aed;
}

.btn-primary { 
  padding: 10px 14px;
  border-radius: 8px;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: #fff; 
  font-weight: 700;
  text-decoration: none; 
  flex: 1; 
  text-align: center;
  font-size: 12px;
  box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);
  transition: all 0.2s;
  border: 0;
  cursor: pointer;
}

.btn-primary:hover {
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
  transform: translateY(-1px);
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}
/* Profile Photo Button - Paling Kanan */
.tk-profile-btn-photo {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  border: 2px solid #e5e7eb;
  background: #fff;
  cursor: pointer;
  padding: 0;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.tk-profile-btn-photo:hover {
  border-color: #7c3aed;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
  transform: translateY(-1px);
}

.profile-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.profile-photo-placeholder {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px;
}

/* Profile */
.tk-profile-btn { 
  display: inline-flex; 
  align-items: center; 
  gap: 0;
  padding: 4px 12px 4px 4px;
  border-radius: 24px;
  cursor: pointer; 
  border: 1px solid #e5e7eb;
  background: #fff;
  transition: all 0.2s;
  max-width: 220px;
}

.tk-profile-btn:hover {
  background: #f9fafb;
  border-color: #d1d5db;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.tk-avatar { 
  width: 36px; 
  height: 36px; 
  border-radius: 50%;
  overflow: hidden; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  font-weight: 700;
  color: #fff;
  font-size: 14px;
}

.tk-avatar img { 
  width: 100%; 
  height: 100%; 
  object-fit: cover;
}

.tk-profile-dropdown { 
  position: absolute; 
  right: 0;
  margin-top: 12px; 
  min-width: 280px; 
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.12);
  overflow: hidden; 
  z-index: 1500; 
  display: none;
  animation: slideDown 0.2s ease-out;
}

.tk-profile-dropdown.show { 
  display: block; 
}

.tk-profile-top { 
  padding: 20px;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.tk-profile-top .tk-avatar {
  background: #fff;
  color: #7c3aed;
}

.tk-profile-top > div > div:first-child {
  color: #fff;
  font-weight: 700;
  font-size: 16px;
}

.tk-profile-top .text-muted {
  color: rgba(255,255,255,0.8);
  font-size: 13px;
}

.text-muted {
  color: #9ca3af;
  font-size: 12px;
}

.tk-profile-link { 
  display: block; 
  padding: 12px 16px;
  text-decoration: none; 
  color: #374151;
  font-size: 14px;
  transition: background 0.2s;
  border: 0;
  width: 100%;
  text-align: left;
  background: transparent;
  cursor: pointer;
}

.tk-profile-link:hover {
  background: #f9fafb;
}

/* Guest actions */
.guest-actions { 
  display: flex; 
  gap: 12px; 
  align-items: center;
}

.guest-actions .btn-ghost {
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  border: 1px solid #e5e7eb;
  background: #fff;
  transition: all 0.2s;
}

.guest-actions .btn-ghost:hover {
  background: #f9fafb;
  border-color: #7c3aed;
  color: #7c3aed;
}

.btn-login-pill { 
  padding: 10px 24px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 14px;
  box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);
}

/* Confirm modal */
#tk-confirm-modal { 
  position: fixed; 
  inset: 0; 
  display: none; 
  align-items: center; 
  justify-content: center; 
  z-index: 99999;
}

#tk-confirm-modal.show { 
  display: flex; 
}

.tk-confirm-backdrop { 
  position: absolute; 
  inset: 0; 
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(4px);
}

.tk-confirm-box { 
  position: relative; 
  z-index: 3; 
  width: 400px; 
  max-width: 90%;
  background: #fff;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  animation: modalFadeIn 0.2s ease-out;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.tk-confirm-title { 
  font-weight: 700;
  font-size: 18px;
  margin-bottom: 12px; 
  color: #111827;
}

.tk-confirm-msg { 
  color: #6b7280;
  margin-bottom: 20px;
  line-height: 1.5;
  font-size: 14px;
}

.tk-confirm-actions { 
  display: flex; 
  gap: 8px; 
  justify-content: flex-end;
}

/* Responsive */
@media (max-width: 1024px) {
  .tk-menu { 
    gap: 20px;
  }
  
  .tk-center {
    max-width: 500px;
  }
  
  .tk-search input {
    font-size: 12px;
    padding: 9px 12px;
  }
}

@media (max-width: 768px) {
  .tk-navbar-secondary {
    display: none;
  }
  
  .tk-topbar {
    font-size: 11px;
    padding: 6px 0;
  }
  
  .tk-container {
    padding: 0 12px;
  }
  
  .tk-row {
    padding: 10px 0;
    gap: 10px;
  }
  
  .tk-logo img {
    height: 28px;
  }
  
  .tk-center {
    flex: 1;
    max-width: none;
  }
  
  .tk-search {
    min-width: auto;
  }
  
  .tk-search input {
    font-size: 12px;
    padding: 8px 48px 8px 16px;
    min-width: 150px;
  }
  
  .tk-search .search-icon {
    width: 38px;
    height: 38px;
    right: 3px;
  }
  
  .tk-search .search-icon svg {
    width: 18px;
    height: 18px;
  }
  
  .icon-btn {
    width: 36px;
    height: 36px;
  }
  
  .icon-btn svg {
    width: 18px;
    height: 18px;
  }
  
  .tk-profile-btn-photo {
    width: 36px;
    height: 36px;
  }
  
  .profile-photo-placeholder {
    font-size: 13px;
  }
  
  /* Mini Cart Fixes for Tablet */
  .tk-mini-cart {
    right: 10px;
    left: auto;
    width: 380px;
    max-width: calc(100vw - 20px);
  }
  
  .guest-actions .btn-ghost {
    display: none;
  }
  
}

@media (max-width: 480px) {
  .tk-topbar {
    font-size: 10px;
    padding: 5px 0;
  }
  
  .tk-topbar a {
    display: block;
    margin: 2px 0 0 0;
  }
  
  .tk-container {
    padding: 0 10px;
  }
  
  .tk-row {
    padding: 8px 0;
    gap: 8px;
  }
  
  .tk-logo img {
    height: 24px;
  }
  
  .tk-search input {
    font-size: 11px;
    padding: 7px 42px 7px 14px;
    min-width: 120px;
  }
  
  .tk-search .search-icon {
    width: 34px;
    height: 34px;
    right: 2px;
  }
  
  .tk-search .search-icon svg {
    width: 16px;
    height: 16px;
  }
  
  .tk-actions {
    gap: 6px;
  }
  
  .icon-btn {
    width: 32px;
    height: 32px;
  }
  
  .icon-btn svg {
    width: 16px;
    height: 16px;
  }
  
  .badge {
    min-width: 14px;
    height: 14px;
    font-size: 8px;
    top: -3px;
    right: -3px;
  }
  
  .tk-profile-btn-photo {
    width: 32px;
    height: 32px;
  }
  
  .profile-photo-placeholder {
    font-size: 12px;
  }
  
  .btn-login-pill {
    padding: 7px 16px;
    font-size: 11px;
  }
}
    padding: 12px;
  }
  
  .tk-mini-head .title {
    font-size: 12px;
    gap: 6px;
  }
  
  .tk-mini-head .title svg {
    width: 16px;
    height: 16px;
  }
  
  .tk-mini-head .summary {
    font-size: 10px;
  }
  
  .tk-mini-body {
    padding: 10px;
    max-height: 320px;
  }
  
  /* MOBILE ITEM LAYOUT - 2 ROW GRID SYSTEM */
  .tk-mini-item {
    display: grid;
    grid-template-columns: 16px 56px 1fr;
    grid-template-rows: auto auto;
    gap: 8px 10px;
    padding: 10px;
    align-items: start;
  }
  
  /* Checkbox - Column 1, Row 1 */
  .item-checkbox {
    width: 13px;
    height: 13px;
    grid-column: 1;
    grid-row: 1;
    align-self: center;
  }
  
  /* Thumbnail - Column 2, Span 2 rows */
  .tk-mini-thumb {
    width: 56px;
    height: 56px;
    border-radius: 6px;
    grid-column: 2;
    grid-row: 1 / 3;
  }
  
  /* Product Info - Column 3, Row 1 */
  .tk-mini-meta {
    grid-column: 3;
    grid-row: 1;
    gap: 4px;
    min-width: 0;
  }
  
  .tk-mini-title {
    font-size: 11px;
    line-height: 1.3;
  }
  
  .tk-mini-sub {
    font-size: 9px;
  }
  
  .tk-mini-sub > div {
    font-size: 10px !important;
  }
  
  .tk-mini-variant {
    font-size: 8px;
    padding: 2px 5px;
  }
  
  .tk-mini-controls {
    gap: 4px;
    margin-top: 4px;
  }
  
  .qty-btn {
    width: 22px;
    height: 22px;
    font-size: 12px;
  }
  
  .qty-input {
    width: 32px;
    font-size: 10px;
  }
  
  /* Price & Delete - Column 3, Row 2 */
  .item-right {
    grid-column: 3;
    grid-row: 2;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-top: 2px;
  }
  
  .item-total {
    font-size: 11px;
    font-weight: 700;
    flex: 1;
    text-align: left;
  }
  
  .btn-trash {
    padding: 5px 7px;
    background: #fef2f2;
    border: 1px solid #fee2e2;
    border-radius: 5px;
    flex-shrink: 0;
  }
  
  .btn-trash svg {
    width: 12px;
    height: 12px;
  }
  
  .mini-body-top {
    padding: 0 4px 8px;
    margin-bottom: 8px;
  }
  
  .mini-body-top label {
    font-size: 10px;
  }
  
  .btn-delete-bulk {
    padding: 4px 8px;
    font-size: 9px;
    gap: 4px;
    border-radius: 5px;
  }
  
  .btn-delete-bulk svg {
    width: 11px;
    height: 11px;
  }
  
  .tk-mini-footer {
    padding: 12px;
    gap: 10px;
  }
  
  .tk-mini-footer > div:first-child {
    padding: 6px 0;
    margin-bottom: 8px;
  }
  
  .tk-mini-footer > div:first-child > div {
    font-size: 10px;
    gap: 4px;
  }
  
  .tk-mini-footer > div:first-child svg {
    width: 12px;
    height: 12px;
  }
  
  .tk-mini-totals .label {
    font-size: 11px;
  }
  
  .tk-mini-totals .amount {
    font-size: 15px;
  }
  
  .tk-actions-row {
    gap: 6px;
  }
  
  .btn-ghost,
  .btn-primary {
    padding: 10px 12px;
    font-size: 11px;
    border-radius: 6px;
  }
  
  .btn-login-pill {
    padding: 7px 16px;
    font-size: 11px;
  }
}

@media (max-width: 360px) {
  .tk-logo img {
    height: 22px;
  }
  
  .tk-search input {
    min-width: 100px;
    font-size: 10px;
    padding: 6px 38px 6px 12px;
  }
  
  .tk-search .search-icon {
    width: 30px;
    height: 30px;
    right: 2px;
  }
  
  .tk-search .search-icon svg {
    width: 14px;
    height: 14px;
  }
  
  .tk-actions {
    gap: 4px;
  }
  
  .icon-btn {
    width: 30px;
    height: 30px;
  }
  
  .icon-btn svg {
    width: 15px;
    height: 15px;
  }
  
  .tk-profile-btn-photo {
    width: 30px;
    height: 30px;
  }
  
  .tk-mini-head {
    padding: 10px;
  }
  
  .tk-mini-head .title {
    font-size: 11px;
  }
  
  .tk-mini-body {
    padding: 8px;
  }
  
  .tk-mini-item {
    grid-template-columns: 14px 48px 1fr;
    gap: 6px;
    padding: 8px;
  }
  
  .item-checkbox {
    width: 12px;
    height: 12px;
  }
  
  .tk-mini-thumb {
    width: 48px;
    height: 48px;
  }
  
  .tk-mini-title {
    font-size: 10px;
  }
  
  .tk-mini-sub {
    font-size: 8px;
  }
  
  .tk-mini-sub > div {
    font-size: 9px !important;
  }
  
  .qty-btn {
    width: 20px;
    height: 20px;
    font-size: 11px;
  }
  
  .qty-input {
    width: 28px;
    font-size: 9px;
  }
  
  .item-total {
    font-size: 10px;
  }
  
  .btn-trash svg {
    width: 12px;
    height: 12px;
  }
  
  .tk-mini-footer {
    padding: 10px;
  }
  
  .tk-mini-totals .amount {
    font-size: 14px;
  }
  
  .btn-ghost,
  .btn-primary {
    padding: 9px 10px;
    font-size: 10px;
  }
}
</style>

{{-- Top promotional bar --}}
<div class="tk-topbar">
  <div class="tk-container">
    🎉 Promo Spesial! Gratis Ongkir Min. Belanja Rp 50.000
    <a href="{{ route('shop.index') }}">Belanja Sekarang →</a>
  </div>
</div>

<nav class="tk-nav" aria-label="Main nav">
  <div class="tk-container">
    <div class="tk-row">

      {{-- LEFT - Logo --}}
      <div class="tk-left" style="margin-left:0;">
        <a class="tk-logo" href="{{ route('dashboard') }}" aria-label="Home">
          <img src="{{ asset('images/logo/logo_tokoriza.png') }}" alt="Logo">
        </a>
      </div>

      {{-- CENTER - Search --}}
      <div class="tk-center">
        <form class="tk-search" role="search" action="{{ route('shop.index') }}" method="GET" aria-label="Search products">
          <input type="search" name="q" placeholder="Cari produk, kategori atau brand..." value="{{ request('q') }}" aria-label="Search products">
          <button type="submit" class="search-icon" aria-label="Search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" aria-hidden="true">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="M21 21l-4.35-4.35"></path>
            </svg>
          </button>
        </form>
      </div>

      {{-- RIGHT - Orders, Cart, Auth --}}
      <div class="tk-actions" style="margin-left:auto;margin-right:0;">

        @php
          $cart = session('cart', []);
          $cartCount = collect($cart)->sum('qty');
          $cartTotal = collect($cart)->reduce(fn($c,$i)=> $c + ($i['price']*$i['qty']), 0);
        @endphp

        {{-- ORDERS/PESANAN (hanya untuk user login) --}}
        @auth
          <a href="{{ route('orders.index') }}" class="icon-btn" title="Pesanan Saya" style="position:relative;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
              <path d="M3 9h18"></path>
              <path d="M9 21V9"></path>
            </svg>
          </a>
        @endauth

        {{-- CART --}}
        <div style="position:relative;">
          <button id="tk-cart-btn" class="icon-btn" aria-haspopup="true" aria-expanded="false" title="Keranjang">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
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
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Keranjang Belanja
              </div>
              <div class="summary" id="tk-mini-count">
                @if($cartCount>0){{ $cartCount }} produk @else Kosong @endif
              </div>
            </div>

            @if($cartCount === 0)
              <div class="tk-mini-body">
                <div class="tk-mini-empty">
                  <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  <div style="font-weight:600;color:#111827;font-size:15px;">Keranjang Belanja Kosong</div>
                  <div style="font-size:13px;color:#6b7280;">Yuk, mulai belanja sekarang!</div>
                  <a href="{{ route('shop.index') }}" class="btn-primary" style="margin-top:8px;display:inline-block;">Belanja Sekarang</a>
                </div>
              </div>
            @else
              <div class="tk-mini-body" id="tk-mini-body">
                <div class="mini-body-top">
                  <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" id="tk-select-all" title="Pilih semua" />
                    <label for="tk-select-all">Pilih Semua</label>
                  </div>
                  <div class="bulk-actions" style="display:flex;gap:8px;align-items:center;">
                    <button id="tk-delete-selected" class="btn-delete-bulk" type="button" title="Hapus Terpilih">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                      </svg>
                      <span>Hapus</span>
                    </button>
                  </div>
                </div>

                <div id="tk-mini-items">
                  @foreach($cart as $loopIndex => $item)
                    @php $id = $item['id'] ?? $loopIndex; @endphp
                    <div class="tk-mini-item" data-item-id="{{ $id }}" data-price="{{ $item['price'] ?? 0 }}">
                      {{-- Checkbox --}}
                      <input type="checkbox" class="item-checkbox" data-item-id="{{ $id }}" title="Pilih item">

                      {{-- Thumbnail --}}
                      <div class="tk-mini-thumb">
                        @if(!empty($item['image']))
                          <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                        @else
                          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                          </svg>
                        @endif
                      </div>

                      {{-- Meta --}}
                      <div class="tk-mini-meta">
                        <div class="tk-mini-title">{{ $item['name'] }}</div>
                        <div class="tk-mini-sub">
                          @if(!empty($item['variant']))
                            <span class="tk-mini-variant">{{ $item['variant'] }}</span>
                          @endif
                          <div style="font-weight:600;color:#374151;font-size:10px;">Rp {{ number_format($item['price'],0,',','.') }}</div>
                        </div>

                        <div class="tk-mini-controls">
                          <button class="qty-btn btn-decrease" type="button" data-item-id="{{ $id }}">−</button>
                          <input type="number" min="1" class="qty-input item-qty" data-item-id="{{ $id }}" value="{{ $item['qty'] }}">
                          <button class="qty-btn btn-increase" type="button" data-item-id="{{ $id }}">+</button>
                        </div>
                      </div>

                      {{-- Right: Price & Delete --}}
                      <div class="item-right">
                        <div class="item-total">Rp {{ number_format(($item['price']*$item['qty']),0,',','.') }}</div>

                        <button class="btn-trash btn-remove-single" data-remove-id="{{ $id }}" title="Hapus">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                          </svg>
                        </button>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="tk-mini-footer">
                <div style="padding:8px 0;border-bottom:1px solid #f0f0f0;margin-bottom:12px;">
                  <div style="font-size:12px;color:#6b7280;display:flex;align-items:center;gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="12" y1="16" x2="12" y2="12"></line>
                      <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Pilih produk yang ingin di-checkout
                  </div>
                </div>
                
                <div class="tk-mini-totals">
                  <div class="label">Total Terpilih</div>
                  <div class="amount" id="tk-mini-total">Rp 0</div>
                </div>

                <div class="tk-actions-row">
                  <a href="{{ route('shop.cart') }}" id="tk-view-cart" class="btn-ghost">Lihat Keranjang</a>
                  <button type="button" id="tk-checkout-btn" class="btn-primary" disabled style="opacity:0.5;cursor:not-allowed;">Checkout</button>
                </div>
              </div>
            @endif
          </div>
        </div>

        {{-- PROFILE/AUTH - PALING KANAN --}}
        @auth
          <div style="position:relative;">
            <button id="tk-profile-btn" class="tk-profile-btn-photo" aria-haspopup="true" aria-expanded="false" title="Akun Saya">
              @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/profile/'.Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="profile-photo">
              @else
                <div class="profile-photo-placeholder">{{ strtoupper(mb_substr(Auth::user()->name,0,1,'UTF-8')) }}</div>
              @endif
            </button>

            <div id="tk-profile-dropdown" class="tk-profile-dropdown" aria-hidden="true">
              <div class="tk-profile-top">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                  @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/profile/'.Auth::user()->profile_photo) }}" alt="avatar" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                  @else
                    <div style="width:48px;height:48px;border-radius:50%;background:#fff;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;">
                      {{ strtoupper(mb_substr(Auth::user()->name,0,1,'UTF-8')) }}
                    </div>
                  @endif
                  <div>
                    <div style="font-weight:700;color:#fff;">{{ Auth::user()->name }}</div>
                    <div style="margin-top:2px;color:rgba(255,255,255,0.8);font-size:13px;">{{ Auth::user()->email }}</div>
                  </div>
                </div>
              </div>

              <a class="tk-profile-link" href="{{ route('profile.edit') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:8px;vertical-align:middle;">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Profil Saya
              </a>
              
              <div style="border-top:1px solid #f0f0f0;margin:8px 0;"></div>
              
              <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="tk-profile-link" style="color:#dc2626;">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:8px;vertical-align:middle;">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>
                  Keluar
                </button>
              </form>
            </div>
          </div>
        @else
          {{-- GUEST ACTIONS --}}
          <div class="guest-actions">
            <a href="{{ route('login') }}" class="btn-ghost" style="padding:10px 20px;">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary btn-login-pill">Daftar</a>
          </div>
        @endauth

      </div>
    </div>
  </div>

  {{-- Secondary Navigation --}}
  <div class="tk-navbar-secondary">
    <div class="tk-container">
      <div class="tk-menu" role="navigation" aria-label="Primary">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:6px;vertical-align:middle;">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          </svg>
          Home
        </a>
        <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.index') ? 'active' : '' }}">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:6px;vertical-align:middle;">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          Produk
        </a>
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:6px;vertical-align:middle;">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
          </svg>
          Pesanan
        </a>
      </div>
    </div>
  </div>
</nav>

{{-- CONFIRMATION MODAL --}}
<div id="tk-confirm-modal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="tk-confirm-backdrop" data-close-modal></div>
  <div class="tk-confirm-box" role="document" aria-labelledby="tk-confirm-title">
    <div class="tk-confirm-title" id="tk-confirm-title">Konfirmasi</div>
    <div class="tk-confirm-msg" id="tk-confirm-msg">Apakah Anda yakin?</div>
    <div class="tk-confirm-actions">
      <button id="tk-confirm-cancel" class="btn-ghost" type="button">Batal</button>
      <button id="tk-confirm-ok" class="btn-primary" type="button">Ya, Hapus</button>
    </div>
  </div>
</div>

{{-- JS (SISTEM TETAP SAMA) --}}
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
    updateQty: () => `/keranjang/item`,
    removeItem: () => `/keranjang/item`,
  };

  function fmt(n){ return 'Rp ' + (Number(n)||0).toLocaleString('id-ID'); }

  function toast(msg, ms=2000){
    const d = document.createElement('div');
    d.textContent = msg;
    Object.assign(d.style, {position:'fixed', right:'18px', bottom:'18px', background:'#111827', color:'#fff', padding:'12px 20px', borderRadius:'8px', zIndex:99999, boxShadow:'0 4px 12px rgba(0,0,0,0.15)', fontWeight:'500', fontSize:'14px'});
    document.body.appendChild(d);
    setTimeout(()=> d.remove(), ms);
  }

  // recalc totals and badge
  function recalcTotals(){
    const items = qsa('.tk-mini-item');
    let selectedTotal = 0;
    let totalCount = 0;
    
    items.forEach(it => {
      const price = parseFloat(it.dataset.price) || 0;
      const qtyEl = it.querySelector('.item-qty');
      const qty = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;
      const checkbox = it.querySelector('.item-checkbox');
      const isChecked = checkbox ? checkbox.checked : false;
      
      // Total count untuk badge (semua item)
      totalCount += qty;
      
      // Total harga hanya untuk yang tercentang
      if (isChecked) {
        selectedTotal += price * qty;
      }
      
      // Update individual item total display
      const totalEl = it.querySelector('.item-total');
      if (totalEl) totalEl.textContent = fmt(price * qty);
    });

    // Update display total (hanya yang tercentang)
    if (miniTotal) {
      miniTotal.textContent = fmt(selectedTotal);
    }

    // Update badge
    if (cartBadge) {
      if (totalCount > 0) {
        cartBadge.classList.remove('hidden');
        cartBadge.textContent = totalCount;
        cartBadge.setAttribute('aria-hidden','false');
      } else {
        cartBadge.classList.add('hidden');
        cartBadge.textContent = '';
        cartBadge.setAttribute('aria-hidden','true');
      }
    }
    
    // Update mini count
    if (miniCount) miniCount.textContent = totalCount > 0 ? `${totalCount} produk` : 'Kosong';

    updateSelectAllState();
  }

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
    
    // Update checkout button state
    updateCheckoutButton();
  }

  function updateCheckoutButton() {
    const checkoutBtn = qs('#tk-checkout-btn');
    if (!checkoutBtn) return;
    
    const checkedBoxes = qsa('.item-checkbox:checked');
    
    console.log('Checked items:', checkedBoxes.length); // Debug
    
    if (checkedBoxes.length > 0) {
      checkoutBtn.disabled = false;
      checkoutBtn.style.opacity = '1';
      checkoutBtn.style.cursor = 'pointer';
      checkoutBtn.style.pointerEvents = 'auto';
    } else {
      checkoutBtn.disabled = true;
      checkoutBtn.style.opacity = '0.5';
      checkoutBtn.style.cursor = 'not-allowed';
      checkoutBtn.style.pointerEvents = 'none';
    }
  }

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
      
      // Add/remove body class for mobile overflow control
      if (window.innerWidth <= 768) {
        if (open) {
          document.body.classList.add('cart-open');
        } else {
          document.body.classList.remove('cart-open');
        }
      }
      
      updateSelectAllState();
    });
    document.addEventListener('click', e => {
      if (!miniCart.contains(e.target) && !cartBtn.contains(e.target)) {
        miniCart.classList.remove('show');
        cartBtn.setAttribute('aria-expanded','false');
        document.body.classList.remove('cart-open');
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
        await fetch(cartApi.updateQty(), {
          method: 'PATCH',
          headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf},
          body: JSON.stringify({cart_key: id, qty})
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
        await fetch(cartApi.updateQty(), {
          method: 'PATCH',
          headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN': csrf},
          body: JSON.stringify({cart_key: id, qty})
        });
      } catch(err){ console.error('update err', err); toast('Gagal memperbarui jumlah'); }
      return;
    }
  });

  // Checkbox change - untuk update total dan button state
  document.addEventListener('click', (e) => {
    if (e.target.matches('.item-checkbox') || e.target.matches('#tk-select-all')) {
      // Beri sedikit delay agar checkbox state sudah berubah
      setTimeout(() => {
        recalcTotals();
        updateCheckoutButton();
      }, 10);
    }
  });

  // single remove via trash: open confirm -> DELETE request -> remove element
  document.addEventListener('click', (e) => {
    const removeBtn = e.target.closest('.btn-remove-single');
    if (!removeBtn) return;
    const id = removeBtn.dataset.removeId;
    if (!id) return;

    openConfirm({
      title: 'Hapus produk ini?',
      msg: 'Produk akan dihapus dari keranjang belanja Anda.',
      action: async () => {
        try {
          const response = await fetch(cartApi.removeItem(), {
            method: 'DELETE',
            headers: {
              'Content-Type':'application/json',
              'X-Requested-With':'XMLHttpRequest',
              'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({cart_key: id})
          });
          
          if (response.ok) {
            const node = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
            if (node) node.remove();
            recalcTotals();
            toast('Produk berhasil dihapus');
            updateSelectAllState();
          } else {
            toast('Gagal menghapus produk');
          }
        } catch(err){
          console.error('remove err', err);
          toast('Gagal menghapus produk');
        }
      }
    });
  });

  // select-all toggles individual checkboxes
  if (selectAll) {
    selectAll.addEventListener('click', (e) => {
      const checked = e.target.checked;
      qsa('.item-checkbox').forEach(cb => {
        cb.checked = checked;
      });
      
      // Update after checkbox changes
      setTimeout(() => {
        selectAll.indeterminate = false;
        recalcTotals();
        updateCheckoutButton();
      }, 10);
    });
  }

  // checkout button - kirim selected items ke checkout controller
  const checkoutBtnEl = qs('#tk-checkout-btn');
  if (checkoutBtnEl) {
    checkoutBtnEl.addEventListener('click', async (e) => {
      e.preventDefault();
      
      const checkedBoxes = qsa('.item-checkbox:checked');
      const selectedIds = checkedBoxes.map(cb => cb.dataset.itemId).filter(Boolean);
      
      console.log('Checkout clicked, selected:', selectedIds); // Debug
      
      if (selectedIds.length === 0) {
        toast('Pilih produk yang ingin di-checkout');
        return;
      }
      
      // Ambil cart dari session untuk mendapatkan qty
      const cart = qsa('.tk-mini-item');
      const items = [];
      
      checkedBoxes.forEach(checkbox => {
        const itemId = checkbox.dataset.itemId;
        const itemEl = document.querySelector(`.tk-mini-item[data-item-id="${itemId}"]`);
        if (itemEl) {
          const qtyInput = itemEl.querySelector('.item-qty');
          const qty = qtyInput ? parseInt(qtyInput.value) : 1;
          items.push({ id: itemId, qty: qty });
        }
      });
      
      console.log('Sending items:', items); // Debug
      
      // Kirim ke checkout.start
      try {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/checkout/start';
        
        // CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);
        
        // Items data
        items.forEach((item, index) => {
          const idInput = document.createElement('input');
          idInput.type = 'hidden';
          idInput.name = `items[${index}][id]`;
          idInput.value = item.id;
          form.appendChild(idInput);
          
          const qtyInput = document.createElement('input');
          qtyInput.type = 'hidden';
          qtyInput.name = `items[${index}][qty]`;
          qtyInput.value = item.qty;
          form.appendChild(qtyInput);
        });
        
        document.body.appendChild(form);
        form.submit();
        
      } catch (err) {
        console.error('Checkout error:', err);
        toast('Terjadi kesalahan, silakan coba lagi');
      }
    });
  }

  // bulk delete: gather checked .item-checkbox:checked
  if (deleteSelectedBtn) {
    deleteSelectedBtn.addEventListener('click', () => {
      const checkedBoxes = qsa('.item-checkbox:checked');
      const ids = checkedBoxes.map(cb => cb.dataset.itemId).filter(Boolean);
      if (!ids.length) { toast('Pilih produk yang ingin dihapus'); return; }

      openConfirm({
        title: `Hapus ${ids.length} produk?`,
        msg: `${ids.length} produk akan dihapus dari keranjang belanja Anda.`,
        action: async () => {
          try {
            await Promise.all(ids.map(id =>
              fetch(cartApi.removeItem(), {
                method: 'DELETE',
                headers: {
                  'Content-Type':'application/json',
                  'X-Requested-With':'XMLHttpRequest',
                  'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({cart_key: id})
              })
            ));

            ids.forEach(id => {
              const node = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
              if (node) node.remove();
            });
            
            recalcTotals();
            toast('Produk terpilih berhasil dihapus');
            updateSelectAllState();
          } catch(err){
            console.error('bulk remove err', err);
            toast('Gagal menghapus beberapa produk');
          }
        }
      });
    });
  }

  // init
  recalcTotals();
  updateCheckoutButton(); // Init button state

  // close on Esc
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (confirmModal && confirmModal.classList.contains('show')) closeConfirm();
      if (miniCart) {
        miniCart.classList.remove('show');
        document.body.classList.remove('cart-open');
      }
      if (profileDrop) profileDrop.classList.remove('show');
    }
  });

  window.tk_closeConfirm = closeConfirm;

})();
</script>