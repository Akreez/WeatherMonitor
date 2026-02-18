<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function index(){
        $cities = City::with('latestWeatherData')->get();

        return view('dashboard', compact('cities'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        City::create($validated);

        return redirect()->back()->with('success', 'Város hozzáadva.');
    }

    public function destroy(City $city){
        $city->delete();

        return redirect()->back()->with('success', 'Város törölve.');
    }
}
