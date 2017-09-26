<?php
/**
 * Contains the Client model class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */

namespace Konekt\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Konekt\Address\Models\AddressProxy;
use Konekt\Address\Models\Organization;
use Konekt\Address\Models\OrganizationProxy;
use Konekt\Address\Models\Person;
use Konekt\Address\Models\PersonProxy;
use Konekt\Client\Contracts\Client as ClientContract;
use Konekt\Client\Contracts\ClientType as ClientTypeContract;


/**
 * @property int                    $id
 * @property ClientType             $type
 * @property Organization|null      $organization
 * @property Person|null            $person
 * @property bool                   $is_active
 */
class Client extends Model implements ClientContract
{
    protected $table = 'clients';

    protected $fillable = ['type', 'person_id', 'organization_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relation for person
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function person()
    {
        return $this->hasOne(PersonProxy::modelClass(), 'id', 'person_id');
    }

    /**
     * Relation for organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organization()
    {
        return $this->hasOne(OrganizationProxy::modelClass(), 'id', 'organization_id');
    }

    /**
     * Relation for client addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this->belongsToMany(AddressProxy::modelClass(), 'client_addresses');
    }

    /**
     * Returns the name of the client (person's name if individual, org name for organizations)
     *
     * @return string
     */
    public function name()
    {
        if ($this->organization) {
            return $this->organization->name;
        } elseif ($this->person) {
            return $this->person->name();
        }

        return __('Empty');
    }

    /**
     * @return ClientType
     */
    public function getTypeAttribute()
    {
        return ClientTypeProxy::create(array_get($this->attributes, 'type'));
    }

    /**
     * @param ClientType|string $value
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value instanceof ClientTypeContract ? $value->value() : $value;
    }

}