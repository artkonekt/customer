<?php

declare(strict_types=1);

use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerPurchase;
use Konekt\Customer\Models\CustomerPurchaseProxy;
use Konekt\Customer\Tests\Dummies\Order;
use Konekt\Customer\Tests\TestCase;

class CustomerPurchaseTest extends TestCase
{
    /**
     * @test
     */
    public function customer_purchase_can_be_created_with_minimal_data(): void
    {
        $customer = CustomerProxy::create([])->fresh();

        $customerPurchase = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
        ])->fresh();

        $this->assertTrue($customer->is($customerPurchase->customer));
    }

    /**
     * @test
     */
    public function customer_purchase_can_be_created_with_a_customer_and_a_purchasable(): void
    {
        $order = Order::create([
            'number' => '70H-0WJB-2OD6'
        ]);

        $customer = CustomerProxy::create([])->fresh();

        $customerPurchase = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $this->assertTrue($order->is($customerPurchase->purchasable));
        $this->assertTrue($customer->is($customerPurchase->customer));
    }

    /**
     * @test
     */
    public function customer_purchase_can_be_created_with_full_data(): void
    {
        $order = Order::create([
            'number' => '70H-0WJB-2OD6'
        ]);

        $customer = CustomerProxy::create([])->fresh();

        $customerPurchase = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'purchase_date' => '2024-11-21',
            'purchase_value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
            'reference' => $order->number,
        ])->fresh();

        $this->assertTrue($order->is($customerPurchase->purchasable));
        $this->assertTrue($customer->is($customerPurchase->customer));
        $this->assertEquals(89.62, $customerPurchase->purchase_value);
        $this->assertEquals('EUR', $customerPurchase->currency);
        $this->assertEquals('2024-11-21', $customerPurchase->purchase_date->toDateString());
        $this->assertEquals('70H-0WJB-2OD6', $customerPurchase->reference);
    }

    /**
     * @test
     */
    public function customer_purchase_can_be_updated_with_full_data(): void
    {
        $order = Order::create([
            'number' => '70H-0WJB-2OD6'
        ]);

        $order2 = Order::create([
            'number' => '50M3-0RD3R-NUMB3R'
        ]);

        $customer = CustomerProxy::create([])->fresh();

        $customer2 = CustomerProxy::create([])->fresh();

        $customerPurchase = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'purchase_date' => '2024-11-21',
            'purchase_value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $customerPurchase->update([
            'customer_id' => $customer2->id,
            'purchase_date' => '2001-01-06',
            'purchase_value' => 2001.06,
            'currency' => 'HUF',
            'purchasable_id' => $order2->id,
            'purchasable_type' => Order::class,
        ]);

        $updatedCustomerPurchase = $customerPurchase->fresh();

        $this->assertFalse($order->is($updatedCustomerPurchase->purchasable));
        $this->assertTrue($order2->is($updatedCustomerPurchase->purchasable));

        $this->assertFalse($customer->is($updatedCustomerPurchase->customer));
        $this->assertTrue($customer2->is($updatedCustomerPurchase->customer));

        $this->assertEquals(2001.06, $updatedCustomerPurchase->purchase_value);
        $this->assertEquals('HUF', $updatedCustomerPurchase->currency);
        $this->assertEquals('2001-01-06', $updatedCustomerPurchase->purchase_date->toDateString());
    }

    /**
     * @test
     */
    public function customer_purchase_can_be_deleted(): void
    {
        $order = Order::create([
            'number' => '50M3-0RD3R-NUMB3R'
        ]);

        $customer = CustomerProxy::create([])->fresh();

        $customerPurchase = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'purchase_date' => '2024-11-21',
            'purchase_value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $customerPurchaseId = $customerPurchase->id;

        $customerPurchase->delete();

        $this->assertNull(CustomerPurchaseProxy::find($customerPurchaseId));
    }

    /**
     * @test
     */
    public function purchases_of_a_customer_can_be_retrieved(): void
    {
        $order = Order::create([
            'number' => '50M3-0RD3R-NUMB3R'
        ]);

        $order2 = Order::create([
            'number' => 'WH47-H4V3-Y0U-B0U6H7'
        ]);

        $customer = CustomerProxy::create([])->fresh();

        $customerPurchase1 = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'purchase_date' => '2024-11-21',
            'purchase_value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $customerPurchase2 = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'purchase_date' => '2023-12-09',
            'purchase_value' => 10000000.94,
            'currency' => 'HUF',
            'purchasable_id' => $order2->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $this->assertEquals(2, $customer->purchases->count());

        $this->assertTrue($customer->purchases->every(function ($purchase) {
            return $purchase instanceof CustomerPurchase;
        }));

        $this->assertTrue($customer->purchases->map->purchasable->every(function ($order) {
            return $order instanceof Order;
        }));

        $this->assertTrue($customer->purchases->pluck('purchase_value')->contains(89.62));
        $this->assertTrue($customer->purchases->pluck('purchase_value')->contains(10000000.94));

        $this->assertTrue($customer->purchases->map->purchasable->pluck('number')->contains('50M3-0RD3R-NUMB3R'));
        $this->assertTrue($customer->purchases->map->purchasable->pluck('number')->contains('WH47-H4V3-Y0U-B0U6H7'));
    }
}
