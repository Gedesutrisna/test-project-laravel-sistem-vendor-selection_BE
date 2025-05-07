<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\OrderInterface;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function __construct(
        protected readonly OrderInterface $order
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ]);

        $orders = $this->order->findAll($request);
        return response()->json([
            'message' => 'Orders retrieved successfully.',
            'data' => $orders,
        ], Response::HTTP_OK);
    }

    public function show(Order $order): JsonResponse
    {
        $order = $this->order->findById($order->id);
        if (!$order) {
            return response()->json([
                'message' => 'Order not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Order retrieved successfully.',
            'data' => $order,
        ], Response::HTTP_OK);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $order = $this->order->store($request->validated());
            DB::commit();

            return response()->json([
                'message' => 'Order created successfully.',
                'data' => $order,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        try {
            DB::beginTransaction();
            $updatedOrder = $this->order->update($request->validated(), $order);
            DB::commit();

            return response()->json([
                'message' => 'Order updated successfully.',
                'data' => $updatedOrder,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Order $order): JsonResponse
    {
        try {
            $deletedOrder = $this->order->delete($order);
            return response()->json([
                'message' => 'Order deleted successfully.',
                'data' => $deletedOrder,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
