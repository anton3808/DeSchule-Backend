<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('schedule', 'ScheduleController')->only(['index', 'store']);
Route::prefix('schedule')->group(function () {
    Route::get('today', [\Modules\User\Http\Controllers\ScheduleController::class, 'today'])->name('schedule.today');
});
