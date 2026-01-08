<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TokoRiza Seller Center</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f5f5f5;
        }

        /* ===== TOP NAV - Match User Navbar ===== */
        .admin-topbar {
            background: linear-gradient(to right, #0ea5e9, #3b82f6);
            color: #fff;
            padding: 4px 0;
            font-size: 11px;
            text-align: center;
            font-weight: 500;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .admin-nav {
            background: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
            position: fixed;
            top: 24px; /* topbar height */
            left: 0;
            right: 0;
            z-index: 999;
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 14px;
        }

        .admin-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 0;
        }

        /* Logo */
        .admin-left {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            width: 200px;
        }

        .admin-logo img {
            height: 48px;
            display: block;
        }

        .seller-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 8px;
            letter-spacing: 0.5px;
        }

        /* Search */
        .admin-center {
            flex: 1;
            display: flex;
            justify-content: center;
            max-width: none;
            padding: 0 20px;
        }

        .admin-search {
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            border: 2px solid #e5e7eb;
            padding: 0;
            border-radius: 50px;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .admin-search:hover {
            border-color: #0ea5e9;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
        }

        .admin-search:focus-within {
            border-color: #0ea5e9;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
            transform: translateY(-1px);
        }

        .admin-search input {
            border: 0;
            outline: 0;
            font-size: 13px;
            width: 100%;
            padding: 11px 52px 11px 20px;
            background: transparent;
            color: #1a1a1a;
            border-radius: 50px;
            font-weight: 500;
        }

        .admin-search input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .search-icon-btn {
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 0;
            transition: all 0.3s ease;
            flex-shrink: 0;
            position: absolute;
            right: 3px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }

        .search-icon-btn:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4);
        }

        .search-icon-btn svg {
            color: #fff;
            width: 18px;
            height: 18px;
        }

        /* Actions */
        .admin-actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-shrink: 0;
            width: 200px;
            justify-content: flex-end;
        }

        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
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
            color: #0ea5e9;
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
            transition: color 0.2s;
            color: #6c757d;
        }

        .badge-notif {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #0ea5e9;
            color: #fff;
            font-size: 9px;
            min-width: 17px;
            height: 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 0 4px;
            font-weight: 700;
            border: 2px solid #fff;
        }

        /* Profile */
        .admin-profile-btn {
            width: 36px;
            height: 36px;
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

        .admin-profile-btn:hover {
            border-color: #0ea5e9;
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-placeholder {
            width: 100%;
            height: 100%;
            background: #0ea5e9;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        /* Profile Dropdown */
        .admin-profile-dropdown {
            position: absolute;
            right: 0;
            margin-top: 7px;
            min-width: 260px;
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            z-index: 1500;
            display: none;
        }

        .admin-profile-dropdown.show {
            display: block;
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

        .profile-dropdown-top {
            padding: 16px;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }

        .profile-dropdown-top .name {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 14px;
        }

        .profile-dropdown-top .email {
            color: #6c757d;
            font-size: 12px;
            margin-top: 3px;
        }

        .profile-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 16px;
            text-decoration: none;
            color: #6c757d;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
            border: 0;
            width: 100%;
            text-align: left;
            background: transparent;
            cursor: pointer;
        }

        .profile-link:hover {
            background: #f9fafb;
            color: #0ea5e9;
        }

        .profile-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .profile-link.logout {
            color: #dc2626;
        }

        .profile-link.logout:hover {
            background: #fef2f2;
        }

        /* Main Content */
        .main-wrapper {
            margin-top: 80px; /* topbar (24px) + navbar (56px) */
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }

        .main-wrapper.sidebar-collapsed {
            margin-left: 72px;
        }
        
        /* Sidebar */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 80px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 900;
        }
        
        .sidebar-collapsed {
            width: 72px;
        }
        
        .sidebar-expanded {
            width: 240px;
        }
        
        /* Mobile Sidebar */
        @media (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                top: 80px;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0 !important;
            }
        }
        
        /* Menu Items */
        .menu-item {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .menu-item:hover {
            background: #f8fafc;
        }
        
        .menu-item.active {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #2563eb;
        }
        
        /* Badge */
        .badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .8;
            }
        }
        
        /* Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Quick Action */
        .quick-action {
            background: white;
            border: 2px dashed #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .quick-action:hover {
            border-color: #2563eb;
            background: #eff6ff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-left {
                width: auto;
            }

            .admin-actions {
                width: auto;
            }

            .admin-center {
                padding: 0 10px;
            }

            .admin-logo img {
                height: 38px;
            }

            .seller-badge {
                display: none;
            }

            .admin-search {
                max-width: none;
            }

            .admin-search input {
                font-size: 12px;
                padding: 10px 50px 10px 16px;
            }

            .search-icon-btn {
                width: 38px;
                height: 38px;
            }
        }
    </style>

    @yield('styles')
</head>

<body class="antialiased">

<!-- TOP BAR - Match User Navbar -->
<div class="admin-topbar">
    <div class="admin-container">
        🎉 Seller Center - Kelola Toko Anda dengan Mudah
    </div>
