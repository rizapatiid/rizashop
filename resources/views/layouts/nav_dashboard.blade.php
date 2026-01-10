<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TokoRiza Seller Center</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ====== Tokopedia/Shopee Compact Navbar ====== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.tk-nav {
  background: #fff;
  box-shadow: 0 1px 2px rgba(0,0,0,0.08);
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  position: sticky;
  top: 0;
  z-index: 1600;
}

/* Top bar - Compact */
.tk-topbar {
  background: linear-gradient(to right, #0ea5e9, #3b82f6);
  color: #fff;
  padding: 4px 0; /* dari 6px → 4px */
  font-size: 11px; /* dari 12px → 11px */
  text-align: center;
  font-weight: 500;
}

.tk-topbar a {
  color: #fff;
  text-decoration: none;
  margin-left: 6px; /* dari 8px → 6px */
  font-weight: 700;
  border-bottom: 1px solid rgba(255,255,255,0.6);
  padding-bottom: 1px;
  transition: border-color 0.2s;
}

.tk-topbar a:hover {
  border-bottom-color: #fff;
}

.tk-container { 
  max-width: 1200px; 
  margin: 0 auto; 
  padding: 0 14px; /* dari 16px → 14px */
}

.tk-row { 
  display: flex; 
  align-items: center; 
  justify-content: space-between;
  gap: 16px; /* dari 20px → 16px */
  padding: 12px 0; /* dari 16px → 12px */
}

/* LEFT - Logo Compact */
.tk-left { 
  display: flex; 
  align-items: center;
  flex-shrink: 0;
  width: 180px; /* dari 200px → 180px */
}

.tk-logo {
  display: inline-block;
}

.tk-logo img { 
  height: 48px; /* dari 40px → 48px */
  display: block;
  transition: opacity 0.2s;
}

.tk-logo:hover img {
  opacity: 0.85;
}

/* CENTER - Search Compact */
.tk-center { 
  flex: 1;
  display: flex;
  justify-content: center;
  max-width: none;
  padding: 0 20px; /* dari 32px → 20px untuk beri ruang quick menu */
}

.tk-search { 
  position: relative;
  display: flex; 
  align-items: center; 
  background: #fff;
  border: 2px solid #e5e7eb;
  padding: 0;
  border-radius: 50px;
  transition: all 0.3s ease;
  width: 100%;
  max-width: 600px; /* dari 650px → 600px */
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.tk-search:hover {
  border-color: #0ea5e9;
  box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
}

.tk-search:focus-within {
  border-color: #0ea5e9;
  box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
  transform: translateY(-1px);
}

.tk-search input { 
  border: 0; 
  outline: 0; 
  font-size: 13px; /* dari 14px → 13px */
  width: 100%;
  padding: 11px 52px 11px 20px; /* dari 14px → 11px, icon space dari 60px → 52px */
  background: transparent;
  color: #1a1a1a;
  border-radius: 50px;
  font-weight: 500;
}

.tk-search input::placeholder {
  color: #9ca3af;
  font-weight: 400;
}

.tk-search .search-icon {
  background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
  width: 42px; /* dari 48px → 42px */
  height: 42px; /* dari 48px → 42px */
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 0;
  transition: all 0.3s ease;
  flex-shrink: 0;
  position: absolute;
  right: 3px; /* dari 4px → 3px */
  top: 50%;
  transform: translateY(-50%);
  box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
}

.tk-search .search-icon:hover {
  transform: translateY(-50%) scale(1.05);
  box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
}

.tk-search .search-icon:active {
  transform: translateY(-50%) scale(0.98);
}

.tk-search .search-icon svg {
  stroke: #fff;
  width: 18px; /* dari 20px → 18px */
  height: 18px; /* dari 20px → 18px */
}

/* Quick Menu - Right of Search */
.tk-quick-menu {
  display: flex;
  align-items: center;
  gap: 4px;
  flex-shrink: 0;
  margin-left: 12px;
}

.quick-menu-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  color: #6c757d;
  text-decoration: none;
  transition: all 0.2s;
  background: transparent;
  border: 1px solid transparent;
}

.quick-menu-link:hover {
  background: #f9fafb;
  color: #0ea5e9;
  border-color: #e5e7eb;
}

.quick-menu-link.active {
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
  color: #0ea5e9;
  border-color: #bfdbfe;
}

.quick-menu-link svg {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
}

.quick-menu-link span {
  white-space: nowrap;
}

/* Navigation menu - Hapus karena sudah tidak dipakai */
.tk-navbar-secondary {
  display: none;
}

.tk-menu { 
  display: none;
}

/* RIGHT - Actions Compact */
.tk-actions { 
  display: flex; 
  align-items: center; 
  gap: 7px; /* dari 8px → 7px */
  flex-shrink: 0;
  width: 180px; /* dari 200px → 180px */
  justify-content: flex-end;
}

.icon-btn { 
  display: inline-flex; 
  align-items: center; 
  justify-content: center; 
  width: 36px; /* dari 40px → 36px */
  height: 36px; /* dari 40px → 36px */
  border-radius: 4px;
  background: transparent;
  border: 1px solid #e5e7eb;
  cursor: pointer; 
  padding: 0;
  position: relative;
  transition: all 0.2s;
}

.icon-btn:hover { 
  background: #f9fafb;
  border-color: #0ea5e9;
}

.icon-btn:hover svg {
  stroke: #0ea5e9;
}

.icon-btn svg { 
  width: 18px; /* dari 20px → 18px */
  height: 18px; /* dari 20px → 18px */
  transition: stroke 0.2s;
  stroke: #6c757d;
}

.cart-badge { 
  position: absolute;
  top: -4px;
  right: -4px;
  background: #0ea5e9;
  color: #fff; 
  font-size: 9px; /* dari 10px → 9px */
  min-width: 17px; /* dari 18px → 17px */
  height: 17px; /* dari 18px → 17px */
  display: inline-flex; 
  align-items: center; 
  justify-content: center; 
  border-radius: 10px;
  padding: 0 4px; /* dari 5px → 4px */
  font-weight: 700;
  border: 2px solid #fff;
}

.badge.hidden { 
  display: none !important; 
}

/* MINI CART - Compact */
.tk-mini-cart { 
  position: absolute; 
  right: 0; 
  margin-top: 7px; /* dari 8px → 7px */
  width: 360px; /* dari 380px → 360px */
  max-height: 480px; /* dari 500px → 480px */
  background: #fff; 
  border-radius: 4px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  overflow: hidden; 
  z-index: 9999;
  border: 1px solid #e5e7eb;
  display: none;
}

.tk-mini-cart.show {
  display: flex;
  flex-direction: column;
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 768px) {
  body.cart-open {
    overflow: hidden;
  }
  
  .tk-mini-cart.show {
    position: fixed;
    right: 0;
    left: auto;
    top: 55px; /* dari 60px → 55px */
    margin: 0;
    width: 100vw;
    max-width: 380px; /* dari 400px → 380px */
    max-height: calc(100vh - 65px); /* dari 70px → 65px */
    border-radius: 0;
  }
}

.tk-mini-head { 
  padding: 14px; /* dari 16px → 14px */
  display: flex; 
  gap: 7px; /* dari 8px → 7px */
  align-items: center; 
  justify-content: space-between; 
  border-bottom: 1px solid #f0f0f0;
  background: #fafafa;
}

.tk-mini-head .title { 
  display: flex; 
  gap: 7px; /* dari 8px → 7px */
  align-items: center; 
  font-weight: 700;
  color: #1a1a1a; 
  font-size: 13px; /* dari 14px → 13px */
}

.tk-mini-head .title svg {
  stroke: #0ea5e9;
  width: 16px; /* dari 18px → 16px */
  height: 16px; /* dari 18px → 16px */
}

.tk-mini-head .summary { 
  font-size: 11px; /* dari 12px → 11px */
  color: #6c757d;
  font-weight: 600;
}

/* Cart body */
.tk-mini-body { 
  flex: 1;
  overflow-y: auto; 
  padding: 10px; /* dari 12px → 10px */
  background: #fff;
}

.tk-mini-body::-webkit-scrollbar {
  width: 5px; /* dari 6px → 5px */
}

.tk-mini-body::-webkit-scrollbar-track {
  background: #f5f5f5;
}

.tk-mini-body::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 3px;
}

