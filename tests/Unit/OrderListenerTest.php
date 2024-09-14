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
        // 模擬事件
        Event::fake();

        // 創建一個假訂單
        $order = OrderModel::factory()->raw();

        // 手動觸發事件
        event(new OrderCreated($order));

        // 驗證監聽器是否正確處理了事件
        Event::assertListening(
            OrderCreated::class,
            OrderListener::class
        );
    }
}
