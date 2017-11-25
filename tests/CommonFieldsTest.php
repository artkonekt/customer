<?php
/**
 * Contains the CommonFieldsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-25
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Client\Models\Client;

class CommonFieldsTest extends TestCase
{
    /**
     * @test
     */
    public function email_field_can_be_set_directly_on_individual_client()
    {
        $client = Client::createIndividualClient([
            'name' => 'Jeremy Fitzgerald'
        ]);

        $client->email = 'hard@tofind.com';
        $client->save();

        $this->assertEquals('hard@tofind.com', $client->email);
        $this->assertEquals('hard@tofind.com', $client->person->email);

        $client = $client->fresh();

        $this->assertEquals('hard@tofind.com', $client->email);
        $this->assertEquals('hard@tofind.com', $client->person->email);
    }

    /**
     * @test
     */
    public function email_field_can_be_set_directly_on_organization_client()
    {
        $client = Client::createOrganizationClient([
            'name' => 'Sound Creation Inc.'
        ]);

        $client->email = 'sound@creation.com';
        $client->save();

        $this->assertEquals('sound@creation.com', $client->email);
        $this->assertEquals('sound@creation.com', $client->organization->email);

        $client = $client->fresh();
        $this->assertEquals('sound@creation.com', $client->email);
        $this->assertEquals('sound@creation.com', $client->organization->email);
    }

    /**
     * @test
     */
    public function phone_field_can_be_set_directly_on_individual_client()
    {
        $client = Client::createIndividualClient([
            'name' => 'Jeremy Fitzgerald'
        ]);

        $client->phone = '+31-555-666-777';
        $client->save();

        $this->assertEquals('+31-555-666-777', $client->phone);
        $this->assertEquals('+31-555-666-777', $client->person->phone);

        $client = $client->fresh();

        $this->assertEquals('+31-555-666-777', $client->phone);
        $this->assertEquals('+31-555-666-777', $client->person->phone);
    }

    /**
     * @test
     */
    public function phone_field_can_be_set_directly_on_organization_client()
    {
        $client = Client::createOrganizationClient([
            'name' => 'Sound Creation Inc.'
        ]);

        $client->phone = '+32-444-555-777';
        $client->save();

        $this->assertEquals('+32-444-555-777', $client->phone);
        $this->assertEquals('+32-444-555-777', $client->organization->phone);

        $client = $client->fresh();
        $this->assertEquals('+32-444-555-777', $client->phone);
        $this->assertEquals('+32-444-555-777', $client->organization->phone);
    }
}
