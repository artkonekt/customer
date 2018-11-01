# Konekt Customer Library (Laravel)

[![Travis Build Status](https://img.shields.io/travis/artkonekt/customer.svg?style=flat-square)](https://travis-ci.org/artkonekt/customer)
[![Packagist version](https://img.shields.io/packagist/v/konekt/customer.svg?style=flat-square)](https://packagist.org/packages/konekt/customer)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/customer.svg?style=flat-square)](https://packagist.org/packages/konekt/customer)
[![StyleCI](https://styleci.io/repos/112073400/shield?branch=master)](https://styleci.io/repos/112073400)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

This is a [Concord](https://github.com/artkonekt/concord) module for handling customers.

Designed to:

- Be very much Laravel common-sense;
- Only does the basic shit;
- Lets you to customize the hell out of it.

## Installation

`composer require konekt/customer`

### With Concord

The service provider should be wired via [Concord](https://artkonekt.github.io/concord/).

Add the customer module to `config/concord.php:

```php
return [
    'modules' => [
        Konekt\Customer\Providers\ModuleServiceProvider::class => []
        // other modules if necessary
    ]
];
```

> If there's no `concord.php` config file use this command:
>
> `php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config`

### Run Migrations

```bash
php artisan migrate
```

### Without Concord

OK, ok. You might be freaked out of this Concord thing. Then you can omit registering the service
provider, but then the migrations won't be published, so copy them from
`src/resorces/database/migrations/` to your app's migration folder.

## Usage

### Creating Customers

_Just go the plain old Laravel way:_

```php
use Konekt\Customer\Models\Customer;
use Konekt\Customer\Models\CustomerType;

$johnDoe = Customer::create([
    'firstname' => 'John',
    'lastname'  => 'Doe',
    'type'      => CustomerType::INDIVIDUAL
]);

echo $johnDoe->getName();
// John Doe
var_dump($johnDoe->type->isIndividual());
// bool(true)
var_dump($johnDoe->type->isOrganization());
// bool(false)

$acmeInc = Customer::create([
   'company_name' => 'Acme Inc.',
   'type'      => CustomerType::ORGANIZATION
]);

echo $acmeInc->getName();
// Acme Inc.
var_dump($acmeInc->type->isIndividual());
// bool(false)
var_dump($acmeInc->type->isOrganization());
// bool(true)
```

### Fields

| Name             | Type                              | Notes                                                                                    |
|:-----------------|:----------------------------------|:-----------------------------------------------------------------------------------------|
| id               | autoinc                           |                                                                                          |
| type             | CustomerType                      | enum                                                                                     |
| email            | string                            |                                                                                          |
| phone            | string(22)                        |                                                                                          |
| firstname        | string                            |                                                                                          |
| lastname         | string                            |                                                                                          |
| company_name     | string                            |                                                                                          |
| tax_nr           | string(17)                        | [Tax/VAT Identification Number](https://en.wikipedia.org/wiki/VAT_identification_number) |
| registration_nr  | Company/Trade Registration Number |                                                                                          |
| is_active        | bool                              | true by default                                                                          |
| last_purchase_at | DateTime                          | nullable                                                                                 |

### Enums

**CustomerType**:

| Const        | Value        | Notes                                                      |
|:-------------|:-------------|:-----------------------------------------------------------|
| ORGANIZATION | organization | (_default_) Use for companies, foundations, GOs, NGOs, etc |
| INDIVIDUAL   | individual   | For natural human customers                                |

## Extending, Customizing

### With Concord

Everything is already written in Concord docs at the
[Models](https://artkonekt.github.io/concord/#/models) and the [Enums](https://artkonekt.github.io/concord/#/enums) sections, so read that
first if you haven't done that yet.

#### Extending CustomerType

This is an [enum type](https://artkonekt.github.io/enum/#/) so if you want to add further variants,
extend the class and define new consts:

```php
// App\CustomerType.php
class CustomerType extends Konekt\Customer\Models\CustomerType
{
    const ROBOT = 'robot';
    const ALIEN = 'alien';
    
    // You can also change the default value:
    const __default = self::ROBOT;
}
```

You need to register your type so that it will be used instead of the stock CustomerType:

```php
// app/Providers/AppServiceProvider.php:

use Illuminate\Support\ServiceProvider;
use Konekt\Customer\Contracts\CustomerType as CustomerTypeContract;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->concord->registerEnum(
            CustomerTypeContract::class, \App\CustomerType::class
        );
    }
}
```

So now your extended type is in effect:

```php
use Konekt\Customer\Models\Customer;

$robot = Customer::create([
    'firstname' => 'R2D2'
]);

var_dump($robot->type);
// object(App\CustomerType)#1050 (1) {
//     ["value":protected]=>
//     string(5) "robot"
//   }
```

#### Extending Customer

First create your extended model class

```php
// app/Customer.php
class Customer extends Konekt\Customer\Models\Customer
{
    public function getName()
    {
        if ($this->type->isRobot()) {
            return 'Robot ' . $this->firstname;
        }
        
        return parent::getName();        
    }
}
```

Register the model with concord:

```php
// app/Providers/AppServiceProvider.php:

use Illuminate\Support\ServiceProvider;
use Konekt\Customer\Contracts\Customer as CustomerContract;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->concord->registerModel(
            CustomerContract::class, \App\Customer::class
        );
    }
}
```

So now any other library using the Konekt Customer module will be aware of your new type and it will
be used.

```php
use Konekt\Customer\Models\CustomerProxy;

echo CustomerProxy::modelClass();
// App\Customer

$r2d2 = CustomerProxy::create([
    'firstname' => 'R2D2'
]);
//=> App\Customer {#1062
//       updated_at: "2017-11-26 14:48:48",
//       created_at: "2017-11-26 14:48:48",
//       id: 8,
//       type: "robot",
//       firstname: "R2D2",
//     }

echo $r2d2->getName();
// 'Robot R2D2'
```

### Without Concord

If you're not using Concord and no other module/library depends on this module, just extend
`Customer` with plain OOP and you're good to go.

Regarding to the automatic enum mapping refer to the
[enum-eloquent readme](https://github.com/artkonekt/enum-eloquent#resolving-enum-class-runtime)

## Runnig Tests

### In Console

```bash
vendor/bin/phpunit -c phpunit.xml
```

### Configure PhpStorm

1. Go to settings -> PHP -> Testing frameworks
2. Add PHPUnit local
3. Choose composer autoloader (need to install deps in advance with `composer install`)
4. Point "path to script" to `vendor/autoload.php` (full path)
5. Choose default configuration file: `phpunit.xml`
