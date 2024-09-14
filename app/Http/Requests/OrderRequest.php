<?php

namespace App\Http\Requests;

use App\Enums\CurrencyEnum;
use App\Support\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'id' => ['required', 'string', Rule::unique('orders', 'id')],
            'name' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.district' => 'required|string|max:255',
            'address.street' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => ['required', Rule::in(CurrencyEnum::values())],
        ];
    }
}
