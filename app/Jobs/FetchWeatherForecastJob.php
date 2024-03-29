<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Integrations\FetchWeatherForecastRequest\Requests\FetchWeatherForecastRequest;
use App\Http\Integrations\OpenWeatherMapConnector\OpenWeatherMapConnector;
use Illuminate\Support\Facades\Log;
use App\Models\CurrentWeather;

class FetchWeatherForecastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public float $lat;
    public float $lon;

    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    public function handle()
    {
        $forecastRequest = new FetchWeatherForecastRequest($this->lat, $this->lon);
        $connector = new OpenWeatherMapConnector();
        $response = $connector->send($forecastRequest);

        if ($response->successful()) {
            $forecastData = $response->json();

            foreach ($forecastData['list'] as $forecast) {
                $date = date('Y-m-d', $forecast['dt']); // Convert Unix timestamp to date

                // Extracting necessary information
                $temperature = $forecast['main']['temp'];
                $weatherConditions = $forecast['weather'][0]['main'];
                $humidity = $forecast['main']['humidity'];
                $pressure = $forecast['main']['pressure'];
                $windSpeed = $forecast['wind']['speed'];
                $windDirection = $forecast['wind']['deg'];

                // Save to database as forecast data
                CurrentWeather::updateOrCreate(
                    ['date' => $date, 'type' => 'forecast'], // Key fields to match or create
                    [
                        'temperature' => $temperature,
                        'weather_conditions' => $weatherConditions,
                        'humidity' => $humidity,
                        'pressure' => $pressure,
                        'wind_speed' => $windSpeed,
                        'wind_direction' => $windDirection,
                        'type' => 'forecast', // Mark as forecast data
                    ]
                );
            }

            Log::info('Weather forecast data fetched and saved successfully.');
        } else {
            Log::error('Failed to fetch weather forecast data: ' . $response->body());
        }
    }
}
