<?php
/**
 * Contains the BaseClientEvent class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Client\Events;


use Konekt\Client\Contracts\ClientAwareEvent;

class BaseClientEvent implements ClientAwareEvent
{
    use HasClient;

    public function __construct($client)
    {
        $this->client = $client;
    }

}