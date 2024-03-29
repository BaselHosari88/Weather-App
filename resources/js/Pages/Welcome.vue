<template>
    <Head title="Welcome" />

    <div class="flex h-screen">
        <div class="w-3/4 bg-blue-200 p-8 flex flex-col justify-between">
            <div class="flex">
                <div class="space-y-2">
                    <p class="text-2xl text-gray-700">{{ location }}</p>
                    <p class="text-lg text-gray-500">{{ currentDateTime.date }}</p>
                    <p class="text-md text-gray-500">{{ currentDateTime.time }}</p>


                    <p class="text-xl text-gray-700">{{ weatherData.weather[0].description }}</p>


                </div>
                <div class="ml-auto">
                    <div class="text-9xl font-bold text-gray-800 leading-none">{{ weatherData.main.temp }}°C</div>
                    <!-- Note: Adjust the following line to display dynamic min/max temperature if available -->
<!--                    <div class="text-2xl text-gray-500 mt-[-0.5rem]">21° / 23°</div>-->
                    <div class="text-2xl text-gray-500 mt-[-0.5rem]">Wind Speed: {{ weatherData.wind.speed }} meter/sec</div>
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4 my-4">
                <div v-for="(forecast, index) in weatherData.forecast" :key="index" class="text-center space-y-2">
<!--                    <p class="text-lg text-gray-700">{{ formatForecastDate(forecast.date) }}</p>-->
<!--                    <p class="text-2xl text-yellow-500">{{ forecast.temp }}°C</p>-->
                    <p class="text-md text-gray-500">{{ forecast.description }}</p>
                    <p class="text-xl text-gray-700">Humidity: {{ forecast.humidity }}%</p>
                    <p class="text-xl text-gray-700">Wind: {{ forecast.wind_speed }} meter/sec</p>
                </div>
            </div>
        </div>
        <div class="p-8 flex flex-col justify-center items-center space-y-4">
            <div class="text-center space-y-2">
                <h1 class="text-3xl font-bold" style="color: black;">Weatheria</h1>
                <p class="text-sm" style="color: black;">
                    Step into the Elements:<br>
                    Your Instant Window to<br>
                    Real-Time Weather Updates!
                </p>
            </div>
            <button class="bg-purple-500 text-white font-bold py-2 px-4 rounded self-center">
                Discover Now
            </button>
            <template v-if="!isAuthenticated">
                <a href="/login" class="mt-2 inline-block text-purple-300 hover:text-white">Log in</a>
                <a ></a>

                <a href="/register" class="mt-2 inline-block text-purple-300 hover:text-white">Register</a>
            </template>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import { ref, computed, onMounted, defineProps} from 'vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    isAuthenticated: Boolean,
    weatherData: Object,
    location: String,
});



const weatherIcon = computed(() => {
    if (props.weatherData && props.weatherData.weather && props.weatherData.weather.length > 0) {
        const iconCode = props.weatherData.weather[0].icon;
        return `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
    }
    return ''; // Fallback if no icon is available
});




// Adapted from Weather.vue
const currentDateTime = computed(() => {
    const now = DateTime.local();
    return {
        date: now.toFormat('cccc, dd LLLL yyyy'),
        time: now.toFormat('HH:mm'),
    };
});

const formatForecastDate = (date) => {
    return DateTime.fromISO(date).toFormat('dd/LL/yyyy');
};

onMounted(() => {
    console.log(props.weatherData);
});
</script>

<style>
/* Include your CSS here. */
/* You might need to adjust it based on your needs after the merge. */
</style>
