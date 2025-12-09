<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TOKORIZA</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

{{-- MOBILE: items-center  | DESKTOP: items-start --}}
<body class="min-h-screen bg-gradient-to-r from-sky-300 via-sky-50 to-yellow-200 
            flex flex-col sm:flex sm:items-start justify-center px-3 sm:px-4 lg:px-8 py-6">

    <div class="w-full max-w-md mx-auto space-y-4 sm:space-y-6 mt-5 sm:mt-0">

        {{-- LOGO (dibesarkan khusus mobile) --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo/logo_tokoriza.png') }}"
                     class="h-20 sm:h-20 md:h-24 object-contain mx-auto hover:scale-105 duration-150"
                     alt="Logo Tokoriza">
            </a>
        </div>

        {{-- CARD LOGIN --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/80 overflow-hidden">

            {{-- MOBILE FORM DIPUSATKAN & DIPERKECILKAN --}}
            <div class="px-4 sm:px-6 md:px-7 pt-5 sm:pt-7 pb-5 sm:pb-7 
                        space-y-4 sm:space-y-5">

                {{-- Judul Login (tengah) --}}
                <h2 class="text-base sm:text-lg font-semibold text-slate-800 text-center">
                    Login
                </h2>

                {{-- STATUS BERHASIL --}}
                @if (session('status'))
                    <div id="alert-status"
                         class="text-xs sm:text-sm rounded-lg px-3 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 flex justify-between">
                        <span>{{ session('status') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-lg leading-none">×</button>
                    </div>
                @endif

                {{-- STATUS GAGAL --}}
                @if ($errors->any())
                    <div id="alert-error"
                         class="text-xs sm:text-sm rounded-lg px-3 py-2 bg-red-50 border border-red-200 text-red-700 flex justify-between">
                        <span>Email atau password salah.</span>
                        <button onclick="this.parentElement.remove()" class="text-lg leading-none">×</button>
                    </div>
                @endif

                {{-- FORM LOGIN --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-3 sm:space-y-4">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="1.8"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 
                                    2 0 002-2V7a2 2 0 00-2-2H5a2 
                                    2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>

                        <input type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username"
                            class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3 py-2.5 
                                   text-sm text-slate-800 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                            placeholder="Email">
                    </div>

                    {{-- PASSWORD --}}
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="1.8"
                                    d="M12 15a2 2 0 100-4 2 
                                    2 0 000 4zM17 8V7a5 5 0 
                                    00-10 0v1M7 8h10a2 2 0 
                                    012 2v8a2 2 0 01-2 2H7a2 
                                    2 0 01-2-2v-8a2 2 0 012-2z"/>
                            </svg>
                        </span>

                        <input id="password" type="password" name="password" required
                            autocomplete="current-password"
                            class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-9 py-2.5 
                                   text-sm text-slate-800 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                            placeholder="Password">

                        {{-- TOGGLE --}}
                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                            
                            {{-- OPEN EYE --}}
                            <svg id="eyeIconOpen" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="1.8"
                                    d="M2.458 12C3.732 7.943 7.523 5 
                                    12 5c4.477 0 8.268 2.943 9.542 
                                    7-1.274 4.057-5.065 7-9.542 
                                    7-4.477 0-8.268-2.943-9.542-7z"/>
                                <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                            </svg>

                            {{-- CLOSED EYE --}}
                            <svg id="eyeIconClosed"
                                class="h-4 w-4 sm:h-5 sm:w-5 hidden"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="1.8"
                                    d="M13.875 18.825A10.05 10.05 0 
                                    0112 19c-4.477 0-8.268-2.943-9.542-7a9.96 
                                    9.96 0 012.223-3.592M9.88 9.88A3 
                                    3 0 0114.12 14.12M6.1 6.1L4 4m0 
                                    0l2.1 2.1M4 4l4.243 4.243M20 
                                    20L4 4"/>
                            </svg>
                        </button>
                    </div>

                    {{-- REMEMBER + LUPA PASSWORD --}}
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center text-xs sm:text-[13px] text-slate-700">
                            <input type="checkbox"
                                class="h-4 w-4 text-sky-500 border-slate-300 focus:ring-sky-500">
                            <span class="ml-2">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs sm:text-[13px] text-sky-600 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    {{-- BUTTON LOGIN --}}
                    <button type="submit"
                        class="w-full rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold
                               py-2.5 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-300
                               active:scale-[0.99] transition">
                        Masuk
                    </button>

                    {{-- REGISTER --}}
                    <p class="text-xs sm:text-[13px] text-slate-700 text-center">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-sky-600 font-semibold hover:underline">
                            Daftar
                        </a>
                    </p>

                </form>
            </div>
        </div>

        {{-- COPYRIGHT --}}
        <p class="text-[10px] sm:text-[11px] text-slate-700 text-center pb-2">
            © {{ date('Y') }} Tokoriza. All rights reserved.
        </p>
    </div>

    {{-- SCRIPT --}}
    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const open = document.getElementById("eyeIconOpen");
            const close = document.getElementById("eyeIconClosed");

            if (input.type === "password") {
                input.type = "text";
                open.classList.add("hidden");
                close.classList.remove("hidden");
            } else {
                input.type = "password";
                close.classList.add("hidden");
                open.classList.remove("hidden");
            }
        }

        // Auto hide alerts after 4 seconds
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                const st = document.getElementById("alert-status");
                const er = document.getElementById("alert-error");
                if (st) st.remove();
                if (er) er.remove();
            }, 4000);
        });
    </script>

</body>
</html>
