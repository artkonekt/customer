<?php
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

use Illuminate\Database\Eloquent\Model;
use Konekt\Address\Models\AddressProxy;
use Konekt\Address\Models\Organization;
use Konekt\Address\Models\OrganizationProxy;
use Konekt\Address\Models\Person;
use Konekt\Address\Models\PersonProxy;
use Konekt\Customer\Contracts\Customer as CustomerContract;
use Konekt\Customer\Events\CustomerTypeWasChanged;
use Konekt\Customer\Events\CustomerWasCreated;
use Konekt\Customer\Events\CustomerWasUpdated;
use Konekt\Enum\Eloquent\CastsEnums;

/**
 * @property int               $id
 * @property CustomerType      $type
 * @property Organization|null $organization
 * @property Person|null       $person
 * @property bool              $is_active
 * @property \DateTime         $last_purchase_at
 */
class Customer extends Model implements CustomerContract
{
    use CastsEnums;

    protected $table = 'customers';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'is_active'        => 'boolean',
        'last_purchase_at' => 'datetime'
    ];

    protected $enums = [
        'type' => 'CustomerTypeProxy@enumClass'
    ];

    // @todo: Drop this and break Laravel 5.4 compatibility
    protected $events = [
        'created' => CustomerWasCreated::class,
        'updated' => CustomerWasUpdated::class
    ];

    protected $dispatchesEvents = [
        'created' => CustomerWasCreated::class,
        'updated' => CustomerWasUpdated::class
    ];

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        if ($this->type->isOrganization()) {
            return $this->company_name;
        }

        return sprintf('%s %s', $this->firstname, $this->lastname);
    }

    /**
     * Relation for person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(PersonProxy::modelClass());
    }

    /**
     * Relation for organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(OrganizationProxy::modelClass());
    }

    /**
     * Relation for customer's addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this->belongsToMany(AddressProxy::modelClass(), 'customer_addresses');
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
