<nav x-data="{ open: false, cartOpen: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo/logo_tokoriza.png') }}"
                             alt="Tokoriza Logo"
                             class="h-8 w-auto" style="max-height:30px;">
                    </a>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Home
                    </x-nav-link>

                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                        Produk
                    </x-nav-link>
                </div>
            </div>

            {{-- Bagian kanan: Keranjang + Auth --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @php
                    $cart = session('cart', []);
                    $cartCount = collect($cart)->sum('qty');
                @endphp

                {{-- CART ICON + MINI CART --}}
                <div class="relative mr-4"
                     @mouseenter="cartOpen = true"
                     @mouseleave="cartOpen = false">

                    {{-- Ikon keranjang --}}
                    <button type="button" class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             class="h-6 w-6 text-gray-700 hover:text-gray-900">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3h3l2.4 12h11l2-7H6" />
                            <circle cx="10" cy="19" r="1.5"/>
                            <circle cx="17" cy="19" r="1.5"/>
                        </svg>

                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px]
                                        font-semibold rounded-full h-4 min-w-[16px] px-1
                                        flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>

                    {{-- MINI CART DROPDOWN --}}
                    <div x-show="cartOpen"
                         x-transition.opacity
                         class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-xl
                                border border-gray-200 z-50 overflow-hidden"
                         style="display: none;">

                        {{-- Header --}}
                        <div class="px-4 py-3 border-b bg-gray-50">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-gray-800">Keranjang</span>
                                @if($cartCount > 0)
                                    <span class="text-xs text-gray-500">
                                        {{ $cartCount }} item
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Isi --}}
                        @if($cartCount === 0)
                            <div class="p-4 text-gray-500 text-sm text-center">
                                Keranjang masih kosong
                            </div>
                        @else
                            <div class="max-h-72 overflow-y-auto">
                                @foreach($cart as $item)
                                    <div class="flex items-center gap-3 px-4 py-3 border-b last:border-b-0 hover:bg-gray-50">
                                        {{-- Gambar produk --}}
                                        @if(!empty($item['image']))
                                            <div class="h-12 w-12 rounded-md overflow-hidden border border-gray-200 flex-shrink-0">
                                                <img src="{{ asset('storage/'.$item['image']) }}"
                                                     alt="{{ $item['name'] }}"
                                                     class="h-full w-full object-cover">
                                            </div>
                                        @else
                                            <div class="h-12 w-12 flex items-center justify-center bg-gray-100
                                                        rounded-md border text-[10px] text-gray-400 flex-shrink-0">
                                                No Img
                                            </div>
                                        @endif

                                        {{-- Info produk --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-800 truncate">
                                                {{ $item['name'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Qty: {{ $item['qty'] }}
                                            </div>
                                        </div>

                                        {{-- Harga --}}
                                        <div class="text-xs font-semibold text-gray-700 text-right whitespace-nowrap">
                                            Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer --}}
                            <div class="px-4 py-3 bg-gray-50 flex items-center justify-between">
                                @php
                                    $total = collect($cart)->reduce(function ($c, $i) {
                                        return $c + ($i['price'] * $i['qty']);
                                    }, 0);
                                @endphp
                                <div class="text-xs text-gray-600">
                                    Total:
                                    <span class="font-semibold text-gray-900">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ route('shop.cart') }}"
                                   class="inline-flex justify-center px-3 py-2 bg-blue-600
                                          text-white rounded-md text-xs font-medium hover:bg-blue-700">
                                    Lihat Keranjang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- AUTH DROPDOWN --}}
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2 py-1 text-sm text-gray-600 bg-white hover:text-gray-800">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8')) }}
                                </span>
                            </div>

                            <span class="mr-1">
                                {{ \Illuminate\Support\Str::limit(Auth::user()->name, 15) }}
                            </span>

                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            {{-- HAMBURGER (MOBILE) --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Home
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                Produk
            </x-responsive-nav-link>

            @php
                $cartCount = collect(session('cart', []))->sum('qty');
            @endphp

            <x-responsive-nav-link :href="route('shop.cart')" :active="request()->routeIs('shop.cart')">
                Keranjang
                @if($cartCount > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs bg-red-600 text-white">
                        {{ $cartCount }}
                    </span>
                @endif
            </x-responsive-nav-link>
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                    <span class="text-xs font-semibold text-gray-700">
                        {{ strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8')) }}
                    </span>
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
