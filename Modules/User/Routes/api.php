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

Route::apiResource('schedule', 'ScheduleController')->only(['index', 'store', 'destroy']);
Route::prefix('schedule')->group(function () {
    Route::get('today', [\Modules\User\Http\Controllers\ScheduleController::class, 'today'])->name('schedule.today');
    Route::get('event-types', [\Modules\User\Http\Controllers\ScheduleController::class, 'eventTypes'])->name('schedule.event-types');
});
