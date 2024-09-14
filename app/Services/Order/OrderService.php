<?php

namespace App\Services\Order;

use App\Repositories\OrderCurrencyStrategyResolverRepository;
use App\Repositories\OrderRepository;
use App\Support\Services\BaseService;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderCurrencyStrategyResolverRepository $orderCurrencyStrategyResolverRepository,

    ) {}

    public function createOrder(array $data)
    {
        $orderCurrencyRepository = $this->orderCurrencyStrategyResolverRepository->getOrderCurrencyRepository($data['currency']);

        $orderCurrency = DB::transaction(function () use ($data, $orderCurrencyRepository) {
            $orderCurrency = $orderCurrencyRepository->create($data);
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
        return $this->orderRepository->find($id);
    }
}
