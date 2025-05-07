<?php

namespace App\Http\Controllers;

use App\Interfaces\VendorInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ReportVendorController extends Controller
{
    public function __construct(
        protected readonly VendorInterface $vendor
    ) {}

    public function reportItems(): JsonResponse
    {
        try {
            $data = $this->vendor->reportItemsPerVendor();
            return response()->json([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $data
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Report Items error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function reportRanking(): JsonResponse
    {
        try {
            $data = $this->vendor->reportVendorRanking();
            return response()->json([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $data
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Report Ranking error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function reportPriceChange(): JsonResponse
    {
        try {
            $data = $this->vendor->reportPriceChange();
            return response()->json([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $data
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Report Price Change error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
