<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country'];

    public function weatherData(){
        return $this->hasMany(WeatherData::class);
    }

    public function latestWeatherData(){
        return $this->hasOne(weatherData::class)->latestOfMany();
        // return $this->hasOne(WeatherData::class)->latest();
    }
}
