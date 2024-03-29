<?php

namespace App\Http\Controllers;

use App\Models\CurrentWeather;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Jobs\FetchWeatherDataJob;
use App\Jobs\FetchWeatherForecastJob;

class WeatherController extends Controller
{
    public function show()
    {
        $data = $this->fetchWeatherData();

        if (!$data) {
            abort(500, 'No weather data available.');
        }

        return Inertia::render('Weather', ['weatherData' => $data]);
    }

    public function updateWeatherData()
    {
        dispatch(new FetchWeatherDataJob(52.3676, 4.9041));
        dispatch(new FetchWeatherForecastJob(52.3676, 4.9041));

        return redirect()->back()->with('message', 'Weather data update initiated.');
    }

    public function fetchWeatherData()
    {
        $weatherData = CurrentWeather::where('type', 'current')

            ->orderBy('created_at', 'desc')
            ->first();

        $forecastData = CurrentWeather::where('type', 'forecast')
            ->orderBy('date', 'asc')
            ->take(5)
            ->get();

        if (!$weatherData) {
            Log::error('No weather data available.');
            return null;
        }

        $data = [
            'main' => [
                'temp' => $weatherData->temperature,
                'humidity' => $weatherData->humidity,
            ],
            'weather' => [
                [
                    'description' => $weatherData->weather_conditions,
                ],
            ],
            'wind' => [
                'speed' => $weatherData->wind_speed,
            ],
            'forecast' => $forecastData->map(function ($day) {
                return [
                    'date' => $day->date,
                    'temp' => $day->temperature,
                    'description' => $day->weather_conditions,
                    'humidity' => $day->humidity,
                    'pressure' => $day->pressure,
                    'wind_speed' => $day->wind_speed,
                    'wind_direction' => $day->wind_direction,
                ];
            }),
        ];

        return $data;
    }
}
