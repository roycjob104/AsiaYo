<?php

namespace App\Services\Order;

use App\Models\Order\OrderModel;
use App\Services\OrderCurrency\OrderCurrencyStrategyResolverService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderCurrencyStrategyResolverService;

    public function __construct(OrderCurrencyStrategyResolverService $orderCurrencyStrategyResolverService)
    {
        $this->orderCurrencyStrategyResolverService = $orderCurrencyStrategyResolverService;
    }

    public function createOrder(array $data)
    {
        $orderCurrencyModel = $this->orderCurrencyStrategyResolverService->getOrderCurrencyModel($data['currency']);

        $orderCurrency = DB::transaction(function () use ($orderCurrencyModel, $data) {
            $orderCurrency = $orderCurrencyModel::create($data);
            $orderCurrency->orders()->create([
                'id' => $orderCurrency->id,
                'currency_type' => get_class($orderCurrency),
            ]);

            return $orderCurrency;
        }, 5);

        return $orderCurrency;
    }

    public function find(string $id)
    {
        $order = OrderModel::findOrFail($id);
        $currencyOrder = $order->currency; // 獲取對應的貨幣訂單模型

        return $currencyOrder;
    }
}
