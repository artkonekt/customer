<?php
/**
 * Contains the ClientFactoryMethodsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-27
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Address\Contracts\Organization;
use Konekt\Address\Contracts\Person;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;

class ClientFactoryMethodsTest extends TestCase
{
    /**
     * @test
     */
    public function individual_client_can_be_created_with_minimal_data()
    {
        $individual = Client::createIndividualClient([
           'firstname' => 'Giovanni',
           'lastname'  => 'Gatto'
        ]);

        $this->assertNotEmpty($individual->id);
        $this->assertTrue($individual->is_active);
        $this->assertInstanceOf(Person::class, $individual->person);
        $this->assertNull($individual->organization);
        $this->assertEquals('Giovanni Gatto', $individual->person->name());

        // I'm evil, will check the same after a complete refetch:
        $individual = Client::find($individual->id);

        $this->assertNotEmpty($individual->id);
        $this->assertTrue($individual->is_active);
        $this->assertInstanceOf(Person::class, $individual->person);
        $this->assertNull($individual->organization);
    }


    /**
     * @test
     */
    public function org_client_can_be_created_with_minimal_data()
    {
        $org = Client::createOrganizationClient([
            'name' => 'Prezi Inc.'
        ]);

        $this->assertNotEmpty($org->id);
        $this->assertTrue($org->is_active);
        $this->assertInstanceOf(Organization::class, $org->organization);
        $this->assertNull($org->person);

        // I'm evil, will check the same after a complete refetch:
        $org = Client::find($org->id);

        $this->assertNotEmpty($org->id);
        $this->assertTrue($org->is_active);
        $this->assertNull($org->person);
        $this->assertInstanceOf(Organization::class, $org->organization);
    }

    /**
     * @test
     */
    public function org_client_can_be_created_with_untyped_create_client_method()
    {
        $org = Client::createClient(ClientType::ORGANIZATION(), [
            'name' => 'Prezi Inc.'
        ]);

        $this->assertNotEmpty($org->id);
        $this->assertTrue($org->is_active);
        $this->assertInstanceOf(Organization::class, $org->organization);
        $this->assertNull($org->person);
    }

    /**
     * @test
     */
    public function individual_client_can_be_created_with_untyped_create_client_method()
    {
        $individual = Client::createClient(ClientType::INDIVIDUAL(), [
                'firstname' => 'Giovanni',
                'lastname'  => 'Gatto'
            ]);

        $this->assertNotEmpty($individual->id);
        $this->assertTrue($individual->is_active);
        $this->assertInstanceOf(Person::class, $individual->person);
        $this->assertNull($individual->organization);
        $this->assertEquals('Giovanni Gatto', $individual->person->name());
    }

    /**
     * @test
     */
    public function clients_can_be_created_via_proxy_as_well()
    {
        $matthaus = ClientProxy::createClient(ClientType::INDIVIDUAL(), [
            'firstname' => 'Lothar',
            'lastname'  => 'Matthäus'
        ]);

        $this->assertNotEmpty($matthaus->id);
        $this->assertInstanceOf(Client::class, $matthaus);
        $this->assertInstanceOf(Person::class, $matthaus->person);

        $fifa = ClientProxy::createClient(ClientType::ORGANIZATION(), [
            'name' => 'Fédération Internationale de Football Association'
        ]);

        $this->assertNotEmpty($fifa->id);
        $this->assertInstanceOf(Client::class, $fifa);
        $this->assertInstanceOf(Organization::class, $fifa->organization);
    }

}