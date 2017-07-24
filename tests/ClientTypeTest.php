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


use Konekt\Client\Models\ClientType;
use Konekt\Client\Models\ClientTypeProxy;

class ClientTypeTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $type = new ClientType();
        $this->assertNotNull($type);
        $this->assertEquals(ClientType::__default, $type->getValue());

        $org = ClientType::ORGANIZATION();
        $this->assertTrue($org->equals(ClientTypeProxy::ORGANIZATION()));

        $individual = ClientType::INDIVIDUAL();
        $this->assertTrue($individual->equals(ClientTypeProxy::INDIVIDUAL()));

    }

}