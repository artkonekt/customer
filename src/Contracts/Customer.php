<?php

declare(strict_types=1);
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

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Customer
{
    /**
     * Returns the name of the customer (either company or person's name)
     */
    public function getName(): string;

    public function addresses(): MorphMany;
}
