<?php

namespace App\Models\Order;

use App\Models\Order\Currencies\OrderJpyModel;
use App\Models\Order\Currencies\OrderUsdModel;
use App\Support\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderModel extends BaseModel
{
    use HasFactory;

    protected $casts = [];

    protected $table = 'orders';

    public function currency()
    {
        return $this->morphTo(__FUNCTION__, 'currency_type', 'id');
    }

    public function orderJpyModel()
    {
        return $this->hasMany(OrderJpyModel::class);
    }

    public function orderUsdModel()
    {
        return $this->hasMany(OrderUsdModel::class);
    }

    public function toRequestArray()
    {
        $data = $this->toArray();
        unset($data['currency_type']);
        unset($data['currency_id']);

        return $data;
    }
}
