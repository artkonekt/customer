<?php
/**
 * Contains the CreateCustomerTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */

namespace Konekt\Customer\Tests;

use Illuminate\Support\Facades\Event;
use Konekt\Customer\Events\CustomerWasCreated;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerType;

class CreateCustomerTest extends TestCase
{
    /**
     * @test
     */
    public function customer_can_be_created_with_minimal_data()
    {
        $customer = CustomerProxy::create([])->fresh();

        $this->assertTrue($customer->is_active);
        $this->assertEquals(CustomerType::__default, $customer->type->value());
    }

    /**
     * @test
     */
    public function customer_type_can_be_set_from_string()
    {
        $customer = new Customer();

        $customer->type = CustomerType::INDIVIDUAL;
        $customer->save();

        $customer = $customer->fresh();
        $this->assertEquals(CustomerType::INDIVIDUAL, $customer->type->value());
    }

    /**
     * @test
     */
    public function customer_type_can_be_set_from_enum()
    {
        $customer = new Customer();

        $customer->type = CustomerType::INDIVIDUAL();
        $customer->save();

        $customer = $customer->fresh();
        $this->assertTrue(CustomerType::INDIVIDUAL()->equals($customer->type));
    }

    /**
     * @test
     */
    public function individual_customer_can_be_created()
    {
        $john = CustomerProxy::create([
            'type'      => CustomerType::INDIVIDUAL,
            'firstname' => 'John',
            'lastname'  => 'Doe'
        ]);

        $this->assertTrue($john->type->isIndividual());
        $this->assertEquals('John', $john->firstname);
        $this->assertEquals('Doe', $john->lastname);

        $john = $john->fresh(); // still there?

        $this->assertEquals('John', $john->firstname);
        $this->assertEquals('Doe', $john->lastname);

        $john = CustomerProxy::find($john->id); // I'm bastard to see if it's still there

        $this->assertEquals('John', $john->firstname);
        $this->assertEquals('Doe', $john->lastname);
    }

    /**
     * @test
     */
    public function org_customer_can_be_created()
    {
        $acme = CustomerProxy::create([
            'type'         => CustomerType::ORGANIZATION,
            'company_name' => 'Acme Inc.',
            'tax_nr'       => '19995521'
        ]);

        $this->assertEquals('Acme Inc.', $acme->company_name);
        $this->assertEquals('19995521', $acme->tax_nr);
    }

    /** @test */
    public function customer_was_created_event_is_fired_on_create()
    {
        Event::fake();

        CustomerProxy::create([
            'type' => CustomerType::ORGANIZATION
        ]);

        Event::assertDispatched(CustomerWasCreated::class);
    }

    /**
     * @test
     */
    public function customer_was_created_event_contains_the_customer()
    {
        Event::fake();

        $acme = CustomerProxy::create([
            'type'         => CustomerType::ORGANIZATION,
            'company_name' => 'Acme Inc.',
            'tax_nr'       => '19995521'
        ]);

        Event::assertDispatched(CustomerWasCreated::class, function ($event) use ($acme) {
            return $event->getCustomer()->id   == $acme->id
                && $event->getCustomer()->name == $acme->name;
        });
    }
}
