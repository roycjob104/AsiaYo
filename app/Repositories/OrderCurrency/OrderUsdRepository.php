<?php

namespace App\Repositories\OrderCurrency;

use App\Models\Order\Currencies\OrderUsdModel;
use App\Support\Repositories\BaseRepository;

class OrderUsdRepository extends BaseRepository
{
    public function create(array $data)
    {
        return OrderUsdModel::create($data);
    }
}
