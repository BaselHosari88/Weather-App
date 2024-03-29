<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('current_weather', function (Blueprint $table) {
            $table->id();
            $table->float('temperature');
            $table->string('weather_conditions');
            $table->integer('humidity');
            $table->integer('pressure');
            $table->float('wind_speed');
            $table->integer('wind_direction');
            $table->timestamps();
            $table->date('date')->nullable(); // For forecast data, nullable because it's not applicable to current weather
            $table->string('type')->default('current'); // 'current' for current weather, 'forecast' for forecasts
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_weather');
    }
};
