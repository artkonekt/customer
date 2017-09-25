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
use Konekt\Client\Contracts\ClientType as ClientTypeContract;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;
use Konekt\Enum\Enum;

class ClientTest extends TestCase
{

    /**
     * @test
     */
    public function concord_has_model()
    {
        $this->assertTrue(
            $this->concord->getModelBindings()->has(ClientContract::class),
            'The client model should be present in Concord'
        );
    }

    /**
     * @test
     */
    public function model_can_be_resolved_from_interface()
    {
        $client = $this->app->make(ClientContract::class);

        $this->assertInstanceOf(ClientContract::class, $client);

        // We also expect that it's the default client model from this package
        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     */
    public function model_proxy_resolves_to_default_model()
    {
        $this->assertEquals(Client::class, ClientProxy::modelClass());
    }

    /**
     * @test
     */
    public function client_can_be_created_with_minimal_data()
    {
        $client = ClientProxy::create([])->fresh();

        $this->assertTrue($client->is_active);
        $this->assertEquals(ClientType::__default, $client->type->value());
    }

    /**
     * @test
     */
    public function client_type_is_an_enum()
    {
        $client = ClientProxy::create([])->fresh();

        $this->assertInstanceOf(ClientTypeContract::class, $client->type);
        $this->assertInstanceOf(Enum::class, $client->type);
    }

    /**
     * @test
     */
    public function client_type_can_be_set_from_string()
    {
        $client = new Client();

        $client->type = ClientType::INDIVIDUAL;
        $client->save();

        $client = $client->fresh();
        $this->assertEquals(ClientType::INDIVIDUAL, $client->type->value());
    }

    /**
     * @test
     */
    public function client_type_can_be_set_from_enum()
    {
        $client = new Client();

        $client->type = ClientType::INDIVIDUAL();
        $client->save();

        $client = $client->fresh();
        $this->assertTrue(ClientType::INDIVIDUAL()->equals($client->type));
    }

    /**
     * @test
     */
    public function individual_client_can_be_created()
    {
        $john = ClientProxy::create([
            'type'      => ClientType::INDIVIDUAL,
            'person_id' => $this->testData->johnDoe->id
        ]);

        $this->assertTrue(ClientType::INDIVIDUAL()->equals($john->type));
        $this->assertEquals($this->testData->johnDoe->firstname, $john->person->firstname);
        $this->assertEquals($this->testData->johnDoe->lastname, $john->person->lastname);

        $john = $john->fresh();

        $this->assertEquals($this->testData->johnDoe->firstname, $john->person->firstname);
        $this->assertEquals($this->testData->johnDoe->lastname, $john->person->lastname);
    }

    /**
     * @test
     */
    public function org_client_can_be_created()
    {
        $acme = ClientProxy::create([
            'type' => ClientType::ORGANIZATION,
            'organization_id' => $this->testData->acmeInc->id
        ]);

        $this->assertEquals($this->testData->acmeInc->name, $acme->organization->name);
        $this->assertEquals($this->testData->acmeInc->tax_nr, $acme->organization->tax_nr);
    }

    /**
     * @test
     */
    public function client_name_method_resolves_properly()
    {
        $john = ClientProxy::create([
            'type'      => ClientType::INDIVIDUAL,
            'person_id' => $this->testData->johnDoe->id
        ]);

        $this->assertEquals($this->testData->johnDoe->name(), $john->name());

        $acme = ClientProxy::create([
            'type' => ClientType::ORGANIZATION,
            'organization_id' => $this->testData->acmeInc->id
        ]);

        $this->assertEquals($this->testData->acmeInc->name, $acme->name());
    }

}