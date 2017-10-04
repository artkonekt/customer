<?php
/**
 * Contains the HasClient trait.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Client\Events;


use Konekt\Client\Contracts\Client;

trait HasClient
{
    /** @var  Client */
    protected $client;

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

}