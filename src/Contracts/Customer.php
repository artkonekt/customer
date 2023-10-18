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
use Konekt\Address\Contracts\Address;

interface Customer
{
    /**
     * Returns the name of the customer (either company or person's name)
     */
    public function getName(): string;

    public function addresses(): MorphMany;

    public function hasDefaultBillingAddress(): bool;

    public function hasDefaultShippingAddress(): bool;

    public function defaultBillingAddress(): ?Address;

    public function defaultShippingAddress(): ?Address;

    public function setDefaultShippingAddress(Address|int|null $address): void;

    public function setDefaultBillingAddress(Address|int|null $address): void;
}
