<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Services\WorkingDayService;
use DateTimeImmutable;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function __construct(
        private readonly WorkingDayService $workingDayService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $date)
    {
        return response()->json([
            'date' => $date,
            'working_day' => $this->workingDayService->isWorkingDay($date),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
