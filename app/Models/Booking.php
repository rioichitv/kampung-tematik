<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'package_name',
        'layanan',
        'visit_date',
        'visit_time',
        'guests',
        'ticket_count',
        'price',
        'admin_fee',
        'status',
        'total_amount',
        'payment_method',
        'payment_status',
        'notes',
        'visit_code',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
