<?php
/**
 * Contains the CustomerDataTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-24
 *
 */


namespace Konekt\Customer\Tests;


use Carbon\Carbon;
use Konekt\Address\Models\Gender;
use Konekt\Address\Models\NameOrder;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerType;

class CustomerDataTest extends TestCase
{
    /**
     * @test
     */
    public function get_name_method_resolves_customer_name_roperly_depending_on_type()
    {
        $john = CustomerProxy::create([
            'type'      => CustomerType::INDIVIDUAL,
            'firstname' => 'John',
            'lastname'  => 'Doe'
        ]);

        $this->assertEquals('John Doe', $john->getName());

        $acme = CustomerProxy::create([
            'type' => CustomerType::ORGANIZATION,
            'company_name' => 'Acme Inc.'
        ]);

        $this->assertEquals('Acme Inc.', $acme->getName());
    }

    /**
     * @test
     */
    public function all_individual_fields_can_be_set()
    {
        $giovanni = Customer::create([
            'type'      => CustomerType::INDIVIDUAL(),
            'firstname' => 'Giovanni',
            'lastname'  => 'Gatto',
            'email'     => 'giovanni.gatto@gattomail.club',
            'phone'     => '+2-123-456-789'
        ]);

        $giovanni->fresh();

        $this->assertEquals($giovanni->getName(), 'Giovanni Gatto');
        $this->assertEquals($giovanni->firstname, 'Giovanni');
        $this->assertEquals($giovanni->lastname, 'Gatto');
        $this->assertEquals($giovanni->email, 'giovanni.gatto@gattomail.club');
        $this->assertEquals($giovanni->phone, '+2-123-456-789');
    }

    /**
     * @test
     */
    public function all_organziation_customer_fields_can_be_set()
    {
        $shark = Customer::create([
            'type'            => CustomerType::ORGANIZATION(),
            'company_name'    => 'Shark Shoes & T-Shirts Inc.',
            'tax_nr'          => 'SH123456',
            'registration_nr' => 'SHARK-123',
            'email'           => 'hey@sharksho.es',
            'phone'           => '001555777444',
        ]);

        $shark = $shark->fresh();

        $this->assertEquals($shark->getName(), 'Shark Shoes & T-Shirts Inc.');
        $this->assertEquals($shark->company_name, 'Shark Shoes & T-Shirts Inc.');
        $this->assertEquals($shark->tax_nr, 'SH123456');
        $this->assertEquals($shark->registration_nr, 'SHARK-123');
        $this->assertEquals($shark->email, 'hey@sharksho.es');
        $this->assertEquals($shark->phone, '001555777444');
    }

}