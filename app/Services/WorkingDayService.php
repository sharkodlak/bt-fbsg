<?php

namespace App\Services;

use App\Models\Holiday;
use DateTimeInterface;

class WorkingDayService
{
    private SlidingHolidayAdapter $slidingHolidayAdapter;

    public function injectSlidingHolidayAdapter(SlidingHolidayAdapter $slidingHolidayAdapter)
    {
        $this->slidingHolidayAdapter = $slidingHolidayAdapter;
    }

    public function isWorkingDay(string $state, DateTimeInterface $date)
    {
        $dayOfWeek = $date->dayOfWeekIso;
        $daysOff = [ 6, 7 ]; // Saturday and Sunday
        // TODO: Create days-off settings for different countries

        if (in_array($dayOfWeek, $daysOff)) {
            return false;
        }

        if ($this->slidingHolidayAdapter->isHoliday($date)) {
            return false;
        }

        $month = $date->format('m');
        $day = $date->format('d');
        $holiday = Holiday::where('state', $state)
            ->where('month', $month)
            ->where('day', $day)
            ->first();

        return $holiday === null;
    }
}
