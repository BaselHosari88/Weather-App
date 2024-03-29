<?php
namespace App\Http\Integrations\FetchWeatherForecastRequest\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use App\Http\Integrations\OpenWeatherMapConnector\OpenWeatherMapConnector;

class FetchWeatherForecastRequest extends Request
{
    protected ?string $connector = OpenWeatherMapConnector::class;
    protected Method $method = Method::GET;

    public float $lat;
    public float $lon;
    public ?string $exclude;

    public function __construct(float $lat, float $lon, ?string $exclude = null)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->exclude = $exclude;
    }

    public function resolveEndpoint(): string
    {
        // Updated to target the forecast endpoint. Ensure this matches the OpenWeatherMap API documentation.
        $endpoint = "forecast?lat={$this->lat}&lon={$this->lon}";
        if (!is_null($this->exclude)) {
            $endpoint .= "&exclude={$this->exclude}";
        }
        return $endpoint;
    }
}
