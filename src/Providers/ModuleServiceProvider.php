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

use Konekt\Concord\BaseModuleServiceProvider;
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        Customer::class
    ];

    protected $enums = [
        CustomerType::class
    ];
}
