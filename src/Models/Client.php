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
use Konekt\Address\Models\OrganizationProxy;
use Konekt\Address\Models\PersonProxy;
use Konekt\Client\Contracts\Client as ClientContract;


class Client extends Model implements ClientContract
{
    protected $fillable = ['type', 'person_id', 'organization_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function person()
    {
        return $this->hasOne(PersonProxy::modelClass(), 'id', 'person_id');
    }

    public function organization()
    {
        return $this->hasOne(OrganizationProxy::modelClass(), 'id', 'organization_id');
    }

    public function name()
    {
        if ($this->organization) {
            return $this->organization->name;
        } elseif ($this->person) {
            return $this->person->name();
        }

        return __('Empty');
    }

}