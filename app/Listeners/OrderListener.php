<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\Order\OrderService;

class OrderListener
{
    protected $orderService;

    /**
     * Create the event listener.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event)
    {
        $this->orderService->createOrder($event->orderData);
    }
}
