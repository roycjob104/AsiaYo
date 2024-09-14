<?php

namespace App\Repositories\OrderCurrency;

use App\Models\Order\Currencies\OrderMyrModel;
use App\Support\Repositories\BaseRepository;

class OrderMyrRepository extends BaseRepository
{
    public function create(array $data)
    {
        return OrderMyrModel::create($data);
    }
}
