<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [];

    protected $table = 'orders';

    public function currency()
    {
        return $this->morphTo(__FUNCTION__, 'currency_type', 'id');
    }
}
