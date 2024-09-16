<?php

namespace Tests\Unit;

use App\Http\Requests\OrderRequest;
use App\Models\Order\OrderModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class OrderRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_request_validates_correct_data()
    {
        // Using the factory to generate valid raw data
        $data = OrderModel::factory()->raw();

        $request = new OrderRequest;
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_order_request_fails_with_incorrect_data()
    {
        // Using the factory to generate valid raw data, then altering it to fail validation
        $data = OrderModel::factory()->raw([
            'id' => '',  // Required field missing
            'name' => '',  // Required field missing
            'address' => [
                'city' => '',  // Required field missing
                'district' => '',  // Required field missing
                'street' => '',  // Required field missing
            ],
            'price' => 'invalid',  // Invalid price, should be numeric
            'currency' => 'INVALID_CURRENCY',  // Invalid currency, not in enum
        ]);

        $request = new OrderRequest;
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('id', $validator->errors()->toArray());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('address.city', $validator->errors()->toArray());
        $this->assertArrayHasKey('address.district', $validator->errors()->toArray());
        $this->assertArrayHasKey('address.street', $validator->errors()->toArray());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
        $this->assertArrayHasKey('currency', $validator->errors()->toArray());
    }
}
