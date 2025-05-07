<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorItemSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all()->keyBy('code');

        $vendors['V01']->items()->attach(1, ['price_before' => 15000.00, 'price_now' => 10000.00]);
        $vendors['V01']->items()->attach(2, ['price_before' => 25000.00, 'price_now' => 27000.00]);

        $vendors['V02']->items()->attach(3, ['price_before' => 15000.00, 'price_now' => 15000.00]);
    }
}