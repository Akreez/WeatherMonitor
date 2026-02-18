<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function index($id): JsonResponse{
        $city = City::findOrFail($id);

        return response()->json([
            'city' => $city->name,
            'country'=> $city->country,
            'history' => $city->weatherData()->latest()->get()
        ]);
    }
}
