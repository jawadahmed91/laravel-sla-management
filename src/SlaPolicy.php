<?php

namespace JawadAhmed\Sla;

final readonly class SlaPolicy
{
    public function __construct(
        public int $minutes,
        public string $opensAt = '09:00',
        public string $closesAt = '17:00',
        public string $timezone = 'UTC',
    ) {
        if ($minutes < 1) {
            throw new \InvalidArgumentException('SLA minutes must be positive.');
        }
    }
}
