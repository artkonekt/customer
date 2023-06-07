<?php

declare(strict_types=1);
/**
 * Contains the TestCase class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */

namespace Konekt\Customer\Tests;

use Konekt\Address\Providers\ModuleServiceProvider as AddressModule;
use Konekt\Concord\ConcordServiceProvider;
use Konekt\Concord\Contracts\Concord;
use Konekt\Customer\Providers\ModuleServiceProvider as CustomerModule;
use Konekt\LaravelMigrationCompatibility\LaravelMigrationCompatibilityProvider;
use Konekt\User\Providers\ModuleServiceProvider as UserModule;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var  Concord */
    protected $concord;

    public function setUp(): void
    {
        parent::setUp();

        $this->concord = $this->app->concord;

        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConcordServiceProvider::class,
            LaravelMigrationCompatibilityProvider::class
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $engine = env('TEST_DB_ENGINE', 'sqlite');

        $app['config']->set('database.default', $engine);
        $app['config']->set('database.connections.' . $engine, [
            'driver' => $engine,
            'database' => 'sqlite' == $engine ? ':memory:' : 'customer_test',
            'prefix' => '',
            'host' => env('TEST_DB_HOST', '127.0.0.1'),
            'port' => env('TEST_DB_PORT'),
            'username' => env('TEST_DB_USERNAME', 'pgsql' === $engine ? 'postgres' : 'root'),
            'password' => env('TEST_DB_PASSWORD', '')
        ]);

        if ('pgsql' === $engine) {
            $app['config']->set("database.connections.{$engine}.charset", 'utf8');
        }
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $this->artisan('migrate:reset');
        $this->loadLaravelMigrations();
        $this->artisan('migrate', ['--force' => true]);
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);
        $app['config']->set('concord.modules', [
            AddressModule::class,
            UserModule::class,
            CustomerModule::class
        ]);
    }
}
