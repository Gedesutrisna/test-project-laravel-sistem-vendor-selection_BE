<?php

namespace App\Repositories;

use App\Interfaces\ItemInterface;
use App\Models\Item;

class ItemRepository implements ItemInterface
{
    public function __construct(
        protected readonly Item $item,
    ) {
    }

    public function findAll($request)
    {
        $query = $this->item->query();

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
        return $this->item->find($id);
    }

    public function store(array $data)
    {
        return $this->item->create($data);
    }

    public function update(array $data, Item $item)
    {
        $item->update($data);
        return $item;
    }

    public function delete(Item $item)
    {
        $item->delete();
        return $item;
    }
}