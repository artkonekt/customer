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


namespace Konekt\Client\Tests;

use Konekt\Client\Contracts\Client as ClientContract;
use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientProxy;

class ContractsTest extends TestCase
{
    /**
     * @test
     */
    public function model_can_be_resolved_from_interface()
    {
        $client = $this->app->make(ClientContract::class);

        $this->assertInstanceOf(ClientContract::class, $client);

        // We also expect that it's the default client model from this package
        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     */
    public function model_proxy_resolves_to_default_model()
    {
        $this->assertEquals(Client::class, ClientProxy::modelClass());
    }

}
