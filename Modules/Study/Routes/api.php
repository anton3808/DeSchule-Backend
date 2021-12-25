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

Route::apiResource('level', 'LevelController')->only(['index', 'show']);
Route::apiResource('lesson', 'LessonController')->only(['index', 'show']);
Route::apiResource('user-answer', 'UserAnswerController')->only(['store']);

//Route::prefix('dictionary')->group(function () {
//    Route::apiResource('word', 'Dictionary\WordController')->only(['index']);
//});
