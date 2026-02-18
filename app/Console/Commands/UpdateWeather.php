<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Models\WeatherData;

class UpdateWeather extends Command
{
    
    protected $signature = 'app:weather-update';
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(){
        $cities = City::all();

        foreach($cities as $city){
            $this->info("Adatok lekérése: {$city->name}.");

            $geoResponse = Http::withoutVerifying()->get("https://geocoding-api.open-meteo.com/v1/search", [
                'name' => $city->name,
                'count' => 1,
                'language'=> 'hu',
                'format' => 'json',
            ]);

            if($geoResponse->successful() && isset($geoResponse['results'][0])){
                $lat = $geoResponse['results'][0]['latitude'];
                $lon = $geoResponse['results'][0]['longitude'];

                $weatherResponse = Http::withoutVerifying()->get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => $lat,
                    'longitude' => $lon,
                    'current_weather' => true,
                ]);

                if($weatherResponse->successful()){
                    $temp = $weatherResponse['current_weather']['temperature'];

                    WeatherData::create([
                        'city_id' => $city->id,
                        'temperature' => $temp,
                    ]);

                    $this->info("Sikeres lekérés: {$temp} °C elmentve.");
                }else{
                    $this->error("Nem található koordináta a városhoz: {$city->name}.");
                }
            }
            $this->info("Az összes város frissítve.");

        }

    }
}
