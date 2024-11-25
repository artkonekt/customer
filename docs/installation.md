# Installation

## Laravel Compatibility

| Laravel | Customer  |
|:--------|:----------|
| 5.4     | 0.9 - 1.0 |
| 5.5     | 0.9 - 1.2 |
| 5.6     | 0.9 - 1.2 |
| 5.7     | 0.9 - 1.2 |
| 5.8     | 1.0 - 1.2 |
| 6.x     | 1.1 - 2.1 |
| 7.x     | 1.2 - 2.1 |
| 8.x     | 2.0 - 2.3 |
| 9.x     | 2.2 - 2.4 |
| 10.x    | 2.4+      |
| 11.x    | 3.0+      |


## Installation With Composer

1. `composer require konekt/customer`
2. Edit `config/concord.php` and add the customer module:

```php
return [
    'modules' => [
        Konekt\Customer\Providers\ModuleServiceProvider::class
    ]
];
```

> If there's no `concord.php` config file use this command:
>
> `php artisan vendor:publish --provider="Konekt\Concord\ConcordServiceProvider" --tag=config`


After this, customer should be listed among the concord modules:

```
php artisan concord:modules -a

+----+------------------------+--------+---------+------------------+-----------------+
| #  | Name                   | Kind   | Version | Id               | Namespace       |
+----+------------------------+--------+---------+------------------+-----------------+
| 1. | Konekt Customer Module | Module | 3.1.0   | konekt.customer  | Konekt\Customer |
+----+------------------------+--------+---------+------------------+-----------------+
```

### Run Migrations

```bash
php artisan migrate
```

### Without Concord

OK, ok. You might be freaked out of this Concord thing. Uou can omit registering the service
provider, but then the migrations won't be published, so copy them from
`src/resorces/database/migrations/` to your app's migration folder.
