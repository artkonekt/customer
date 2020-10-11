# Customer Type Model

The customer type is an [enum class](https://konekt.dev/enum) and contains the following types by
default:

| Const        | Value        | Notes                                                      |
|:-------------|:-------------|:-----------------------------------------------------------|
| ORGANIZATION | organization | (_default_) Use for companies, foundations, GOs, NGOs, etc |
| INDIVIDUAL   | individual   | For natural human customers                                |

## Extending, Customizing

Concord is the foundation for customizable classes, its Documentation contains and
[Extending Enums](https://konekt.dev/concord/1.8/enums#extending-enums) section. Read that
first if you haven't done that yet.

This is an [enum type](https://konekt.dev/enum) so if you want to add further variants,
extend the class and define new consts:

```php
// App\CustomerType.php
class CustomerType extends Konekt\Customer\Models\CustomerType
{
    const ROBOT = 'robot';
    const ALIEN = 'alien';
    
    // You can also change the default value:
    const __DEFAULT = self::ROBOT;
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
