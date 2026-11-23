<?php

namespace JawadAhmed\Sla;

use Carbon\CarbonImmutable;
use DateTimeInterface;

final class DeadlineCalculator
{
    /** @param list<string> $holidays */
    public function deadline(DateTimeInterface $openedAt, SlaPolicy $policy, array $holidays = []): CarbonImmutable
    {
        $cursor = CarbonImmutable::instance($openedAt)->setTimezone($policy->timezone);
        $remaining = $policy->minutes;

        while ($remaining > 0) {
            $cursor = $this->nextBusinessMinute($cursor, $policy, $holidays);
            $cursor = $cursor->addMinute();
            $remaining--;
        }

        return $cursor;
    }

    public function breached(DateTimeInterface $deadline, ?DateTimeInterface $at = null): bool
    {
        return CarbonImmutable::instance($at ?? new \DateTimeImmutable())->isAfter($deadline);
    }

    /** @param list<string> $holidays */
    private function nextBusinessMinute(CarbonImmutable $cursor, SlaPolicy $policy, array $holidays): CarbonImmutable
    {
        while ($cursor->isWeekend() || in_array($cursor->toDateString(), $holidays, true)) {
            $cursor = $cursor->addDay()->setTimeFromTimeString($policy->opensAt);
        }

        $open = $cursor->setTimeFromTimeString($policy->opensAt);
        $close = $cursor->setTimeFromTimeString($policy->closesAt);

        if ($cursor->lt($open)) return $open;
        if ($cursor->gte($close)) return $this->nextBusinessMinute($cursor->addDay()->setTimeFromTimeString($policy->opensAt), $policy, $holidays);
        return $cursor;
    }
}
