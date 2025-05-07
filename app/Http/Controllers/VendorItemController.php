<?php

namespace App\Http\Controllers;

use App\Models\VendorItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\VendorItemInterface;
use App\Http\Requests\StoreVendorItemRequest;
use App\Http\Requests\UpdateVendorItemRequest;

class VendorItemController extends Controller
{
    public function __construct(
        protected readonly VendorItemInterface $vendorItem
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ]);

        $vendorItems = $this->vendorItem->findAll($request);
        return response()->json([
            'message' => 'VendorItems retrieved successfully.',
            'data' => $vendorItems,
        ], Response::HTTP_OK);
    }

    public function show(VendorItem $vendorItem): JsonResponse
    {
        $vendorItem = $this->vendorItem->findById($vendorItem->id);
        if (!$vendorItem) {
            return response()->json([
                'message' => 'Vendor Item not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Vendor Item retrieved successfully.',
            'data' => $vendorItem,
        ], Response::HTTP_OK);
    }

    public function store(StoreVendorItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $vendorItem = $this->vendorItem->store($request->validated());
            DB::commit();

            return response()->json([
                'message' => 'Vendor Item created successfully.',
                'data' => $vendorItem,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateVendorItemRequest $request, VendorItem $vendorItem): JsonResponse
    {
        try {
            DB::beginTransaction();
            $updatedVendorItem = $this->vendorItem->update($request->validated(), $vendorItem);
            DB::commit();

            return response()->json([
                'message' => 'Vendor Item updated successfully.',
                'data' => $updatedVendorItem,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(VendorItem $vendorItem): JsonResponse
    {
        try {
            $deletedVendorItem = $this->vendorItem->delete($vendorItem);
            return response()->json([
                'message' => 'Vendor Item deleted successfully.',
                'data' => $deletedVendorItem,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
