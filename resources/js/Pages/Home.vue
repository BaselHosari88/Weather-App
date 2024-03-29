<template>
    <main class="flex items-center justify-center min-h-screen bg-gray-400">
        <!-- Big Div -->
        <div class="bg-blue-200 shadow-lime-100 w-2/3 p-8 m-4 flex">

            <!-- First Div (Left - Full Width) -->
            <div class="w-full p-4">
                Hi from home Page
                <h1>test search from Basel = {{ search.more }}</h1>
                {{
                    new Date().toLocaleString('en-us', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    })
                }}
            </div>

            <!-- Second Div (Right - Remaining Width) -->
            <div class="flex-1 p-4">

                <form>
                    <div class="bg-white border border-indigo-600/30 rounded-lg shadow-lg flex items-center">
                        <i class="fa-solid fa-magnifying-glass p-2 text-indigo-600"></i>
                        <input
                            v-model="search.more"
                            type="text"
                            placeholder="Search for a place"
                            class="rounded-r-lg p-2 border-0 outline-0 focus:ring-2 focus:ring-indigo-600 ring-inset w-full"
                        />
                    </div>
                </form>

                <div class="my-2 rounded-lg">
                    <div>
                        <button
                            class="bg-blue-400 text-black font-sans px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300"
                        >
                            Click me
                        </button>
                    </div>
                </div>
                <div id="third" class="bg-white p-6 rounded-lg shadow-lg max-w-xs mx-auto">
                    <h2 class="text-xl font-semibold mb-4">Weather Card</h2>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">Temperature:</p>
                        <p class="text-blue-500 font-semibold">25°C</p>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-gray-600">Condition:</p>
                        <p class="text-blue-500 font-semibold">Clear</p>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-gray-600">Wind:</p>
                        <p class="text-blue-500 font-semibold">10 km/h</p>
                    </div>
                    <div class="mt-4">
                        <button
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300"
                        >
                            View Details
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>
</template>

<script setup>
import { reactive } from 'vue';

const search = reactive({
    more: ''
});
</script>
