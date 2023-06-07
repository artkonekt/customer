<?php

declare(strict_types=1);

/**
 * Contains the CustomerIsOptional trait.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-15
 *
 */

namespace Konekt\Customer\Traits;

trait CustomerIsOptional
{
    public function isAssociatedWithACustomer(): bool
    {
        return null !== $this->customer_id;
    }

    public function isNotAssociatedWithACustomer(): bool
    {
        return !$this->isAssociatedWithACustomer();
    }
}
