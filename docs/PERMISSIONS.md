# Permissions & Policies

## TicketPolicy

| Ability | Who can |
|---------|---------|
| `view`  | Ticket owner **or** root admin |
| `close` | Root admin only |
| `archive` | Root admin only |
| `addNote` | Root admin only |

## BillingPolicy

| Ability | Who can |
|---------|---------|
| `view`  | Root admin only |

## Registering policies

Add to your application's `AuthServiceProvider`:

```php
use Pltx\Theme\Models\Ticket;
use Pltx\Theme\Policies\TicketPolicy;

protected $policies = [
    Ticket::class => TicketPolicy::class,
];
```
