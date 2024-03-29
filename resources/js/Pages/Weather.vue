<template>
    <div class="flex h-screen">
        <div class="w-3/4 bg-blue-200 p-8 flex flex-col justify-between">
            <div class="flex">
                <div class="space-y-2">
                    <p class="text-2xl text-gray-700">Amsterdam, Netherlands</p>
                    <p class="text-lg text-gray-500">{{ currentDateTime.date }}</p>
                    <p class="text-md text-gray-500">{{ currentDateTime.time }}</p>
                    <p class="text-xl text-gray-700">{{ weatherData.weather[0].description }}</p>
                    <p class="text-xl text-gray-700">{{ weatherData.main.humidity }}%</p>
                </div>
                <div class="ml-auto">
                    <div class="text-9xl font-bold text-gray-800 leading-none">{{ weatherData.main.temp }}°C</div>
                    <div class="text-2xl text-gray-500 mt-[-0.5rem]">21° / 23°</div>
                    <div class="text-2xl text-gray-500 mt-[-0.5rem]">Wind Speed: {{ weatherData.wind.speed }} meter/sec</div>
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 my-4">
                <div v-for="(forecast, index) in weatherData.forecast" :key="index" class="text-center space-y-2">
                    <p class="text-lg text-gray-700">{{ formatForecastDate(forecast.date) }}</p>
                    <p class="text-2xl text-yellow-500">{{ forecast.temp }}°C</p>
                    <p class="text-md text-gray-500">{{ forecast.description }}</p>
                    <p class="text-xl text-gray-700">Humidity: {{ forecast.humidity }}%</p>
                    <p class="text-xl text-gray-700">Wind: {{ forecast.wind_speed }} meter/sec</p>
                </div>
            </div>
        </div>
        <div class="w-1/4 bg-purple-700 text-white p-8 flex flex-col justify-center items-center space-y-4">
            <div class="mb-4">
                <p class="font-bold text-lg">Weatheria</p>
                <p>Step into the Elements: Your Instant Window to Real-Time Weather Updates!</p>
            </div>
            <button class="bg-purple-500 text-white font-bold py-2 px-4 rounded self-center">
                Discover Now
            </button>
            <template v-if="!isAuthenticated">
                <a v-if="canLogin" href="/login" class=" inline-block text-purple-300 hover:text-white">Log in</a>
                <a v-if="canRegister" href="/register" class="mt-2 inline-block text-purple-300 hover:text-white">Register</a>
            </template>
        </div>
    </div>
</template>

<script setup>
import { DateTime } from 'luxon';
import {ref, computed, onMounted} from 'vue';

// Props
const props = defineProps({
    weatherData: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    isAuthenticated: Boolean,
});

// Current Date and Time using Luxon
const currentDateTime = computed(() => {
    const now = DateTime.local();
    return {
        date: now.toFormat('cccc, dd LLLL yyyy'),
        time: now.toFormat('HH:mm'),
    };
});

// Format forecast dates using Luxon
const formatForecastDate = (date) => {
    return DateTime.fromISO(date).toFormat('dd/LL/yyyy');
};

// Log the weather data on mount
onMounted(() => {
    console.log(props.weatherData);
});
</script>
