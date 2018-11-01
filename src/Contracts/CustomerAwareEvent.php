<?php
/**
 * Contains the CustomerAwareEvent interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Customer\Contracts;

interface CustomerAwareEvent
{
    /**
     * @return Customer
     */
    public function getCustomer();
}
