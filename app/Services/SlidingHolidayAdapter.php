<?php

declare(strict_types=1);

namespace App\Services;

use DateTimeInterface;

interface SlidingHolidayAdapter
{
    public function isHoliday(DateTimeInterface $date): bool;
}