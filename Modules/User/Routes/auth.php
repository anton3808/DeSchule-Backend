<?php

Route::post('register', [\Modules\User\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
Route::post('logout', [\Modules\User\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
Route::post('login', [\Modules\User\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
