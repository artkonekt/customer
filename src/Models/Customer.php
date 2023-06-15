<?php

declare(strict_types=1);
/**
 * Contains the Customer model class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */

namespace Konekt\Customer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Konekt\Address\Models\AddressProxy;
use Konekt\Customer\Contracts\Customer as CustomerContract;
use Konekt\Customer\Events\CustomerTypeWasChanged;
use Konekt\Customer\Events\CustomerWasCreated;
use Konekt\Customer\Events\CustomerWasUpdated;
use Konekt\Enum\Eloquent\CastsEnums;

/**
 * @property int $id
 * @property CustomerType $type
 * @property string $email
 * @property string $phone
 * @property string $firstname
 * @property string $lastname
 * @property string $company_name
 * @property string $name
 * @property string $tax_nr
 * @property string $registration_nr
 * @property string $currency
 * @property string $timezone
 * @property bool $is_active
 * @property float $ltv
 * @property Carbon|null $last_purchase_at
 *
 * @method static Customer create(array $attributes)
 */
class Customer extends Model implements CustomerContract
{
    use CastsEnums;

    protected $table = 'customers';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
        'last_purchase_at' => 'datetime',
        'ltv' => 'float',
    ];

    protected $enums = [
        'type' => 'CustomerTypeProxy@enumClass',
    ];

    protected $dispatchesEvents = [
        'created' => CustomerWasCreated::class,
        'updated' => CustomerWasUpdated::class,
    ];

    public function getName(): string
    {
        if ($this->type->isOrganization()) {
            return $this->company_name;
        }

        return sprintf('%s %s', $this->firstname, $this->lastname);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(AddressProxy::modelClass(), 'model');
    }

    protected function getNameAttribute()
    {
        return $this->getName();
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($customer) {
            if ($customer->original['type'] != $customer->type) {
                event(
                    new CustomerTypeWasChanged(
                        $customer,
                        CustomerTypeProxy::create($customer->original['type']),
                        $customer->original
                    )
                );
            }
        });
    }
}
