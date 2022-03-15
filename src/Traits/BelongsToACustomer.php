<?php

declare(strict_types=1);

/**
 * Contains the BelongsToACustomer trait.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-15
 *
 */

namespace Konekt\Customer\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Konekt\Customer\Contracts\Customer;
use Konekt\Customer\Models\CustomerProxy;

/**
 * @property int $customer_id
 * @property Customer|null $customer
 */
trait BelongsToACustomer
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id', 'id');
    }
}
