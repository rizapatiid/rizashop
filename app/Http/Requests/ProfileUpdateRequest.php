<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Authorize the request.
     * Return true so the controller receives the validated data.
     */
    public function authorize(): bool
    {
        // Atau gunakan: return auth()->check();
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            // --- DATA USER ---
            'name' => ['nullable','string', 'max:255'],

            'email' => [
                'nullable','email','max:255',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],

            'phone_country' => [
                'nullable','string','max:5',
            ],

            'phone' => [
                'nullable','string','max:20',
                'regex:/^[0-9]+$/',
            ],

            // --- FOTO PROFIL ---
            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            // --- ALAMAT TERPERINCI ---
            'address_full' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'village' => [
                'nullable',
                'string',
                'max:120',
            ],

            'subdistrict' => [
                'nullable',
                'string',
                'max:120',
            ],

            'city' => [
                'nullable',
                'string',
                'max:120',
            ],

            'province' => [
                'nullable',
                'string',
                'max:120',
            ],

            'country' => [
                'nullable',
                'string',
                'max:120',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9]+$/', // kode pos hanya angka
            ],
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'postal_code.regex' => 'Kode pos hanya boleh berisi angka.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ];
    }
}
