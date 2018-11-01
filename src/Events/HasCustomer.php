<?php
/**
 * Contains the HasCustomer trait.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Customer\Events;

use Konekt\Customer\Contracts\Customer;

trait HasCustomer
{
    /** @var  Customer */
    protected $customer;

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
