<?php
/**
 * Contains the ClientTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Client\Contracts\Client as ClientContract;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;

class ClientTest extends TestCase
{

    public function testHasModel()
    {
        $this->assertTrue(
            $this->concord->getModelBindings()->has(ClientContract::class),
            'The client model should be present in Concord'
        );
    }

    public function testModelCanBeResolvedFromInterface()
    {
        $client = $this->app->make(ClientContract::class);

        $this->assertInstanceOf(ClientContract::class, $client);

        // We also expect that it's the default client model from this package
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testModelProxyResolvesToDefaultModel()
    {
        $this->assertEquals(Client::class, ClientProxy::modelClass());
    }

    public function testClientCanBeCreated()
    {
        $client = ClientProxy::create([])->fresh();

        $this->assertTrue($client->is_active);
        $this->assertEquals(ClientType::__default, $client->type);

        $john = ClientProxy::create([
            'type'      => ClientType::INDIVIDUAL,
            'person_id' => $this->testData->johnDoe->id
        ]);

        $this->assertEquals($this->testData->johnDoe->firstname, $john->person->firstname);
        $this->assertEquals($this->testData->johnDoe->lastname, $john->person->lastname);

        $acme = ClientProxy::create([
            'type' => ClientType::ORGANIZATION,
            'organization_id' => $this->testData->acmeInc->id
        ]);

        $this->assertEquals($this->testData->acmeInc->name, $acme->organization->name);
        $this->assertEquals($this->testData->acmeInc->tax_nr, $acme->organization->tax_nr);
    }

}