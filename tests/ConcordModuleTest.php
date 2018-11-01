<?php
/**
 * Contains the ConcordModuleTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Customer\Tests;

use Konekt\Customer\Contracts\Customer;

class ConcordModuleTest extends TestCase
{
    /**
     * @test
     */
    public function dependent_concord_modules_are_present()
    {
        $modules = $this->concord
            ->getModules()
            ->keyBy(function ($module) {
                return $module->getId();
            });

        $this->assertTrue($modules->has('konekt.customer'), 'Customer module should be registered');
        $this->assertTrue($modules->has('konekt.address'), 'Address module should be registered');
        $this->assertTrue($modules->has('konekt.user'), 'User module should be registered');

        $this->assertTrue(
            $modules->get('konekt.customer')
                    ->getKind()
                    ->isModule(),
            'Concord Module Type Should be a module'
        );
    }

    /**
     * @test
     */
    public function concord_has_model()
    {
        $this->assertTrue(
            $this->concord->getModelBindings()->has(Customer::class),
            'The customer model should be present in Concord'
        );
    }
}
