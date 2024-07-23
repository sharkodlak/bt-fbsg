<?php

namespace App\Http\Controllers;

use App\Services\CzechEasterHolidays;
use App\Services\NullSlidingHolidayAdapter;
use App\Services\WorkingDayService;

abstract class Controller
{
    static protected function loadSlidingHolidaysAdapter(WorkingDayService $workingDayService, string $state)
    {
        $adapter = match ($state) {
            'cz' => new CzechEasterHolidays(),
            default => new NullSlidingHolidayAdapter(),
        };

        $workingDayService->injectSlidingHolidayAdapter($adapter);
    }
}
