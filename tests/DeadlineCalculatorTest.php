<?php

namespace Tests;

use Carbon\CarbonImmutable;
use JawadAhmed\Sla\DeadlineCalculator;
use JawadAhmed\Sla\SlaPolicy;
use PHPUnit\Framework\TestCase;

final class DeadlineCalculatorTest extends TestCase
{
    public function test_it_skips_the_weekend(): void
    {
        $deadline = (new DeadlineCalculator())->deadline(
            CarbonImmutable::parse('2026-11-20 16:00', 'UTC'),
            new SlaPolicy(120),
        );
        self::assertSame('2026-11-23 10:00', $deadline->format('Y-m-d H:i'));
    }
}
