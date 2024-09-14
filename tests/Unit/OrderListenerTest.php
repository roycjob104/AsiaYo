<?php

namespace Tests\Unit;

use App\Events\OrderCreated;
use App\Listeners\OrderListener;
use App\Models\Order\OrderModel;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderListenerTest extends TestCase
{
    public function test_order_created_listener_is_called()
    {
        Event::fake();

        $order = OrderModel::factory()->raw();

        event(new OrderCreated($order));

        Event::assertListening(
            OrderCreated::class,
            OrderListener::class
        );
    }
}
