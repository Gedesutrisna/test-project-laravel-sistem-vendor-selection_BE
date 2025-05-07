<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface
{
    public function __construct(
        protected readonly Order $order,
    ) {
    }

    public function findAll($request): mixed
    {
        $query = $this->order->with(['vendor', 'item']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('no_order', 'like', "%{$search}%");
        }

        return $request->per_page > 0
            ? $query->paginate($request->per_page)
            : $query->get();
    }

    public function findById(string $id): mixed
    {
        return $this->order->with(['vendor', 'item'])->find($id);
    }

    public function store(array $data): mixed
    {
        return $this->order->create($data);
    }

    public function update(array $data, $order): mixed
    {
        $order->update($data);
        return $order;
    }

    public function delete($order): mixed
    {
        $order->delete();
        return $order;
    }
}
