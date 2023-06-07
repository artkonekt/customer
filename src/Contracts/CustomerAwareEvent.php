<?php

declare(strict_types=1);
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
    public function getCustomer(): Customer;
}
