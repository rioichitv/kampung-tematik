<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodPayment extends Model
{
    use HasFactory;

    protected $table = 'methodpayment';

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'image_path',
    ];

}
