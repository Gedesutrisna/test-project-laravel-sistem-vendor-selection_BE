<?php

namespace App\Repositories;

use App\Interfaces\VendorInterface;
use App\Models\Vendor;

class VendorRepository implements VendorInterface
{
    public function __construct(
        protected readonly Vendor $vendor,
    ) {
    }

    public function reportItemsPerVendor(): array
    {
        return Vendor::with(['items:id,code,name'])
            ->select('id', 'code', 'name')
            ->get()
            ->map(fn($v) => [
                'id_vendor' => $v->id,
                'kode_vendor' => $v->code,
                'nama_vendor' => $v->name,
                'item' => $v->items->map(fn($i) => [
                    'id_item' => $i->id,
                    'kode_item' => $i->code,
                    'nama_item' => $i->name,
                ])
            ])
            ->toArray();
    }

    public function reportVendorRanking(): array
    {
        return Vendor::withCount('orders')
            ->orderByDesc('orders_count')
            ->get()
            ->map(fn($v) => [
                'id_vendor' => $v->id,
                'kode_vendor' => $v->code,
                'nama_vendor' => $v->name,
                'jumlah_transaksi' => number_format($v->orders_count, 2, '.', '')
            ])
            ->toArray();
    }

    public function reportPriceChange(): array
    {
        return Vendor::with(['items'])->get()->map(function ($vendor) {
            $items = $vendor->items->map(function ($item) {
                $before = (float) $item->pivot->price_before;
                $now = (float) $item->pivot->price_now;
                $selisih = $now - $before;
                $rate = $before == 0 ? 0 : round(($selisih / $before) * 100, 2);
                $status = $selisih > 0 ? 'up' : ($selisih < 0 ? 'down' : 'stable');

                return [
                    'id_item' => $item->id,
                    'kode_item' => $item->code,
                    'nama_item' => $item->name,
                    'harga_sebelum' => number_format($before, 2, '.', ''),
                    'harga_sekarang' => number_format($now, 2, '.', ''),
                    'selisih' => number_format($selisih, 2, '.', ''),
                    'rate' => number_format($rate, 2, '.', ''),
                    'status' => $status,
                ];
            });

            return [
                'id_vendor' => $vendor->id,
                'kode_vendor' => $vendor->code,
                'nama_vendor' => $vendor->name,
                'item' => $items
            ];
        })->toArray();
    }

    public function findAll($request)
    {
        $query = $this->vendor->query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        return $request->per_page > 0
            ? $query->paginate($request->per_page)
            : $query->get();
    }

    public function findById(string $id)
    {
        return $this->vendor->find($id);
    }

    public function store(array $data)
    {
        return $this->vendor->create($data);
    }

    public function update(array $data, Vendor $vendor)
    {
        $vendor->update($data);
        return $vendor;
    }

    public function delete(Vendor $vendor)
    {
        $vendor->delete();
        return $vendor;
    }
}