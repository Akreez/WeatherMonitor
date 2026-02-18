<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\City;
use App\Http\Controllers\WeatherController;

Route::get('/weather/{cityId}', [WeatherController::class, 'index']);
