<?php

namespace App\Models\Order;

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
}
