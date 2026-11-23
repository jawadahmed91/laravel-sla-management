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
