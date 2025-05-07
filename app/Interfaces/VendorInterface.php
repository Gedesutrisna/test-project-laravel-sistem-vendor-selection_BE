<?php

namespace App\Interfaces;

use App\Models\Vendor;

interface VendorInterface
{
    public function reportItemsPerVendor(): mixed;
    public function reportVendorRanking(): mixed;
    public function reportPriceChange(): mixed;

    public function findAll($request);
    public function findById(string $id);
    public function store(array $data);
    public function update(array $data, Vendor $vendor);
    public function delete(Vendor $vendor);
}