</div>

<!-- MAIN NAVIGATION - Match User Navbar -->
<nav class="admin-nav">
    <div class="admin-container">
        <div class="admin-row">

            {{-- LEFT - Logo --}}
            <div class="admin-left">
                <a href="{{ route('admin.dashboard') }}" class="admin-logo">
                    <img src="{{ asset('images/logo/headlogo.png') }}" alt="Logo">
                </a>
                <span class="seller-badge">SELLER</span>
            </div>

            {{-- CENTER - Search --}}
            <div class="admin-center">
                <form class="admin-search" role="search">
                    <input type="search" name="q" placeholder="Cari produk, pesanan, pelanggan..." value="">
                    <button type="submit" class="search-icon-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="M21 21l-4.35-4.35"></path>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- RIGHT - Actions --}}
            <div class="admin-actions">

                {{-- Add Dropdown --}}
                <div style="position:relative;">
                    <button id="add-dropdown-btn" class="icon-btn" title="Tambah">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>

                    <div id="add-dropdown" class="admin-profile-dropdown" style="min-width: 220px;">
                        <a href="{{ route('admin.products.create') }}" class="profile-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <path d="M3 9h18"></path>
                                <path d="M9 21V9"></path>
                            </svg>
                            Tambah Produk
                        </a>

                        <a href="{{ route('admin.banners.create') }}" class="profile-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            Buat Banner
                        </a>
                    </div>
                </div>

                {{-- Notifications --}}
                <button class="icon-btn" title="Notifikasi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="badge-notif">3</span>
                </button>

                {{-- Profile --}}
                <div style="position:relative;">
                    <button id="admin-profile-btn" class="admin-profile-btn" title="Akun Saya">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/profile/'.auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="profile-photo">
                        @else
                            <div class="profile-placeholder">{{ strtoupper(mb_substr(auth()->user()->name,0,1,'UTF-8')) }}</div>
                        @endif
                    </button>

                    <div id="admin-profile-dropdown" class="admin-profile-dropdown">
                        <div class="profile-dropdown-top">
                            <div style="display:flex;align-items:center;gap:12px;">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/profile/'.auth()->user()->profile_photo) }}" alt="avatar" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                                @else
                                    <div style="width:48px;height:48px;border-radius:50%;background:#0ea5e9;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;">
                                        {{ strtoupper(mb_substr(auth()->user()->name,0,1,'UTF-8')) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="name">{{ auth()->user()->name }}</div>
                                    <div class="email">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                        </div>

                        <a class="profile-link" href="{{ route('profile.edit') }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Profil Saya
                        </a>

                        <a class="profile-link" href="{{ route('dashboard') }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            Toko Saya
                        </a>
                        
                        <div style="border-top:1px solid #f0f0f0;margin:8px 0;"></div>
                        
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="profile-link logout">
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

            </div>
        </div>
    </div>
</nav>

<!-- LAYOUT CONTAINER -->
<div class="flex">
    
    <!-- LEFT SIDEBAR -->
    <aside id="sidebar" class="sidebar sidebar-expanded custom-scrollbar">
        
        <!-- Toggle Button Inside Sidebar -->
        <div class="p-3 border-b border-gray-200">
            <button id="toggleSidebar" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors text-xs text-gray-600 font-medium">
                <i class="fas fa-bars"></i>
                <span class="sidebar-text">Ciutkan Menu</span>
            </button>
        </div>
        
        <!-- Main Menu -->
        <div class="py-3">
            <div class="sidebar-text px-5 mb-2">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</div>
            </div>
            
            @php
                $menuItems = [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-chart-line', 'label' => 'Dashboard', 'badge' => null],
                    ['route' => 'admin.products.*', 'icon' => 'fa-box', 'label' => 'Produk', 'badge' => null],
                    ['route' => 'admin.orders.*', 'icon' => 'fa-shopping-cart', 'label' => 'Pesanan', 'badge' => '3'],
                    ['route' => 'admin.users.*', 'icon' => 'fa-users', 'label' => 'Pelanggan', 'badge' => null],
                ];
            @endphp
            
            @foreach($menuItems as $item)
            <a href="{{ route(str_replace('.*', '.index', $item['route'])) }}" 
               class="menu-item flex items-center px-5 py-2.5 {{ request()->routeIs($item['route']) ? 'active' : 'text-gray-700' }}">
                <i class="fas {{ $item['icon'] }} w-5 text-center text-sm"></i>
                <span class="sidebar-text ml-3 text-sm font-medium">{{ $item['label'] }}</span>
                @if($item['badge'])
                <span class="sidebar-text ml-auto badge text-white text-xs px-2 py-0.5 rounded-full font-semibold">{{ $item['badge'] }}</span>
                @endif
            </a>
            @endforeach
        </div>
        
        <!-- Divider -->
        <div class="mx-5 border-t border-gray-200"></div>
        
        <!-- Secondary Menu -->
        <div class="py-3">
            <div class="sidebar-text px-5 mb-2">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Lainnya</div>
            </div>
            
            <a href="#" class="menu-item flex items-center px-5 py-2.5 text-gray-700">
                <i class="fas fa-chart-bar w-5 text-center text-sm"></i>
                <span class="sidebar-text ml-3 text-sm font-medium">Laporan</span>
            </a>
            
            <a href="{{ route('admin.banners.index') }}" class="menu-item flex items-center px-5 py-2.5 {{ request()->routeIs('admin.banners.*') ? 'active' : 'text-gray-700' }}">
                <i class="fas fa-bullhorn w-5 text-center text-sm"></i>
                <span class="sidebar-text ml-3 text-sm font-medium">Marketing</span>
            </a>
            
            <a href="#" class="menu-item flex items-center px-5 py-2.5 text-gray-700">
                <i class="fas fa-cog w-5 text-center text-sm"></i>
                <span class="sidebar-text ml-3 text-sm font-medium">Pengaturan</span>
            </a>
        </div>
        
        <!-- Quick Actions -->
        <div class="sidebar-text px-3 py-4 mb-8">
            <a href="#" class="quick-action rounded-xl p-3 text-center block">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-headset text-blue-600 text-lg"></i>
                </div>
                <div class="text-xs font-semibold text-gray-800 mb-1">Butuh Bantuan?</div>
                <div class="text-xs text-gray-500 mb-2">Tim support siap membantu</div>
                <span class="text-xs text-blue-600 font-semibold hover:underline">Hubungi Kami</span>
            </a>
        </div>
        
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"></div>

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="main-wrapper flex-1 overflow-y-auto custom-scrollbar">
        <!-- Content -->
        <div class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </div>
    </main>
</div>

<!-- JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const profileBtn = document.getElementById('admin-profile-btn');
    const profileDrop = document.getElementById('admin-profile-dropdown');
    
    // Check if we're on mobile
    const isMobile = () => window.innerWidth < 1024;
    
    // Load saved sidebar state
    const loadSidebarState = () => {
        const sidebarState = localStorage.getItem('sidebarState');
        return sidebarState === 'collapsed';
    };
    
    // Save sidebar state
    const saveSidebarState = (isCollapsed) => {
        localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
    };
    
    // Initialize layout based on screen size and saved state
    const initLayout = () => {
        if (isMobile()) {
            mainContent.classList.remove('sidebar-collapsed');
            sidebar.classList.remove('mobile-open');
        } else {
            const isCollapsed = loadSidebarState();
            
            if (isCollapsed) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.add('sidebar-collapsed');
                
                document.querySelectorAll('.sidebar-text').forEach(el => {
                    el.classList.add('hidden');
                });
                
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                mainContent.classList.remove('sidebar-collapsed');
                
                document.querySelectorAll('.sidebar-text').forEach(el => {
                    el.classList.remove('hidden');
                });
                
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i><span class="sidebar-text">Ciutkan Menu</span>';
            }
        }
    };
    
    initLayout();
    
    // Handle window resize
    window.addEventListener('resize', () => {
        initLayout();
    });
    
    // Desktop Toggle Sidebar
    toggleBtn?.addEventListener('click', () => {
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('hidden');
            return;
        }
        
        const isExpanded = sidebar.classList.contains('sidebar-expanded');
        
        if (isExpanded) {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
            mainContent.classList.add('sidebar-collapsed');
            
            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.add('hidden');
            });
            
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            saveSidebarState(true);
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
            mainContent.classList.remove('sidebar-collapsed');
            
            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.remove('hidden');
            });
            
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i><span class="sidebar-text">Ciutkan Menu</span>';
            saveSidebarState(false);
        }
    });
    
    // Close mobile sidebar when clicking overlay
    sidebarOverlay?.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.add('hidden');
    });
    
    // Profile Dropdown
    if (profileBtn && profileDrop) {
        profileBtn.addEventListener('click', e => {
            e.stopPropagation();
            profileDrop.classList.toggle('show');
            // Close add dropdown
            const addDrop = document.getElementById('add-dropdown');
            if (addDrop) addDrop.classList.remove('show');
        });
        
        document.addEventListener('click', e => {
            if (!profileDrop.contains(e.target) && !profileBtn.contains(e.target)) {
                profileDrop.classList.remove('show');
            }
        });
    }

    // Add Dropdown
    const addBtn = document.getElementById('add-dropdown-btn');
    const addDrop = document.getElementById('add-dropdown');
    
    if (addBtn && addDrop) {
        addBtn.addEventListener('click', e => {
            e.stopPropagation();
            addDrop.classList.toggle('show');
            // Close profile dropdown
            if (profileDrop) profileDrop.classList.remove('show');
        });
        
        document.addEventListener('click', e => {
            if (!addDrop.contains(e.target) && !addBtn.contains(e.target)) {
                addDrop.classList.remove('show');
            }
        });
    }
});
</script>

@yield('scripts')
</body>
</html>