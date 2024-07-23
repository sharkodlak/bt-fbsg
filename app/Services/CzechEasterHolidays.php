<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use DateTimeImmutable;
use DateTimeInterface;

class CzechEasterHolidays implements SlidingHolidayAdapter
{
    public function isHoliday(DateTimeInterface $date): bool
    {
        $date = Carbon::parse($date);
        $year = (int) $date->format('Y');
        $easterDays = \easter_days($year);
        $equinox = DateTimeImmutable::createFromInterface($date)
            ->modify('21 March');
        $easter = $equinox->modify("+$easterDays days");
        $goodFriday = $easter->modify('-2 days');
        $easterMonday = $easter->modify('+1 day');

        return $date->isSameDay($goodFriday) || $date->isSameDay($easterMonday);
    }
}