<?php
/**
 * Contains the ClientTypeTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Client\Tests;


use Konekt\Client\Contracts\ClientType as ClientTypeContract;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;
use Konekt\Client\Models\ClientTypeProxy;
use Konekt\Enum\Enum;

class ClientTypeTest extends TestCase
{
    /**
     * @test
     */
    public function can_be_instantiated()
    {
        $type = new ClientType();
        $this->assertNotNull($type);
        $this->assertEquals(ClientType::__default, $type->value());

        $org = ClientType::ORGANIZATION();
        $this->assertTrue($org->equals(ClientTypeProxy::ORGANIZATION()));

        $individual = ClientType::INDIVIDUAL();
        $this->assertTrue($individual->equals(ClientTypeProxy::INDIVIDUAL()));

    }

    /**
     * @test
     */
    public function client_type_is_an_enum()
    {
        $client = ClientProxy::create([])->fresh();

        $this->assertInstanceOf(ClientTypeContract::class, $client->type);
        $this->assertInstanceOf(Enum::class, $client->type);
    }

}