<?php

declare(strict_types=1);

use Carbon\Carbon;
use Konekt\Customer\Contracts\CustomerPurchase as CustomerPurchaseContract;
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
            'date' => '2024-11-21',
            'value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
            'reference' => $order->number,
        ])->fresh();

        $this->assertTrue($order->is($customerPurchase->purchasable));
        $this->assertTrue($customer->is($customerPurchase->customer));
        $this->assertEquals(89.62, $customerPurchase->value);
        $this->assertEquals('EUR', $customerPurchase->currency);
        $this->assertEquals('2024-11-21', $customerPurchase->date->toDateString());
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
            'date' => '2024-11-21',
            'value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $customerPurchase->update([
            'customer_id' => $customer2->id,
            'date' => '2001-01-06',
            'value' => 2001.06,
            'currency' => 'HUF',
            'purchasable_id' => $order2->id,
            'purchasable_type' => Order::class,
        ]);

        $updatedCustomerPurchase = $customerPurchase->fresh();

        $this->assertFalse($order->is($updatedCustomerPurchase->purchasable));
        $this->assertTrue($order2->is($updatedCustomerPurchase->purchasable));

        $this->assertFalse($customer->is($updatedCustomerPurchase->customer));
        $this->assertTrue($customer2->is($updatedCustomerPurchase->customer));

        $this->assertEquals(2001.06, $updatedCustomerPurchase->value);
        $this->assertEquals('HUF', $updatedCustomerPurchase->currency);
        $this->assertEquals('2001-01-06', $updatedCustomerPurchase->date->toDateString());
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
            'date' => '2024-11-21',
            'value' => 89.62,
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
            'date' => '2024-11-21',
            'value' => 89.62,
            'currency' => 'EUR',
            'purchasable_id' => $order->id,
            'purchasable_type' => Order::class,
        ])->fresh();

        $customerPurchase2 = CustomerPurchaseProxy::create([
            'customer_id' => $customer->id,
            'date' => '2023-12-09',
            'value' => 10000000.94,
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

        $this->assertTrue($customer->purchases->pluck('value')->contains(89.62));
        $this->assertTrue($customer->purchases->pluck('value')->contains(10000000.94));

        $this->assertTrue($customer->purchases->map->purchasable->pluck('number')->contains('50M3-0RD3R-NUMB3R'));
        $this->assertTrue($customer->purchases->map->purchasable->pluck('number')->contains('WH47-H4V3-Y0U-B0U6H7'));
    }

    /** @test */
    public function it_can_be_created_via_the_customers_adder_method_with_minimal_data()
    {
        /** @var \Konekt\Customer\Models\Customer $customer */
        $customer = CustomerProxy::create([])->fresh();
        $purchase = $customer->addPurchase(Carbon::parse('2025-01-11'), 5790.12, 'SEK');

        $this->assertInstanceOf(CustomerPurchaseContract::class, $purchase);
        $this->assertEquals('2025-01-11', $purchase->date->format('Y-m-d'));
        $this->assertEquals(5790.12, $purchase->value);
        $this->assertEquals('SEK', $purchase->currency);
        $this->assertNull($purchase->reference);
        $this->assertNull($purchase->purchasable);
        $this->assertTrue($customer->is($purchase->customer));
    }

    /** @test */
    public function it_can_be_created_via_the_customers_adder_method_using_a_reference()
    {
        /** @var \Konekt\Customer\Models\Customer $customer */
        $customer = CustomerProxy::create([])->fresh();
        $purchase = $customer->addPurchase(Carbon::parse('2025-01-12'), 107.99, 'USD', null, 'Invoice IVR-79807');

        $this->assertInstanceOf(CustomerPurchaseContract::class, $purchase);
        $this->assertEquals('2025-01-12', $purchase->date->format('Y-m-d'));
        $this->assertEquals(107.99, $purchase->value);
        $this->assertEquals('USD', $purchase->currency);
        $this->assertEquals('Invoice IVR-79807', $purchase->reference);
        $this->assertNull($purchase->purchasable);
        $this->assertTrue($customer->is($purchase->customer));
    }

    /** @test */
    public function it_can_be_created_via_the_customers_adder_method_using_a_purchasable()
    {
        /** @var \Konekt\Customer\Models\Customer $customer */
        $customer = CustomerProxy::create([])->fresh();

        $order = Order::create(['number' => 'gI61lXT9JOmpBnz6mcRtH']);

        $purchase = $customer->addPurchase(Carbon::parse('2025-01-13'), 81, 'USD', $order)->fresh();

        $this->assertInstanceOf(CustomerPurchaseContract::class, $purchase);
        $this->assertEquals('2025-01-13', $purchase->date->format('Y-m-d'));
        $this->assertEquals(81, $purchase->value);
        $this->assertEquals('USD', $purchase->currency);
        $this->assertNull($purchase->reference);
        $this->assertInstanceOf(Order::class, $purchase->purchasable);
        $this->assertTrue($purchase->purchasable->is($order));
        $this->assertTrue($customer->is($purchase->customer));
    }
}
