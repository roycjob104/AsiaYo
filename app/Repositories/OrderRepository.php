<?php

namespace App\Repositories;

use App\Models\Order\OrderModel;
use App\Support\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function find(string $id)
    {
        $order = OrderModel::findOrFail($id);
        $currencyOrder = $order->currency; // 獲取對應的貨幣訂單模型

        return $currencyOrder;
    }

    public function create(array $data) {}
}
