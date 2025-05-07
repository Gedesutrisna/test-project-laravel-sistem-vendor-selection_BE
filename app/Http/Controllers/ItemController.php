<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\ItemInterface;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;

class ItemController extends Controller
{
    public function __construct(
        protected readonly ItemInterface $item
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ]);

        $items = $this->item->findAll($request);
        return response()->json([
            'message' => 'Items retrieved successfully.',
            'data' => $items,
        ], Response::HTTP_OK);
    }

    public function show(Item $item): JsonResponse
    {
        $item = $this->item->findById($item->id);
        if (!$item) {
            return response()->json([
                'message' => 'Item not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Item retrieved successfully.',
            'data' => $item,
        ], Response::HTTP_OK);
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->item->store($request->validated());
            DB::commit();

            return response()->json([
                'message' => 'Item created successfully.',
                'data' => $item,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        try {
            DB::beginTransaction();
            $updatedItem = $this->item->update($request->validated(), $item);
            DB::commit();

            return response()->json([
                'message' => 'Item updated successfully.',
                'data' => $updatedItem,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Item $item): JsonResponse
    {
        try {
            $deletedItem = $this->item->delete($item);
            return response()->json([
                'message' => 'Item deleted successfully.',
                'data' => $deletedItem,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
