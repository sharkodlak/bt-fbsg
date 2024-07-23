<?php

declare(strict_types=1);

namespace App\Services;

use DateTimeInterface;

class NullSlidingHolidayAdapter implements SlidingHolidayAdapter
{
    public function isHoliday(DateTimeInterface $date): bool
    {
        return false;
    }
}