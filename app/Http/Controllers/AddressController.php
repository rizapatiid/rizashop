<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // optional: halaman daftar alamat (jika diperlukan)
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->get();

        return view('profile.addresses.index', compact('addresses', 'user'));
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'label' => ['nullable','string','max:120'],
            'recipient_name' => ['nullable','string','max:120'],
            'address_full' => ['nullable','string','max:2000'],
            'village' => ['nullable','string','max:255'],
            'subdistrict' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'province' => ['nullable','string','max:255'],
            'country' => ['nullable','string','max:255'],
            'postal_code' => ['nullable','string','max:32'],
            'phone_country' => ['nullable','string','max:8'],
            'phone' => ['nullable','string','max:32'],
            'is_primary' => ['sometimes','boolean'],
        ]);

        $isPrimary = !empty($data['is_primary']) && (bool)$data['is_primary'];

        DB::transaction(function () use ($user, $data, $isPrimary) {
            if ($isPrimary) {
                $user->addresses()->update(['is_primary' => false]);
            }

            $data['is_primary'] = $isPrimary;
            $data['user_id'] = $user->id;

            Address::create($data);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Alamat berhasil ditambahkan.']);
        }

        // redirect to /account#address
        return Redirect::to(route('profile.edit') . '#address')->with('message', 'Alamat berhasil ditambahkan.');
    }

    /**
     * Show edit form (optional: return JSON if AJAX)
     */
    public function edit(Address $address)
    {
        $this->authorizeOwnership($address);

        // if AJAX request, return address as JSON (used by modal edit)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['address' => $address]);
        }

        return view('profile.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, Address $address)
    {
        $this->authorizeOwnership($address);

        $data = $request->validate([
            'label' => ['nullable','string','max:120'],
            'recipient_name' => ['nullable','string','max:120'],
            'address_full' => ['nullable','string','max:2000'],
            'village' => ['nullable','string','max:255'],
            'subdistrict' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'province' => ['nullable','string','max:255'],
            'country' => ['nullable','string','max:255'],
            'postal_code' => ['nullable','string','max:32'],
            'phone_country' => ['nullable','string','max:8'],
            'phone' => ['nullable','string','max:32'],
            'is_primary' => ['sometimes','boolean'],
        ]);

        $isPrimary = !empty($data['is_primary']) && (bool)$data['is_primary'];

        DB::transaction(function () use ($address, $data, $isPrimary) {
            if ($isPrimary) {
                $address->user->addresses()->update(['is_primary' => false]);
            }
            $data['is_primary'] = $isPrimary;
            $address->update($data);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Alamat berhasil diperbarui.']);
        }

        return Redirect::to(route('profile.edit') . '#address')->with('message', 'Alamat berhasil diperbarui.');
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Request $request, Address $address)
    {
        $this->authorizeOwnership($address);

        $address->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Alamat berhasil dihapus.']);
        }

        return Redirect::to(route('profile.edit') . '#address')->with('message', 'Alamat berhasil dihapus.');
    }

    /**
     * Set an address as primary.
     */
    public function setPrimary(Request $request, Address $address)
    {
        $this->authorizeOwnership($address);

        try {
            DB::transaction(function () use ($address) {
                $user = $address->user;
                $user->addresses()->update(['is_primary' => false]);
                $address->update(['is_primary' => true]);
            });

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Alamat utama berhasil diubah.']);
            }

            return Redirect::to(route('profile.edit') . '#address')->with('message', 'Alamat utama berhasil diubah.');
        } catch (\Throwable $e) {
            // return error JSON for AJAX, or redirect back with error message
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengubah alamat utama.'], 500);
            }
            return Redirect::to(route('profile.edit') . '#address')->with('error', 'Gagal mengubah alamat utama.');
        }
    }

    /**
     * Simple ownership check - abort 403 if user does not own the address.
     */
    protected function authorizeOwnership(Address $address): void
    {
        $user = Auth::user();
        if (!$user || $address->user_id !== $user->id) {
            abort(403, 'Aksi tidak diizinkan.');
        }
    }
}
