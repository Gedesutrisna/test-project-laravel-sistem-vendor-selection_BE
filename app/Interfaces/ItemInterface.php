<?php

namespace App\Interfaces;

use App\Models\Item;

interface ItemInterface
{
    public function findAll($request);
    public function findById(string $id);
    public function store(array $data);
    public function update(array $data, Item $item);
    public function delete(Item $item);
}
