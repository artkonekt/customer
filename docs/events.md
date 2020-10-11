# Events

The model manages and fires the following events:

- `CustomerWasCreated`
- `CustomerWasUpdated`
- `CustomerTypeWasChanged`

All 3 events implement the `CustomerAwareEvent` interface, so that you can retrieve the affected
customer from the event:

```php
class SomeListener
{
    public function handle(CustomerAwareEvent $event)
    {
        $customer = $event->getCustomer();
    }
}
```
