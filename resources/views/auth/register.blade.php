<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - TOKORIZA</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-r from-sky-300 via-sky-50 to-yellow-200 flex items-start sm:items-center justify-center px-3 sm:px-4 lg:px-8 py-6">

    <div class="w-full max-w-md mx-auto space-y-4 sm:space-y-6">

        {{-- LOGO (sama seperti login) --}}
        <div class="flex flex-col items-center text-center mt-2 sm:mt-0">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo/logo_tokoriza.png') }}"
                     class="h-20 sm:h-20 md:h-24 object-contain mx-auto hover:scale-105 duration-150"
                     alt="Logo Tokoriza">
            </a>
        </div>

        {{-- CARD REGISTER --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/80 overflow-hidden">
            <div class="px-4 sm:px-6 md:px-7 pt-5 sm:pt-7 pb-5 sm:pb-7 space-y-4 sm:space-y-5">

                {{-- Judul --}}
                <h2 class="text-base sm:text-lg font-semibold text-slate-800 text-center">
                    Daftar Akun
                </h2>

                {{-- STATUS --}}
                @if (session('status'))
                    <div id="alert-status"
                         class="text-xs sm:text-sm rounded-lg px-3 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 flex justify-between">
                        <span>{{ session('status') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-lg leading-none">×</button>
                    </div>
                @endif

                {{-- ERROR GLOBAL --}}
                @if ($errors->any())
                    <div id="alert-error"
                         class="text-xs sm:text-sm rounded-lg px-3 py-2 bg-red-50 border border-red-200 text-red-700 flex justify-between">
                        <span>Terjadi kesalahan, silakan cek kembali data yang diisi.</span>
                        <button onclick="this.parentElement.remove()" class="text-lg leading-none">×</button>
                    </div>
                @endif

                {{-- FORM REGISTER --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-3 sm:space-y-4">
                    @csrf

                    {{-- NAMA --}}
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700">
                            Nama Lengkap
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="1.8"
                                          d="M5.121 17.804A9 9 0 1112 21a8.965 8.965 0 01-6.879-3.196z" />
                                </svg>
                            </span>

                            <input type="text" name="name" value="{{ old('name') }}" required
                                   autocomplete="name"
                                   class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3 py-2.5
                                          text-sm text-slate-800 placeholder-slate-400
                                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                                   placeholder="Nama lengkap Anda">
                        </div>

                        @error('name')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700">
                            Email
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                   placeholder="email@example.com">
                        </div>

                        @error('email')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NOMOR HANDPHONE (kode negara + nomor) --}}
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700">
                            Nomor Handphone
                        </label>

                        <div class="flex flex-col sm:flex-row gap-2">
                            {{-- SELECT KODE NEGARA (dengan bendera, banyak opsi → dropdown akan bisa scroll otomatis) --}}
                            <div class="relative sm:w-40">
                                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 text-[11px]">
                                    🌐
                                </span>
                                <select name="phone_country"
                                        class="w-full rounded-lg border border-slate-300 bg-white pl-7 pr-6 py-2.5
                                               text-sm text-slate-800 focus:outline-none focus:ring-2
                                               focus:ring-sky-300 focus:border-sky-400">
                                    <option value="+62" {{ old('phone_country', '+62') == '+62' ? 'selected' : '' }}>🇮🇩 +62 (Indonesia)</option>
                                    <option value="+60" {{ old('phone_country') == '+60' ? 'selected' : '' }}>🇲🇾 +60 (Malaysia)</option>
                                    <option value="+65" {{ old('phone_country') == '+65' ? 'selected' : '' }}>🇸🇬 +65 (Singapore)</option>
                                    <option value="+66" {{ old('phone_country') == '+66' ? 'selected' : '' }}>🇹🇭 +66 (Thailand)</option>
                                    <option value="+63" {{ old('phone_country') == '+63' ? 'selected' : '' }}>🇵🇭 +63 (Philippines)</option>
                                    <option value="+81" {{ old('phone_country') == '+81' ? 'selected' : '' }}>🇯🇵 +81 (Japan)</option>
                                    <option value="+82" {{ old('phone_country') == '+82' ? 'selected' : '' }}>🇰🇷 +82 (Korea)</option>
                                    <option value="+86" {{ old('phone_country') == '+86' ? 'selected' : '' }}>🇨🇳 +86 (China)</option>
                                    <option value="+91" {{ old('phone_country') == '+91' ? 'selected' : '' }}>🇮🇳 +91 (India)</option>
                                    <option value="+1"  {{ old('phone_country') == '+1'  ? 'selected' : '' }}>🇺🇸 +1 (USA)</option>
                                    <option value="+44" {{ old('phone_country') == '+44' ? 'selected' : '' }}>🇬🇧 +44 (UK)</option>
                                    <option value="+49" {{ old('phone_country') == '+49' ? 'selected' : '' }}>🇩🇪 +49 (Germany)</option>
                                    <option value="+33" {{ old('phone_country') == '+33' ? 'selected' : '' }}>🇫🇷 +33 (France)</option>
                                    <option value="+39" {{ old('phone_country') == '+39' ? 'selected' : '' }}>🇮🇹 +39 (Italy)</option>
                                    <option value="+61" {{ old('phone_country') == '+61' ? 'selected' : '' }}>🇦🇺 +61 (Australia)</option>
                                </select>
                            </div>

                            {{-- INPUT NOMOR HP --}}
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-width="1.8"
                                              d="M3 5a2 2 0 012-2h2.28a1 1 0 01.95.684l1.1 3.3a1 1 0 01-.417 1.185l-1.52.95a11.04 11.04 0 005.02 5.02l.95-1.52a1 1 0 011.185-.417l3.3 1.1A1 1 0 0121 15.72V18a2 2 0 01-2 2h-1C9.82 20 4 14.18 4 7V5z" />
                                    </svg>
                                </span>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3 py-2.5
                                              text-sm text-slate-800 placeholder-slate-400
                                              focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                                       placeholder="contoh: 81234567890">
                            </div>
                        </div>

                        @error('phone_country')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                        @error('phone')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700">
                            Password
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="1.8"
                                          d="M12 15a2 2 0 100-4 2 
                                          2 0 000 4zM17 8V7a5 5 0 
                                          00-10 0v1M7 8h10a2 2 0 
                                          012 2v8a2 2 0 01-2 2H7a2 
                                          2 0 01-2-2v-8a2 2 0 012-2z"/>
                                </svg>
                            </span>

                            <input id="password" type="password" name="password" required
                                   autocomplete="new-password"
                                   class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-9 py-2.5
                                          text-sm text-slate-800 placeholder-slate-400
                                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                                   placeholder="Minimal 8 karakter">

                            {{-- Toggle --}}
                            <button type="button"
                                    onclick="togglePassword('password','eyeOpen1','eyeClose1')"
                                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg id="eyeOpen1" class="h-4 w-4" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="1.8"
                                        d="M2.458 12C3.732 7.943 7.523 5 
                                        12 5c4.477 0 8.268 2.943 9.542 
                                        7-1.274 4.057-5.065 7-9.542 
                                        7-4.477 0-8.268-2.943-9.542-7z"/>
                                    <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                                </svg>

                                <svg id="eyeClose1"
                                     class="h-4 w-4 hidden"
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

                        @error('password')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700">
                            Konfirmasi Password
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="1.8"
                                          d="M12 15a2 2 0 100-4 2 
                                          2 0 000 4zM17 8V7a5 5 0 
                                          00-10 0v1M7 8h10a2 2 0 
                                          012 2v8a2 2 0 01-2 2H7a2 
                                          2 0 01-2-2v-8a2 2 0 012-2z"/>
                                </svg>
                            </span>

                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   autocomplete="new-password"
                                   class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-9 py-2.5
                                          text-sm text-slate-800 placeholder-slate-400
                                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                                   placeholder="Ulangi password">

                            {{-- Toggle --}}
                            <button type="button"
                                    onclick="togglePassword('password_confirmation','eyeOpen2','eyeClose2')"
                                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">

                                <svg id="eyeOpen2" class="h-4 w-4" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="1.8"
                                          d="M2.458 12C3.732 7.943 7.523 5 
                                          12 5c4.477 0 8.268 2.943 9.542 
                                          7-1.274 4.057-5.065 7-9.542 
                                          7-4.477 0-8.268-2.943-9.542-7z"/>
                                    <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                                </svg>

                                <svg id="eyeClose2"
                                     class="h-4 w-4 hidden"
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

                        @error('password_confirmation')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON DAFTAR --}}
                    <button type="submit"
                            class="w-full rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold
                                   py-2.5 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-300
                                   active:scale-[0.99] transition">
                        Daftar
                    </button>

                    {{-- SUDAH PUNYA AKUN --}}
                    <p class="text-center text-xs sm:text-[13px] text-slate-700">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-sky-600 font-semibold hover:underline">
                            Login
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
        function togglePassword(field, openIcon, closeIcon) {
            const input = document.getElementById(field);
            const open = document.getElementById(openIcon);
            const close = document.getElementById(closeIcon);

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
