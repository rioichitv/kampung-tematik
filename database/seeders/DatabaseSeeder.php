<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder default dibiarkan kosong untuk menghindari konflik data/order_id.
    }
}
