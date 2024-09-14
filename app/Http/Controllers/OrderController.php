<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Response;
use App\Services\Order\OrderService;
use App\Events\OrderCreated;
use App\Support\Controllers\BaseController;

class OrderController extends BaseController
{

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Method to handle creating a new order
    public function store(OrderRequest $request)
    {
        $validated = $request->validated();

        event(new OrderCreated($request->all()));

        return response()->json(['message' => 'Order created successfully!'], Response::HTTP_OK);
    }

    // Method to handle showing a specific order
    public function show($id)
    {
        $order = $this->orderService->find($id);

        if ($order) {
            return response()->json($order, Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
