<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\OrderRequest;
use App\Http\Responses\OrderResponse;
use App\Services\Order\OrderService;
use App\Support\Controllers\BaseController;
use Illuminate\Http\Response;

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

        return new OrderResponse($order);
    }
}
