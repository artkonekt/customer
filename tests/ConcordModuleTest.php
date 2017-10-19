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


namespace Konekt\Client\Tests;



class ConcordModuleTest extends TestCase
{
    /**
     * @test
     */
    public function dependent_concord_modules_are_present()
    {
        $modules = $this->concord
            ->getModules()
            ->keyBy(function($module) {
                return $module->getId();
            });

        $this->assertTrue($modules->has('konekt.client'), 'Client module should be registered');
        $this->assertTrue($modules->has('konekt.address'), 'Address module should be registered');
        $this->assertTrue($modules->has('konekt.user'), 'User module should be registered');

        $this->assertTrue(
            $modules->get('konekt.client')
                    ->getManifest()
                    ->getKind()
                    ->isModule(),
            'Concord Module Type Should be a module'
        );
    }

}