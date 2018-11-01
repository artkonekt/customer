<?php
/**
 * Contains the CustomerType enum class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Customer\Models;

use Konekt\Customer\Contracts\CustomerType as CustomerTypeContract;
use Konekt\Enum\Enum;

class CustomerType extends Enum implements CustomerTypeContract
{
    const __default    = self::ORGANIZATION;

    const ORGANIZATION = 'organization';
    const INDIVIDUAL   = 'individual';


    protected static $labels = [];

    protected static function boot()
    {
        static::$labels = [
            self::ORGANIZATION => __('Organization'),
            self::INDIVIDUAL   => __('Individual')
        ];
    }
}
