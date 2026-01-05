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
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: #f8fafc;
        }
        
        /* Top Navigation */
        .top-nav {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Sidebar Minimalis */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
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
        
        /* Dropdown */
        .dropdown {
            animation: slideDown 0.2s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Button */
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }
        
        /* Stats Card */
        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }
        
        /* Search */
        .search-box {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .search-box:focus-within {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
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
        
        /* Profile Avatar */
        .avatar-ring {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
    </style>

    @yield('styles')
</head>

<body class="antialiased">

<!-- TOP NAVIGATION BAR -->
<nav class="top-nav fixed w-full h-14 z-50">
    <div class="h-full px-4 flex items-center justify-between">
        
        <!-- Left: Logo & Store Info -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo/logo_tokoriza.png') }}" class="h-7">
                <div class="h-5 w-px bg-white opacity-20 hidden lg:block"></div>
                <div class="hidden lg:block">
                    <div class="text-white text-xs font-semibold">Seller Center</div>
                    <div class="text-blue-300 text-xs">TokoRiza Official Store</div>
                </div>
            </div>
            
            <!-- Search Global - Desktop Only -->
            <div class="search-box rounded-lg px-3 py-1.5 items-center gap-2 w-64 xl:w-80 ml-2 hidden md:flex">
                <i class="fas fa-search text-white opacity-60 text-xs"></i>
                <input type="text" 
                       placeholder="Cari produk, pesanan..." 
                       class="bg-transparent text-white text-xs placeholder-white placeholder-opacity-50 outline-none w-full">
                <span class="text-white opacity-40 text-xs hidden xl:inline">Ctrl+K</span>
            </div>
        </div>

        <!-- Right: Actions & Profile -->
        <div class="flex items-center gap-2">
            
            <!-- Mobile Search Toggle -->
            <button class="w-9 h-9 rounded-lg hover:bg-white hover:bg-opacity-10 flex items-center justify-center transition-colors md:hidden">
                <i class="fas fa-search text-white"></i>
            </button>
            
            <!-- Quick Add -->
            <div class="relative">
                <button id="quick-add-btn" class="btn-primary px-3 py-1.5 rounded-lg text-white text-xs font-semibold flex items-center gap-2 relative z-10">
                    <i class="fas fa-plus"></i>
                    <span class="hidden sm:inline">Tambah</span>
                    <i class="fas fa-chevron-down text-xs hidden sm:inline"></i>
                </button>
                
                <div id="quick-add-dropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden dropdown">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center px-3 py-2.5 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-2.5">
                            <i class="fas fa-box text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-800">Produk Baru</div>
                            <div class="text-xs text-gray-500">Tambah produk</div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Notifications -->
            <button class="w-9 h-9 rounded-lg hover:bg-white hover:bg-opacity-10 flex items-center justify-center relative transition-colors">
                <i class="fas fa-bell text-white"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-gray-900"></span>
            </button>
            
            <!-- Help - Desktop Only -->
            <a href="/account#help" class="w-9 h-9 rounded-lg hover:bg-white hover:bg-opacity-10 items-center justify-center transition-colors hidden lg:flex">
                <i class="fas fa-question-circle text-white"></i>
            </a>
            
            <!-- Divider - Desktop Only -->
            <div class="h-7 w-px bg-white opacity-20 mx-1 hidden lg:block"></div>
            
            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profile-btn" class="flex items-center gap-2 hover:bg-white hover:bg-opacity-10 px-2 py-1.5 rounded-lg transition-colors">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff&bold=true&size=80" 
                         class="w-8 h-8 rounded-full avatar-ring">
                    <div class="text-left hidden lg:block">
                        <div class="text-white text-xs font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-blue-300 text-xs">Administrator</div>
                    </div>
                    <i class="fas fa-chevron-down text-white text-xs opacity-60 hidden lg:inline"></i>
                </button>
                
                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden dropdown">
                    <div class="px-3 py-3 border-b border-gray-100">
                        <div class="font-semibold text-gray-800 text-xs">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500">administrator@tokoriza.com</div>
                    </div>
                    
                    <a href="/account" class="flex items-center px-3 py-2.5 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-user-circle w-5 text-gray-600 mr-2.5 text-sm"></i>
                        <span class="text-xs text-gray-700">Profil Saya</span>
                    </a>
                    
                    <div class="border-t border-gray-100"></div>
                    
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center px-3 py-2.5 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-5 text-red-600 mr-2.5 text-sm"></i>
                        <span class="text-xs text-red-600 font-medium">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<!-- LAYOUT CONTAINER -->
<div class="flex pt-14 h-screen">
    
    <!-- LEFT SIDEBAR -->
    <aside id="sidebar" class="sidebar sidebar-expanded fixed h-full overflow-y-auto custom-scrollbar z-40 lg:z-auto pb-4">
        
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
            
            <a href="#" class="menu-item flex items-center px-5 py-2.5 text-gray-700">
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
            <a href="/account#cs" class="quick-action rounded-xl p-3 text-center block">
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
    <main id="main-content" class="flex-1 overflow-y-auto custom-scrollbar transition-all duration-300" style="margin-left: 260px;">
        

        
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
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    
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
            mainContent.style.marginLeft = '0';
            sidebar.classList.remove('mobile-open');
        } else {
            // Apply saved state on desktop
            const isCollapsed = loadSidebarState();
            
            if (isCollapsed) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                mainContent.style.marginLeft = '72px';
                
                document.querySelectorAll('.sidebar-text').forEach(el => {
                    el.classList.add('hidden');
                });
                
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                mainContent.style.marginLeft = '240px';
                
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
        if (isMobile()) return;
        
        const isExpanded = sidebar.classList.contains('sidebar-expanded');
        
        if (isExpanded) {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
            mainContent.style.marginLeft = '72px';
            
            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.add('hidden');
            });
            
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            saveSidebarState(true); // Save collapsed state
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
            mainContent.style.marginLeft = '240px';
            
            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.remove('hidden');
            });
            
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i><span class="sidebar-text">Ciutkan Menu</span>';
            saveSidebarState(false); // Save expanded state
        }
    });
    
    // Mobile Menu Toggle
    mobileMenuToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('hidden');
    });
    
    // Close mobile sidebar when clicking overlay
    sidebarOverlay?.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.add('hidden');
    });
    
    // Close mobile sidebar when clicking a menu item
    if (isMobile()) {
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.add('hidden');
            });
        });
    }
    
    // Dropdown handlers
    const bindDropdown = (btnId, dropdownId) => {
        const btn = document.getElementById(btnId);
        const dropdown = document.getElementById(dropdownId);
        
        btn?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
            
            // Close other dropdowns
            document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
                if (el.id !== dropdownId) {
                    el.classList.add('hidden');
                }
            });
        });
    };
    
    bindDropdown('quick-add-btn', 'quick-add-dropdown');
    bindDropdown('profile-btn', 'profile-dropdown');
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
            el.classList.add('hidden');
        });
    });
});
</script>

@yield('scripts')
</body>
</html>