<?php
/**
 * Contains the ClientAwareEvent interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Client\Contracts;


interface ClientAwareEvent
{
    /**
     * @return Client
     */
    public function getClient();

}