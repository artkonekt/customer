<?php
/**
 * Contains the ClientTypeWasChanged class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Client\Events;

use Konekt\Client\Contracts\Client;
use Konekt\Client\Contracts\ClientType;

class ClientTypeWasChanged extends BaseClientEvent
{
    /** @var  ClientType */
    public $fromType;

    public $oldAttributes = [];

    /**
     * ClientTypeWasChanged constructor.
     *
     * @param Client     $client
     * @param ClientType $fromType
     * @param array      $oldAttributes
     */
    public function __construct(Client $client, ClientType $fromType, $oldAttributes)
    {
        parent::__construct($client);

        $this->fromType      = $fromType;
        $this->oldAttributes = $oldAttributes;
    }

}