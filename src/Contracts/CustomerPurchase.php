<?php

declare(strict_types=1);

namespace Konekt\Customer\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface CustomerPurchase
{
    public function purchasable(): MorphTo;

    public function customer(): BelongsTo;
}
