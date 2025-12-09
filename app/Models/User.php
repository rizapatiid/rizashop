<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_country',
        'phone',
        'role',
        'is_active',
        'profile_photo',
        // ❌ HAPUS semua field alamat lama karena sekarang pakai tabel addresses
        // 'address_full',
        // 'village',
        // 'subdistrict',
        // 'city',
        // 'province',
        // 'country',
        // 'postal_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * RELATIONSHIP: User punya banyak alamat (multi-address)
     */
    public function addresses()
    {
        return $this->hasMany(Address::class)
            ->orderByDesc('is_primary')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * RELATIONSHIP: Ambil alamat utama user
     */
    public function primaryAddress()
    {
        return $this->hasOne(Address::class)
            ->where('is_primary', true);
    }
}
