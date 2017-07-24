<?php
/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Client\Providers;


use Konekt\Client\Models\Client;
use Konekt\Client\Models\ClientType;
use Konekt\Concord\BaseBoxServiceProvider;


class ModuleServiceProvider extends BaseBoxServiceProvider
{
    protected $models = [
        Client::class
    ];

    protected $enums = [
        ClientType::class
    ];

}