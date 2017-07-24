<?php
/**
 * Contains the TestData class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Address\Models\Person;
use Konekt\Address\Models\Gender;
use Konekt\Address\Models\Organization;
use Konekt\Address\Models\OrganizationProxy;
use Konekt\Address\Models\PersonProxy;

class TestData
{
    /** @var  Person */
    public $johnDoe;

    /** @var  Organization */
    public $acmeInc;

    public function __construct()
    {
        $this->johnDoe = PersonProxy::create([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'gender'    => Gender::MALE()
        ])->fresh();

        $this->acmeInc = OrganizationProxy::create([
            'name'   => 'Acme Inc.',
            'tax_nr' => '19995521'
        ]);
    }

}