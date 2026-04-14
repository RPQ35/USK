<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class customseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     Customer::create([
        'CustomerName'=>'rahmat',
        'Addres'=>'jalan jalan',
        'PhoneNumber'=>'081234567',
     ]);
    }
}
