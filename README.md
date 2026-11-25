# Laravel SLA Management


A business-hours deadline calculator for Laravel 13. It skips weekends and configured holidays, supports time zones, and provides breach checks suitable for tickets and support cases.


```bash
composer install
composer test
```


```php
$policy = new SlaPolicy(minutes: 240, opensAt: '09:00', closesAt: '17:00', timezone: 'Asia/Karachi');
$deadline = (new DeadlineCalculator())->deadline($openedAt, $policy, ['2026-12-25']);
```

## Add this to an existing Laravel project

1. Copy `src/SlaPolicy.php` and `src/DeadlineCalculator.php` to `app/Support/Sla/`.
2. Change both namespaces from `JawadAhmed\Sla` to `App\Support\Sla`.
3. Decide where policies live. Small applications can keep them in configuration, while multi-tenant applications usually store minutes, business hours, and time zone per customer or priority.
4. Store holidays as dates in each policy's local time zone and load them from configuration or a database calendar.
5. When a ticket opens, create an `SlaPolicy`, call `deadline()`, and store the resulting UTC deadline on the ticket.
6. Display the deadline in the user's time zone, but perform breach comparisons with consistently normalized timestamps.
7. Recalculate only when the policy or a defined pause and resume workflow requires it. Keep an audit trail when a deadline changes.
8. Run a scheduled command every minute to find newly breached tickets and dispatch notifications or escalation jobs.
9. Copy `tests/DeadlineCalculatorTest.php` into your project, update its namespace and imports, and run `php artisan test`.
10. Add cases for after-hours creation, weekends, consecutive holidays, daylight-saving changes for supported regions, and an already breached deadline.
