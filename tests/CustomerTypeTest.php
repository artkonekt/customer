<?php
/**
 * Contains the CustomerTypeTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Customer\Tests;

use Konekt\Customer\Contracts\CustomerType as CustomerTypeContract;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerType;
use Konekt\Customer\Models\CustomerTypeProxy;
use Konekt\Enum\Enum;

class CustomerTypeTest extends TestCase
{
    /**
     * @test
     */
    public function can_be_instantiated()
    {
        $type = new CustomerType();
        $this->assertNotNull($type);
        $this->assertEquals(CustomerType::__DEFAULT, $type->value());

        $org = CustomerType::ORGANIZATION();
        $this->assertTrue($org->equals(CustomerTypeProxy::ORGANIZATION()));

        $individual = CustomerType::INDIVIDUAL();
        $this->assertTrue($individual->equals(CustomerTypeProxy::INDIVIDUAL()));
    }

    /**
     * @test
     */
    public function customer_type_is_an_enum()
    {
        $customer = CustomerProxy::create([])->fresh();

        $this->assertInstanceOf(CustomerTypeContract::class, $customer->type);
        $this->assertInstanceOf(Enum::class, $customer->type);
    }
}
