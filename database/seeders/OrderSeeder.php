<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 30; $i++) {
            Order::create([
                'vendor_id' => 1,
                'item_id' => rand(1, 2),
                'no_order' => 'ORD-' . str_pad((1000 + $i), 5, '0', STR_PAD_LEFT),
                'date_order' => now()->toDateString(), 
            ]);
        }
    
        for ($i = 0; $i < 25; $i++) {
            Order::create([
                'vendor_id' => 2,
                'item_id' => 3,
                'no_order' => 'ORD-' . str_pad((2000 + $i), 5, '0', STR_PAD_LEFT),
                'date_order' => now()->toDateString(),
            ]);
        }
    
        for ($i = 0; $i < 20; $i++) {
            Order::create([
                'vendor_id' => 3,
                'item_id' => 3,
                'no_order' => 'ORD-' . str_pad((3000 + $i), 5, '0', STR_PAD_LEFT),
                'date_order' => now()->toDateString(),
            ]);
        }
    }
    
}

