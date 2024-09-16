<?php

namespace App\Http\Requests;

use App\Enums\CurrencyEnum;
use App\Support\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends BaseFormRequest
{
    public const MAX_STRING_LENGTH = 255;

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => ['required', 'string', Rule::unique('orders', 'id')],
            'name' => 'required|string|max:'.self::MAX_STRING_LENGTH,
            'address.city' => 'required|string|max:'.self::MAX_STRING_LENGTH,
            'address.district' => 'required|string|max:'.self::MAX_STRING_LENGTH,
            'address.street' => 'required|string|max:'.self::MAX_STRING_LENGTH,
            'price' => 'required|numeric',
            'currency' => ['required', Rule::in(CurrencyEnum::values())],
        ];
    }
}
