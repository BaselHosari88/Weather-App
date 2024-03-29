<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WeatherController;

// Keep your existing routes for weather data display and update
Route::get('/weather', [WeatherController::class, 'show']);
Route::get('/weather/update', [WeatherController::class, 'updateWeatherData']);

// Adjusted route to include weather data on the welcome page
Route::get('/', function (WeatherController $weatherController) {
    // Fetch weather data for the welcome page
    $weatherData = $weatherController->fetchWeatherData();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'weatherData' => $weatherData, // Passing weather data to the welcome component
        'location' => env('DEFAULT_LOCATION', 'Unknown Location'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
