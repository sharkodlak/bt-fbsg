<?php

use App\Http\Controllers\TaskEtaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingDayController;

Route::prefix('v1')->group(function () {
    Route::get('/task-eta/{state}', [TaskEtaController::class, 'calculate']);
    Route::get('/working-day/{state}/{date}', [WorkingDayController::class, 'show']);
});
