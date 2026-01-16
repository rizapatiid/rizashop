<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'subtotal',
        'shipping_cost',
        'shipping_method',
        'shipping_courier',
        'total',
        'currency',
        'status',
        'notes',
    ];

    // casts
    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function address()
    {
        return $this->belongsTo(\App\Models\Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // helper: generate a simple order number
    public static function generateOrderNumber(): string
    {
        return 'TR-' . strtoupper(uniqid());
    }



        public function payment() { return $this->hasOne(\App\Models\Payment::class); }


}
