<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

Route::get('/', [CityController::class, 'index'])->name('cities.index');
Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
