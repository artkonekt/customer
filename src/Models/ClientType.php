<?php
/**
 * Contains the ClientType enum class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Client\Models;

use Konekt\Client\Contracts\ClientType as ClientTypeContract;
use Konekt\Enum\Enum;

class ClientType extends Enum implements ClientTypeContract
{
    const __default    = self::ORGANIZATION;
    const ORGANIZATION = 'organization';
    const INDIVIDUAL   = 'individual';

    protected static $displayTexts = [
        self::ORGANIZATION => 'Organization',
        self::INDIVIDUAL   => 'Individual'
    ];

}
