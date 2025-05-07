<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['id' => 1, 'code' => 'IT01', 'name' => 'Item 1'],
            ['id' => 2, 'code' => 'IT02', 'name' => 'Item 2'],
            ['id' => 3, 'code' => 'IT03', 'name' => 'Item 3'],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(['id' => $item['id']], $item);
        }
    }
}
