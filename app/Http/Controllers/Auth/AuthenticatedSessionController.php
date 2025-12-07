<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // authenticate (LoginRequest dari Breeze)
        $request->authenticate();

        // Ambil user yang baru saja login
        $user = Auth::user();

        // Jika ada kolom is_active dan user non-aktif, force logout dan kirim error
        if (isset($user->is_active) && $user->is_active === false) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
            ]);
        }

        // Regenerate session setelah berhasil login
        $request->session()->regenerate();

        // Ambil intended (jika user sempat diarahkan ke halaman terlindungi sebelum login)
        $intended = session()->pull('url.intended', null);
        $isValidIntended = $intended && ! str_contains($intended, '/login') && ! str_contains($intended, '/register');

        // Redirect berdasarkan role
        if ($user && $user->role === 'admin') {
            if ($isValidIntended) {
                return redirect()->intended($intended);
            }
            return redirect()->route('admin.dashboard');
        }

        // User biasa
        if ($isValidIntended) {
            return redirect()->intended($intended);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
