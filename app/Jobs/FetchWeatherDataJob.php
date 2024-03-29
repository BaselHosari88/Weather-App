<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Integrations\FetchWeatherRequest\Requests\FetchWeatherRequest;
use App\Http\Integrations\OpenWeatherMapConnector\OpenWeatherMapConnector;
use Illuminate\Support\Facades\Log;
use App\Models\CurrentWeather;

class FetchWeatherDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lat;
    protected $lon;


    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        // Updated to use the constructor parameters correctly
        $weatherRequest = new FetchWeatherRequest($this->lat, $this->lon);

        $connector = new OpenWeatherMapConnector();

        $response = $connector->send($weatherRequest);

        if($response->successful()){
            $weatherData = $response->json();

            CurrentWeather::create([
                'temperature' => $weatherData['main']['temp'],
                'weather_conditions' => $weatherData['weather'][0]['main'],
                'humidity' => $weatherData['main']['humidity'],
                'pressure' => $weatherData['main']['pressure'],
                'wind_speed' => $weatherData['wind']['speed'],
                'wind_direction' => $weatherData['wind']['deg'],
                // Add more fields as necessary
            ]);

            Log::info('Weather data fetched successfully: ' . json_encode($weatherData));
        } else {
            Log::error('Failed to fetch weather data: ' . $response->body());
        }

        return true;
    }
}
