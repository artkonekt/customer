<?php
/**
 * Contains the Contracts Test class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-24
 *
 */

namespace Konekt\Customer\Tests;

use Konekt\Customer\Contracts\Customer as CustomerContract;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerProxy;

class ContractsTest extends TestCase
{
    /**
     * @test
     */
    public function model_can_be_resolved_from_interface()
    {
        $customer = $this->app->make(CustomerContract::class);

        $this->assertInstanceOf(CustomerContract::class, $customer);

        // We also expect that it's the default customer model from this package
        $this->assertInstanceOf(Customer::class, $customer);
    }

    /**
     * @test
     */
    public function model_proxy_resolves_to_default_model()
    {
        $this->assertEquals(Customer::class, CustomerProxy::modelClass());
    }
}
