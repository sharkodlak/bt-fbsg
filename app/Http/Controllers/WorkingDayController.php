<?php

namespace App\Http\Controllers;

use App\Services\CzechEasterHolidays;
use App\Services\NullSlidingHolidayAdapter;
use App\Services\WorkingDayService;
use Carbon\Carbon;

class WorkingDayController extends Controller
{
    public function __construct(
        private readonly WorkingDayService $workingDayService,
    ) {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $state, string $date)
    {
        $this->loadSlidingHolidaysAdapter($state);
        $dateInstance = Carbon::parse($date);

        return response()->json([
            'date' => $date,
            'working_day' => $this->workingDayService->isWorkingDay($state, $dateInstance),
        ]);
    }

    private function loadSlidingHolidaysAdapter(string $state)
    {
        $adapter = match ($state) {
            'cz' => new CzechEasterHolidays(),
            default => new NullSlidingHolidayAdapter(),
        };

        $this->workingDayService->injectSlidingHolidayAdapter($adapter);
    }
}
