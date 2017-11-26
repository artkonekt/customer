<?php
/**
 * Contains the CustomerNameTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-24
 *
 */


namespace Konekt\Customer\Tests;


use Konekt\Address\Models\NameOrder;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;

class CustomerNameTest extends TestCase
{
    /**
     * @test
     */
    public function get_name_method_properly_returns_company_name()
    {
        $fooBarInc = Customer::create([
            'type'         => CustomerType::ORGANIZATION,
            'company_name' => 'Foo Bar Inc.'
        ]);

        $this->assertEquals('Foo Bar Inc.', $fooBarInc->getName());

        $fooBarInc->company_name = 'Baz Bang Ltd.';

        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->getName());

        $fooBarInc->save();
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->getName());

        $fooBarInc = $fooBarInc->fresh();
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->getName());
    }

    /**
     * @test
     */
    public function get_name_returns_company_name_on_a_customer_having_person_name_but_being_organization()
    {
        $acmeJohnDoe = Customer::create([
            'firstname'    => 'John',
            'lastname'     => 'Doe',
            'company_name' => 'Acme Inc.'
        ]);

        $this->assertEquals('Acme Inc.', $acmeJohnDoe->getName());
        $this->assertEquals('John', $acmeJohnDoe->firstname);
        $this->assertEquals('Doe', $acmeJohnDoe->lastname);
    }

    /**
     * @test
     */
    public function get_name_returns_first_and_last_name_for_individual_customers()
    {
        $jeremy = Customer::create([
            'firstname' => 'Jeremy',
            'lastname'  => 'Fitzgerald',
            'type'      => CustomerType::INDIVIDUAL
        ]);

        $this->assertEquals('Jeremy Fitzgerald', $jeremy->getName());
        $this->assertEquals('Jeremy', $jeremy->firstname);
        $this->assertEquals('Fitzgerald', $jeremy->lastname);
    }
}
