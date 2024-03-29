<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentWeather extends Model
{
    use HasFactory;


    protected $fillable = [

        'temperature',
        'weather_conditions',
        'humidity',
        'pressure',
        'wind_speed',
        'wind_direction',
        'date',
        'type',
    ];

}
