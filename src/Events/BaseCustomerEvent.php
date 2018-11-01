<?php
/**
 * Contains the BaseCustomerEvent class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Customer\Events;

use Konekt\Customer\Contracts\CustomerAwareEvent;

class BaseCustomerEvent implements CustomerAwareEvent
{
    use HasCustomer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }
}
