<?php

Route::post('register', [\Modules\User\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
Route::post('login', [\Modules\User\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::post('reset-password', [\Modules\User\Http\Controllers\AuthController::class, 'resetPassword'])->name('auth.reset-password');
Route::post('reset-password-confirmation', [\Modules\User\Http\Controllers\AuthController::class, 'resetPasswordConfirmation'])->name('auth.reset-password-confirmation');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\Modules\User\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
    Route::post('change-password', [\Modules\User\Http\Controllers\AuthController::class, 'changePassword'])->name('auth.change-password');
});
