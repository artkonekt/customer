<?php

declare(strict_types=1);

/**
 * Contains the AddressDefaultsTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-10-18
 *
 */

namespace Konekt\Customer\Tests;

use Illuminate\Support\Collection;
use Konekt\Address\Models\Address;
use Konekt\Customer\Models\Customer;

class AddressDefaultsTest extends TestCase
{
    /** @test */
    public function customer_has_no_default_addresses_by_default()
    {
        $customer = Customer::create([]);

        $this->assertFalse($customer->hasDefaultBillingAddress());
        $this->assertFalse($customer->hasDefaultShippingAddress());

        $this->assertNull($customer->defaultBillingAddress());
        $this->assertNull($customer->defaultShippingAddress());

        $this->assertNull($customer->default_billing_address_id);
        $this->assertNull($customer->default_shipping_address_id);

        $this->assertNull($customer->default_billing_address);
        $this->assertNull($customer->default_shipping_address);
    }

    /** @test */
    public function default_shipping_address_can_be_set()
    {
        $customer = Customer::create([])->fresh();
        $address = Address::create(['name' => 'Xyz', 'country_id' => 'UK', 'address' => 'asdqwe']);
        $customer->setDefaultShippingAddress($address);

        $this->assertTrue($customer->hasDefaultShippingAddress());
        $this->assertInstanceOf(Address::class, $customer->defaultShippingAddress());
        $this->assertEquals($address->id, $customer->default_shipping_address_id);
        $this->assertInstanceOf(Address::class, $customer->default_shipping_address);
    }

    /** @test */
    public function default_billing_address_can_be_set()
    {
        $customer = Customer::create([])->fresh();
        $address = Address::create(['name' => 'Xyz', 'country_id' => 'UK', 'address' => 'asdqwe']);
        $customer->setDefaultBillingAddress($address);

        $this->assertTrue($customer->hasDefaultBillingAddress());
        $this->assertInstanceOf(Address::class, $customer->defaultBillingAddress());
        $this->assertEquals($address->id, $customer->default_billing_address_id);
        $this->assertInstanceOf(Address::class, $customer->default_billing_address);
    }
}
