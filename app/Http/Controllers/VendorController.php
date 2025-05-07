<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\VendorInterface;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;

class VendorController extends Controller
{
    public function __construct(
        protected readonly VendorInterface $vendor
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ]);

        $vendors = $this->vendor->findAll($request);
        return response()->json([
            'message' => 'Vendors retrieved successfully.',
            'data' => $vendors,
        ], Response::HTTP_OK);
    }

    public function show(Vendor $vendor): JsonResponse
    {
        $vendor = $this->vendor->findById($vendor->id);
        if (!$vendor) {
            return response()->json([
                'message' => 'Vendor not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Vendor retrieved successfully.',
            'data' => $vendor,
        ], Response::HTTP_OK);
    }

    public function store(StoreVendorRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $vendor = $this->vendor->store($request->validated());
            DB::commit();

            return response()->json([
                'message' => 'Vendor created successfully.',
                'data' => $vendor,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor): JsonResponse
    {
        try {
            DB::beginTransaction();
            $updatedVendor = $this->vendor->update($request->validated(), $vendor);
            DB::commit();

            return response()->json([
                'message' => 'Vendor updated successfully.',
                'data' => $updatedVendor,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Vendor $vendor): JsonResponse
    {
        try {
            $deletedVendor = $this->vendor->delete($vendor);
            return response()->json([
                'message' => 'Vendor deleted successfully.',
                'data' => $deletedVendor,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
