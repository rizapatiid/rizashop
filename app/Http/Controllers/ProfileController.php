<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil + list alamat (diambil dari tabel addresses)
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.edit', [
            'user'      => $user,
            'addresses' => $user->addresses()->orderByDesc('is_primary')->get(),
        ]);
    }

    /**
     * Update data profil USER SAJA (tanpa alamat)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        /** -----------------------------
         *  HANDLE FOTO PROFIL
         * ----------------------------- */
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());

            // simpan file
            $file->storeAs('public/profile', $filename);

            // hapus foto lama
            if ($user->profile_photo && Storage::exists('public/profile/'.$user->profile_photo)) {
                Storage::delete('public/profile/'.$user->profile_photo);
            }

            $data['profile_photo'] = $filename;
        }

        /** -----------------------------
         *  NORMALISASI DATA KOSONG
         * ----------------------------- */
        foreach (['name','email','phone_country','phone'] as $f) {
            if (isset($data[$f]) && $data[$f] === '') {
                $data[$f] = null;
            }
        }

        /** -----------------------------
         *  HANDLE UPDATE USER
         * ----------------------------- */
        $user->fill($data);

        // reset verifikasi email jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        /** -----------------------------
         *  RESPONSE AJAX
         * ----------------------------- */
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
            ]);
        }

        /** -----------------------------
         *  RESPONSE NORMAL
         * ----------------------------- */
        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('message', 'Profil berhasil disimpan.');
    }

    /**
     * Upload foto profil (khusus AJAX)
     */
    public function uploadPhoto(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'profile_photo' => ['required', 'image', 'max:2048'],
        ]);

        try {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());

            $file->storeAs('public/profile', $filename);

            // hapus lama
            if ($user->profile_photo && Storage::exists('public/profile/'.$user->profile_photo)) {
                Storage::delete('public/profile/'.$user->profile_photo);
            }

            $user->profile_photo = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'url'     => asset('storage/profile/'.$filename),
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah foto.',
            ], 500);
        }
    }

    /**
     * Hapus akun user
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required','current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // hapus foto
        if ($user->profile_photo && Storage::exists('public/profile/'.$user->profile_photo)) {
            Storage::delete('public/profile/'.$user->profile_photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
