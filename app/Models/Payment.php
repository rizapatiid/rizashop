<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','method','amount','status','proof_path','meta'];

    protected $casts = ['amount' => 'decimal:2','meta' => 'array'];

    public function order() { return $this->belongsTo(\App\Models\Order::class); }
}
