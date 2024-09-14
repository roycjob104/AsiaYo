<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order\OrderModel;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\Event;

class OrderEventTest extends TestCase
{
    public function test_order_created_event_is_dispatched()
    {
        // 模擬事件
        Event::fake();

        // 創建一個假訂單
        $order = OrderModel::factory()->raw();

        // 手動觸發事件
        event(new OrderCreated($order));

        // 確認事件被觸發
        Event::assertDispatched(OrderCreated::class, function ($event) use ($order) {
            return $event->orderData['id'] === $order['id'];
        });
    }
}
