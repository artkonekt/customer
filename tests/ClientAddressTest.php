<?php
/**
 * Contains the ClientAddressTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-26
 *
 */


namespace Konekt\Client\Tests;


use Illuminate\Support\Collection;
use Konekt\Address\Models\AddressProxy;
use Konekt\Address\Models\AddressType;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;

class ClientAddressTest extends TestCase
{
    /**
     * @test
     */
    public function client_has_addresses_collection()
    {
        $client = ClientProxy::create([]);

        $this->assertInstanceOf(Collection::class, $client->addresses);
    }

    /**
     * @test
     */
    public function client_addresses_can_be_added()
    {
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

        $client = Client::create([
            'organization_id' => $this->testData->acmeInc->id
        ]);

        $client->addresses()->save($billing);
        $client->addresses()->save($shipping);

        $client = $client->fresh();

        $this->assertCount(2, $client->addresses);
    }
    

}