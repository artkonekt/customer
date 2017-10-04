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

use Collective\Html\Eloquent\FormAccessible;
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
    use FormAccessible;

    protected $table = 'clients';

    protected $fillable = ['type', 'person_id', 'organization_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

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

    /**
     * Form accessor for the type field
     *
     * @return string
     */
    public function formTypeAttribute()
    {
        return $this->type->value();
    }


    /**
     * @inheritdoc
     */
    public static function createIndividualClient(array $attributes)
    {
        $client = static::create([
            'type' => ClientType::INDIVIDUAL,
            'is_active' => array_get($attributes, 'is_active', true)
        ]);

        $client->person()->associate(
            PersonProxy::create(array_except($attributes, 'is_active'))
        );

        $client->save();

        return $client;
    }

    /**
     * @inheritdoc
     */
    public static function createOrganizationClient(array $attributes)
    {
        $client = static::create([
            'type' => ClientType::ORGANIZATION,
            'is_active' => array_get($attributes, 'is_active', true)
        ]);

        $client->organization()->associate(
            OrganizationProxy::create(array_except($attributes, 'is_active'))
        );

        $client->save();

        return $client;
    }

    /**
     * @inheritdoc
     */
    public static function createClient(ClientTypeContract $type, array $attributes)
    {
        $methodName = sprintf('create%sClient', camel_case($type->value()));

        return call_user_func(static::class . '::' . $methodName, $attributes);
    }

    /**
     * @inheritdoc
     */
    public function updateClient(array $attributes, ClientTypeContract $type = null)
    {
        if (!is_null($type) && !$this->type->equals($type)) {
            // Remove old related type
            // Create new related type
            // Emit type was changed event
        } else {
            // just update related model data
        }

    }


}