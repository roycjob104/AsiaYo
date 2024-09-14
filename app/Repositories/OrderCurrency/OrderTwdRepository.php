<?php

namespace App\Repositories\OrderCurrency;

use App\Models\Order\Currencies\OrderTwdModel;
use App\Support\Repositories\BaseRepository;

class OrderTwdRepository extends BaseRepository
{
    public function create(array $data)
    {
        return OrderTwdModel::create($data);
    }
}
