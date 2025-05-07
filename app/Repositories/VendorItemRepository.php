<?php

namespace App\Repositories;

use App\Interfaces\VendorItemInterface;
use App\Models\VendorItem;

class VendorItemRepository implements VendorItemInterface
{
    public function __construct(
        protected readonly VendorItem $vendorItem,
    ) {
    }

    public function findAll($request): mixed
    {
        $query = $this->vendorItem->with(['vendor', 'item']);

        if ($request->has('search')) {
            $search = (float) $request->search;
            $query->where('price_before', $search)
                ->orWhere('price_now', $search);
        }        

        return $request->per_page > 0
            ? $query->paginate($request->per_page)
            : $query->get();
    }

    public function findById(string $id): mixed
    {
        return $this->vendorItem->with(['vendor', 'item'])->find($id);
    }

    public function store(array $data): mixed
    {
        return $this->vendorItem->create($data);
    }

    public function update(array $data, $vendorItem): mixed
    {
        $vendorItem->update($data);
        return $vendorItem;
    }

    public function delete($vendorItem): mixed
    {
        $vendorItem->delete();
        return $vendorItem;
    }
}
