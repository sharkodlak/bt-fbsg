<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingDayController;

Route::prefix('v1')->group(function () {
    Route::get('/working-day/{date}', [WorkingDayController::class, 'show']);
});
