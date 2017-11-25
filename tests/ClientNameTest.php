<?php
/**
 * Contains the ClientNameTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-24
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Address\Models\NameOrder;
use Konekt\Client\Models\Client;

class ClientNameTest extends TestCase
{
    /**
     * @test
     */
    public function setting_client_name_properly_updates_underlying_organization()
    {
        $fooBarInc = Client::createOrganizationClient([
            'name' => 'Foo Bar Inc.'
        ]);

        $this->assertEquals('Foo Bar Inc.', $fooBarInc->name);
        $this->assertEquals('Foo Bar Inc.', $fooBarInc->organization->name);

        $fooBarInc->name = 'Baz Bang Ltd.';

        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->name);
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->organization->name);

        $fooBarInc->save();
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->name);
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->organization->name);

        $fooBarInc = $fooBarInc->fresh();
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->name);
        $this->assertEquals('Baz Bang Ltd.', $fooBarInc->organization->name);
    }

    /**
     * @test
     */
    public function setting_client_name_properly_updates_underlying_person()
    {
        $johnDoe = Client::createIndividualClient([
            'name' => 'John Doe'
        ]);

        $this->assertEquals('John Doe', $johnDoe->name);
        $this->assertEquals('John', $johnDoe->person->firstname);
        $this->assertEquals('Doe', $johnDoe->person->lastname);

        $johnDoe->name = 'Johnathan Doe';
        $johnDoe->save();
        $johnDoe = $johnDoe->fresh();

        $this->assertEquals('Johnathan Doe', $johnDoe->name);
        $this->assertEquals('Johnathan', $johnDoe->person->firstname);
        $this->assertEquals('Doe', $johnDoe->person->lastname);
    }

    /**
     * @test
     */
    public function setting_client_name_properly_updates_underlying_person_with_eastern_name_order()
    {
        $puskas = Client::createIndividualClient([
            'name'      => 'Puskás Ferenc',
            'nameorder' => NameOrder::EASTERN
        ]);

        $this->assertEquals('Puskás Ferenc', $puskas->name);
        $this->assertEquals('Ferenc', $puskas->person->firstname);
        $this->assertEquals('Puskás', $puskas->person->lastname);

        $puskas->name = 'Puskás Öcsi';
        $puskas->save();
        $puskas = $puskas->fresh();

        $this->assertEquals('Puskás Öcsi', $puskas->name);
        $this->assertEquals('Öcsi', $puskas->person->firstname);
        $this->assertEquals('Puskás', $puskas->person->lastname);
    }
}
