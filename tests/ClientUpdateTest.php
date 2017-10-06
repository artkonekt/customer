<?php
/**
 * Contains the ClientUpdateTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Client\Tests;


use Illuminate\Support\Facades\Event;
use Konekt\Address\Contracts\Organization;
use Konekt\Address\Contracts\Person;
use Konekt\Address\Models\OrganizationProxy;
use Konekt\Address\Models\PersonProxy;
use Konekt\Client\Events\ClientTypeWasChanged;
use Konekt\Client\Events\ClientWasUpdated;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientType;

class ClientUpdateTest extends TestCase
{
    /** @var  Client */
    protected $acme;

    /** @var  Client */
    protected $johnDoe;

    public function setUp()
    {
        parent::setUp();

        $this->acme    = Client::createOrganizationClient($this->testData->acmeInc->attributesToArray());
        $this->johnDoe = Client::createIndividualClient($this->testData->johnDoe->attributesToArray());
    }


    /**
     * @test
     */
    public function individual_client_field_can_be_updated()
    {
        $this->johnDoe->updateClient(['firstname' => 'Jack']);

        $this->assertEquals('Jack Doe', $this->johnDoe->name());
        $this->assertEquals('Jack', $this->johnDoe->person->firstname);

        // Let's see if it persists
        $this->johnDoe = $this->johnDoe->fresh();
        $this->assertEquals('Jack Doe', $this->johnDoe->name());

        // Also in the underlying model
        $this->assertEquals('Jack', $this->johnDoe->person->fresh()->firstname);
    }

    /**
     * @test
     */
    public function individual_client_multiple_fields_can_be_updated()
    {
        $this->johnDoe->updateClient([
            'firstname' => 'Jack',
            'lastname'  => 'Smith'
        ]);

        $this->assertEquals('Jack Smith', $this->johnDoe->name());

        // Persists?
        $this->johnDoe = $this->johnDoe->fresh();
        $this->assertEquals('Jack Smith', $this->johnDoe->name());
    }

    /**
     * @test
     */
    public function organization_client_field_can_be_updated()
    {
        $this->acme->updateClient(['name' => 'Splash Inc.']);

        $this->assertEquals('Splash Inc.', $this->acme->name());
        $this->assertEquals('Splash Inc.', $this->acme->organization->name);

        // Let's see if it persists
        $this->acme = $this->acme->fresh();
        $this->assertEquals('Splash Inc.', $this->acme->name());

        // Also in the underlying model
        $this->assertEquals('Splash Inc.', $this->acme->organization->fresh()->name);
    }

    /**
     * @test
     */
    public function client_was_updated_event_is_fired_on_update()
    {
        $this->expectsEvents(ClientWasUpdated::class);

        $this->acme->updateClient(['name' => 'Events Fire Ltd.']);
    }

    /**
     * @test
     */
    public function client_was_updated_event_contains_the_client_on_update()
    {
        Event::fake();

        $acme = $this->acme;
        $acme->updateClient(['name' => 'Events Dispatch Ltd.']);

        Event::assertDispatched(ClientWasUpdated::class, function ($event) use ($acme) {
            return $event->getClient()->id   == $acme->id
                && $event->getClient()->name() == 'Events Dispatch Ltd.';
        });
    }

    /**
     * @test
     */
    public function org_client_type_can_be_converted_to_individual()
    {
        $update = array_merge(
            $this->testData->johnDoe->attributesToArray(),
            ['type' => ClientType::INDIVIDUAL]
        );

        $this->acme->updateClient($update);
        $localDoe = $this->acme->fresh();

        $this->assertEquals(ClientType::INDIVIDUAL, $localDoe->type->value());
        $this->assertEquals($this->testData->johnDoe->firstname, $localDoe->person->firstname);
        $this->assertEquals($this->testData->johnDoe->lastname, $localDoe->person->lastname);
        $this->assertTrue($this->testData->johnDoe->gender->equals($localDoe->person->gender));
    }

    /**
     * @test
     */
    public function individual_client_type_can_be_converted_to_organization()
    {
        $update = array_merge(
            $this->testData->acmeInc->attributesToArray(),
            ['type' => ClientType::ORGANIZATION]
        );

        $this->johnDoe->updateClient($update);
        $acme = $this->johnDoe->fresh();

        $this->assertEquals(ClientType::ORGANIZATION, $acme->type->value());
        $this->assertEquals($this->testData->acmeInc->name, $acme->organization->name);
        $this->assertEquals($this->testData->acmeInc->tax_nr, $acme->organization->tax_nr);
    }

    /**
     * @test
     */
    public function client_type_was_changed_event_is_fired_on_type_conversion()
    {
        $this->expectsEvents(ClientTypeWasChanged::class);

        $this->johnDoe->updateClient(['name' => 'Clients Change Inc.', 'type' => ClientType::ORGANIZATION]);
    }

    /**
     * @test
     */
    public function client_type_was_changed_event_contains_the_client_on_update()
    {
        Event::fake();

        $oldAttrs = $this->johnDoe->person->attributesToArray();
        $this->johnDoe->updateClient([
            'name' => 'Company Ltd.',
            'type' => ClientType::ORGANIZATION
        ]);
        $company = $this->johnDoe->fresh();


        Event::assertDispatched(ClientTypeWasChanged::class, function ($event) use ($oldAttrs, $company) {
            return $event->getClient()->id   == $company->id
                && $event->getClient()->name() == 'Company Ltd.'
                && ClientType::INDIVIDUAL()->equals($event->fromType)
                && $event->oldAttributes['firstname'] == $oldAttrs['firstname']
                && $event->oldAttributes['lastname'] == $oldAttrs['lastname']
                && $event->oldAttributes['gender'] == $oldAttrs['gender'];
        });
    }

    /**
     * @test
     */
    public function person_entity_gets_removed_when_client_gets_converted_to_organization()
    {
        $personId = $this->johnDoe->person->id;
        $this->johnDoe->updateClient([
            'name' => 'Brownies Ltd.',
            'type' => ClientType::ORGANIZATION
        ]);

        $brownies = $this->johnDoe->fresh();

        $this->assertNull($brownies->person);
        $this->assertInstanceOf(Organization::class, $brownies->organization);
        $this->assertNull(PersonProxy::find($personId));
    }

    /**
     * @test
     */
    public function organization_entity_gets_removed_when_client_gets_converted_to_individual()
    {
        $orgId = $this->acme->organization->id;
        $this->acme->updateClient([
            'firstname' => 'Jack',
            'lastname'  => 'Sparrow',
            'type'      => ClientType::INDIVIDUAL
        ]);

        $sparrow = $this->acme->fresh();

        $this->assertNull($sparrow->organization);
        $this->assertInstanceOf(Person::class, $sparrow->person);
        $this->assertNull(OrganizationProxy::find($orgId));
    }

}