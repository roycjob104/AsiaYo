<?php

namespace Tests\Unit;

use App\Http\Requests\OrderRequest;
use App\Models\Order\Currencies\OrderUsdModel;
use App\Models\Order\OrderModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class OrderRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $request;

    protected $data;

    protected function setUp(): void
    {
        parent::setUp();
        $orderUsdModel = OrderUsdModel::factory()->create();
        $this->data = OrderModel::factory()->forOrderUsdModel($orderUsdModel)->raw($orderUsdModel->toArray());
        $this->request = new OrderRequest;
    }

    // Testing 'id' parameter
    public function test_order_request_fails_when_id_is_missing()
    {
        $data = $this->data;
        unset($data['id']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('id', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_id_is_not_string()
    {
        $data = $this->data;
        $data['id'] = 12345;  // Invalid: should be string

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('id', $validator->errors()->toArray());
    }

    // Testing 'name' parameter
    public function test_order_request_fails_when_name_is_missing()
    {
        $data = $this->data;
        unset($data['name']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_name_is_not_string()
    {
        $data = $this->data;
        $data['name'] = 12345;  // Invalid: should be string

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_name_exceeds_max_length()
    {
        $data = $this->data;
        $data['name'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH + 1);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_order_request_validates_name_at_max_length()
    {
        $data = $this->data;
        $data['name'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH);
        $validator = Validator::make($data, $this->request->rules());
        $this->assertFalse($validator->fails());
    }

    // Testing 'address.city' parameter
    public function test_order_request_fails_when_city_is_missing()
    {
        $data = $this->data;
        unset($data['address']['city']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.city', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_city_is_not_string()
    {
        $data = $this->data;
        $data['address']['city'] = 12345;  // Invalid: should be string

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.city', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_city_exceeds_max_length()
    {
        $data = $this->data;
        $data['address']['city'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH + 1);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.city', $validator->errors()->toArray());
    }

    public function test_order_request_validates_city_at_max_length()
    {
        $data = $this->data;
        $data['address']['city'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertFalse($validator->fails());
    }

    // Testing 'address.district' parameter
    public function test_order_request_fails_when_district_is_missing()
    {
        $data = $this->data;
        unset($data['address']['district']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.district', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_district_is_not_string()
    {
        $data = $this->data;
        $data['address']['district'] = 12345;  // Invalid: should be string

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.district', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_district_exceeds_max_length()
    {
        $data = $this->data;
        $data['address']['district'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH + 1);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.district', $validator->errors()->toArray());
    }

    public function test_order_request_validates_district_at_max_length()
    {
        $data = $this->data;
        $data['address']['district'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertFalse($validator->fails());
    }

    // Testing 'address.street' parameter
    public function test_order_request_fails_when_street_is_missing()
    {
        $data = $this->data;
        unset($data['address']['street']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.street', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_street_is_not_string()
    {
        $data = $this->data;
        $data['address']['street'] = 12345;  // Invalid: should be string

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.street', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_street_exceeds_max_length()
    {
        $data = $this->data;
        $data['address']['street'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH + 1);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('address.street', $validator->errors()->toArray());
    }

    public function test_order_request_validates_street_at_max_length()
    {
        $data = $this->data;
        $data['address']['street'] = str_repeat('a', OrderRequest::MAX_STRING_LENGTH);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertFalse($validator->fails());
    }

    // Testing 'price' parameter
    public function test_order_request_fails_when_price_is_missing()
    {
        $data = $this->data;
        unset($data['price']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_price_is_not_numeric()
    {
        $data = $this->data;
        $data['price'] = 'not a number';  // Invalid: should be numeric

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    // Testing 'currency' parameter
    public function test_order_request_fails_when_currency_is_missing()
    {
        $data = $this->data;
        unset($data['currency']);

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('currency', $validator->errors()->toArray());
    }

    public function test_order_request_fails_when_currency_is_not_in_enum()
    {
        $data = $this->data;
        $data['currency'] = 'INVALID_CURRENCY';  // Invalid: should be in enum

        $validator = Validator::make($data, $this->request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('currency', $validator->errors()->toArray());
    }
}
