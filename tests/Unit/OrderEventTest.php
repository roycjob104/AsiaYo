<?php

namespace Tests\Unit;

use App\Events\OrderCreated;
use App\Models\Order\OrderModel;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderEventTest extends TestCase
{
    public function test_order_created_event_is_dispatched()
    {
        Event::fake();

        $order = OrderModel::factory()->raw();

        event(new OrderCreated($order));

        Event::assertDispatched(OrderCreated::class, function ($event) use ($order) {
            return $event->orderData['id'] === $order['id'];
        });
    }
}
