<?php

declare(strict_types=1);

namespace Konekt\Customer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Konekt\Customer\Contracts\CustomerPurchase as CustomerPurchaseContract;

/**
 * @property int $id
 * @property int $customer_id
 * @property Carbon $purchase_date
 * @property float $purchase_value
 * @property string $currency
 * @property int|null $purchasable_id
 * @property string|null $purchasable_type
 *
 * @property-read Model|null $purchasable
 * @property-read Customer $customer
 */
class CustomerPurchase extends Model implements CustomerPurchaseContract
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProxy::modelClass());
    }
}
