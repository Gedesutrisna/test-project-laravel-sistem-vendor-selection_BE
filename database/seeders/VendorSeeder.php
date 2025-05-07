<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            ['id' => 1, 'code' => 'V01', 'name' => 'Vendor 1'],
            ['id' => 2, 'code' => 'V02', 'name' => 'Vendor 2'],
            ['id' => 3, 'code' => 'V03', 'name' => 'Vendor 3'],
        ];

        foreach ($vendors as $vendor) {
            Vendor::updateOrCreate(['id' => $vendor['id']], $vendor);
        }
    }
}

