<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - TOKORIZA</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-r from-sky-300 via-sky-50 to-yellow-200 
            flex items-start sm:items-center justify-center px-3 sm:px-4 lg:px-8 py-6">

    <div class="w-full max-w-md mx-auto space-y-4 sm:space-y-6">

        {{-- LOGO (sama seperti login & register) --}}
        <div class="flex flex-col items-center text-center mt-2 sm:mt-0">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo/logo_tokoriza.png') }}"
                     class="h-20 sm:h-20 md:h-24 object-contain mx-auto hover:scale-105 duration-150"
                     alt="Logo Tokoriza">
            </a>
        </div>

        {{-- CARD RESET PASSWORD --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200/80 overflow-hidden">
            <div class="px-4 sm:px-6 md:px-7 pt-5 sm:pt-7 pb-5 sm:pb-7 space-y-4 sm:space-y-5">

                {{-- JUDUL --}}
                <h2 class="text-base sm:text-lg font-semibold text-slate-800 text-center">
                    Reset Password
                </h2>

                {{-- STATUS SUCCESS --}}
                @if (session('status'))
                    <div id="alert-status"
                         class="text-xs sm:text-sm rounded-lg px-3 py-2 bg-emerald-50
                                border border-emerald-200 text-emerald-700 flex justify-between">
                        <span>{{ session('status') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-lg leading-none">×</button>
                    </div>
                @endif

                {{-- ERROR --}}
                @if ($errors->any())
                    <div id="alert-error"
                         class="text-xs sm:text-sm rounded-lg px-3 py-2 bg-red-50 border-red-200 text-red-700 
                                border flex justify-between">
                        <span>Terjadi kesalahan, cek email Anda.</span>
                        <button onclick="this.parentElement.remove()" class="text-lg leading-none">×</button>
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-3 sm:space-y-4">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700">
                            Email Terdaftar
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="1.8"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 
                                        2 0 002-2V7a2 2 0 00-2-2H5a2 
                                        2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>

                            <input type="email" name="email" required
                                   class="w-full rounded-lg border border-slate-300 bg-white pl-9 pr-3 py-2.5
                                          text-sm text-slate-800 placeholder-slate-400
                                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400"
                                   placeholder="email@example.com"
                                   value="{{ old('email') }}">
                        </div>

                        @error('email')
                            <p class="text-[11px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON RESET PASSWORD --}}
                    <button type="submit"
                            class="w-full rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold
                                   py-2.5 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-300
                                   active:scale-[0.99] transition">
                        Kirim Link Reset Password
                    </button>

                    {{-- KEMBALI KE LOGIN --}}
                    <p class="text-center text-xs sm:text-[13px] text-slate-700">
                        Ingat password Anda?
                        <a href="{{ route('login') }}" class="text-sky-600 font-semibold hover:underline">
                            Kembali ke Login
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

    {{-- AUTO HIDE ALERT --}}
    <script>
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
