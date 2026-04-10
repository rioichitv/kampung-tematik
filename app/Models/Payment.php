<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'order_id',
        'pid',
        'harga',
        'fee',
        'total_harga',
        'no_pembayaran',
        'no_pembeli',
        'status',
        'metode',
        'metode_tipe',
        'snap_token',
        'visit_code',
        'reference',
        'type',
        'log',
    ];

    protected $casts = [
        'harga' => 'integer',
        'fee' => 'integer',
        'total_harga' => 'integer',
        'log' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
