<?php

declare(strict_types=1);
/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */

namespace Konekt\Customer\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerPurchase;
use Konekt\Customer\Models\CustomerType;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        Customer::class,
        CustomerPurchase::class,
    ];

    protected $enums = [
        CustomerType::class
    ];

    public function boot(): void
    {
        parent::boot();

        Relation::morphMap([
            'customer' => CustomerProxy::modelClass(),
        ]);
    }
}
