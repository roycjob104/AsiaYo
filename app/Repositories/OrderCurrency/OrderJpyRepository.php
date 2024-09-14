<?php

namespace App\Repositories\OrderCurrency;

use App\Models\Order\Currencies\OrderJpyModel;
use App\Support\Repositories\BaseRepository;

class OrderJpyRepository extends BaseRepository
{
    public function create(array $data)
    {
        return OrderJpyModel::create($data);
    }
}
