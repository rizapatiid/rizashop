# 🛒 Laravel Marketplace Project

Aplikasi **Marketplace berbasis Laravel** dengan sistem **multi-role** yang dirancang untuk **Seller (Admin)** dan **Pelanggan (User)**.  
Saat ini pengembangan difokuskan pada **Seller & Pelanggan**, dengan rencana pengembangan lanjutan untuk role tambahan dan fitur pendukung.

---

## 🚀 Status Pengembangan
- ✅ Seller (Admin) – Aktif
- ✅ Pelanggan (User) – Aktif
- ⏳ Admin Utama – Perencanaan
- ⏳ Live Chat Customer Service – Pengembangan
- ⏳ Custom UI User – Pengembangan

---

## 🔐 Authentication
Fitur autentikasi dengan **UI custom**:
- Login
- Register
- Forget Password

---

## 📊 Dashboard
Dashboard dibedakan berdasarkan role pengguna:

### 👤 Pelanggan (User)
- Route: `/dashboard` *(rencana akan menjadi `/`)*

### 🛍️ Seller (Admin)
- Route: `/masterdashboard` *(rencana akan menjadi `/seller`)*

---

## 👤 Profile Page (Custom)
Route: `/account`  
Tampilan profile **akan dibedakan** antara Seller & Pelanggan.

### Fitur Profile:
- Edit foto profil
- Edit data profil
- Ubah password
- Hapus akun

### 📍 Manajemen Alamat *(Sudah Fix)*:
- Tambah alamat
- Edit alamat
- Hapus alamat
- Set alamat utama

### ❓ Bantuan:
- Hubungi CS *(Live Chat – dalam pengembangan)*

---

## 🛠️ Dashboard Seller (Admin)

### 📦 Manajemen Produk  
Route: `/products`  
> Sistem sudah berjalan, UI masih dalam pengembangan

- Tambah produk
- Edit produk
- Hapus produk

### 👥 Manajemen Pengguna  
Route: `/users`  
> Sistem sudah berjalan, UI masih dalam pengembangan

- Tambah pengguna
- Edit pengguna
- Hapus pengguna

---

## 🛒 Dashboard Pelanggan (User)
> Fitur sudah berjalan, UI masih default

- Melihat produk (`/produk`)
- Tambah ke keranjang
- Keranjang (`/keranjang`)
- Checkout (`/checkout`)

---

## 📸 Screenshot UI

### 🔐 Authentication
<p align="center">
  <img src="screenshots/login.png" width="45%">
  <img src="screenshots/register.png" width="45%">
</p>

---

### 👤 Dashboard Pelanggan
<p align="center">
  <img src="screenshots/dashboard-user.png" width="80%">
</p>

---

### 🛍️ Dashboard Seller (Admin)
<p align="center">
  <img src="screenshots/dashboard-seller.png" width="80%">
</p>

---

### 📦 Manajemen Produk
<p align="center">
  <img src="screenshots/products.png" width="80%">
</p>

### 📦 kelola Pengguna
<p align="center">
  <img src="screenshots/pengguna.png" width="80%">
</p>

### 📦 Pesanan
<p align="center">
  <img src="screenshots/pesanan.png" width="80%">
</p>
---

### 🛒 Keranjang & Checkout
<p align="center">
  <img src="screenshots/cart.png" width="45%">
  <img src="screenshots/checkout.png" width="45%">
</p>

---

## 🧰 Teknologi yang Digunakan
- Laravel
- Blade Template
- MySQL
- Bootstrap / Custom UI
- Laravel Authentication

---

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

## 📌 Catatan
Project ini masih dalam tahap **pengembangan aktif** dan akan terus dikembangkan dari sisi fitur maupun tampilan UI.

---

## 📄 License
Project ini menggunakan lisensi **MIT**.
