<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],

            'email' => [
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // Kode negara nomor HP (contoh: +62)
            'phone_country' => [
                'required',
                'string',
                'max:5',
            ],

            // Nomor HP (hanya angka)
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9]+$/', // hanya angka
            ],

            // Foto profil (opsional)
            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2MB
            ],
        ];
    }
}
