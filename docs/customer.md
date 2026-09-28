# The Customer Model

## Creating Customers

Just go the plain old Laravel way:

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

## Fields

| Name                | Type                              | Notes                                                                                                       |
|:--------------------|:----------------------------------|:------------------------------------------------------------------------------------------------------------|
| id                  | autoinc                           |                                                                                                             |
| type                | CustomerType*                     | enum                                                                                                        |
| email               | string                            |                                                                                                             |
| phone               | string(22)                        |                                                                                                             |
| firstname           | string                            |                                                                                                             |
| lastname            | string                            |                                                                                                             |
| company_name        | string                            |                                                                                                             |
| tax_nr              | string(17)                        | [Tax/VAT Identification Number](https://en.wikipedia.org/wiki/VAT_identification_number)                    |
| registration_nr     | Company/Trade Registration Number |                                                                                                             |
| is_active           | bool                              | true by default                                                                                             |
| timezone            | string                            | e.g. `Europe/Amsterdam`                                                                                     |
| ltv                 | float                             | Lifetime Value of the customer                                                                              |
| currency            | string(3)                         | The currency of the customer (individual purchases can still be in other currencies)                        |
| last_purchase_at    | DateTime                          |                                                                                                             |
| customer_number     | string                            | This can be the id/number of the customer in other systems like an ERP                                      |
| acquired_via        | string                            | Here you can freely record where the customer was acquired from. E.g. "registration", "newsletter", etc     |
| acquisition_details | json/array                        | In this field you can save additional details about the customer acquisition like campaing id, location, etc |

## Extending & Customizing

Create your extended model class:

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

Regarding the automatic enum mapping refer to the
[enum-eloquent readme](https://github.com/artkonekt/enum-eloquent#resolving-enum-class-runtime)
