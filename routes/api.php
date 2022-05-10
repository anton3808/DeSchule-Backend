<?php

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix'=> 'auth'],function(){
    Route::post('/register', '\App\Http\Controllers\Auth\AuthController@register');
    Route::post('/login', '\App\Http\Controllers\Auth\AuthController@login');
    Route::get('/refresh-token', '\App\Http\Controllers\Auth\AuthController@refreshToken');
});

Route::group(['prefix' => 'password'],function() {
    Route::post('/email', '\App\Http\Controllers\Auth\ForgotPasswordController@getResetToken');
    Route::post('/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset');
});


Route::group(['middleware' => 'jwt.auth'], function() {
    Route::apiResource('/users', '\App\Http\Controllers\UserController');

    Route::group(['prefix'=> 'auth'],function(){
        Route::post('/logout', '\App\Http\Controllers\Auth\AuthController@logout');
        Route::get('/me', '\App\Http\Controllers\UserController@me');
    });

    Route::apiResource('/payments', '\App\Http\Controllers\PaymentController');
    Route::apiResource('/comments', '\App\Http\Controllers\NewsCommentController');
});

Route::apiResource('/packages', '\App\Http\Controllers\PackageController');
Route::apiResource('/news', '\App\Http\Controllers\NewsController');

Route::apiResource('/u/schedule', '\App\Http\Controllers\ScheduleController')->only(['index', 'store', 'destroy']);
Route::prefix('/u/schedule')->group(function () {
    Route::get('today', [\App\Http\Controllers\ScheduleController::class, 'today']);
});

Route::apiResource('/challenge', '\App\Http\Controllers\ChallengeController');
