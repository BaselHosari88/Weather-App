<?php
namespace App\Http\Integrations\FetchWeatherRequest\Requests;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use App\Http\Integrations\OpenWeatherMapConnector\OpenWeatherMapConnector;
class FetchWeatherRequest extends Request
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
        $endpoint = "weather?lat={$this->lat}&lon={$this->lon}";
        if (!is_null($this->exclude)) {
            $endpoint .= "&exclude={$this->exclude}";
        }
        return $endpoint;
    }
}

