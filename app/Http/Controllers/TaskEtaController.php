<?php

namespace App\Http\Controllers;

use App\Services\TaskEtaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskEtaController extends Controller
{
    public function __construct(
        private readonly TaskEtaService $taskEtaService,
    ) {
    }

    /**
     * Display the specified resource.
     */
    public function calculate(Request $request, string $state)
    {
        self::loadSlidingHolidaysAdapter($this->taskEtaService->getWorkingDayService(), $state);

        $validator = Validator::make($request->all(), [
            'start' => 'required|date_format:Y-m-d H:i:s',
            'estimate' => 'required|integer',
            'only_working_days' => 'required|boolean',
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $etaDto = $this->taskEtaService->calculate(
            $state,
            Carbon::parse($request->start),
            (int) $request->estimate,
            (bool) $request->only_working_days,
            $request->working_hours_start,
            $request->working_hours_end
        );

        return response()->json([
            'ETA' => $etaDto->getDate()->format('Y-m-d H:i:s'),
            'daily_work' => $etaDto->getDailyWork(),
        ]);
    }
}
