<?php
/**
 * Contains the CustomerTypeWasChanged class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\Customer\Events;

use Konekt\Customer\Contracts\Customer;
use Konekt\Customer\Contracts\CustomerType;

class CustomerTypeWasChanged extends BaseCustomerEvent
{
    /** @var  CustomerType */
    public $fromType;

    public $oldAttributes = [];

    /**
     * CustomerTypeWasChanged constructor.
     *
     * @param Customer     $customer
     * @param CustomerType $fromType
     * @param array        $oldAttributes
     */
    public function __construct(Customer $customer, CustomerType $fromType, $oldAttributes)
    {
        parent::__construct($customer);

        $this->fromType      = $fromType;
        $this->oldAttributes = $oldAttributes;
    }
}
