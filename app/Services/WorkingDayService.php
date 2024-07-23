<?php

namespace App\Services;

use App\Models\Holiday;
use Carbon\Carbon;

class WorkingDayService
{
    public function isWorkingDay($date)
    {
        $dateInstance = Carbon::parse($date);
        $dayOfWeek = $dateInstance->dayOfWeekIso;
        $daysOff = [ 6, 7 ]; // Saturday and Sunday
        // TODO: Create days-off settings for different countries

        if (in_array($dayOfWeek, $daysOff)) {
            return false;
        }

        $month = $dateInstance->format('m');
        $day = $dateInstance->format('d');
        $holiday = Holiday::where('month', $month)
            ->where('day', $day)
            ->first();

        return $holiday === null;
    }
}
