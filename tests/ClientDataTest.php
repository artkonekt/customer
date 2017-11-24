<?php
/**
 * Contains the ClientData Test class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-24
 *
 */


namespace Konekt\Client\Tests;


use Carbon\Carbon;
use Konekt\Address\Models\Gender;
use Konekt\Address\Models\NameOrder;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;

class ClientDataTest extends TestCase
{
    /**
     * @test
     */
    public function client_name_method_resolves_properly()
    {
        $john = ClientProxy::create([
            'type'      => ClientType::INDIVIDUAL,
            'person_id' => $this->testData->johnDoe->id
        ]);

        $this->assertEquals($this->testData->johnDoe->getFullName(), $john->name());

        $acme = ClientProxy::create([
            'type' => ClientType::ORGANIZATION,
            'organization_id' => $this->testData->acmeInc->id
        ]);

        $this->assertEquals($this->testData->acmeInc->name, $acme->name());
    }

    /**
     * @test
     */
    public function all_individual_client_fields_can_be_set()
    {
        $giovanni = Client::createClient(
            ClientType::INDIVIDUAL(), [
                'firstname' => 'Giovanni',
                'lastname'  => 'Gatto',
                'email'     => 'giovanni.gatto@gattomail.club',
                'phone'     => '+2-123-456-789',
                'birthdate' => '1978-11-27',
                'gender'    => Gender::MALE,
                'nin'       => '1781127212318',
                'nameorder' => NameOrder::WESTERN
            ]
        );

        $giovanni->fresh();

        $this->assertEquals($giovanni->name(), 'Giovanni Gatto');
        $this->assertEquals($giovanni->person->firstname, 'Giovanni');
        $this->assertEquals($giovanni->person->lastname, 'Gatto');
        $this->assertEquals($giovanni->person->email, 'giovanni.gatto@gattomail.club');
        $this->assertEquals($giovanni->person->phone, '+2-123-456-789');

        $this->assertTrue(
            $giovanni->person->birthdate->eq(
                Carbon::create(1978, 11, 27, 0, 0, 0)
            )
        );

        $this->assertTrue($giovanni->person->gender->isMale());
        $this->assertEquals($giovanni->person->nin, '1781127212318');
        $this->assertTrue($giovanni->person->nameorder->isWestern());
    }

    /**
     * @test
     */
    public function all_organziation_client_fields_can_be_set()
    {
        $giovanni = Client::createClient(
            ClientType::ORGANIZATION(), [
                'name'            => 'Shark Shoes & T-Shirts Inc.',
                'tax_nr'          => 'SH123456',
                'registration_nr' => 'SHARK-123',
                'email'           => 'hey@sharksho.es',
                'phone'           => '001555777444',
            ]
        );

        $giovanni->fresh();

        $this->assertEquals($giovanni->name(), 'Shark Shoes & T-Shirts Inc.');
        $this->assertEquals($giovanni->organization->name, 'Shark Shoes & T-Shirts Inc.');
        $this->assertEquals($giovanni->organization->tax_nr, 'SH123456');
        $this->assertEquals($giovanni->organization->registration_nr, 'SHARK-123');
        $this->assertEquals($giovanni->organization->email, 'hey@sharksho.es');
        $this->assertEquals($giovanni->organization->phone, '001555777444');
    }

}