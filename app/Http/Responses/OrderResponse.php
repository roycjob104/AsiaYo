<?php

namespace App\Http\Responses;

use App\Support\Responses\BaseResponse;
use Illuminate\Http\Request;

class OrderResponse extends BaseResponse
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'price' => $this->price,
            'currency' => $this->currency,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
