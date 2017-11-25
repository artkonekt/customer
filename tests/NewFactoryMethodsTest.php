<?php
/**
 * Contains the NewFactoryMethodsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-25
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Address\Contracts\Organization;
use Konekt\Address\Contracts\Person;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;

class NewFactoryMethodsTest extends TestCase
{
    /**
     * @test
     */
    public function individual_client_object_can_be_created_with_minimal_data()
    {
        $individual = Client::newIndividualClient([
            'firstname' => 'Giovanni',
            'lastname'  => 'Gatto'
        ]);

        $this->assertEmpty($individual->id);
        $this->assertTrue($individual->is_active);
        $this->assertInstanceOf(Person::class, $individual->person);
        $this->assertNull($individual->organization);
        $this->assertEquals('Giovanni Gatto', $individual->person->getFullName());
        $this->assertEquals('Giovanni Gatto', $individual->name);

        // Records shouldn't be saved to db
        $this->assertFalse($individual->exists);
        $this->assertFalse($individual->person->exists);
    }

    /**
     * @test
     */
    public function org_client_object_can_be_created_with_minimal_data()
    {
        $org = Client::newOrganizationClient([
            'name' => 'Prezi Inc.'
        ]);

        $this->assertEmpty($org->id);
        $this->assertTrue($org->is_active);
        $this->assertInstanceOf(Organization::class, $org->organization);
        $this->assertNull($org->person);

        $this->assertEquals('Prezi Inc.', $org->organization->name);
        $this->assertEquals('Prezi Inc.', $org->name);

        // Records shouldn't be saved to db
        $this->assertFalse($org->exists);
        $this->assertFalse($org->organization->exists);
    }

    /**
     * @test
     */
    public function org_client_object_can_be_created_with_untyped_new_client_method()
    {
        $org = Client::newClient(ClientType::ORGANIZATION(), [
            'name' => 'Prezi Inc.'
        ]);

        $this->assertTrue($org->is_active);
        $this->assertInstanceOf(Organization::class, $org->organization);
        $this->assertEquals('Prezi Inc.', $org->name);
        $this->assertEquals('Prezi Inc.', $org->organization->name);
        $this->assertNull($org->person);

        // Check data hasn't been saved to DB
        $this->assertEmpty($org->id);
        $this->assertFalse($org->exists);
        $this->assertFalse($org->organization->exists);
    }

    /**
     * @test
     */
    public function individual_client_object_can_be_created_with_untyped_new_client_method()
    {
        $individual = Client::newClient(ClientType::INDIVIDUAL(), [
            'firstname' => 'Giovanni',
            'lastname'  => 'Gatto'
        ]);

        $this->assertTrue($individual->is_active);
        $this->assertInstanceOf(Person::class, $individual->person);
        $this->assertNull($individual->organization);
        $this->assertEquals('Giovanni Gatto', $individual->name);
        $this->assertEquals('Giovanni Gatto', $individual->person->getFullName());

        // Check data hasn't been saved to DB
        $this->assertEmpty($individual->id);
        $this->assertFalse($individual->exists);
        $this->assertFalse($individual->person->exists);
    }

    /**
     * @test
     */
    public function the_individual_client_created_by_new_client_factory_method_can_be_saved_afterwards()
    {
        $wayne = Client::newIndividualClient([
            'firstname' => 'Wayne',
            'lastname'  => 'Gretzky'
        ]);

        $wayne->save();

        $this->assertEquals('Wayne Gretzky', $wayne->name());
        $this->assertTrue($wayne->exists);
        $this->assertTrue($wayne->person->exists);

        $this->assertGreaterThanOrEqual(1, $wayne->id);
        $this->assertGreaterThanOrEqual(1, $wayne->person->id);
    }

    /**
     * @test
     */
    public function the_organization_client_created_by_new_client_factory_method_can_be_saved_afterwards()
    {
        $kobehavn = Client::newOrganizationClient([
            'name' => 'Copenhagen Loft AS'
        ]);

        $kobehavn->save();

        $this->assertEquals('Copenhagen Loft AS', $kobehavn->name());
        $this->assertTrue($kobehavn->exists);
        $this->assertTrue($kobehavn->organization->exists);

        $this->assertGreaterThanOrEqual(1, $kobehavn->id);
        $this->assertGreaterThanOrEqual(1, $kobehavn->organization->id);

        // Refetch from db so the ultimate truth hits the fan
        $copenhagen = Client::find($kobehavn->id);

        $this->assertEquals('Copenhagen Loft AS', $copenhagen->name());
        $this->assertTrue($copenhagen->exists);
        $this->assertTrue($copenhagen->organization->exists);

        $this->assertGreaterThanOrEqual(1, $copenhagen->id);
        $this->assertGreaterThanOrEqual(1, $copenhagen->organization->id);
    }

}