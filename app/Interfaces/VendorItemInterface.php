<?php

namespace App\Interfaces;

use App\Models\VendorItem;

interface VendorItemInterface
{
    public function findAll($request): mixed;
    public function findById(string $id): mixed;
    public function store(array $data): mixed;
    public function update(array $data, VendorItem $vendorItem): mixed;
    public function delete(VendorItem $vendorItem): mixed;
}
