# Upgrade

## 1.x -> 2.x

The new minimal requirements are:

- PHP 7.3+
- Laravel 6+

### Enum Upgrade to V3

The customer module has upgraded its enum dependency from v2 to v3.
This means that all the `__default` constants have been renamed to `__DEFAULT` (value unchanged).

Affected classes:
- `CustomerType`

All your enums must be [upgraded to v3](https://konekt.dev/enum/3.0/upgrade#from-v2-to-v3).
This way the codebase fully complies with the PSR-1 standard.

This is a breaking change, so you have to check your codebase for enums that have
`__default` constants defined and rename them to `__DEFAULT`.

### Interface Changes

#### Customer

The `string` return type declaration has been added to the `Customer` interface's getName method:

```php
public function getName(): string;
```

If you implemented your own variant of this model, make sure the method signature matches the new
definition.

#### CustomerAwareEvent

The `Customer` return type declaration has been added to the `CustomerAwareEvent` interface's
getCustomer method:

```php
public function getCustomer(): Customer;
```

If you created an event that implements this interface,make sure the method signature matches the
new definition.