.tk-mini-body::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}

/* Mini cart item - Compact */
.tk-mini-item { 
  display: grid; 
  grid-template-columns: 18px 56px 1fr 80px; /* dari 20px 60px 1fr 85px */
  gap: 10px; /* dari 12px → 10px */
  align-items: start;
  padding: 10px; /* dari 12px → 10px */
  border-radius: 4px;
  margin-bottom: 7px; /* dari 8px → 7px */
  background: #fff;
  border: 1px solid #f0f0f0;
  transition: all 0.2s;
}

.tk-mini-item:hover {
  border-color: #e5e7eb;
  box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.item-checkbox { 
  width: 15px; /* dari 16px → 15px */
  height: 15px; /* dari 16px → 15px */
  cursor: pointer;
  accent-color: #0ea5e9;
  margin: 0;
  align-self: center;
}

/* Thumbnail Compact */
.tk-mini-thumb { 
  width: 56px; /* dari 60px → 56px */
  height: 56px; /* dari 60px → 56px */
  border-radius: 4px;
  overflow: hidden; 
  background: #f5f5f5;
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

/* Meta info - Compact */
.tk-mini-meta { 
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 5px; /* dari 6px → 5px */
}

.tk-mini-title { 
  font-weight: 600;
  font-size: 12px; /* dari 13px → 12px */
  color: #1a1a1a;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  line-height: 1.4;
}

.tk-mini-sub { 
  font-size: 10px; /* dari 11px → 10px */
  color: #6c757d;
  display: flex;
  flex-direction: column;
  gap: 3px; /* dari 4px → 3px */
}

.tk-mini-variant-row{
  display: flex;
  flex-wrap: nowrap;
  gap: 5px; /* dari 6px → 5px */
  margin-top: 2px;
}

.tk-mini-variant{
  font-size: 10px; /* dari 11px → 10px */
  color: #6c757d;
  background: #f5f5f5;
  padding: 2px 7px; /* dari 3px 8px */
  border-radius: 2px;
  font-weight: 500;
  white-space: nowrap;
  border: 1px solid #e5e7eb;
}

/* Quantity controls - Compact */
.tk-mini-controls { 
  display: flex; 
  gap: 3px; /* dari 4px → 3px */
  align-items: center;
  margin-top: 5px; /* dari 6px → 5px */
  border: 1px solid #e5e7eb;
  border-radius: 2px;
  width: fit-content;
}

.qty-btn { 
  width: 22px; /* dari 24px → 22px */
  height: 22px; /* dari 24px → 22px */
  border: none;
  border-right: 1px solid #e5e7eb;
  background: #fff;
  cursor: pointer; 
  display: inline-flex; 
  align-items: center; 
  justify-content: center; 
  font-size: 13px; /* dari 14px → 13px */
  font-weight: 600;
  color: #6c757d;
  transition: all 0.2s;
}

.qty-btn:last-child {
  border-right: none;
  border-left: 1px solid #e5e7eb;
}

.qty-btn:hover {
  background: #f9fafb;
  color: #0ea5e9;
}

.qty-input { 
  width: 32px; /* dari 36px → 32px */
  padding: 3px; /* dari 4px → 3px */
  border: none;
  text-align: center;
  font-size: 11px; /* dari 12px → 11px */
  font-weight: 600;
  color: #1a1a1a;
  background: #fff;
}

.qty-input:focus {
  outline: none;
}

/* Right side - Price & Delete Compact */
.item-right { 
  display: flex; 
  flex-direction: column; 
  align-items: flex-end;
  justify-content: space-between;
  gap: 7px; /* dari 8px → 7px */
  min-width: 80px; /* dari 85px → 80px */
  height: 100%;
}

.item-total { 
  font-weight: 700;
  color: #0ea5e9;
  font-size: 12px; /* dari 13px → 12px */
  white-space: nowrap;
}

.btn-trash { 
  background: transparent;
  border: none;
  cursor: pointer; 
  padding: 5px; /* dari 6px → 5px */
  border-radius: 2px;
  display: inline-flex; 
  align-items: center; 
  justify-content: center;
  transition: all 0.2s;
}

.btn-trash:hover { 
  background: #fee2e2;
}

.btn-trash svg {
  width: 15px; /* dari 16px → 15px */
  height: 15px; /* dari 16px → 15px */
  stroke: #ef4444;
}

/* Bulk actions Compact */
.mini-body-top { 
  display: flex; 
  justify-content: space-between; 
  align-items: center; 
  padding: 0 3px 8px; /* dari 0 4px 10px */
  border-bottom: 1px solid #f0f0f0;
  margin-bottom: 8px; /* dari 10px → 8px */
}

.mini-body-top label {
  font-size: 11px; /* dari 12px → 11px */
  color: #6c757d;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 5px; /* dari 6px → 5px */
}

.btn-delete-bulk {
  display: inline-flex;
  align-items: center;
  gap: 4px; /* dari 5px → 4px */
  padding: 4px 9px; /* dari 5px 10px */
  font-size: 10px; /* dari 11px → 10px */
  border-radius: 2px;
  border: 1px solid #fecaca;
  background: #fff;
  color: #ef4444;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-delete-bulk:hover {
  background: #fee2e2;
}

.btn-delete-bulk svg {
  flex-shrink: 0;
  width: 13px; /* dari 14px → 13px */
  height: 13px; /* dari 14px → 13px */
}

/* Empty state Compact */
.tk-mini-empty { 
  padding: 40px 20px; /* dari 50px 24px */
  text-align: center; 
  color: #9ca3af;
  display: flex; 
  flex-direction: column; 
  gap: 10px; /* dari 12px → 10px */
  align-items: center;
}

.tk-mini-empty svg {
  opacity: 0.4;
}

/* Footer - Compact */
.tk-mini-footer { 
  padding: 14px; /* dari 16px → 14px */
  border-top: 1px solid #f0f0f0;
  background: #fafafa;
  position: sticky;
  bottom: 0;
  z-index: 10;
}

.tk-mini-totals { 
  display: flex; 
  justify-content: space-between; 
  align-items: center;
}

.tk-mini-totals .label { 
  color: #6c757d;
  font-size: 12px; /* dari 13px → 12px */
  font-weight: 600;
}

.tk-mini-totals .amount { 
  font-weight: 700;
  font-size: 16px; /* dari 18px → 16px */
  color: #0ea5e9;
}

.tk-actions-row { 
  display: flex; 
  gap: 7px; /* dari 8px → 7px */
}

.btn-ghost { 
  padding: 9px 14px; /* dari 10px 16px */
  border-radius: 4px;
  border: 1px solid #e5e7eb;
  background: #fff;
  color: #6c757d;
  text-decoration: none; 
  font-weight: 600;
  flex: 1; 
  text-align: center;
  font-size: 12px; /* dari 13px → 12px */
  transition: all 0.2s;
}

.btn-ghost:hover {
  border-color: #0ea5e9;
  color: #0ea5e9;
}

.btn-primary { 
  padding: 9px 14px; /* dari 10px 16px */
  border-radius: 4px;
  background: #0ea5e9;
  color: #fff; 
  font-weight: 700;
  text-decoration: none; 
  flex: 1; 
  text-align: center;
  font-size: 12px; /* dari 13px → 12px */
  transition: all 0.2s;
  border: none;
  cursor: pointer;
}

.btn-primary:hover {
  background: #0284c7;
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}

/* Profile Photo Button Compact */
.tk-profile-btn-photo {
  width: 36px; /* dari 40px → 36px */
  height: 36px; /* dari 40px → 36px */
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
  border-color: #0ea5e9;
}

.profile-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile-photo-placeholder {
  width: 100%;
  height: 100%;
  background: #0ea5e9;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px; /* dari 16px → 14px */
}

/* Profile Dropdown Compact */
.tk-profile-dropdown { 
  position: absolute; 
  right: 0;
  margin-top: 7px; /* dari 8px → 7px */
  min-width: 260px; /* dari 280px → 260px */
  background: #fff;
  border-radius: 4px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  border: 1px solid #e5e7eb;
  overflow: hidden; 
  z-index: 1500; 
  display: none;
}

.tk-profile-dropdown.show { 
  display: block;
  animation: fadeIn 0.2s ease-out;
}

.tk-profile-top { 
  padding: 16px; /* dari 20px → 16px */
  background: #fff;
  border-bottom: 1px solid #f0f0f0;
}

.tk-profile-top > div > div:first-child {
  color: #1a1a1a;
  font-weight: 700;
  font-size: 14px; /* dari 16px → 14px */
}

.tk-profile-top .text-muted {
  color: #6c757d;
  font-size: 12px; /* dari 13px → 12px */
  margin-top: 3px; /* dari 4px → 3px */
}

.text-muted {
  color: #9ca3af;
  font-size: 11px; /* dari 12px → 11px */
}

.tk-profile-link { 
  display: flex;
  align-items: center;
  gap: 9px; /* dari 10px → 9px */
  padding: 10px 16px; /* dari 12px 20px */
  text-decoration: none; 
  color: #6c757d;
  font-size: 13px; /* dari 14px → 13px */
  font-weight: 600;
  transition: all 0.2s;
  border: 0;
  width: 100%;
  text-align: left;
  background: transparent;
  cursor: pointer;
}

.tk-profile-link:hover {
  background: #f9fafb;
  color: #0ea5e9;
}

.tk-profile-link svg {
  width: 16px; /* dari 18px → 16px */
  height: 16px; /* dari 18px → 16px */
  flex-shrink: 0;
}

/* Guest actions Compact */
.guest-actions { 
  display: flex; 
  gap: 7px; /* dari 8px → 7px */
  align-items: center;
}

.guest-actions .btn-ghost {
  padding: 0 14px; /* dari 16px → 14px */
  height: 36px; /* dari 40px → 36px */
  line-height: 34px; /* dari 38px → 34px */
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
  font-weight: 600;
  font-size: 12px; /* dari 13px → 12px */
  border: 1px solid #e5e7eb;
  background: #fff;
  transition: all 0.2s;
  text-decoration: none;
  white-space: nowrap;
  box-sizing: border-box;
  color: #6c757d;
}

.guest-actions .btn-ghost:hover {
  border-color: #0ea5e9;
  color: #0ea5e9;
}

.btn-login-pill { 
  padding: 0 14px; /* dari 16px → 14px */
  height: 36px; /* dari 40px → 36px */
  line-height: 34px; /* dari 38px → 34px */
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
  font-weight: 600;
  font-size: 12px; /* dari 13px → 12px */
  background: #0ea5e9;
  color: #fff;
  border: 1px solid transparent;
  text-decoration: none;
  white-space: nowrap;
  transition: all 0.2s;
  box-sizing: border-box;
}

.btn-login-pill:hover {
  background: #0284c7;
}

/* Confirm modal Compact */
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
}

.tk-confirm-box { 
  position: relative; 
  z-index: 3; 
  width: 380px; /* dari 400px → 380px */
  max-width: 90%;
  background: #fff;
  border-radius: 4px;
  padding: 20px; /* dari 24px → 20px */
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}

.tk-confirm-title { 
  font-weight: 700;
  font-size: 16px; /* dari 18px → 16px */
  margin-bottom: 10px; /* dari 12px → 10px */
  color: #1a1a1a;
}

.tk-confirm-msg { 
  color: #6c757d;
  margin-bottom: 16px; /* dari 20px → 16px */
  line-height: 1.5;
  font-size: 13px; /* dari 14px → 13px */
}

.tk-confirm-actions { 
  display: flex; 
  gap: 7px; /* dari 8px → 7px */
  justify-content: flex-end;
}

/* Responsive - Compact adjustments */
@media (max-width: 1024px) {
  .tk-quick-menu {
    gap: 2px;
  }
  
  .quick-menu-link {
    padding: 7px 12px;
    font-size: 12px;
  }
  
  .quick-menu-link svg {
    width: 15px;
    height: 15px;
  }
  
  .tk-center {
    padding: 0 16px;
  }
  
  .tk-search {
    max-width: 480px;
  }
  
  .tk-left,
  .tk-actions {
    width: 140px;
  }
}

@media (max-width: 768px) {
  .tk-navbar-secondary {
    display: none;
  }
  
  .tk-quick-menu {
    display: none; /* Hide di mobile */
  }
  
  /* Hide Pesanan link di mobile, show icon-btn jika ada */
  .tk-actions .quick-menu-link {
    display: none;
  }
  
  .tk-topbar {
    font-size: 10px; /* dari 11px → 10px */
    padding: 4px 0;
  }
  
  .tk-container {
    padding: 0 10px; /* dari 14px → 10px */
  }
  
  .tk-row {
    padding: 10px 0; /* dari 12px → 10px */
    gap: 10px; /* dari 16px → 10px */
  }
  
  .tk-left {
    width: auto;
  }
  
  .tk-logo img {
    height: 42px; /* dari 36px → 42px */
  }
  
  .tk-center {
    flex: 1;
    padding: 0 10px; /* dari 32px → 10px */
  }
  
  .tk-search {
    max-width: none;
    border-radius: 50px;
  }
  
  .tk-search input {
    font-size: 12px; /* dari 13px → 12px */
    padding: 10px 50px 10px 16px; /* dari 11px 52px 11px 20px */
  }
  
  .tk-search .search-icon {
    width: 38px; /* dari 42px → 38px */
    height: 38px; /* dari 42px → 38px */
  }
  
  .tk-actions {
    width: auto;
  }
  
  .icon-btn {
    width: 34px; /* dari 36px → 34px */
    height: 34px; /* dari 36px → 34px */
  }
  
  .icon-btn svg {
    width: 17px; /* dari 18px → 17px */
    height: 17px; /* dari 18px → 17px */
  }
  
  .tk-profile-btn-photo {
    width: 34px; /* dari 36px → 34px */
    height: 34px; /* dari 36px → 34px */
  }
  
  .guest-actions {
    gap: 5px; /* dari 7px → 5px */
  }
  
  .guest-actions .btn-ghost {
    height: 34px; /* dari 36px → 34px */
    line-height: 32px; /* dari 34px → 32px */
    padding: 0 12px; /* dari 14px → 12px */
    font-size: 11px; /* dari 12px → 11px */
  }
  
  .btn-login-pill {
    height: 34px; /* dari 36px → 34px */
    line-height: 32px; /* dari 34px → 32px */
    padding: 0 12px; /* dari 14px → 12px */
    font-size: 11px; /* dari 12px → 11px */
  }
}

@media (max-width: 480px) {
  .tk-topbar {
    font-size: 9px; /* dari 10px → 9px */
    padding: 3px 0; /* dari 4px → 3px */
  }
  
  .tk-container {
    padding: 0 8px; /* dari 10px → 8px */
  }
  
  .tk-row {
    padding: 8px 0; /* dari 10px → 8px */
    gap: 8px; /* dari 10px → 8px */
  }
  
  .tk-logo img {
    height: 38px; /* dari 32px → 38px */
  }
  
  .tk-center {
    padding: 0 6px; /* dari 10px → 6px */
  }
  
  .tk-search {
    border-radius: 50px;
  }
  
  .tk-search input {
    font-size: 11px; /* dari 12px → 11px */
    padding: 8px 46px 8px 14px; /* dari 10px 50px 10px 16px */
  }
  
  .tk-search .search-icon {
    width: 36px; /* dari 38px → 36px */
    height: 36px; /* dari 38px → 36px */
  }
  
  .tk-search .search-icon svg {
    width: 16px; /* dari 18px → 16px */
    height: 16px; /* dari 18px → 16px */
  }
  
  .icon-btn {
    width: 32px; /* dari 34px → 32px */
    height: 32px; /* dari 34px → 32px */
  }
  
  .icon-btn svg {
    width: 16px; /* dari 17px → 16px */
    height: 16px; /* dari 17px → 16px */
  }
  
  .cart-badge {
    min-width: 15px; /* dari 17px → 15px */
    height: 15px; /* dari 17px → 15px */
    font-size: 8px; /* dari 9px → 8px */
  }
  
  .tk-profile-btn-photo {
    width: 32px; /* dari 34px → 32px */
    height: 32px; /* dari 34px → 32px */
  }
  
  .guest-actions {
    gap: 4px; /* dari 5px → 4px */
  }
  
  .guest-actions .btn-ghost {
    height: 32px; /* dari 34px → 32px */
    line-height: 30px; /* dari 32px → 30px */
    padding: 0 10px; /* dari 12px → 10px */
    font-size: 10px; /* dari 11px → 10px */
  }
  
  .btn-login-pill {
    height: 32px; /* dari 34px → 32px */
    line-height: 30px; /* dari 32px → 30px */
    padding: 0 10px; /* dari 12px → 10px */
    font-size: 10px; /* dari 11px → 10px */
  }
  
  /* Mini cart mobile adjustments */
  .tk-mini-head {
    padding: 12px; /* dari 14px → 12px */
  }
  
  .tk-mini-body {
    padding: 8px; /* dari 10px → 8px */
  }
  
  .tk-mini-item {
    grid-template-columns: 16px 52px 1fr; /* dari 18px 56px 1fr */
    grid-template-rows: auto auto;
    gap: 8px; /* dari 10px → 8px */
    padding: 8px; /* dari 10px → 8px */
  }
  
  .item-checkbox {
    grid-column: 1;
    grid-row: 1;
    align-self: center;
  }
  
  .tk-mini-thumb {
    width: 52px; /* dari 56px → 52px */
    height: 52px; /* dari 56px → 52px */
    grid-column: 2;
    grid-row: 1 / 3;
  }
  
  .tk-mini-meta {
    grid-column: 3;
    grid-row: 1;
  }
  
  .tk-mini-title {
    font-size: 11px; /* dari 12px → 11px */
  }
  
  .item-right {
    grid-column: 3;
    grid-row: 2;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
  
  .item-total {
    font-size: 11px; /* dari 12px → 11px */
  }
  
  .btn-trash svg {
    width: 13px; /* dari 15px → 13px */
    height: 13px; /* dari 15px → 13px */
  }
  
  .tk-mini-footer {
    padding: 12px; /* dari 14px → 12px */
  }
  
  .tk-mini-totals .amount {
    font-size: 14px; /* dari 16px → 14px */
  }
  
  .btn-ghost,
  .btn-primary {
    padding: 9px 12px; /* dari 9px 14px */
    font-size: 11px; /* dari 12px → 11px */
  }
}

@media (max-width: 360px) {
  .tk-logo img {
    height: 34px; /* dari 28px → 34px */
  }
  
  .tk-search input {
    font-size: 10px; /* dari 11px → 10px */
    padding: 6px 40px 6px 8px; /* dari 8px 46px 8px 14px */
  }
  
  .tk-search .search-icon {
    width: 34px; /* dari 36px → 34px */
    height: 28px; /* dari 36px → 28px */
  }
  
  .icon-btn {
    width: 30px; /* dari 32px → 30px */
    height: 30px; /* dari 32px → 30px */
  }
  
  .tk-profile-btn-photo {
    width: 30px; /* dari 32px → 30px */
    height: 30px; /* dari 32px → 30px */
  }
  
  .tk-mini-item {
    grid-template-columns: 14px 48px 1fr; /* dari 16px 52px 1fr */
    gap: 7px; /* dari 8px → 7px */
    padding: 7px; /* dari 8px → 7px */
  }
  
  .tk-mini-thumb {
    width: 48px; /* dari 52px → 48px */
    height: 48px; /* dari 52px → 48px */
  }
}
</style>
</head>
<body>

{{-- HTML Structure tetap 100% SAMA seperti sebelumnya --}}
{{-- (Copy semua HTML dari versi sebelumnya, tidak ada perubahan di HTML) --}}
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
          <img src="{{ asset('images/logo/headlogo.png') }}" alt="Logo">
        </a>
      </div>

      {{-- CENTER - Search --}}
      <div class="tk-center">
        <form class="tk-search" role="search" action="{{ route('shop.index') }}" method="GET" aria-label="Search products">
          <input type="search" name="q" placeholder="Cari produk, kategori atau brand..." value="{{ request('q') }}" aria-label="Search products">
          <button type="submit" class="search-icon" aria-label="Search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="M21 21l-4.35-4.35"></path>
            </svg>
          </button>
        </form>
      </div>

      {{-- CENTER RIGHT - Quick Menu --}}
      <div class="tk-quick-menu">
        <a href="{{ route('dashboard') }}" class="quick-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          </svg>
          <span>Home</span>
        </a>
        <a href="{{ route('shop.index') }}" class="quick-menu-link {{ request()->routeIs('shop.index') ? 'active' : '' }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <span>Produk</span>
        </a>
      </div>

      {{-- RIGHT - Orders, Cart, Auth --}}
      <div class="tk-actions" style="margin-left:auto;margin-right:0;">

        @php
          $cart = session('cart', []);
          $cartCount = collect($cart)->sum('qty');
          $cartTotal = collect($cart)->reduce(fn($c,$i)=> $c + ($i['price']*$i['qty']), 0);
        @endphp

        {{-- ORDERS/PESANAN - Style sama dengan quick menu --}}
        @auth
          <a href="{{ route('orders.index') }}" class="quick-menu-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" title="Pesanan Saya">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
              <path d="M3 9h18"></path>
              <path d="M9 21V9"></path>
            </svg>
            <span>Pesanan</span>
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
              <span class="cart-badge" id="tk-cart-badge">{{ $cartCount }}</span>
            @else
              <span class="cart-badge hidden" id="tk-cart-badge" aria-hidden="true"></span>
            @endif
          </button>

          {{-- MINI CART - HTML tetap sama seperti sebelumnya --}}
          <div id="tk-mini-cart" class="tk-mini-cart" aria-hidden="true">
            <div class="tk-mini-head">
              <div class="title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
                  <div style="font-weight:700;color:#1a1a1a;font-size:15px;">Keranjang Belanja Kosong</div>
                  <div style="font-size:13px;color:#6c757d;">Yuk, mulai belanja sekarang!</div>
                  <a href="{{ route('shop.index') }}" class="btn-primary" style="margin-top:12px;display:inline-block;">Belanja Sekarang</a>
                </div>
              </div>
            @else
              <div class="tk-mini-body" id="tk-mini-body">
                <div class="mini-body-top">
                  <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" id="tk-select-all" title="Pilih semua" />
                    <label for="tk-select-all">Pilih Semua</label>
                  </div>
                  <button id="tk-delete-selected" class="btn-delete-bulk" type="button" title="Hapus Terpilih">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                    </svg>
                    <span>Hapus</span>
                  </button>
                </div>

                <div id="tk-mini-items">
                  @foreach($cart as $loopIndex => $item)
                    @php $id = $item['id'] ?? $loopIndex; @endphp
                    <div class="tk-mini-item" data-item-id="{{ $id }}" data-price="{{ $item['price'] ?? 0 }}">
                      <input type="checkbox" class="item-checkbox" data-item-id="{{ $id }}" title="Pilih item">

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

                      <div class="tk-mini-meta">
                        <div class="tk-mini-title">{{ $item['name'] }}</div>
                        <div class="tk-mini-sub">
                     
                          @if(!empty($item['variant']))
                            <div class="tk-mini-variant-row">
                              @if(is_array($item['variant']))
                                @foreach($item['variant'] as $v)
                                  <span class="tk-mini-variant">{{ $v }}</span>
                                @endforeach
                              @else
                                <span class="tk-mini-variant">{{ $item['variant'] }}</span>
                              @endif
                            </div>
                          @endif

                          <div style="font-weight:600;color:#6c757d;font-size:11px;">Rp {{ number_format($item['price'],0,',','.') }}</div>
                        </div>

                        <div class="tk-mini-controls">
                          <button class="qty-btn btn-decrease" type="button" data-item-id="{{ $id }}">−</button>
                          <input type="number" min="1" class="qty-input item-qty" data-item-id="{{ $id }}" value="{{ $item['qty'] }}">
                          <button class="qty-btn btn-increase" type="button" data-item-id="{{ $id }}">+</button>
                        </div>
                      </div>

                      <div class="item-right">
                        <div class="item-total">Rp {{ number_format(($item['price']*$item['qty']),0,',','.') }}</div>

                        <button class="btn-trash btn-remove-single" data-remove-id="{{ $id }}" title="Hapus">
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
                <div style="padding:8px 0;border-bottom:1px solid #f0f0f0;margin-bottom:10px;">
                  <div style="font-size:12px;color:#6c757d;font-weight:500;">
                    💡 Pilih produk yang ingin di-checkout
                  </div>
                </div>
                
                <div class="tk-mini-totals">
                  <div class="label">Total Terpilih</div>
                  <div class="amount" id="tk-mini-total">Rp 0</div>
                </div>

                <div class="tk-actions-row">
                  <a href="{{ route('shop.cart') }}" class="btn-ghost">Lihat Keranjang</a>
                  <button type="button" id="tk-checkout-btn" class="btn-primary" disabled style="opacity:0.5;">Checkout</button>
                </div>
              </div>
            @endif
          </div>
        </div>

        {{-- PROFILE/AUTH --}}
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
                <div style="display:flex;align-items:center;gap:12px;">
                  @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/profile/'.Auth::user()->profile_photo) }}" alt="avatar" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                  @else
                    <div style="width:48px;height:48px;border-radius:50%;background:#ee4d2d;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;">
                      {{ strtoupper(mb_substr(Auth::user()->name,0,1,'UTF-8')) }}
                    </div>
                  @endif
                  <div>
                    <div>{{ Auth::user()->name }}</div>
                    <div class="text-muted">{{ Auth::user()->email }}</div>
                  </div>
                </div>
              </div>

              <a class="tk-profile-link" href="{{ route('profile.edit') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Profil Saya
              </a>

              <a class="tk-profile-link" href="{{ route('orders.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                  <path d="M3 9h18"></path>
                  <path d="M9 21V9"></path>
                </svg>
                Riwayat Pesanan
              </a>
              
              <div style="border-top:1px solid #f0f0f0;margin:8px 0;"></div>
              
              <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="tk-profile-link" style="color:#dc2626;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
          <div class="guest-actions">
            <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary btn-login-pill">Daftar</a>
          </div>
        @endauth

      </div>
    </div>
  </div>
</nav>

{{-- CONFIRMATION MODAL --}}
<div id="tk-confirm-modal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="tk-confirm-backdrop" data-close-modal></div>
  <div class="tk-confirm-box">
    <div class="tk-confirm-title" id="tk-confirm-title">Konfirmasi</div>
    <div class="tk-confirm-msg" id="tk-confirm-msg">Apakah Anda yakin?</div>
    <div class="tk-confirm-actions">
      <button id="tk-confirm-cancel" class="btn-ghost" type="button">Batal</button>
      <button id="tk-confirm-ok" class="btn-primary" type="button">Ya, Hapus</button>
    </div>
  </div>
</div>

{{-- JAVASCRIPT SISTEM TETAP 100% SAMA --}}
<script>
(function(){
  const qs = s => document.querySelector(s);
  const qsa = s => Array.from(document.querySelectorAll(s));

  const cartBtn = qs('#tk-cart-btn');
  const miniCart = qs('#tk-mini-cart');
  const miniCount = qs('#tk-mini-count');
  const cartBadge = qs('#tk-cart-badge');
  const miniTotal = qs('#tk-mini-total');
  const selectAll = qs('#tk-select-all');
  const deleteSelectedBtn = qs('#tk-delete-selected');
  const profileBtn = qs('#tk-profile-btn');
  const profileDrop = qs('#tk-profile-dropdown');
  const confirmModal = qs('#tk-confirm-modal');
  const confirmMsg = qs('#tk-confirm-msg');
  const confirmOk = qs('#tk-confirm-ok');
  const confirmCancel = qs('#tk-confirm-cancel');

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  const cartApi = {
    updateQty: () => `/keranjang/item`,
    removeItem: () => `/keranjang/item`,
  };

  function fmt(n){ return 'Rp ' + (Number(n)||0).toLocaleString('id-ID'); }

  function toast(msg, ms=2000){
    const d = document.createElement('div');
    d.textContent = msg;
    Object.assign(d.style, {position:'fixed', right:'20px', bottom:'80px', background:'#1a1a1a', color:'#fff', padding:'12px 20px', borderRadius:'4px', zIndex:99999, boxShadow:'0 4px 12px rgba(0,0,0,0.2)', fontWeight:'600', fontSize:'13px'});
    document.body.appendChild(d);
    setTimeout(()=> d.remove(), ms);
  }

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
      
      totalCount += qty;
      
      if (isChecked) {
        selectedTotal += price * qty;
      }
      
      const totalEl = it.querySelector('.item-total');
      if (totalEl) totalEl.textContent = fmt(price * qty);
    });

    if (miniTotal) miniTotal.textContent = fmt(selectedTotal);

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
    
    updateCheckoutButton();
  }

  function updateCheckoutButton() {
    const checkoutBtn = qs('#tk-checkout-btn');
    if (!checkoutBtn) return;
    
    const checkedBoxes = qsa('.item-checkbox:checked');
    
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

  if (cartBtn && miniCart) {
    cartBtn.addEventListener('click', e => {
      e.stopPropagation();
      const open = miniCart.classList.toggle('show');
      cartBtn.setAttribute('aria-expanded', open?'true':'false');
      if (profileDrop) profileDrop.classList.remove('show');
      
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

  document.addEventListener('change', async (e) => {
    if (e.target.matches('.item-qty')) {
      const id = e.target.dataset.itemId;
      let qty = parseInt(e.target.value) || 1;
      if (qty < 1) qty = 1;
      e.target.value = qty;
      const itemEl = document.querySelector(`.tk-mini-item[data-item-id="${id}"]`);
      if (itemEl) {
        const price = parseFloat(itemEl.dataset.price) || 0;
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

  document.addEventListener('click', (e) => {
    if (e.target.matches('.item-checkbox') || e.target.matches('#tk-select-all')) {
      setTimeout(() => {
        recalcTotals();
        updateCheckoutButton();
      }, 10);
    }
  });

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

  if (selectAll) {
    selectAll.addEventListener('click', (e) => {
      const checked = e.target.checked;
      qsa('.item-checkbox').forEach(cb => cb.checked = checked);
      
      setTimeout(() => {
        selectAll.indeterminate = false;
        recalcTotals();
        updateCheckoutButton();
      }, 10);
    });
  }

  const checkoutBtnEl = qs('#tk-checkout-btn');
  if (checkoutBtnEl) {
    checkoutBtnEl.addEventListener('click', async (e) => {
      e.preventDefault();
      
      const checkedBoxes = qsa('.item-checkbox:checked');
      const selectedIds = checkedBoxes.map(cb => cb.dataset.itemId).filter(Boolean);
      
      if (selectedIds.length === 0) {
        toast('Pilih produk yang ingin di-checkout');
        return;
      }
      
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
      
      try {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/checkout/start';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrf;
        form.appendChild(csrfInput);
        
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

  recalcTotals();
  updateCheckoutButton();

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
@yield('scripts')
</body>

</html>