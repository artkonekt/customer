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


use Illuminate\Support\Facades\Event;
use Konekt\Client\Events\ClientWasCreated;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;

class ClientCreateTest extends TestCase
{
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

        $john = $john->fresh(); // still there?

        $this->assertEquals($this->testData->johnDoe->firstname, $john->person->firstname);
        $this->assertEquals($this->testData->johnDoe->lastname, $john->person->lastname);

        $john = ClientProxy::find($john->id); // I'm bastard to see if it's still there

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
     * The event gets fired but expectsEvents doesn't detect it for some reason - disabled
     * @ test
     */
    public function client_was_created_event_is_fired_on_create()
    {
        $this->expectsEvents(ClientWasCreated::class);

        ClientProxy::create([
            'type' => ClientType::ORGANIZATION,
            'organization_id' => $this->testData->acmeInc->id
        ]);
    }

    /**
     * @test
     */
    public function client_was_created_event_contains_the_client()
    {
        Event::fake();

        $acme = ClientProxy::create([
            'type' => ClientType::ORGANIZATION,
            'organization_id' => $this->testData->acmeInc->id
        ]);

        Event::assertDispatched(ClientWasCreated::class, function ($event) use ($acme) {
            return $event->getClient()->id   == $acme->id
                && $event->getClient()->name() == $acme->name();
        });
    }

}