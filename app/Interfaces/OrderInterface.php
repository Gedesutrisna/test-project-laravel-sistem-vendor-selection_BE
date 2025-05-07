<?php

namespace App\Interfaces;

use App\Models\Order;

interface OrderInterface
{
    public function findAll($request): mixed;
    public function findById(string $id): mixed;
    public function store(array $data): mixed;
    public function update(array $data, Order $order): mixed;
    public function delete(Order $order): mixed;
}
