<?php
/**
 * Contains the AddressesTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-26
 *
 */


namespace Konekt\Customer\Tests;

use Illuminate\Support\Collection;
use Konekt\Address\Models\AddressProxy;
use Konekt\Address\Models\AddressType;
use Konekt\Address\Models\CountryProxy;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerType;

class AddressesTest extends TestCase
{
    /**
     * @test
     */
    public function customer_has_addresses_collection()
    {
        $customer = CustomerProxy::create([]);

        $this->assertInstanceOf(Collection::class, $customer->addresses);
    }

    /**
     * @test
     */
    public function customer_addresses_can_be_added()
    {
        CountryProxy::create([
            'id'           => 'US',
            'name'         => 'United States',
            'phonecode'    => 1,
            'is_eu_member' => false
        ]);

        $billing = AddressProxy::create([
            'name'       => 'Acme Inc.',
            'country_id' => 'US',
            'address'    => 'HQ Street 2',
            'type'       => AddressType::BILLING
        ]);

        $shipping = AddressProxy::create([
            'name'       => 'Acme Inc.',
            'country_id' => 'US',
            'address'    => 'Billing Street 1',
            'type'       => AddressType::SHIPPING
        ]);

        $customer = Customer::create([
            'type'         => CustomerType::ORGANIZATION,
            'company_name' => 'Acme Inc.'
        ]);

        $customer->addresses()->save($billing);
        $customer->addresses()->save($shipping);

        $customer = $customer->fresh();

        $this->assertCount(2, $customer->addresses);
    }
}
