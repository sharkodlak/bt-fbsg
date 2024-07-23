<?php

namespace App\Http\Controllers;

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
        self::loadSlidingHolidaysAdapter($this->workingDayService, $state);
        $dateInstance = Carbon::parse($date);

        return response()->json([
            'date' => $date,
            'working_day' => $this->workingDayService->isWorkingDay($state, $dateInstance),
        ]);
    }
}
