<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TranslationController;

Route::post('auth/register', [AuthController::class, 'register'])->name('register');

Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware'=> ['auth:sanctum']], function ()  {
    
    Route::apiResource('languages', LanguageController::class);

    Route::apiResource('translations', TranslationController::class);
});