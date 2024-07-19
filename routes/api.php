<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/statistics/daily', [StatisticController::class, 'dailyStatistics']);
Route::get('/statistics/weekly', [StatisticController::class, 'weeklyStatistics']);
Route::get('/statistics/monthly', [StatisticController::class, 'monthlyStatistics']);

Route::get('/statistics', [StatisticController::class, 'index']);

