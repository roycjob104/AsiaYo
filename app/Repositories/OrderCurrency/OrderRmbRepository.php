<?php

namespace App\Repositories\OrderCurrency;

use App\Models\Order\Currencies\OrderRmbModel;
use App\Support\Repositories\BaseRepository;

class OrderRmbRepository extends BaseRepository
{
    public function create(array $data)
    {
        return OrderRmbModel::create($data);
    }
}
