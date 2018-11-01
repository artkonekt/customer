<?php
/**
 * Contains the Customer interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Customer\Contracts;

interface Customer
{
    /**
     * Returns the name of the customer (either company or person's name)
     *
     * @return string
     */
    public function getName();
}
