<?php
namespace App\Http\Integrations\OpenWeatherMapConnector;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
class OpenWeatherMapConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    protected function getBaseUrl(): string
    {
        return 'https://api.openweathermap.org/data/2.5/';
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return $this->getBaseUrl();
    }

    /**
     * Default headers for every request
     */
    public function defaultHeaders(): array
    {
        return ['Accept' => 'application/json'];
    }

    /**
     * Default HTTP client options
     */
    public function defaultQuery(): array
    {
        return ['appid' => env('OPENWEATHERMAP_API_KEY'), 'units' => 'metric'];
    }
}
